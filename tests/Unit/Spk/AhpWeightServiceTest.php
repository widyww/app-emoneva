<?php

namespace Tests\Unit\Spk;

use App\Services\SPK\AhpWeightService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Uji AhpWeightService terhadap studi kasus dokumen (docs/SPK-AHP-SAW.md Bagian 10.1).
 * Semua uji murni (tanpa database).
 */
class AhpWeightServiceTest extends TestCase
{
    private AhpWeightService $ahp;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ahp = new AhpWeightService();
    }

    /** Matriks contoh dokumen menghasilkan bobot & konsistensi yang sesuai. */
    public function test_bobot_dan_konsistensi_sesuai_contoh_dokumen(): void
    {
        $matriks = $this->ahp->bangunMatriks(4, [
            '0,1' => 2, '0,2' => 3, '0,3' => 4,
            '1,2' => 2, '1,3' => 3,
            '2,3' => 2,
        ]);

        $hasil = $this->ahp->proses($matriks);

        // Bobot (toleransi kecil karena pembulatan)
        $this->assertEqualsWithDelta(0.4658, $hasil['bobot'][0], 0.0005);
        $this->assertEqualsWithDelta(0.2772, $hasil['bobot'][1], 0.0005);
        $this->assertEqualsWithDelta(0.1611, $hasil['bobot'][2], 0.0005);
        $this->assertEqualsWithDelta(0.0960, $hasil['bobot'][3], 0.0005);

        // Total bobot = 1
        $this->assertEqualsWithDelta(1.0, array_sum($hasil['bobot']), 0.0001);

        // Konsistensi
        $this->assertEqualsWithDelta(4.031, $hasil['lambda_maks'], 0.005);
        $this->assertEqualsWithDelta(0.0115, $hasil['cr'], 0.001);
        $this->assertTrue($hasil['konsisten']);
    }

    /** Penilaian yang saling bertentangan (A>B>C tapi C>A) harus terdeteksi tidak konsisten. */
    public function test_mendeteksi_penilaian_tidak_konsisten(): void
    {
        $matriks = $this->ahp->bangunMatriks(3, [
            '0,1' => 5,   // A jauh lebih penting dari B
            '1,2' => 5,   // B jauh lebih penting dari C
            '0,2' => 0.2, // tapi C lebih penting dari A (kontradiksi)
        ]);

        $hasil = $this->ahp->proses($matriks);

        $this->assertGreaterThan(AhpWeightService::BATAS_CR, $hasil['cr']);
        $this->assertFalse($hasil['konsisten']);
    }

    /** bangunMatriks mengisi diagonal 1 dan elemen bawah sebagai kebalikan. */
    public function test_bangun_matriks_mengisi_kebalikan(): void
    {
        $matriks = $this->ahp->bangunMatriks(2, ['0,1' => 4]);

        $this->assertSame(1.0, $matriks[0][0]);
        $this->assertSame(1.0, $matriks[1][1]);
        $this->assertSame(4.0, $matriks[0][1]);
        $this->assertEqualsWithDelta(0.25, $matriks[1][0], 1e-9);
    }

    /** n <= 2 selalu konsisten (CR = 0). */
    public function test_dua_kriteria_selalu_konsisten(): void
    {
        $matriks = $this->ahp->bangunMatriks(2, ['0,1' => 7]);
        $hasil = $this->ahp->proses($matriks);

        $this->assertSame(0.0, $hasil['cr']);
        $this->assertTrue($hasil['konsisten']);
    }

    /** Matriks tidak persegi ditolak. */
    public function test_matriks_tidak_persegi_ditolak(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->ahp->hitungBobot([[1, 2, 3], [0.5, 1]]);
    }

    /** Nilai non-positif ditolak. */
    public function test_nilai_non_positif_ditolak(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->ahp->hitungBobot([[1, 0], [0, 1]]);
    }
}
