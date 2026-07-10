<?php

namespace Tests\Unit\Spk;

use App\Models\Sekolah;
use App\Models\SekolahBantuanStatus;
use App\Models\SekolahFasilitas;
use App\Models\SekolahFasilitasLab;
use App\Models\SekolahSosekbud;
use App\Services\SPK\KonversiKriteriaService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Uji rubrik KonversiKriteriaService (data mentah -> skor kebutuhan 1-5).
 * Model dibangun di memori (forceFill + setRelation) sehingga TANPA database.
 *
 * Prinsip yang diuji: makin buruk kondisi / makin butuh => skor makin tinggi.
 */
class KonversiKriteriaServiceTest extends TestCase
{
    private KonversiKriteriaService $konversi;

    protected function setUp(): void
    {
        parent::setUp();
        $this->konversi = new KonversiKriteriaService();
    }

    /**
     * Bangun objek Sekolah lengkap dengan relasi tanpa menyentuh database.
     *
     * @param  array<string,mixed>  $sekolah
     * @param  array<string,mixed>|null  $fasilitas
     * @param  array<int,array<string,mixed>>  $labs  daftar lab (labkom_jumlah_pc)
     */
    private function buatSekolah(
        array $sekolah = [],
        ?array $fasilitas = null,
        array $labs = [],
        ?string $statusBantuan = null,
        ?array $sosekbud = null
    ): Sekolah {
        $model = (new Sekolah())->forceFill($sekolah);

        if ($fasilitas !== null) {
            $f = (new SekolahFasilitas())->forceFill($fasilitas);
            $koleksiLab = new Collection(array_map(
                fn($l) => (new SekolahFasilitasLab())->forceFill($l),
                $labs
            ));
            $f->setRelation('labs', $koleksiLab);
            $model->setRelation('fasilitas', $f);
        } else {
            $model->setRelation('fasilitas', null);
        }

        $model->setRelation(
            'bantuanStatus',
            $statusBantuan === null ? null : (new SekolahBantuanStatus())->forceFill(['status' => $statusBantuan])
        );

        $model->setRelation(
            'sekolah_sosekbud',
            $sosekbud === null ? null : (new SekolahSosekbud())->forceFill($sosekbud)
        );

        return $model;
    }

    /** Sekolah tanpa listrik, tanpa lab, tanpa internet, belum pernah dibantu => skor maksimum. */
    public function test_kondisi_terburuk_menghasilkan_skor_maksimum(): void
    {
        $sekolah = $this->buatSekolah(
            fasilitas: [
                'listrik_status' => 'tidak',
                'labkom_status' => 'tidak',
                'internet_status' => 'tidak',
            ],
            statusBantuan: null,
            sosekbud: ['kondisi_geografis' => 'Daerah sangat terpencil di pegunungan', 'akses_transportasi' => 'sulit']
        );

        $skor = $this->konversi->konversi($sekolah);

        $this->assertSame(5, $skor['C1']); // listrik
        $this->assertSame(5, $skor['C2']); // lab
        $this->assertSame(5, $skor['C3']); // internet
        $this->assertSame(5, $skor['C4']); // riwayat bantuan (belum pernah)
        $this->assertSame(5, $skor['C5']); // keterpencilan
    }

    /** Listrik stabil 24 jam => C1 skor terendah. */
    public function test_listrik_stabil_penuh_skor_rendah(): void
    {
        $sekolah = $this->buatSekolah(fasilitas: [
            'listrik_status' => 'ada',
            'listrik_durasi' => '24 jam',
        ]);

        $this->assertSame(1, $this->konversi->konversi($sekolah)['C1']);
    }

    /** Listrik sering padam => C1 = 3. */
    public function test_listrik_tidak_stabil_skor_menengah(): void
    {
        $sekolah = $this->buatSekolah(fasilitas: [
            'listrik_status' => 'ada',
            'listrik_durasi' => 'sering padam',
        ]);

        $this->assertSame(3, $this->konversi->konversi($sekolah)['C1']);
    }

