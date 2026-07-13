<?php

namespace App\Services\Spk;

/**
 * AhpService
 * ------------------------------------------------------------------
 * Menurunkan bobot kriteria dari matriks perbandingan berpasangan
 * (skala Saaty) dengan metode AHP dan menguji konsistensinya (CR).
 *
 * Metode bobot = RATA-RATA GEOMETRIK BARIS (sesuai berkas Excel skripsi).
 * Alternatif "normalisasi kolom lalu rata-rata baris" disertakan sebagai
 * komentar; selisih bobot <= 0,18 poin persen dan peringkat tetap identik.
 */
class AhpService
{
    /** Indeks Random Saaty */
    private array $RI = [1 => 0.0, 2 => 0.0, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45, 10 => 1.49];

    /**
     * @param array<int,array<int,float>> $m  Matriks n x n (indeks 0..n-1 selaras urutan kriteria)
     * @return array{bobot:array<int,float>,lambda_maks:float,ci:float,ri:float,cr:float,konsisten:bool}
     */
    public function hitung(array $m): array
    {
        $n = count($m);

        // (1) Rata-rata geometrik tiap baris  => bobot ternormalisasi
        $gm = [];
        for ($i = 0; $i < $n; $i++) {
            $prod = 1.0;
            for ($j = 0; $j < $n; $j++) {
                $prod *= $m[$i][$j];
            }
            $gm[$i] = $prod ** (1 / $n);
        }
        $sum   = array_sum($gm);
        $bobot = array_map(fn ($g) => $g / $sum, $gm);

        // --- Alternatif "normalisasi kolom lalu rata-rata baris" (sesuai kalimat Bab III):
        // $colSum = array_map(fn($j)=>array_sum(array_column($m,$j)), range(0,$n-1));
        // for ($i=0;$i<$n;$i++){ $s=0; for($j=0;$j<$n;$j++) $s += $m[$i][$j]/$colSum[$j]; $bobot[$i]=$s/$n; }

        // (2) lambda maks = rata-rata (A*w)_i / w_i
        $lambda = 0.0;
        for ($i = 0; $i < $n; $i++) {
            $aw = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $aw += $m[$i][$j] * $bobot[$j];
            }
            $lambda += $aw / $bobot[$i];
        }
        $lambdaMaks = $lambda / $n;

        // (3) CI, CR
        $ci = ($lambdaMaks - $n) / ($n - 1);
        $ri = $this->RI[$n] ?? 1.49;
        $cr = $ri == 0.0 ? 0.0 : $ci / $ri;

        return [
            'bobot'       => $bobot,
            'lambda_maks' => $lambdaMaks,
            'ci'          => $ci,
            'ri'          => $ri,
            'cr'          => $cr,
            'konsisten'   => $cr <= 0.10,
        ];
    }
}
