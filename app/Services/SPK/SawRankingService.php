<?php

namespace App\Services\SPK;

use App\Models\Periode;
use App\Models\Sekolah;
use App\Models\SpkHasil;
use App\Models\SpkKriteria;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * SawRankingService
 * ------------------------------------------------------------------
 * Merangking sekolah dengan metode SAW (Simple Additive Weighting):
 *   V_i = Σ ( w_j × r_ij )
 * dengan:
 *   - w_j = bobot kriteria (hasil AHP, dibaca dari tabel spk_kriteria)
 *   - r_ij = nilai ternormalisasi (semua kriteria benefit: r = x / max kolom)
 *   - x_ij = skor kebutuhan 1-5 dari KonversiKriteriaService
 *
 * Lihat docs/SPK-AHP-SAW.md Bagian 7, 8, dan studi kasus 10.2.
 *
 * Hanya memproses sekolah TERVERIFIKASI (status_verifikasi = 2) pada
 * PERIODE AKTIF. Hasil disimpan ke spk_hasil (1 baris per sekolah+periode).
 */
class SawRankingService
{
    // Ambang kategori prioritas berdasarkan nilai V (dapat disesuaikan Balai).
    private const AMBANG_TINGGI = 0.70;
    private const AMBANG_SEDANG = 0.40;

    public function __construct(
        private KonversiKriteriaService $konversi
    ) {}

    /**
     * Jalankan perhitungan SAW untuk satu periode lalu simpan ke spk_hasil.
     * Jika $periode null, memakai periode dengan status aktif.
     *
     * @return array<int,array{sekolah_id:int,skor:float,peringkat:int,kategori:string}>
     */
    public function hitung(?Periode $periode = null): array
    {
        $periode = $periode ?? $this->periodeAktif();

        $bobot = $this->bobotKriteria();          // [kode => bobot], sudah dinormalisasi Σ=1
        $sekolahList = $this->sekolahTerverifikasi($periode);

        if ($sekolahList->isEmpty()) {
            return [];
        }

        // 1. Matriks keputusan: [sekolah_id => [kode => skor 1-5]]
        $matriks = [];
        foreach ($sekolahList as $sekolah) {
            $skor = $this->konversi->konversi($sekolah);
            // hanya ambil kriteria yang aktif (ada di $bobot)
            $matriks[$sekolah->id] = array_intersect_key($skor, $bobot);
        }

        // 2. Normalisasi + skor V + rincian (murni, tanpa DB)
        $hasil = $this->normalisasiDanSkor($matriks, $bobot, $this->namaKriteria());

        // 3. Ranking (V terbesar = prioritas tertinggi) + kategori
        uasort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        $ringkasan = [];
        $peringkat = 0;
        DB::transaction(function () use ($hasil, $periode, &$ringkasan, &$peringkat) {
            foreach ($hasil as $sekolahId => $row) {
                $peringkat++;
                $kategori = $this->kategori($row['skor']);

                SpkHasil::updateOrCreate(
                    ['sekolah_id' => $sekolahId, 'periode_id' => $periode->id],
                    [
                        'skor' => round($row['skor'], 5),
                        'peringkat' => $peringkat,
                        'kategori' => $kategori,
                        'rincian' => $row['rincian'],
                        'dihitung_pada' => now(),
                    ]
                );

                $ringkasan[] = [
                    'sekolah_id' => $sekolahId,
                    'skor' => round($row['skor'], 5),
                    'peringkat' => $peringkat,
                    'kategori' => $kategori,
                ];
            }
        });

        return $ringkasan;
    }

    /**
     * Bagian MURNI SAW: normalisasi benefit + hitung V + rincian per kriteria.
     * Dipisah agar dapat diuji tanpa database.
     *
     * @param  array<int,array<string,float|int>>  $matriks  [sekolahId => [kode => skor]]
     * @param  array<string,float>  $bobot  [kode => bobot]
     * @param  array<string,string>  $namaKriteria  [kode => nama] (opsional, untuk rincian)
     * @return array<int,array{skor:float,rincian:array<string,mixed>}>
     */
    public function normalisasiDanSkor(array $matriks, array $bobot, array $namaKriteria = []): array
    {
        if (empty($matriks) || empty($bobot)) {
            return [];
        }

        // Nilai maksimum tiap kolom (kriteria) untuk normalisasi benefit
        $maksKolom = [];
        foreach ($bobot as $kode => $w) {
            $maks = 0.0;
            foreach ($matriks as $baris) {
                $maks = max($maks, (float) ($baris[$kode] ?? 0));
            }
            $maksKolom[$kode] = $maks;
        }

        $hasil = [];
        foreach ($matriks as $sekolahId => $baris) {
            $v = 0.0;
            $rincian = [];
            foreach ($bobot as $kode => $w) {
                $skor = (float) ($baris[$kode] ?? 0);
                $maks = $maksKolom[$kode];
                $r = $maks > 0 ? $skor / $maks : 0.0; // benefit: r = x / max
                $kontribusi = $w * $r;
                $v += $kontribusi;

                $rincian[$kode] = [
                    'nama' => $namaKriteria[$kode] ?? $kode,
                    'skor' => $skor,
                    'bobot' => round($w, 4),
                    'normalisasi' => round($r, 4),
                    'kontribusi' => round($kontribusi, 5),
                ];
            }
            $hasil[$sekolahId] = ['skor' => $v, 'rincian' => $rincian];
        }

        return $hasil;
    }

    /**
     * Bobot kriteria aktif dari spk_kriteria, dinormalisasi agar Σ = 1
     * (menjaga ambang kategori tetap bermakna meski total tersimpan ≠ 1).
     *
     * @return array<string,float>
     */
    private function bobotKriteria(): array
    {
        $kriteria = SpkKriteria::aktif()->get();
        if ($kriteria->isEmpty()) {
            throw new RuntimeException('Belum ada kriteria SPK aktif. Tetapkan bobot AHP terlebih dahulu.');
        }

        $total = (float) $kriteria->sum('bobot');
        if ($total <= 0) {
            throw new RuntimeException('Total bobot kriteria SPK nol. Jalankan pembobotan AHP terlebih dahulu.');
        }

        return $kriteria->mapWithKeys(fn($k) => [$k->kode => (float) $k->bobot / $total])->all();
    }

    /** @return array<string,string> [kode => nama] kriteria aktif */
    private function namaKriteria(): array
    {
        return SpkKriteria::aktif()->pluck('nama', 'kode')->all();
    }

    /**
     * Sekolah terverifikasi pada periode terkait.
     * Catatan: sekolah tidak punya periode_id; keterkaitan periode lewat
     * kolom string sekolah.tahun yang dicocokkan ke periode.tahun.
     */
    private function sekolahTerverifikasi(Periode $periode)
    {
        return Sekolah::terverifikasi()
            ->where('tahun', $periode->tahun)
            ->with(['fasilitas.labs', 'bantuanStatus', 'sekolah_sosekbud'])
            ->get();
    }

    private function periodeAktif(): Periode
    {
        $periode = Periode::where('status', 1)->first();
        if (!$periode) {
            throw new RuntimeException('Tidak ada periode aktif. Aktifkan satu periode terlebih dahulu.');
        }
        return $periode;
    }

    private function kategori(float $v): string
    {
        if ($v >= self::AMBANG_TINGGI) {
            return 'tinggi';
        }
        if ($v >= self::AMBANG_SEDANG) {
            return 'sedang';
        }
        return 'rendah';
    }
}
