<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder extends Seeder
{
    private function kec(string $nama, string $namaKota): ?int
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecamatan = Kecamatan::firstOrCreate(['nama' => $nama, 'kota_id' => $kota->id]);
        return $kecamatan->id;
    }

    private function kota(string $nama): ?int
    {
        return Kota::firstOrCreate(['nama' => $nama])->id;
    }

    private function tambah(string $npsn, string $nama, string $namaKota, string $namaKec): void
    {
        $kotaId = $this->kota($namaKota);
        $kecId  = $this->kec($namaKec, $namaKota);

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => 'SMA', 'kota_id' => $kotaId, 'kecamatan_id' => $kecId]
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
        // ── KOTA TUAL ────────────────────────────────────────────────────────
        $kota = 'Kota Tual';
        $this->tambah('60100819','SMA NEGERI 1 KOTA TUAL',$kota,'Pulau Dullah Selatan');
        $this->tambah('60102292','SMA NEGERI 2 KOTA TUAL',$kota,'Kur Selatan');
        $this->tambah('60103318','SMA NEGERI 3 KOTA TUAL',$kota,'Tayando Tam');
        $this->tambah('60103463','SMA NEGERI 4 KOTA TUAL',$kota,'Pulau Dullah Utara');
        $this->tambah('69761907','SMA NEGERI 5 KOTA TUAL',$kota,'Pulau Dullah Selatan');
        $this->tambah('69849368','SMA NEGERI 6 KOTA TUAL',$kota,'Pulau Dullah Utara');
        $this->tambah('69849369','SMA NEGERI 7 KOTA TUAL',$kota,'Pulau Dullah Selatan');

        // ── KABUPATEN MALUKU TENGAH ──────────────────────────────────────────
        $kota = 'Kabupaten Maluku Tengah';
        $this->tambah('60100153','SMA NEGERI 1 MALUKU TENGAH',$kota,'Banda');
        $this->tambah('60100157','SMA NEGERI 2 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('60100159','SMA NEGERI 3 MALUKU TENGAH',$kota,'Salahutu');
        $this->tambah('60100161','SMA NEGERI 4 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('60100164','SMA NEGERI 5 MALUKU TENGAH',$kota,'Salahutu');
        $this->tambah('60100313','SMA NEGERI 6 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('60100315','SMA NEGERI 7 MALUKU TENGAH',$kota,'Saparua');
        $this->tambah('60100316','SMA NEGERI 8 MALUKU TENGAH',$kota,'Seram Utara');
        $this->tambah('60100317','SMA NEGERI 9 MALUKU TENGAH',$kota,'Tehoru');
        $this->tambah('60100319','SMA NEGERI 10 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('60100320','SMA NEGERI 11 MALUKU TENGAH',$kota,'Pulau Haruku');
        $this->tambah('60100321','SMA NEGERI 12 MALUKU TENGAH',$kota,'Saparua Timur');
        $this->tambah('60100322','SMA NEGERI 13 MALUKU TENGAH',$kota,'Seram Utara Timur Seti');
        $this->tambah('60100324','SMA NEGERI 14 MALUKU TENGAH',$kota,'Leihitu Barat');
        $this->tambah('60100325','SMA NEGERI 15 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('60100326','SMA NEGERI 16 MALUKU TENGAH',$kota,'Pulau Haruku');
        $this->tambah('60100327','SMA NEGERI 17 MALUKU TENGAH',$kota,'Teon Nila Serua');
        $this->tambah('60100346','SMA NEGERI 18 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('60102240','SMA NEGERI 19 MALUKU TENGAH',$kota,'Pulau Haruku');
        $this->tambah('60102244','SMA NEGERI 20 MALUKU TENGAH',$kota,'Seram Utara Barat');
        $this->tambah('60102245','SMA NEGERI 21 MALUKU TENGAH',$kota,'Teluti');
        $this->tambah('60102249','SMA NEGERI 22 MALUKU TENGAH',$kota,'Salahutu');
        $this->tambah('60103505','SMA NEGERI 23 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('60103506','SMA NEGERI 24 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('60103509','SMA NEGERI 25 MALUKU TENGAH',$kota,'Tehoru');
        $this->tambah('60103512','SMA NEGERI 26 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('60103513','SMA NEGERI 27 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('60103514','SMA NEGERI 28 MALUKU TENGAH',$kota,'Leihitu Barat');
        $this->tambah('60103517','SMA NEGERI 29 MALUKU TENGAH',$kota,'Teluti');
        $this->tambah('60103518','SMA NEGERI 30 MALUKU TENGAH',$kota,'Banda');
        $this->tambah('60103611','SMA NEGERI 31 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('60103737','SMA NEGERI 32 MALUKU TENGAH',$kota,'Tehoru');
        $this->tambah('60104031','SMA NEGERI 33 MALUKU TENGAH',$kota,'Seram Utara Timur Seti');
        $this->tambah('60104032','SMA NEGERI 34 MALUKU TENGAH',$kota,'Nusalaut');
        $this->tambah('60104038','SMA NEGERI 35 MALUKU TENGAH',$kota,'Seram Utara Timur Kobi');
        $this->tambah('69770333','SMA NEGERI 36 MALUKU TENGAH',$kota,'Seram Utara');
        $this->tambah('69774664','SMA NEGERI 37 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('69774665','SMA NEGERI 38 MALUKU TENGAH',$kota,'Leihitu Barat');
        $this->tambah('69774666','SMA NEGERI 39 MALUKU TENGAH',$kota,'Salahutu');
        $this->tambah('69774667','SMA NEGERI 40 MALUKU TENGAH',$kota,'Saparua Timur');
        $this->tambah('69774668','SMA NEGERI 41 MALUKU TENGAH',$kota,'Saparua');
        $this->tambah('69774669','SMA NEGERI 42 MALUKU TENGAH',$kota,'Saparua');
        $this->tambah('69774670','SMA NEGERI 43 MALUKU TENGAH',$kota,'Pulau Haruku');
        $this->tambah('69775663','SMA NEGERI 44 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('69822771','SMA NEGERI 45 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('69822772','SMA NEGERI 46 MALUKU TENGAH',$kota,'Teluti');
        $this->tambah('69822773','SMA NEGERI 47 MALUKU TENGAH',$kota,'Salahutu');
        $this->tambah('69822774','SMA NEGERI 48 MALUKU TENGAH',$kota,'Amahai');
        $this->tambah('69831985','SMA NEGERI 49 MALUKU TENGAH',$kota,'Seram Utara Barat');
        $this->tambah('69832004','SMA NEGERI 50 MALUKU TENGAH',$kota,'Teluk Elpaputih');
        $this->tambah('69870670','SMA NEGERI 51 MALUKU TENGAH',$kota,'Tehoru');
        $this->tambah('69870898','SMA NEGERI 52 MALUKU TENGAH',$kota,'Banda');
        $this->tambah('69937935','SMA NEGERI 53 MALUKU TENGAH',$kota,'Leihitu Barat');
        $this->tambah('69937940','SMA NEGERI 54 MALUKU TENGAH',$kota,'Teluk Elpaputih');
        $this->tambah('69937942','SMA NEGERI 55 MALUKU TENGAH',$kota,'Teluk Elpaputih');
        $this->tambah('69937943','SMA NEGERI 56 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('69938216','SMA NEGERI 57 MALUKU TENGAH',$kota,'Leihitu Barat');
        $this->tambah('69940233','SMA NEGERI 58 MALUKU TENGAH',$kota,'Seram Utara Timur Kobi');
        $this->tambah('69947368','SMA NEGERI 59 MALUKU TENGAH',$kota,'Tehoru');
        $this->tambah('69947434','SMA NEGERI 60 MALUKU TENGAH',$kota,'Seram Utara');
        $this->tambah('69947454','SMA NEGERI 61 MALUKU TENGAH',$kota,'Teon Nila Serua');
        $this->tambah('69947867','SMA NEGERI 62 MALUKU TENGAH',$kota,'Leihitu');
        $this->tambah('69949714','SMA NEGERI 63 MALUKU TENGAH',$kota,'Pulau Haruku');

        // ── KABUPATEN MALUKU TENGGARA ────────────────────────────────────────
        $kota = 'Kabupaten Maluku Tenggara';
        $this->tambah('60100817','SMA NEGERI 1 MALUKU TENGGARA',$kota,'Kei Besar');
        $this->tambah('60100818','SMA NEGERI 2 MALUKU TENGGARA',$kota,'Kei Kecil');
        $this->tambah('60100820','SMA NEGERI 3 MALUKU TENGGARA',$kota,'Kei Kecil');
        $this->tambah('60103317','SMA NEGERI 4 MALUKU TENGGARA',$kota,'Kei Kecil Barat');
        $this->tambah('60103320','SMA NEGERI 5 MALUKU TENGGARA',$kota,'Kei Kecil Timur Selatan');
        $this->tambah('60103632','SMA NEGERI 6 MALUKU TENGGARA',$kota,'Kei Besar Utara Timur');
        $this->tambah('60103646','SMA NEGERI 7 MALUKU TENGGARA',$kota,'Kei Besar');
        $this->tambah('60103647','SMA NEGERI 8 MALUKU TENGGARA',$kota,'Kei Besar Selatan');
        $this->tambah('60103895','SMA NEGERI 9 MALUKU TENGGARA',$kota,'Kei Besar Utara Timur');
        $this->tambah('69893230','SMA NEGERI 10 MALUKU TENGGARA',$kota,'Hoat Sorbay');
        $this->tambah('69893231','SMA NEGERI 11 MALUKU TENGGARA',$kota,'Kei Kecil Timur');

        // ── KABUPATEN MALUKU TENGGARA BARAT (KEPULAUAN TANIMBAR) ─────────────
        $kota = 'Kabupaten Maluku Tenggara Barat';
        $this->tambah('60101330','SMA NEGERI 1 KEPULAUAN TANIMBAR',$kota,'Nirunmas');
        $this->tambah('60101438','SMA NEGERI 2 KEPULAUAN TANIMBAR',$kota,'Tanimbar Selatan');
        $this->tambah('60101443','SMA NEGERI 3 KEPULAUAN TANIMBAR',$kota,'Nirunmas');
        $this->tambah('60101465','SMA NEGERI 4 KEPULAUAN TANIMBAR',$kota,'Wermaktian');
        $this->tambah('60102374','SMA NEGERI 5 KEPULAUAN TANIMBAR',$kota,'Selaru');
        $this->tambah('60103079','SMA NEGERI 6 KEPULAUAN TANIMBAR',$kota,'Wuarlabobar');
        $this->tambah('60103400','SMA NEGERI 7 KEPULAUAN TANIMBAR',$kota,'Tanimbar Utara');
        $this->tambah('60103695','SMA NEGERI 8 KEPULAUAN TANIMBAR',$kota,'Tanimbar Selatan');
        $this->tambah('60103897','SMA NEGERI 9 KEPULAUAN TANIMBAR',$kota,'Yaru');
        $this->tambah('60105301','SMA NEGERI 10 KEPULAUAN TANIMBAR',$kota,'Tanimbar Selatan');
        $this->tambah('60105312','SMA NEGERI 11 KEPULAUAN TANIMBAR',$kota,'Kormomolin');
        $this->tambah('60105429','SMA NEGERI 12 KEPULAUAN TANIMBAR',$kota,'Tanimbar Utara');
        $this->tambah('60724705','SMA NEGERI 13 KEPULAUAN TANIMBAR',$kota,'Wermaktian');
        $this->tambah('60724708','SMA NEGERI 14 KEPULAUAN TANIMBAR',$kota,'Molu Maru');
        $this->tambah('69949130','SMA NEGERI 15 KEPULAUAN TANIMBAR',$kota,'Nirunmas');
        $this->tambah('69989359','SMA NEGERI 16 KEPULAUAN TANIMBAR',$kota,'Wermaktian');

        // ── KABUPATEN KEPULAUAN ARU ──────────────────────────────────────────
        $kota = 'Kabupaten Kepulauan Aru';
        $this->tambah('60101787','SMA NEGERI 1 KEPULAUAN ARU',$kota,'Pulau-pulau Aru');
        $this->tambah('60101800','SMA NEGERI 2 KEPULAUAN ARU',$kota,'Aru Selatan');

        // ── KABUPATEN SERAM BAGIAN TIMUR ─────────────────────────────────────
        $kota = 'Kabupaten Seram Bagian Timur';
        $this->tambah('60101661','SMA NEGERI 1 SERAM BAGIAN TIMUR',$kota,'Bula');
        $this->tambah('60101667','SMA NEGERI 2 SERAM BAGIAN TIMUR',$kota,'Seram Timur');
        $this->tambah('60101668','SMA NEGERI 3 SERAM BAGIAN TIMUR',$kota,'Werinama');
        $this->tambah('60101669','SMA NEGERI 4 SERAM BAGIAN TIMUR',$kota,'Pulau-pulau Gorom');
        $this->tambah('60102519','SMA NEGERI 5 SERAM BAGIAN TIMUR',$kota,'Bula');
        $this->tambah('60102520','SMA NEGERI 6 SERAM BAGIAN TIMUR',$kota,'Tutuk Tolu');
        $this->tambah('60102957','SMA NEGERI 7 SERAM BAGIAN TIMUR',$kota,'Wakate');
        $this->tambah('60102958','SMA NEGERI 8 SERAM BAGIAN TIMUR',$kota,'Gorom Timur');
        $this->tambah('60102959','SMA NEGERI 9 SERAM BAGIAN TIMUR',$kota,'Kian Darat');
        $this->tambah('60102960','SMA NEGERI 10 SERAM BAGIAN TIMUR',$kota,'Gorom Timur');
        $this->tambah('60103879','SMA NEGERI 11 SERAM BAGIAN TIMUR',$kota,'Pulau-pulau Gorom');
        $this->tambah('69725963','SMA NEGERI 12 SERAM BAGIAN TIMUR',$kota,'Siwalalat');
        $this->tambah('69822777','SMA NEGERI 13 SERAM BAGIAN TIMUR',$kota,'Teluk Waru');
        $this->tambah('69872005','SMA NEGERI 14 SERAM BAGIAN TIMUR',$kota,'Teor');
        $this->tambah('69878241','SMA NEGERI 15 SERAM BAGIAN TIMUR',$kota,'Kilmury');

        // ── KABUPATEN BURU SELATAN ───────────────────────────────────────────
        $kota = 'Kabupaten Buru Selatan';
        $this->tambah('60100974','SMA NEGERI 1 BURU SELATAN',$kota,'Waesama');
        $this->tambah('60100976','SMA NEGERI 2 BURU SELATAN',$kota,'Ambalau');
        $this->tambah('60100978','SMA NEGERI 3 BURU SELATAN',$kota,'Leksula');
        $this->tambah('60100980','SMA NEGERI 4 BURU SELATAN',$kota,'Kepala Madan');
        $this->tambah('60100981','SMA NEGERI 5 BURU SELATAN',$kota,'Ambalau');
        $this->tambah('60101018','SMA NEGERI 6 BURU SELATAN',$kota,'Waesama');
        $this->tambah('60101019','SMA NEGERI 7 BURU SELATAN',$kota,'Namrole');
        $this->tambah('60103989','SMA NEGERI 8 BURU SELATAN',$kota,'Leksula');
        $this->tambah('60725087','SMA NEGERI 9 BURU SELATAN',$kota,'Leksula');
        $this->tambah('69728727','SMA NEGERI 10 BURU SELATAN',$kota,'Namrole');
        $this->tambah('69728728','SMA NEGERI 11 BURU SELATAN',$kota,'Leksula');
        $this->tambah('69886265','SMA NEGERI 12 BURU SELATAN',$kota,'Kepala Madan');
        $this->tambah('69920547','SMA NEGERI 13 BURU SELATAN',$kota,'Kepala Madan');
        $this->tambah('69940652','SMA NEGERI 14 BURU SELATAN',$kota,'Namrole');

        // ── KABUPATEN SERAM BAGIAN BARAT ─────────────────────────────────────
        $kota = 'Kabupaten Seram Bagian Barat';
        $this->tambah('60101529','SMA NEGERI 1 SERAM BAGIAN BARAT',$kota,'Kairatu');
        $this->tambah('60101530','SMA NEGERI 2 SERAM BAGIAN BARAT',$kota,'Kairatu Barat');
        $this->tambah('60101540','SMA NEGERI 3 SERAM BAGIAN BARAT',$kota,'Seram Barat');
        $this->tambah('60101541','SMA NEGERI 4 SERAM BAGIAN BARAT',$kota,'Taniwel');
        $this->tambah('60101542','SMA NEGERI 5 SERAM BAGIAN BARAT',$kota,'Huamual');
        $this->tambah('60101543','SMA NEGERI 6 SERAM BAGIAN BARAT',$kota,'Huamual');
        $this->tambah('60101560','SMA NEGERI 7 SERAM BAGIAN BARAT',$kota,'Huamual Belakang');
        $this->tambah('60102712','SMA NEGERI 8 SERAM BAGIAN BARAT',$kota,'Huamual');
        $this->tambah('60102713','SMA NEGERI 9 SERAM BAGIAN BARAT',$kota,'Huamual Belakang');
        $this->tambah('60102716','SMA NEGERI 10 SERAM BAGIAN BARAT',$kota,'Kairatu');
        $this->tambah('60102886','SMA NEGERI 11 SERAM BAGIAN BARAT',$kota,'Amalatu');
        $this->tambah('60102887','SMA NEGERI 12 SERAM BAGIAN BARAT',$kota,'Seram Barat');
        $this->tambah('60102889','SMA NEGERI 13 SERAM BAGIAN BARAT',$kota,'Kepulauan Manipa');
        $this->tambah('60102893','SMA NEGERI 14 SERAM BAGIAN BARAT',$kota,'Huamual Belakang');
        $this->tambah('60102894','SMA NEGERI 15 SERAM BAGIAN BARAT',$kota,'Amalatu');
        $this->tambah('60103465','SMA NEGERI 16 SERAM BAGIAN BARAT',$kota,'Kepulauan Manipa');
        $this->tambah('60103902','SMA NEGERI 17 SERAM BAGIAN BARAT',$kota,'Huamual Belakang');
        $this->tambah('60103903','SMA NEGERI 18 SERAM BAGIAN BARAT',$kota,'Huamual Belakang');
        $this->tambah('60103904','SMA NEGERI 19 SERAM BAGIAN BARAT',$kota,'Taniwel Timur');
        $this->tambah('60103939','SMA NEGERI 20 SERAM BAGIAN BARAT',$kota,'Elpaputih');
        $this->tambah('69772549','SMA NEGERI 21 SERAM BAGIAN BARAT',$kota,'Huamual');
        $this->tambah('69822775','SMA NEGERI 22 SERAM BAGIAN BARAT',$kota,'Kairatu');
        $this->tambah('69867932','SMA NEGERI 23 SERAM BAGIAN BARAT',$kota,'Kepulauan Manipa');
        $this->tambah('69867933','SMA NEGERI 24 SERAM BAGIAN BARAT',$kota,'Huamual');
        $this->tambah('69955228','SMA NEGERI 25 SERAM BAGIAN BARAT',$kota,'Taniwel');
        $this->tambah('69972701','SMA NEGERI 26 SERAM BAGIAN BARAT',$kota,'Huamual Belakang');
    }
}
