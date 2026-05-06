<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder7 extends Seeder
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
        // ── KAB. SERAM BAGIAN BARAT (SMA Negeri & Swasta tambahan) ──────────
        $k = 'Kabupaten Seram Bagian Barat';
        $this->tambah('60102473','SMA NEGERI 27 SERAM BAGIAN BARAT','SMA',$k,'Huamual Belakang');
        $this->tambah('60102707','SMAS AL-FIKRI TALAGA PIRU','SMA',$k,'Seram Barat');
        $this->tambah('60102708','SMAS HUAMUAL BARAT TALAGA','SMA',$k,'Huamual Belakang');
        $this->tambah('60102474','SMAS MUHAMMADIYAH IMBRO','SMA',$k,'Huamual');
        $this->tambah('60101537','SMAS MUHAMMADIYAH LUHU','SMA',$k,'Huamual');
        $this->tambah('60102895','SMAS PGRI 2 KAIRATU','SMA',$k,'Kairatu');
        $this->tambah('60102717','SMAS PGRI 3 KAIRATU','SMA',$k,'Kairatu');
        $this->tambah('60102897','SMAS PGRI 4 KAIRATU','SMA',$k,'Kairatu');
        $this->tambah('60101538','SMAS PGRI PELITA JAYA','SMA',$k,'Kairatu');

        // ── KAB. SERAM BAGIAN TIMUR (SMA Swasta tambahan) ───────────────────
        $k = 'Kabupaten Seram Bagian Timur';
        $this->tambah('69643089','SMA INSAN CITA KWAOS','SMA',$k,'Pulau-pulau Gorom');

        // ── KOTA AMBON (SMAN 12 yang belum masuk) ───────────────────────────
        $k = 'Kota Ambon';
        $this->tambah('60103097','SMA NEGERI 12 AMBON','SMA',$k,'Sirimau');

        // ── KAB. BURU (SMK Negeri 1 & 2 yang belum masuk) ───────────────────
        $k = 'Kabupaten Buru';
        $this->tambah('60100971','SMK NEGERI 1 BURU','SMK',$k,'Namlea');
        $this->tambah('60103377','SMK NEGERI 2 BURU','SMK',$k,'Namlea');

        // ── KAB. SERAM BAGIAN BARAT (SMK tambahan) ──────────────────────────
        $k = 'Kabupaten Seram Bagian Barat';
        $this->tambah('60102895','SMKS PGRI 2 KAIRATU','SMK',$k,'Kairatu');
    }
}
