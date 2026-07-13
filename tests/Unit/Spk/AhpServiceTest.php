<?php

namespace Tests\Unit\Spk;

use App\Services\Spk\AhpService;
use PHPUnit\Framework\TestCase;

/**
 * Memastikan AhpService mereproduksi angka pada berkas Excel/skripsi
 * (panduan §1.4): bobot C1..C5 dan CR = 0,019 (<= 0,10).
 */
class AhpServiceTest extends TestCase
{
    /** Matriks perbandingan default dari panduan §1.3 (indeks 0..4 = C1..C5). */
    private function matriks(): array
    {
        // Nilai segitiga atas (baris terhadap kolom); bawah = kebalikannya.
        $atas = [
            [0, 1, 3], [0, 2, 2], [0, 3, 3], [0, 4, 5],
            [1, 2, 1 / 3], [1, 3, 1 / 2], [1, 4, 2],
            [2, 3, 2], [2, 4, 4],
            [3, 4, 3],
        ];

        $n = 5;
        $m = [];
        for ($i = 0; $i < $n; $i++) {
            $m[$i] = array_fill(0, $n, 1.0);
        }
        foreach ($atas as [$i, $j, $nilai]) {
            // gunakan pembulatan 4 desimal seperti yang disimpan seeder
            $atasVal = round($nilai, 4);
            $bawahVal = round(1 / $nilai, 4);
            $m[$i][$j] = $atasVal;
            $m[$j][$i] = $bawahVal;
        }

        return $m;
    }

    public function test_bobot_sesuai_excel(): void
    {
        $hasil = (new AhpService())->hitung($this->matriks());
        $bobot = $hasil['bobot'];

        $this->assertEqualsWithDelta(0.4011, $bobot[0], 0.001, 'Bobot C1');
        $this->assertEqualsWithDelta(0.1051, $bobot[1], 0.001, 'Bobot C2');
        $this->assertEqualsWithDelta(0.2681, $bobot[2], 0.001, 'Bobot C3');
        $this->assertEqualsWithDelta(0.1631, $bobot[3], 0.001, 'Bobot C4');
        $this->assertEqualsWithDelta(0.0626, $bobot[4], 0.001, 'Bobot C5');

        $this->assertEqualsWithDelta(1.0, array_sum($bobot), 1e-9, 'Total bobot harus 1');
    }

    public function test_konsisten_cr_di_bawah_ambang(): void
    {
        $hasil = (new AhpService())->hitung($this->matriks());

        $this->assertEqualsWithDelta(0.019, $hasil['cr'], 0.005, 'CR mendekati 0,019');
        $this->assertTrue($hasil['konsisten'], 'CR harus <= 0,10');
        $this->assertEqualsWithDelta(5.086, $hasil['lambda_maks'], 0.02, 'lambda maks mendekati 5,086');
    }
}
