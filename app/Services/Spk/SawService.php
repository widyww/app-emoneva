<?php

namespace App\Services\Spk;

use App\Models\AhpBobot;
use App\Models\Periode;
use App\Models\SawHasil;
use App\Models\Sekolah;
use Illuminate\Support\Facades\DB;

/**
 * SawService
 * ------------------------------------------------------------------
 * Merangking sekolah dengan metode SAW (Simple Additive Weighting):
 *   r_ij = x_ij / max_i(x_ij)   (semua kriteria benefit)
 *   V_i  = Σ_j (W_j * r_ij)
 * dengan W_j bobot AHP periode berjalan dan x_ij skor rubrik 1-5.
 * Peringkat diurutkan menurun terhadap V_i.
 */
class SawService
{
    public function __construct(private RubrikKebutuhan $rubrik) {}

    public function hitungDanSimpan(Periode $periode): array
    {
        // 1) Ambil bobot AHP periode ini: ['C1'=>0.4011, ...]
        $bobot = AhpBobot::where('periode_id', $periode->id)
            ->join('kriteria', 'kriteria.id', '=', 'ahp_bobot.kriteria_id')
            ->pluck('bobot', 'kriteria.kode')->map(fn ($b) => (float) $b)->all();

        // 2) Alternatif = SMA yang punya data fasilitas (lihat catatan filter di panduan §12)
        $sekolahs = Sekolah::with(['fasilitas', 'bantuanStatus'])
            ->where('tingkatan', 'SMA')
            ->whereHas('fasilitas')
            // ->where('status_verifikasi', 2)   // aktifkan bila hanya data tervalidasi
            // ->where('tahun', $periode->tahun)  // aktifkan bila sekolah.tahun sudah terisi
            ->get();

        // 3) Matriks skor kebutuhan
        $skor = [];
        foreach ($sekolahs as $s) {
            $skor[$s->id] = $this->rubrik->skor($s);
        }

        // 4) Nilai maksimum tiap kriteria (semua benefit)
        $maks = [];
        foreach (['C1', 'C2', 'C3', 'C4', 'C5'] as $k) {
            $maks[$k] = max(array_column($skor, $k) ?: [1]) ?: 1;
        }

        // 5) Vi = Σ (Wj * rij),  rij = xij / maks
        $vi = [];
        foreach ($skor as $id => $sk) {
            $v = 0.0;
            foreach ($sk as $k => $x) {
                $v += ($bobot[$k] ?? 0) * ($x / $maks[$k]);
            }
            $vi[$id] = $v;
        }
        arsort($vi);                    // urut menurun

        // 6) Simpan hasil + peringkat
        DB::transaction(function () use ($periode, $vi, $skor) {
            SawHasil::where('periode_id', $periode->id)->delete();
            $rank = 1;
            foreach ($vi as $id => $nilai) {
                SawHasil::create([
                    'periode_id'    => $periode->id,
                    'sekolah_id'    => $id,
                    'skor'          => $skor[$id],
                    'nilai_vi'      => round($nilai, 6),
                    'peringkat'     => $rank++,
                    'dihitung_pada' => now(),
                ]);
            }
        });

        return ['jumlah' => count($vi)];
    }
}
