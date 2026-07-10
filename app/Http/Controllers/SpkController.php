<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Sekolah;
use App\Models\SpkHasil;
use App\Models\SpkKriteria;
use App\Services\SPK\AhpWeightService;
use App\Services\SPK\SawRankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * SpkController
 * ------------------------------------------------------------------
 * Antarmuka SPK (AHP + SAW) untuk role Kabalai:
 *  - bobot()/simpanBobot() : kelola bobot kriteria via perbandingan AHP
 *  - hitung()              : jalankan perankingan SAW untuk periode aktif
 *  - ranking()/detail()    : lihat hasil & rincian per sekolah
 */
class SpkController extends Controller
{
    /** Tampilkan kriteria + form perbandingan berpasangan (AHP). */
    public function bobot()
    {
        $kriteria = SpkKriteria::orderBy('kode')->get();

        return view('kabalai.spk.bobot', compact('kriteria'));
    }

    /**
     * Hitung bobot dari matriks perbandingan; simpan hanya bila CR <= 10%.
     * Input: nilai[i][j] (i<j, indeks 0-based) berisi nilai skala Saaty
     * (boleh pecahan seperti "1/3").
     */
    public function simpanBobot(Request $request, AhpWeightService $ahp)
    {
        $kriteria = SpkKriteria::orderBy('kode')->get()->values();
        $n = $kriteria->count();

        if ($n < 2) {
            return back()->with('error', 'Minimal 2 kriteria untuk melakukan perbandingan AHP.');
        }

        // Bangun nilai segitiga atas dari input
        $input = $request->input('nilai', []);
        $atas = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $atas["{$i},{$j}"] = $this->parseSaaty($input[$i][$j] ?? 1);
            }
        }

        try {
            $matriks = $ahp->bangunMatriks($n, $atas);
            $hasil = $ahp->proses($matriks);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', 'Matriks perbandingan tidak valid: ' . $e->getMessage());
        }

        $crPersen = number_format($hasil['cr'] * 100, 2);

        if (!$hasil['konsisten']) {
            return back()->with('error',
                "Penilaian tidak konsisten (CR = {$crPersen}% > 10%). Perbaiki perbandingan berpasangan."
            );
        }

        DB::transaction(function () use ($kriteria, $hasil) {
            foreach ($kriteria as $idx => $k) {
                $k->update(['bobot' => round($hasil['bobot'][$idx], 4)]);
            }
        });

        return redirect()->route('spk.bobot')->with('success',
            "Bobot AHP tersimpan. Konsisten (CR = {$crPersen}%)."
        );
    }

    /** Jalankan perhitungan SAW untuk periode aktif. */
    public function hitung(SawRankingService $saw)
    {
        try {
            $ringkasan = $saw->hitung();
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        if (empty($ringkasan)) {
            return back()->with('error', 'Tidak ada sekolah terverifikasi pada periode aktif untuk dihitung.');
        }

        return redirect()->route('spk.ranking')->with('success',
            count($ringkasan) . ' sekolah berhasil dihitung dan dirangking.'
        );
    }

    /** Tabel ranking hasil SAW pada periode aktif. */
    public function ranking()
    {
        $periode = Periode::where('status', 1)->first();

        $hasil = collect();
        if ($periode) {
            $hasil = SpkHasil::with('sekolah')
                ->where('periode_id', $periode->id)
                ->orderBy('peringkat')
                ->get();
        }

        return view('kabalai.spk.ranking', compact('hasil', 'periode'));
    }

    /** Rincian skor per kriteria untuk satu sekolah. */
    public function detail(Sekolah $sekolah)
    {
        $periode = Periode::where('status', 1)->first();

        $hasil = SpkHasil::where('sekolah_id', $sekolah->id)
            ->when($periode, fn($q) => $q->where('periode_id', $periode->id))
            ->latest('dihitung_pada')
            ->first();

        if (!$hasil) {
            return redirect()->route('spk.ranking')
                ->with('error', 'Belum ada hasil SPK untuk sekolah ini. Jalankan perhitungan terlebih dahulu.');
        }

        return view('kabalai.spk.detail', compact('sekolah', 'hasil', 'periode'));
    }

    /**
     * Konversi input skala Saaty menjadi float; mendukung pecahan "1/3".
     */
    private function parseSaaty($nilai): float
    {
        if (is_string($nilai) && str_contains($nilai, '/')) {
            [$pembilang, $penyebut] = array_map('trim', explode('/', $nilai, 2));
            $penyebut = (float) $penyebut;
            return $penyebut != 0.0 ? (float) $pembilang / $penyebut : 1.0;
        }

        $nilai = (float) $nilai;
        return $nilai > 0 ? $nilai : 1.0;
    }
}
