<?php

namespace App\Services\SPK;

use App\Models\Sekolah;

/**
 * KonversiKriteriaService
 * ------------------------------------------------------------------
 * Mengubah data mentah sekolah menjadi "skor kebutuhan" 1-5 untuk tiap
 * kriteria SPK (C1-C7). Prinsip: SEMAKIN BURUK kondisi / SEMAKIN butuh
 * bantuan => skor SEMAKIN TINGGI. Dengan begitu semua kriteria bersifat
 * benefit terhadap tujuan "prioritas bantuan" (lihat docs/SPK-AHP-SAW.md
 * Bagian 7.2 & 9).
 *
 * PENTING (jebakan data nyata di emoneva):
 *  - Banyak kolom sumber bertipe string/text BEBAS, bukan kategori bersih:
 *      listrik_durasi, jumlah_kom, internet_bandwith, labkom_jumlah_pc,
 *      jum_siswa_*, bantuan_status.status, internet_kesesuaian,
 *      kondisi_geografis, akses_transportasi.
 *  - Karena itu konversi memakai parsing angka + pencocokan kata kunci +
 *    fallback aman, BUKAN pemetaan enum langsung.
 *  - Ambang & kata kunci di bawah adalah HEURISTIK AWAL yang WAJIB
 *    divalidasi terhadap nilai data sebenarnya bersama pembimbing/Balai
 *    sebelum dipakai untuk keputusan final. Semua ambang sengaja ditaruh
 *    sebagai konstanta agar mudah disetel.
 */
class KonversiKriteriaService
{
    /** Urutan kriteria SPK yang didukung. */
    public const KODE_KRITERIA = ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7'];

    // Ambang C1 (durasi listrik, dalam jam)
    private const LISTRIK_JAM_MINIM = 6;    // < 6 jam => sangat terbatas
    private const LISTRIK_JAM_SEDANG = 12;  // < 12 jam => terbatas
    private const LISTRIK_JAM_PENUH = 24;   // >= 24 jam => stabil penuh

    // Ambang C2 (rasio siswa per 1 PC; makin besar makin kurang memadai)
    private const RASIO_PC_MEMADAI = 10;
    private const RASIO_PC_CUKUP = 20;
    private const RASIO_PC_KURANG = 40;

    // Ambang C3 (bandwidth internet, dalam Mbps)
    private const BW_RENDAH = 5;

    // Ambang C6 (jumlah siswa terdampak)
    private const SISWA_SANGAT_BANYAK = 500;
    private const SISWA_BANYAK = 300;
    private const SISWA_SEDANG = 150;
    private const SISWA_SEDIKIT = 50;

    /**
     * Konversi seluruh kriteria untuk satu sekolah.
     *
     * @return array<string,int> mis. ['C1' => 5, 'C2' => 4, ...]
     */
    public function konversi(Sekolah $sekolah): array
    {
        return [
            'C1' => $this->skorListrik($sekolah),
            'C2' => $this->skorLabKomputer($sekolah),
            'C3' => $this->skorInternet($sekolah),
            'C4' => $this->skorRiwayatBantuan($sekolah),
            'C5' => $this->skorKeterpencilan($sekolah),
            'C6' => $this->skorJumlahSiswa($sekolah),
            'C7' => $this->skorUnbkAkreditasi($sekolah),
        ];
    }

    // ================================================================
    // C1 — Kondisi Listrik
    // ================================================================
    private function skorListrik(Sekolah $sekolah): int
    {
        $fasilitas = $sekolah->fasilitas;

        // Tidak ada listrik (atau data fasilitas kosong) => kebutuhan tertinggi
        if (!$fasilitas || strtolower((string) $fasilitas->listrik_status) !== 'ada') {
            return 5;
        }

        // Indikasi eksplisit tidak stabil pada teks durasi
        if ($this->mengandung($fasilitas->listrik_durasi, ['padam', 'tidak stabil', 'mati', 'sering'])) {
            return 3;
        }

        $jam = $this->angka($fasilitas->listrik_durasi);
        if ($jam !== null) {
            if ($jam < self::LISTRIK_JAM_MINIM) {
                return 4;
            }
            if ($jam < self::LISTRIK_JAM_SEDANG) {
                return 3;
            }
            if ($jam < self::LISTRIK_JAM_PENUH) {
                return 2;
            }
            return 1; // >= 24 jam, stabil penuh
        }

        // Ada listrik tapi durasi tidak diketahui => asumsi cukup stabil (tengah-bawah)
        return 2;
    }

