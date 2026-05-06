<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahFinalCleanupSeeder extends Seeder
{
    private function tambah(string $npsn, string $nama, string $tingkatan, string $namaKota, ?string $namaKec = null): void
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecId = $namaKec ? Kecamatan::firstOrCreate(['nama' => $namaKec, 'kota_id' => $kota->id])->id : null;

        // Use updateOrCreate for the name to fix typos while keeping NPSN as key
        $sekolah = Sekolah::updateOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => $tingkatan, 'kota_id' => $kota->id, 'kecamatan_id' => $kecId]
        );

        if ($sekolah->wasRecentlyCreated) {
            SekolahSosekbud::firstOrCreate(['sekolah_id' => $sekolah->id]);
            User::firstOrCreate(
                ['email' => $npsn],
                ['name' => 'Operator ' . $nama, 'password' => Hash::make($npsn), 'role' => 3, 'sekolah_id' => $sekolah->id]
            );
        } else {
            // Update operator name if school name changed
            User::where('email', $npsn)->update(['name' => 'Operator ' . $nama]);
        }
    }

    public function run(): void
    {
        // ── TYPO FIXES ───────────────────────────────────────────────────────
        $this->tambah('60102474','SMAS MUHAMMADIYAH LIMBORO','SMA','Kabupaten Seram Bagian Barat','Huamual');
        $this->tambah('60102896','SMKN 2 SERAM BARAT','SMK','Kabupaten Seram Bagian Barat','Kairatu');
        
        // ── MISSING SCHOOLS FOUND IN SCAN ────────────────────────────────────
        $this->tambah('69894451','SMA RAUDAH DANAR','SMA','Kabupaten Maluku Tenggara','Kei Kecil Timur');
        $this->tambah('69831986','SMK NEGERI 10 MALUKU TENGAH','SMK','Kabupaten Maluku Tengah','Tehoru'); // Ensure correct name
        $this->tambah('69831987','SMK NEGERI 11 MALUKU TENGAH','SMK','Kabupaten Maluku Tengah','Seram Utara'); // Ensure correct name

        // Re-checking some swasta from early pages
        $k = 'Kabupaten Maluku Tengah';
        $this->tambah('60100350','SMAS PGRI OMA HARUKU','SMA',$k,'Pulau Haruku'); // Fix name if needed
    }
}
