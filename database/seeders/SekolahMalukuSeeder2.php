<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder2 extends Seeder
{
    private function tambah(string $npsn, string $nama, string $namaKota, string $namaKec): void
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecamatan = Kecamatan::firstOrCreate(['nama' => $namaKec, 'kota_id' => $kota->id]);

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => 'SMA', 'kota_id' => $kota->id, 'kecamatan_id' => $kecamatan->id]
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
        // ── KABUPATEN KEPULAUAN ARU (lanjutan) ──────────────────────────────
        $kota = 'Kabupaten Kepulauan Aru';
        $this->tambah('60101801','SMA NEGERI 3 KEPULAUAN ARU',$kota,'Pulau-pulau Aru');
        $this->tambah('60101804','SMA NEGERI 4 KEPULAUAN ARU',$kota,'Aru Tengah');
        $this->tambah('60101805','SMA NEGERI 5 KEPULAUAN ARU',$kota,'Aru Utara Timur Batuley');
        $this->tambah('60103921','SMA NEGERI 6 KEPULAUAN ARU',$kota,'Aru Utara');
        $this->tambah('60103922','SMA NEGERI 7 KEPULAUAN ARU',$kota,'Aru Tengah Timur');
        $this->tambah('60103923','SMA NEGERI 8 KEPULAUAN ARU',$kota,'Aru Tengah Selatan');

        // ── KABUPATEN MALUKU BARAT DAYA ──────────────────────────────────────
        $kota = 'Kabupaten Maluku Barat Daya';
        $this->tambah('60101331','SMA NEGERI 1 MALUKU BARAT DAYA',$kota,'Babar Timur');
        $this->tambah('60101437','SMA NEGERI 2 MALUKU BARAT DAYA',$kota,'Damer');
        $this->tambah('60101447','SMA NEGERI 3 MALUKU BARAT DAYA',$kota,'Babar Timur');
        $this->tambah('60101448','SMA NEGERI 4 MALUKU BARAT DAYA',$kota,'Pulau-pulau Terselatan');
        $this->tambah('60101449','SMA NEGERI 5 MALUKU BARAT DAYA',$kota,'Pulau-pulau Babar');
        $this->tambah('60101460','SMA NEGERI 6 MALUKU BARAT DAYA',$kota,'Wetar');
        $this->tambah('60103191','SMA NEGERI 7 MALUKU BARAT DAYA',$kota,'Pulau-pulau Terselatan');
        $this->tambah('60103192','SMA NEGERI 8 MALUKU BARAT DAYA',$kota,'Pulau-pulau Terselatan');
        $this->tambah('60103917','SMA NEGERI 9 MALUKU BARAT DAYA',$kota,'Moa Lakor');
        $this->tambah('60103950','SMA NEGERI 10 MALUKU BARAT DAYA',$kota,'Mdona Hyera');
        $this->tambah('60103956','SMA NEGERI 11 MALUKU BARAT DAYA',$kota,'Pulau Wetang');
        $this->tambah('60105433','SMA NEGERI 12 MALUKU BARAT DAYA',$kota,'Letti');
        $this->tambah('69772524','SMA NEGERI 13 MALUKU BARAT DAYA',$kota,'Moa Lakor');
        $this->tambah('69772525','SMA NEGERI 14 MALUKU BARAT DAYA',$kota,'Lakor');
        $this->tambah('69822769','SMA NEGERI 15 MALUKU BARAT DAYA',$kota,'Wetar Timur');
        $this->tambah('69822770','SMA NEGERI 16 MALUKU BARAT DAYA',$kota,'Wetar');
        $this->tambah('69899235','SMA NEGERI 17 MALUKU BARAT DAYA',$kota,'Dawelor Dawera');
        $this->tambah('69899749','SMA NEGERI 18 MALUKU BARAT DAYA',$kota,'Damer');
        $this->tambah('69937363','SMA NEGERI 19 MALUKU BARAT DAYA',$kota,'Pulau-pulau Babar');
        $this->tambah('69974306','SMA NEGERI 20 MALUKU BARAT DAYA',$kota,'Pulau Masela');
    }
}