    // ================================================================
    // C2 — Ketersediaan Lab & Rasio Komputer (siswa per PC)
    // ================================================================
    private function skorLabKomputer(Sekolah $sekolah): int
    {
        $fasilitas = $sekolah->fasilitas;

        if (!$fasilitas || strtolower((string) $fasilitas->labkom_status) !== 'ada') {
            return 5; // tidak ada lab komputer
        }

        // Total PC: utamakan penjumlahan per-lab, fallback ke kolom ringkas jumlah_kom
        $totalPc = 0.0;
        if ($fasilitas->relationLoaded('labs') || $fasilitas->labs) {
            foreach ($fasilitas->labs as $lab) {
                $totalPc += $this->angka($lab->labkom_jumlah_pc) ?? 0;
            }
        }
        if ($totalPc <= 0) {
            $totalPc = $this->angka($fasilitas->jumlah_kom) ?? 0;
        }

        // Lab ada tapi tidak ada PC tercatat => rasio sangat kurang
        if ($totalPc <= 0) {
            return 4;
        }

        $totalSiswa = $this->totalSiswa($sekolah);
        // Jumlah siswa tak diketahui => rasio tak bisa dihitung, ambil tengah
        if ($totalSiswa <= 0) {
            return 3;
        }

        $rasio = $totalSiswa / $totalPc; // siswa per 1 PC
        if ($rasio <= self::RASIO_PC_MEMADAI) {
            return 1;
        }
        if ($rasio <= self::RASIO_PC_CUKUP) {
            return 2;
        }
        if ($rasio <= self::RASIO_PC_KURANG) {
            return 3;
        }
        return 4; // lab ada tapi rasio sangat kurang (maks 4; skor 5 khusus tanpa lab)
    }

    // ================================================================
    // C3 — Kondisi Internet
    // ================================================================
    private function skorInternet(Sekolah $sekolah): int
    {
        $fasilitas = $sekolah->fasilitas;

        if (!$fasilitas || strtolower((string) $fasilitas->internet_status) !== 'ada') {
            return 5; // tidak ada internet
        }

        $kesesuaian = $fasilitas->internet_kesesuaian;
        $bw = $this->angka($fasilitas->internet_bandwith);

        if ($this->mengandung($kesesuaian, ['tidak sesuai', 'tidak memadai', 'sangat kurang'])) {
            return 4;
        }
        if ($bw !== null && $bw < self::BW_RENDAH) {
            return 4; // bandwidth sangat rendah
        }
        if ($this->mengandung($kesesuaian, ['kadang', 'kurang', 'belum sesuai'])) {
            return 3;
        }
        if ($this->mengandung($kesesuaian, ['sesuai', 'memadai', 'baik'])) {
            return 2;
        }

        // Ada internet, kesesuaian tak jelas => tengah
        return 3;
    }

    // ================================================================
    // C4 — Riwayat Bantuan
    // ================================================================
    private function skorRiwayatBantuan(Sekolah $sekolah): int
    {
        $status = $sekolah->bantuanStatus;

        // Tidak ada catatan bantuan => anggap belum pernah dibantu
        if (!$status) {
            return 5;
        }

        $teks = strtolower(trim((string) $status->status));

        // Cek "belum" lebih dulu (mis. "belum pernah" mengandung kata "pernah")
        if ($teks === '' || $this->mengandung($teks, ['belum', 'tidak pernah', 'tidak ada'])) {
            return 5;
        }
        if ($this->mengandung($teks, ['baru', 'baru saja', 'tahun ini'])) {
            return 1; // baru menerima bantuan
        }

        // Ada status bantuan lain (pernah) => prioritas menengah
        return 3;
    }

