<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UpdateGuruSekolahDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. UPDATE DATA GURU
        $gurus = Guru::all();
        $totalGuru = $gurus->count();

        if ($totalGuru > 0) {
            $chunkSize = ceil($totalGuru / 3);
            
            // Chunk 1: Mahir
            // Chunk 2: Menengah
            // Chunk 3: Dasar
            $i = 0;
            foreach ($gurus as $guru) {
                if ($i < $chunkSize) {
                    $kategori = 'Mahir';
                } elseif ($i < ($chunkSize * 2)) {
                    $kategori = 'Menengah';
                } else {
                    $kategori = 'Dasar';
                }

                $guru->update([
                    'kompetensi_word' => $kategori,
                    'kompetensi_powerpoin' => $kategori,
                    'kompetensi_excel' => $kategori,
                    'kompetensi_pemrogramman' => $kategori,
                    'kompetensi_jaringan' => $kategori,
                    'kompetensi_multimedia' => $kategori,
                ]);

                $i++;
            }
            $this->command->info("Data Kompetensi Guru (Total: {$totalGuru}) berhasil dibagi menjadi Mahir, Menengah, Dasar!");
        } else {
            $this->command->warn("Data Guru kosong.");
        }


        // 2. LENGKAPI IDENTITAS SEKOLAH
        $sekolahs = Sekolah::all();
        foreach ($sekolahs as $sekolah) {
            $domain = strtolower(Str::slug($sekolah->nama, '')) . '.sch.id';
            
            $sekolah->update([
                'alamat' => $sekolah->alamat ?? $faker->address,
                'telepon' => $sekolah->telepon ?? $faker->phoneNumber,
                'email' => $sekolah->email ?? "info@{$domain}",
                'website' => $sekolah->website ?? "www.{$domain}",
                'kepsek_nama' => $sekolah->kepsek_nama ?? $faker->name,
                'kepsek_hp' => $sekolah->kepsek_hp ?? $faker->phoneNumber,
                'sk_ijin' => $sekolah->sk_ijin ?? $faker->numerify('SK-####/DIKBUD/2020'),
                'status_akreditasi' => $sekolah->status_akreditasi ?? $faker->randomElement(['A', 'B', 'C']),
                'status_tanah' => $sekolah->status_tanah ?? $faker->randomElement(['Sertifikat Hak Milik', 'Hak Pakai', 'Sertifikat Hak Guna Bangunan']),
                'jum_siswa_pria' => $sekolah->jum_siswa_pria ?? rand(50, 300),
                'jum_siswa_wanita' => $sekolah->jum_siswa_wanita ?? rand(50, 300),
                'jum_guru' => $sekolah->jum_guru ?? rand(15, 60),
            ]);
        }
        $this->command->info("Identitas Sekolah secara keseluruhan berhasil dilengkapi!");
    }
}
