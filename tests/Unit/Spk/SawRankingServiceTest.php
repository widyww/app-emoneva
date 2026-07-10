<?php

namespace Tests\Unit\Spk;

use App\Services\SPK\KonversiKriteriaService;
use App\Services\SPK\SawRankingService;
use PHPUnit\Framework\TestCase;

/**
 * Uji bagian MURNI SAW (normalisasiDanSkor) terhadap studi kasus dokumen
 * (docs/SPK-AHP-SAW.md Bagian 10.2). Tanpa database.
 */
class SawRankingServiceTest extends TestCase
{
    private SawRankingService $saw;

    /** Bobot hasil AHP dari contoh dokumen. */
    private array $bobot = ['C1' => 0.4658, 'C2' => 0.2772, 'C3' => 0.1611, 'C4' => 0.0960];

    protected function setUp(): void
    {
        parent::setUp();
        $this->saw = new SawRankingService(new KonversiKriteriaService());
    }

    private function matriksContoh(): array
    {
        return [
            1 => ['C1' => 5, 'C2' => 5, 'C3' => 5, 'C4' => 5], // Sekolah A
            2 => ['C1' => 3, 'C2' => 4, 'C3' => 3, 'C4' => 5], // Sekolah B
            3 => ['C1' => 1, 'C2' => 2, 'C3' => 1, 'C4' => 1], // Sekolah C
        ];
    }

    /** Skor V tiap sekolah sesuai perhitungan manual dokumen. */
    public function test_skor_sesuai_contoh_dokumen(): void
    {
        $hasil = $this->saw->normalisasiDanSkor($this->matriksContoh(), $this->bobot);

        $this->assertEqualsWithDelta(1.000, $hasil[1]['skor'], 0.001);
        $this->assertEqualsWithDelta(0.694, $hasil[2]['skor'], 0.001);
        $this->assertEqualsWithDelta(0.256, $hasil[3]['skor'], 0.001);
    }

    /** Sekolah A memiliki skor tertinggi (prioritas utama). */
    public function test_sekolah_kebutuhan_tertinggi_skornya_teratas(): void
    {
        $hasil = $this->saw->normalisasiDanSkor($this->matriksContoh(), $this->bobot);

        $this->assertGreaterThan($hasil[2]['skor'], $hasil[1]['skor']);
        $this->assertGreaterThan($hasil[3]['skor'], $hasil[2]['skor']);
    }

    /** Rincian menyimpan kontribusi (w x r) per kriteria untuk transparansi. */
    public function test_rincian_kontribusi_per_kriteria(): void
    {
        $hasil = $this->saw->normalisasiDanSkor($this->matriksContoh(), $this->bobot);

        $rincianB = $hasil[2]['rincian'];
        // C1 Sekolah B: skor 3, max kolom 5 => r = 0.6; kontribusi = 0.4658 * 0.6
        $this->assertEqualsWithDelta(0.6, $rincianB['C1']['normalisasi'], 0.001);
        $this->assertEqualsWithDelta(0.2795, $rincianB['C1']['kontribusi'], 0.001);
        $this->assertSame(3.0, $rincianB['C1']['skor']);
    }

    /** Input kosong menghasilkan array kosong (tidak error). */
    public function test_matriks_kosong_aman(): void
    {
        $this->assertSame([], $this->saw->normalisasiDanSkor([], $this->bobot));
        $this->assertSame([], $this->saw->normalisasiDanSkor($this->matriksContoh(), []));
    }
}