    // ================================================================
    // C5 — Keterpencilan / Aksesibilitas
    // ================================================================
    private function skorKeterpencilan(Sekolah $sekolah): int
    {
        $sosekbud = $sekolah->sekolah_sosekbud;
        if (!$sosekbud) {
            return 3; // data tak tersedia => tengah (tidak menaikkan/menurunkan prioritas)
        }

        $teks = strtolower(
            trim(($sosekbud->kondisi_geografis ?? '') . ' ' . ($sosekbud->akses_transportasi ?? ''))
        );
        if ($teks === '') {
            return 3;
        }

        if ($this->mengandung($teks, ['sangat terpencil', 'sangat sulit', 'pegunungan', 'pulau', 'pedalaman', 'tidak terjangkau'])) {
            return 5;
        }
        if ($this->mengandung($teks, ['terpencil', 'sulit', 'terbatas', 'jauh', 'rusak', 'pelosok'])) {
            return 3;
        }
        if ($this->mengandung($teks, ['mudah', 'perkotaan', 'kota', 'lancar', 'baik', 'dekat'])) {
            return 1;
        }

        return 3;
    }

    // ================================================================
    // C6 — Jumlah Siswa Terdampak
    // ================================================================
    private function skorJumlahSiswa(Sekolah $sekolah): int
    {
        $total = $this->totalSiswa($sekolah);

        // Data tak diketahui => skor terendah agar tidak keliru menaikkan prioritas
        if ($total <= 0) {
            return 1;
        }
        if ($total > self::SISWA_SANGAT_BANYAK) {
            return 5;
        }
        if ($total > self::SISWA_BANYAK) {
            return 4;
        }
        if ($total > self::SISWA_SEDANG) {
            return 3;
        }
        if ($total > self::SISWA_SEDIKIT) {
            return 2;
        }
        return 1;
    }

    // ================================================================
    // C7 — Urgensi UNBK & Akreditasi
    // ================================================================
    private function skorUnbkAkreditasi(Sekolah $sekolah): int
    {
        $unbkMandiri = $this->mengandung($sekolah->unbk_status, ['mandiri', 'ya', 'sudah']);

        $akr = strtoupper(trim((string) $sekolah->status_akreditasi));
        $akreditasiBaik = in_array($akr, ['A', 'B'], true)
            || $this->mengandung($sekolah->status_akreditasi, ['baik', 'unggul']);

        if (!$unbkMandiri && !$akreditasiBaik) {
            return 5; // belum UNBK mandiri & akreditasi rendah/tak diketahui
        }
        if ($unbkMandiri && $akreditasiBaik) {
            return 1; // sudah UNBK mandiri & akreditasi baik
        }
        return 3; // salah satu terpenuhi
    }

    // ================================================================
    // Helper
    // ================================================================

    /** Jumlah siswa (pria + wanita) dari kolom string. */
    private function totalSiswa(Sekolah $sekolah): float
    {
        return ($this->angka($sekolah->jum_siswa_pria) ?? 0)
            + ($this->angka($sekolah->jum_siswa_wanita) ?? 0);
    }

    /**
     * Ambil angka pertama dari string bebas (mis. "24 jam" => 24,
     * "10 Mbps" => 10, "1.5" => 1.5). Mengembalikan null jika tak ada angka.
     */
    private function angka(?string $value): ?float
    {
        if ($value === null) {
            return null;
        }
        // Normalisasi koma desimal ke titik, lalu tangkap angka pertama
        $value = str_replace(',', '.', $value);
        if (preg_match('/\d+(\.\d+)?/', $value, $m)) {
            return (float) $m[0];
        }
        return null;
    }

    /** Cek apakah teks (case-insensitive) mengandung salah satu kata kunci. */
    private function mengandung(?string $teks, array $kataKunci): bool
    {
        if ($teks === null || trim($teks) === '') {
            return false;
        }
        $teks = strtolower($teks);
        foreach ($kataKunci as $kunci) {
            if (str_contains($teks, strtolower($kunci))) {
                return true;
            }
        }
        return false;
    }
}