    /** Lab ada dengan rasio PC memadai (siswa sedikit, PC banyak) => C2 rendah. */
    public function test_rasio_pc_memadai_skor_rendah(): void
    {
        $sekolah = $this->buatSekolah(
            sekolah: ['jum_siswa_pria' => '30', 'jum_siswa_wanita' => '30'],
            fasilitas: ['labkom_status' => 'ada'],
            labs: [['labkom_jumlah_pc' => '20'], ['labkom_jumlah_pc' => '20']] // 40 PC, 60 siswa => rasio 1.5
        );

        $this->assertSame(1, $this->konversi->konversi($sekolah)['C2']);
    }

    /** Lab ada tapi tanpa PC tercatat => C2 = 4. */
    public function test_lab_ada_tanpa_pc_skor_tinggi(): void
    {
        $sekolah = $this->buatSekolah(
            sekolah: ['jum_siswa_pria' => '100', 'jum_siswa_wanita' => '100'],
            fasilitas: ['labkom_status' => 'ada'],
            labs: []
        );

        $this->assertSame(4, $this->konversi->konversi($sekolah)['C2']);
    }

    /** Jumlah siswa sangat banyak => C6 = 5; data kosong => C6 = 1. */
    public function test_jumlah_siswa_terdampak(): void
    {
        $banyak = $this->buatSekolah(sekolah: ['jum_siswa_pria' => '300', 'jum_siswa_wanita' => '250']); // 550
        $this->assertSame(5, $this->konversi->konversi($banyak)['C6']);

        $kosong = $this->buatSekolah();
        $this->assertSame(1, $this->konversi->konversi($kosong)['C6']);
    }

    /** Sekolah baru menerima bantuan => C4 = 1. */
    public function test_baru_menerima_bantuan_skor_rendah(): void
    {
        $sekolah = $this->buatSekolah(statusBantuan: 'Baru saja menerima bantuan tahun ini');
        $this->assertSame(1, $this->konversi->konversi($sekolah)['C4']);
    }

    /** "Belum pernah" tidak keliru dibaca sebagai "pernah". */
    public function test_belum_pernah_dibantu_skor_maksimum(): void
    {
        $sekolah = $this->buatSekolah(statusBantuan: 'Belum pernah menerima bantuan');
        $this->assertSame(5, $this->konversi->konversi($sekolah)['C4']);
    }

    /** Sekolah perkotaan mudah diakses => C5 = 1. */
    public function test_akses_mudah_skor_rendah(): void
    {
        $sekolah = $this->buatSekolah(sosekbud: [
            'kondisi_geografis' => 'Berada di pusat perkotaan',
            'akses_transportasi' => 'Mudah dijangkau kendaraan umum',
        ]);
        $this->assertSame(1, $this->konversi->konversi($sekolah)['C5']);
    }

    /** Semua skor selalu berada pada rentang 1-5. */
    public function test_semua_skor_dalam_rentang_valid(): void
    {
        $sekolah = $this->buatSekolah(
            sekolah: ['jum_siswa_pria' => '120', 'jum_siswa_wanita' => '130', 'status_akreditasi' => 'B'],
            fasilitas: [
                'listrik_status' => 'ada', 'listrik_durasi' => '10 jam',
                'labkom_status' => 'ada', 'internet_status' => 'ada',
                'internet_kesesuaian' => 'cukup sesuai', 'internet_bandwith' => '20 Mbps',
            ],
            labs: [['labkom_jumlah_pc' => '15']],
            statusBantuan: 'pernah dibantu 2019',
            sosekbud: ['kondisi_geografis' => 'daerah terpencil', 'akses_transportasi' => 'terbatas']
        );

        foreach ($this->konversi->konversi($sekolah) as $kode => $skor) {
            $this->assertGreaterThanOrEqual(1, $skor, "{$kode} di bawah 1");
            $this->assertLessThanOrEqual(5, $skor, "{$kode} di atas 5");
        }
    }
}
