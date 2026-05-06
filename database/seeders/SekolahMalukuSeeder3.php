<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder3 extends Seeder
{
    private function tambah(string $npsn, string $nama, string $namaKota, ?string $namaKec = null): void
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecId = null;
        if ($namaKec) {
            $kecId = Kecamatan::firstOrCreate(['nama' => $namaKec, 'kota_id' => $kota->id])->id;
        }

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => 'SMA', 'kota_id' => $kota->id, 'kecamatan_id' => $kecId]
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
        // ── KAB. BURU ────────────────────────────────────────────────────────
        $kota = 'Kabupaten Buru';
        $this->tambah('60103372','SMA NEGERI 1 BURU',$kota,'Namlea');
        $this->tambah('60101016','SMA NEGERI 2 BURU',$kota,'Namlea');
        $this->tambah('60101015','SMA NEGERI 3 BURU',$kota,'Namlea');
        $this->tambah('60100979','SMA NEGERI 4 BURU',$kota,'Waelata');
        $this->tambah('60100977','SMA NEGERI 5 BURU',$kota,'Waeapo');
        $this->tambah('60100997','SMA NEGERI 6 BURU',$kota,'Lilialy');
        $this->tambah('60100973','SMA NEGERI 8 BURU',$kota,'Namlea');
        $this->tambah('60103375','SMA NEGERI 9 BURU',$kota,'Teluk Kaiely');
        $this->tambah('69856923','SMA NEGERI 11 BURU',$kota,'Waplau');
        $this->tambah('69900165','SMA NEGERI 12 BURU',$kota,'Lolong Guba');
        $this->tambah('69953439','SMA NEGERI 13 BURU',$kota,'Fena Leisela');
        $this->tambah('60101017','SMA TARBIYAH AIRBUAYA',$kota,'Airbuaya');
        $this->tambah('69980082','SMA MUHAMMADIYAH TANJUNG KARANG',$kota,'Namlea');

        // ── KOTA AMBON ───────────────────────────────────────────────────────
        $kota = 'Kota Ambon';
        $this->tambah('60102008','SMA NEGERI 1 AMBON',$kota,'Sirimau');
        $this->tambah('60102006','SMA NEGERI 2 AMBON',$kota,'Sirimau');
        $this->tambah('60102005','SMA NEGERI 3 AMBON',$kota,'Nusaniwe');
        $this->tambah('60102004','SMA NEGERI 4 AMBON',$kota,'Nusaniwe');
        $this->tambah('60102002','SMA NEGERI 5 AMBON',$kota,'Sirimau');
        $this->tambah('60102013','SMA NEGERI 6 AMBON',$kota,'Teluk Ambon');
        $this->tambah('60102014','SMA NEGERI 7 AMBON',$kota,'Nusaniwe');
        $this->tambah('60102015','SMA NEGERI 8 AMBON',$kota,'Sirimau');
        $this->tambah('60102025','SMA NEGERI 9 AMBON',$kota,'Teluk Ambon');
        $this->tambah('60102007','SMA NEGERI 10 AMBON',$kota,'Sirimau');
        $this->tambah('60102965','SMA NEGERI 11 AMBON',$kota,'Nusaniwe');
        $this->tambah('60102966','SMA NEGERI 13 AMBON',$kota,'Sirimau');
        $this->tambah('60103406','SMA NEGERI 14 AMBON',$kota,'Teluk Ambon Baguala');
        $this->tambah('69933068','SMA NEGERI 15 AMBON',$kota,'Leitimur Selatan');
        $this->tambah('60103098','SMAN SIWALIMA AMBON',$kota,'Sirimau');
        $this->tambah('60102003','SMA SWASTA 45 AMBON',$kota,'Sirimau');
        $this->tambah('60102016','SMA XAVERIUS AMBON',$kota,'Nusaniwe');
        $this->tambah('60103095','SMA KRISTEN PASSO',$kota,'Teluk Ambon Baguala');
        $this->tambah('60102967','SMA PGRI I AMBON',$kota,'Sirimau');
        $this->tambah('70039001','SMA AS-SALAM AMBON',$kota,'Sirimau');

        // ── KAB. SERAM BAGIAN TIMUR (tambahan) ──────────────────────────────
        $kota = 'Kabupaten Seram Bagian Timur';
        $this->tambah('70034784','SMA NEGERI 16 SERAM BAGIAN TIMUR',$kota,'Seram Timur');
        $this->tambah('69867920','SMA PERSIAPAN WATUBELA',$kota,'Pulau-pulau Gorom');
        $this->tambah('60101660','SMA MUHAMMADIYAH ATIAHU',$kota,'Bula');
        $this->tambah('60103628','SMAS NAFIRI UKAR SENGN',$kota,'Seram Timur');

        // ── KOTA TUAL (tambahan swasta) ──────────────────────────────────────
        $kota = 'Kota Tual';
        $this->tambah('60105446','SMAS MUHAMMADIYAH TUAL',$kota,'Pulau Dullah Selatan');
        $this->tambah('60103319','SMA TERPADU AL-IKHLAS TUAL',$kota,'Tayando Tam');
    }
}
