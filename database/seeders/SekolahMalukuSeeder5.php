<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder5 extends Seeder
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
        // ── KAB. MALUKU TENGAH (SMA Swasta) ─────────────────────────────────
        $kota = 'Kabupaten Maluku Tengah';
        $this->tambah('60102238','SMAS AL-HILAL TEHORU',$kota,'Tehoru');
        $this->tambah('60100343','SMAS KRISTEN AMAHAI',$kota,'Amahai');
        $this->tambah('60100347','SMAS MATHLAUL ANWAR MASOHI',$kota,'Amahai');
        $this->tambah('60103515','SMAS MUHAMMADIYAH MAMALA',$kota,'Leihitu');
        $this->tambah('60100348','SMAS MUHAMMADIYAH MASOHI',$kota,'Amahai');
        $this->tambah('60100244','SMAS MUHAMMADIYAH ULONG SAWAI',$kota,'Seram Utara');
        $this->tambah('60100349','SMAS MUHAMMADIYAH SEPA',$kota,'Teluti');
        $this->tambah('60100247','SMAS NAMBUSA TULEHU',$kota,'Salahutu');
        $this->tambah('60100351','SMAS PGRI 1 SAPARUA',$kota,'Saparua');
        $this->tambah('60100314','SMAS PGRI OMA HARUKU',$kota,'Pulau Haruku');
        $this->tambah('60100332','SMAS TOS SOEDARSO MASOHI',$kota,'Amahai');
        $this->tambah('60103515','SMAS MUHAMMADIYAH MAMALA',$kota,'Leihitu');
        $this->tambah('60100341','SMAS NONA MILA MASOHI',$kota,'Amahai');
        $this->tambah('60100350','SMAS PGRI OMA HARUKU',$kota,'Pulau Haruku');

        // ── KAB. MALUKU TENGGARA (SMA Swasta) ───────────────────────────────
        $kota = 'Kabupaten Maluku Tenggara';
        $this->tambah('60100618','SMA SANATA KARYA LANGGUR',$kota,'Kei Kecil');
        $this->tambah('60100898','SMA SEMINARI ST YUDAS THADEUS LANGGUR',$kota,'Kei Kecil');
        $this->tambah('60103014','SMA AL-HILAL KEI KECIL',$kota,'Kei Kecil');
        $this->tambah('69870788','SMA KRISTEN ANUGERAH',$kota,'Kei Kecil');

        // ── KAB. SERAM BAGIAN BARAT (SMA Swasta) ────────────────────────────
        $kota = 'Kabupaten Seram Bagian Barat';
        $this->tambah('69965201','SMA IGRO AMAHOLU',$kota,'Huamual');
        $this->tambah('69960793','SMA MUHAMMADIYAH KELAPA DUA',$kota,'Kairatu');
        $this->tambah('60906754','SMA MUHAMMADIYAH PATINEA',$kota,'Kairatu');

        // ── KAB. MALUKU TENGAH (SMA Swasta dari halaman 9 tambahan) ─────────
        $kota = 'Kabupaten Maluku Tengah';
        $this->tambah('60100248','SMAS MUHAMMADIYAH TULEHU',$kota,'Salahutu');
        $this->tambah('60100352','SMAS KRISTEN 1 SAPARUA',$kota,'Saparua');
        $this->tambah('60103507','SMAS TRANA TNS',$kota,'Teon Nila Serua');
        $this->tambah('60103515','SMAS MUHAMMADIYAH MAMALA',$kota,'Leihitu');
    }
}
