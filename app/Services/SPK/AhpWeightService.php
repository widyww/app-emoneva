<?php

namespace App\Services\SPK;

use InvalidArgumentException;

/**
 * AhpWeightService
 * ------------------------------------------------------------------
 * Menurunkan BOBOT kriteria dari matriks perbandingan berpasangan
 * (skala Saaty 1-9) dengan metode AHP, sekaligus menguji konsistensi
 * penilaian (Consistency Ratio). Lihat docs/SPK-AHP-SAW.md Bagian 6 & 10.1.
 *
 * Alur:
 *   1. hitungBobot()       -> priority vector (rata-rata baris matriks ternormalisasi)
 *   2. hitungKonsistensi() -> lambda maks, CI, CR, status konsisten
 *   3. proses()            -> gabungan keduanya (dipakai controller)
 *
 * Aturan: bobot dianggap sah bila CR <= 0.10 (10%). Bila CR > 10%,
 * penilaian perbandingan harus diperbaiki (bukan disimpan).
 */
class AhpWeightService
{
    /** Batas maksimum Consistency Ratio agar penilaian dapat diterima. */
    public const BATAS_CR = 0.10;

    /**
     * Random Index (RI) dari tabel Saaty, diindeks oleh n (jumlah kriteria).
     * Untuk n <= 2 konsistensi selalu terpenuhi (RI = 0).
     */
    private const RANDOM_INDEX = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
    ];

    /**
     * Proses lengkap: validasi -> bobot -> konsistensi.
     *
     * @param  array<int,array<int,float|int|string>>  $matriks  matriks n x n (nilai Saaty)
     * @return array{
     *     n:int,
     *     bobot:array<int,float>,
     *     lambda_maks:float,
     *     ci:float,
     *     ri:float,
     *     cr:float,
     *     konsisten:bool
     * }
     */
    public function proses(array $matriks): array
    {
        $matriks = $this->validasiMatriks($matriks);
        $bobot = $this->hitungBobot($matriks);
        $konsistensi = $this->hitungKonsistensi($matriks, $bobot);

        return array_merge(
            ['n' => count($matriks), 'bobot' => $bobot],
            $konsistensi
        );
    }

    /**
     * Hitung bobot (priority vector):
     *   1. jumlahkan tiap kolom
     *   2. normalisasi: bagi tiap sel dengan jumlah kolomnya
     *   3. bobot = rata-rata tiap baris matriks ternormalisasi
     *
     * @return array<int,float> bobot per kriteria (total = 1)
     */
    public function hitungBobot(array $matriks): array
    {
        $matriks = $this->validasiMatriks($matriks);
        $n = count($matriks);

        // 1. Jumlah tiap kolom
        $jumlahKolom = array_fill(0, $n, 0.0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $jumlahKolom[$j] += $matriks[$i][$j];
            }
        }

        // 2 & 3. Normalisasi kolom lalu rata-rata baris
        $bobot = array_fill(0, $n, 0.0);
        for ($i = 0; $i < $n; $i++) {
            $totalBaris = 0.0;
            for ($j = 0; $j < $n; $j++) {
                if ($jumlahKolom[$j] == 0.0) {
                    throw new InvalidArgumentException("Jumlah kolom ke-{$j} nol; matriks tidak valid.");
                }
                $totalBaris += $matriks[$i][$j] / $jumlahKolom[$j];
            }
            $bobot[$i] = $totalBaris / $n;
        }

        return $bobot;
    }

    /**
     * Uji konsistensi:
     *   lambda maks = rata-rata dari (Aw)_i / w_i
     *   CI = (lambda maks - n) / (n - 1)
     *   CR = CI / RI
     *
     * @return array{lambda_maks:float,ci:float,ri:float,cr:float,konsisten:bool}
     */
    public function hitungKonsistensi(array $matriks, array $bobot): array
    {
        $matriks = $this->validasiMatriks($matriks);
        $n = count($matriks);

        // n <= 2: matriks perbandingan selalu konsisten
        if ($n <= 2) {
            return [
                'lambda_maks' => (float) $n,
                'ci' => 0.0,
                'ri' => 0.0,
                'cr' => 0.0,
                'konsisten' => true,
            ];
        }

        // Aw = matriks x bobot
        $aw = array_fill(0, $n, 0.0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $aw[$i] += $matriks[$i][$j] * $bobot[$j];
            }
        }

        // lambda maks = rata-rata (Aw_i / w_i)
        $totalLambda = 0.0;
        for ($i = 0; $i < $n; $i++) {
            if ($bobot[$i] == 0.0) {
                throw new InvalidArgumentException("Bobot kriteria ke-{$i} nol; tidak dapat menghitung lambda.");
            }
            $totalLambda += $aw[$i] / $bobot[$i];
        }
        $lambdaMaks = $totalLambda / $n;

        $ci = ($lambdaMaks - $n) / ($n - 1);
        $ri = $this->randomIndex($n);
        $cr = $ri > 0 ? $ci / $ri : 0.0;

        return [
            'lambda_maks' => $lambdaMaks,
            'ci' => $ci,
            'ri' => $ri,
            'cr' => $cr,
            'konsisten' => $cr <= self::BATAS_CR,
        ];
    }

    /**
     * Bangun matriks perbandingan n x n lengkap dari nilai segitiga atas.
     * Diagonal diisi 1, elemen bawah = kebalikan elemen atas (a[j][i] = 1/a[i][j]).
     *
     * @param  int  $n
     * @param  array<string,float|int|string>  $nilaiAtas  key "i,j" (i<j, indeks 0-based) => nilai Saaty
     * @return array<int,array<int,float>>
     */
    public function bangunMatriks(int $n, array $nilaiAtas): array
    {
        if ($n < 1) {
            throw new InvalidArgumentException('Jumlah kriteria minimal 1.');
        }

        $matriks = [];
        for ($i = 0; $i < $n; $i++) {
            $matriks[$i] = array_fill(0, $n, 1.0);
        }

        foreach ($nilaiAtas as $kunci => $nilai) {
            [$i, $j] = array_map('intval', explode(',', (string) $kunci));
            if ($i < 0 || $j < 0 || $i >= $n || $j >= $n) {
                throw new InvalidArgumentException("Indeks perbandingan di luar rentang: {$kunci}.");
            }
            $nilai = (float) $nilai;
            if ($nilai <= 0) {
                throw new InvalidArgumentException("Nilai perbandingan harus positif: {$kunci} = {$nilai}.");
            }
            $matriks[$i][$j] = $nilai;
            $matriks[$j][$i] = 1 / $nilai;
        }

        return $matriks;
    }

    /**
     * Random Index untuk n kriteria (mengikuti tabel Saaty).
     * Untuk n > 10 dipakai nilai n=10 sebagai pendekatan.
     */
    private function randomIndex(int $n): float
    {
        if ($n <= 0) {
            return 0.0;
        }
        return self::RANDOM_INDEX[$n] ?? self::RANDOM_INDEX[10];
    }

    /**
     * Pastikan matriks persegi, tidak kosong, dan berisi nilai positif.
     * Mengembalikan matriks yang seluruh selnya sudah di-cast ke float.
     *
     * @return array<int,array<int,float>>
     */
    private function validasiMatriks(array $matriks): array
    {
        $n = count($matriks);
        if ($n === 0) {
            throw new InvalidArgumentException('Matriks perbandingan kosong.');
        }

        $bersih = [];
        $i = 0;
        foreach ($matriks as $baris) {
            if (!is_array($baris) || count($baris) !== $n) {
                throw new InvalidArgumentException('Matriks perbandingan harus persegi (n x n).');
            }
            $j = 0;
            foreach (array_values($baris) as $sel) {
                if (!is_numeric($sel)) {
                    throw new InvalidArgumentException('Semua elemen matriks harus berupa angka.');
                }
                $sel = (float) $sel;
                if ($sel <= 0) {
                    throw new InvalidArgumentException('Semua elemen matriks harus bernilai positif.');
                }
                $bersih[$i][$j] = $sel;
                $j++;
            }
            $i++;
        }

        return $bersih;
    }
}
