<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder4 extends Seeder
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
        // ── KAB. KEPULAUAN ARU (SMA Swasta) ─────────────────────────────────
        $kota = 'Kabupaten Kepulauan Aru';
        $this->tambah('60103885','SMAS KRISTEN DOBO',$kota,'Pulau-pulau Aru');
        $this->tambah('60101803','SMAS PGRI DOBO',$kota,'Pulau-pulau Aru');
        $this->tambah('60101802','SMAS YOS SUDARSO DOBO',$kota,'Pulau-pulau Aru');

        // ── KAB. KEPULAUAN TANIMBAR (SMA Swasta) ────────────────────────────
        $kota = 'Kabupaten Maluku Tenggara Barat';
        $this->tambah('60105318','SMAS BUDI MULIA SAUMLAKI',$kota,'Tanimbar Selatan');
        $this->tambah('60101486','SMAS CORJESU LARAT',$kota,'Tanimbar Selatan');
        $this->tambah('60102371','SMAS KRISTEN 1 TANIMBAR UTARA',$kota,'Tanimbar Utara');
        $this->tambah('60101485','SMAS KRISTEN SAUMLAKI',$kota,'Tanimbar Selatan');

        // ── KAB. MALUKU TENGAH (SMA Swasta) ─────────────────────────────────
        $kota = 'Kabupaten Maluku Tengah';
        $this->tambah('60105289','SMAS KRISTEN AMETH',$kota,'Saparua');
        $this->tambah('69674791','SMA MUHAMMADIYAH MISSA',$kota,'Amahai');

        // ── KAB. BURU (SMA Swasta tambahan) ─────────────────────────────────
        $kota = 'Kabupaten Buru';
        $this->tambah('60103376','SMA KRISTEN LEKSULA',$kota,'Lilialy');

        // ── KAB. MALUKU BARAT DAYA (SMA Swasta) ─────────────────────────────
        $kota = 'Kabupaten Maluku Barat Daya';
        $this->tambah('60101442','SMA KRISTEN APRIAN',$kota,'Babar Timur');

    }
}
