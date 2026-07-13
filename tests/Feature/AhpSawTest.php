<?php

namespace Tests\Feature;

use App\Models\AhpBobot;
use App\Models\AhpPerbandingan;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\SawHasil;
use App\Models\Sekolah;
use App\Models\SekolahBantuanStatus;
use App\Models\SekolahFasilitas;
use App\Services\Spk\AhpService;
use App\Services\Spk\SawService;
use Database\Seeders\AhpPerbandinganSeeder;
use Database\Seeders\KriteriaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifikasi end-to-end modul SPK (panduan §11):
 *  - seeder kriteria + matriks default menghasilkan bobot & CR = Excel
 *  - SawService mengurutkan sekolah dan menyimpan hasil dengan benar
 */
class AhpSawTest extends TestCase
{
    use RefreshDatabase;

    private function seedAhp(): Periode
    {
        (new KriteriaSeeder())->run();
        $periode = Periode::create(['tahun' => 2025, 'status' => 1]);
        (new AhpPerbandinganSeeder())->run();

        return $periode;
    }

    /** Bangun matriks numerik dari DB seperti pada controller/tinker panduan. */
    private function matriksDariDb(Periode $periode): array
    {
        $ids = Kriteria::orderBy('urutan')->pluck('id')->values();
        $m = [];
        foreach ($ids as $i => $a) {
            foreach ($ids as $j => $b) {
                $m[$i][$j] = (float) AhpPerbandingan::where([
                    'periode_id' => $periode->id,
                    'kriteria_baris_id' => $a,
                    'kriteria_kolom_id' => $b,
                ])->value('nilai');
            }
        }

        return $m;
    }

    public function test_seeder_menghasilkan_bobot_dan_cr_sesuai_excel(): void
    {
        $periode = $this->seedAhp();

        $r = (new AhpService())->hitung($this->matriksDariDb($periode));

        $this->assertEqualsWithDelta(0.4011, $r['bobot'][0], 0.001);
        $this->assertEqualsWithDelta(0.1051, $r['bobot'][1], 0.001);
        $this->assertEqualsWithDelta(0.2681, $r['bobot'][2], 0.001);
        $this->assertEqualsWithDelta(0.1631, $r['bobot'][3], 0.001);
        $this->assertEqualsWithDelta(0.0626, $r['bobot'][4], 0.001);
        $this->assertEqualsWithDelta(0.019, $r['cr'], 0.005);
        $this->assertTrue($r['konsisten']);
    }

    public function test_saw_merangking_dan_menyimpan_hasil(): void
    {
        $periode = $this->seedAhp();

        // Simpan bobot AHP ke ahp_bobot (langkah yang biasanya dilakukan controller)
        $r = (new AhpService())->hitung($this->matriksDariDb($periode));
        foreach (Kriteria::orderBy('urutan')->get() as $i => $k) {
            AhpBobot::create([
                'periode_id' => $periode->id,
                'kriteria_id' => $k->id,
                'bobot' => round($r['bobot'][$i], 6),
            ]);
        }

        // Sekolah A: kondisi terburuk => skor maksimum pada semua kriteria (V = 1)
        $a = Sekolah::create(['nama' => 'SMA A', 'tingkatan' => 'SMA',
            'jum_siswa_pria' => '50', 'jum_siswa_wanita' => '50']);
        SekolahFasilitas::create(['sekolah_id' => $a->id, 'jumlah_kom' => null,
            'listrik_durasi' => '6', 'internet_status' => 'tidak', 'labkom_status' => 'tidak']);

        // Sekolah B: kondisi terbaik => skor minimum (V ≈ 0,2125 sesuai panduan)
        $b = Sekolah::create(['nama' => 'SMA B', 'tingkatan' => 'SMA',
            'jum_siswa_pria' => '50', 'jum_siswa_wanita' => '50']);
        SekolahFasilitas::create(['sekolah_id' => $b->id, 'jumlah_kom' => '100',
            'listrik_durasi' => '24', 'internet_status' => 'ada', 'internet_bandwith' => '100',
            'labkom_status' => 'ada']);
        SekolahBantuanStatus::create(['sekolah_id' => $b->id, 'status' => 'ya']);

        // Sekolah non-SMA & SMA tanpa fasilitas harus DIKECUALIKAN
        Sekolah::create(['nama' => 'SMK X', 'tingkatan' => 'SMK']);
        Sekolah::create(['nama' => 'SMA tanpa fasilitas', 'tingkatan' => 'SMA']);

        $hasil = (new SawService(new \App\Services\Spk\RubrikKebutuhan()))
            ->hitungDanSimpan($periode);

        // Hanya 2 sekolah (A & B) yang diproses
        $this->assertSame(2, $hasil['jumlah']);
        $this->assertSame(2, SawHasil::where('periode_id', $periode->id)->count());

        $rankA = SawHasil::where('sekolah_id', $a->id)->first();
        $rankB = SawHasil::where('sekolah_id', $b->id)->first();

        $this->assertSame(1, $rankA->peringkat, 'Sekolah terburuk harus peringkat 1');
        $this->assertSame(2, $rankB->peringkat);
        $this->assertEqualsWithDelta(1.0, $rankA->nilai_vi, 0.0001, 'V sekolah A = 1');
        $this->assertEqualsWithDelta(0.2125, $rankB->nilai_vi, 0.001, 'V sekolah B ≈ 0,2125 (panduan)');

        // skor rubrik tersimpan sebagai JSON dengan lima kriteria
        $this->assertEquals(['C1' => 5, 'C2' => 5, 'C3' => 5, 'C4' => 5, 'C5' => 5], $rankA->skor);
        $this->assertEquals(['C1' => 1, 'C2' => 1, 'C3' => 1, 'C4' => 1, 'C5' => 2], $rankB->skor);
    }
}
