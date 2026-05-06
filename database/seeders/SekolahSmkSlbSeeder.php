<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahSmkSlbSeeder extends Seeder
{
    private function tambah(string $npsn, string $nama, string $tingkatan, string $namaKota, ?string $namaKec = null): void
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecId = $namaKec ? Kecamatan::firstOrCreate(['nama' => $namaKec, 'kota_id' => $kota->id])->id : null;

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => $tingkatan, 'kota_id' => $kota->id, 'kecamatan_id' => $kecId]
        );

        if ($sekolah->wasRecentlyCreated) {
            SekolahSosekbud::firstOrCreate(['sekolah_id' => $sekolah->id]);
            User::firstOrCreate(
                ['email' => $npsn],
                ['name' => 'Operator ' . $nama, 'password' => Hash::make($npsn), 'role' => 3, 'sekolah_id' => $sekolah->id]
            );
        }
    }

    public function run(): void
    {
        // ════════════════════════════════════════════════
        // SLB
        // ════════════════════════════════════════════════
        $this->tambah('60103980','SLB NEGERI MARLOSO','SLB','Kabupaten Buru','Namlea');
        $this->tambah('69786774','SLB NEGERI NAMROLE','SLB','Kabupaten Buru Selatan','Namrole');
        $this->tambah('69984910','SLB NEGERI ARU','SLB','Kabupaten Kepulauan Aru','Pulau-pulau Aru');
        $this->tambah('60102350','SLBS KARTINI SAUMLAKI','SLB','Kabupaten Maluku Tenggara Barat','Tanimbar Selatan');
        $this->tambah('60100723','SLB NEGERI MASOHI','SLB','Kabupaten Maluku Tengah','Amahai');
        $this->tambah('60103471','SLB NEGERI HARURU','SLB','Kabupaten Maluku Tengah','Leihitu');
        $this->tambah('69862415','SLB NEGERI LANGGUR','SLB','Kabupaten Maluku Tenggara','Kei Kecil');
        $this->tambah('69866254','SLB NEGERI PIRU','SLB','Kabupaten Seram Bagian Barat','Kairatu');
        $this->tambah('69786770','SLB ABCD LELEANI 2','SLB','Kota Ambon','Sirimau');
        $this->tambah('60102576','SLB KARYA KASIH','SLB','Kota Ambon','Nusaniwe');
        $this->tambah('60102578','SLB NEGERI KOTA AMBON','SLB','Kota Ambon','Sirimau');
        $this->tambah('69922560','SLB PELITA KASIH','SLB','Kota Ambon','Sirimau');
        $this->tambah('60102577','SLBS ABC LELEANI 1 AMBON','SLB','Kota Ambon','Nusaniwe');
        $this->tambah('76006907','SLB NEGERI TUAL','SLB','Kota Tual','Pulau Dullah Selatan');

        // ════════════════════════════════════════════════
        // SMK — KAB. BURU
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Buru';
        $this->tambah('60103635','SMK NEGERI 3 BURU','SMK',$k,'Namlea');
        $this->tambah('60103998','SMK NEGERI 4 BURU','SMK',$k,'Namlea');
        $this->tambah('69775703','SMK NEGERI 5 BURU','SMK',$k,'Waeapo');
        $this->tambah('69659382','SMK NEGERI 6 BURU','SMK',$k,'Lilialy');
        $this->tambah('69900613','SMK NEGERI 7 BURU','SMK',$k,'Airbuaya');
        $this->tambah('69650965','SMK NEGERI 8 BURU','SMK',$k,'Waelata');
        $this->tambah('69922326','SMK NEGERI 10 BURU','SMK',$k,'Namlea');

        // ════════════════════════════════════════════════
        // SMK — KAB. BURU SELATAN
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Buru Selatan';
        $this->tambah('60103374','SMK NEGERI 1 BURU SELATAN','SMK',$k,'Namrole');
        $this->tambah('60103429','SMK NEGERI 2 BURU SELATAN','SMK',$k,'Leksula');
        $this->tambah('60103929','SMK NEGERI 3 BURU SELATAN','SMK',$k,'Ambalau');
        $this->tambah('60103981','SMK NEGERI 4 BURU SELATAN','SMK',$k,'Kepala Madan');
        $this->tambah('60103992','SMK NEGERI 5 BURU SELATAN','SMK',$k,'Waesama');
        $this->tambah('60724631','SMK NEGERI 6 BURU SELATAN','SMK',$k,'Leksula');
        $this->tambah('69728666','SMK NEGERI 7 BURU SELATAN','SMK',$k,'Namrole');
        $this->tambah('69824466','SMK NEGERI 9 BURU SELATAN','SMK',$k,'Leksula');
        $this->tambah('69821214','SMKN NALBESSY','SMK',$k,'Namrole');

        // ════════════════════════════════════════════════
        // SMK — KAB. KEPULAUAN ARU
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Kepulauan Aru';
        $this->tambah('60101798','SMK NEGERI 1 DOBO','SMK',$k,'Pulau-pulau Aru');
        $this->tambah('69949674','SMK NEGERI 2 KEPULAUAN ARU','SMK',$k,'Aru Selatan');
        $this->tambah('60101807','SMK ARAFURA DOBO','SMK',$k,'Pulau-pulau Aru');
        $this->tambah('60101799','SMK JELAKAIKA DOBO','SMK',$k,'Pulau-pulau Aru');
        $this->tambah('60101806','SMKS PGRI DOBO','SMK',$k,'Pulau-pulau Aru');
        $this->tambah('69815443','SMK KESEHATAN JARSARA DOBO','SMK',$k,'Pulau-pulau Aru');

        // ════════════════════════════════════════════════
        // SMK — KAB. MALUKU TENGGARA BARAT (TANIMBAR)
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Maluku Tenggara Barat';
        $this->tambah('60101451','SMK NEGERI 1 KEPULAUAN TANIMBAR','SMK',$k,'Tanimbar Selatan');
        $this->tambah('60101459','SMK NEGERI 2 KEPULAUAN TANIMBAR','SMK',$k,'Nirunmas');
        $this->tambah('60102736','SMK NEGERI 5 KEPULAUAN TANIMBAR','SMK',$k,'Tanimbar Selatan');
        $this->tambah('60105436','SMK NEGERI 6 KEPULAUAN TANIMBAR','SMK',$k,'Tanimbar Utara');
        $this->tambah('69902278','SMK NEGERI 7 KEPULAUAN TANIMBAR','SMK',$k,'Tanimbar Selatan');
        $this->tambah('60101458','SMKS MAKULATA SAUMLAKI','SMK',$k,'Tanimbar Selatan');

        // ════════════════════════════════════════════════
        // SMK — KAB. MALUKU BARAT DAYA
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Maluku Barat Daya';
        $this->tambah('60101332','SMK NEGERI 1 MALUKU BARAT DAYA','SMK',$k,'Wetar');
        $this->tambah('60102375','SMK NEGERI 2 MALUKU BARAT DAYA','SMK',$k,'Pulau-pulau Babar');
        $this->tambah('60103080','SMK NEGERI 3 MALUKU BARAT DAYA','SMK',$k,'Damer');
        $this->tambah('60103088','SMK NEGERI 4 MALUKU BARAT DAYA','SMK',$k,'Moa Lakor');
        $this->tambah('69772520','SMK NEGERI 7 MALUKU BARAT DAYA','SMK',$k,'Wetar');
        $this->tambah('69772521','SMK NEGERI 8 MALUKU BARAT DAYA','SMK',$k,'Wetar Timur');
        $this->tambah('60103861','SMKN MDONA HEYRA','SMK',$k,'Mdona Hyera');
        $this->tambah('60103852','SMKN PETERNAKAN DAN PERTANIAN MULA','SMK',$k,'Pulau-pulau Babar');
        $this->tambah('69699240','SMK PGRI AHANARI','SMK',$k,'Wetar');
        $this->tambah('60102304','SMKN SEIRA','SMK',$k,'Dawelor Dawera');

        // ════════════════════════════════════════════════
        // SMK — KAB. MALUKU TENGAH
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Maluku Tengah';
        $this->tambah('60100168','SMK NEGERI 2 MALUKU TENGAH','SMK',$k,'Amahai');
        $this->tambah('60100189','SMK NEGERI 3 MALUKU TENGAH','SMK',$k,'Salahutu');
        $this->tambah('60100353','SMK NEGERI 4 MALUKU TENGAH','SMK',$k,'Leihitu');
        $this->tambah('60102291','SMK NEGERI 5 MALUKU TENGAH','SMK',$k,'Saparua');
        $this->tambah('60103508','SMK NEGERI 6 MALUKU TENGAH','SMK',$k,'Seram Utara');
        $this->tambah('69770334','SMK NEGERI 9 MALUKU TENGAH','SMK',$k,'Amahai');
        $this->tambah('60100972','SMK NEGERI 10 MALUKU TENGAH','SMK',$k,'Amahai');
        $this->tambah('69631987','SMK NEGERI 11 MALUKU TENGAH','SMK',$k,'Leihitu');
        $this->tambah('60100613','SMKN 2 SAPARUA','SMK',$k,'Saparua');
        $this->tambah('60103610','SMK SERAM UTARA BARAT','SMK',$k,'Seram Utara Barat');
        $this->tambah('60100167','SMKS MUHAMMADIYAH MASOHI','SMK',$k,'Amahai');
        $this->tambah('60103612','SMKS PARIWISATA PAMAHANU-NUSA','SMK',$k,'Saparua');
        $this->tambah('60105434','SMKS RIJALI SALAHUTU','SMK',$k,'Salahutu');
        $this->tambah('70011890','SMK KASIH THERESIA','SMK',$k,'Amahai');

        // ════════════════════════════════════════════════
        // SMK — KAB. MALUKU TENGGARA
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Maluku Tenggara';
        $this->tambah('60100234','SMK KESEHATAN LANGGUR','SMK',$k,'Kei Kecil');
        $this->tambah('69621599','SMK KESEHATAN USWED CHOI DIAN DATA','SMK',$k,'Kei Kecil');
        $this->tambah('60900072','SMK MITRA KARYA','SMK',$k,'Kei Kecil');
        $this->tambah('69900136','SMK MUHAMMADIYAH WAIN','SMK',$k,'Kei Kecil');
        $this->tambah('60100827','SMK PARIWISATA SANTA THERESIA LANGGUR','SMK',$k,'Kei Kecil');
        $this->tambah('60100826','SMK SIWA LIMA ST. JOSEPH LANGGUR','SMK',$k,'Kei Kecil');
        $this->tambah('69621558','SMK TEKNOLOGI AZZAHRAH','SMK',$k,'Kei Kecil');

        // ════════════════════════════════════════════════
        // SMK — KAB. SERAM BAGIAN BARAT
        // ════════════════════════════════════════════════
        $k = 'Kabupaten Seram Bagian Barat';
        $this->tambah('60102780','SMKN 1 SERAM BARAT','SMK',$k,'Seram Barat');
        $this->tambah('60102896','SMKN 2 SERAM BARAT','SMK',$k,'Kairatu');

        // ════════════════════════════════════════════════
        // SMK — KOTA AMBON
        // ════════════════════════════════════════════════
        $k = 'Kota Ambon';
        $this->tambah('60102576','SMK KARYA KASIH AMBON','SMK',$k,'Nusaniwe');
    }
}
