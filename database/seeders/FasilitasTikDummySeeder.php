<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasTikDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = Sekolah::all();

        if ($sekolahs->isEmpty()) {
            $this->command->info('Data sekolah kosong, harap jalankan seeder sekolah terlebih dahulu.');
            return;
        }

        // Bagi 2: 50% Lengkap, 50% Belum Lengkap
        $half = floor($sekolahs->count() / 2);

        $i = 0;
        foreach ($sekolahs as $sekolah) {
            $isLengkap = ($i < $half);

            if ($isLengkap) {
                // Fasilitas TIK Lengkap
                DB::table('sekolah_fasilitastik')->updateOrInsert(
                    ['sekolah_id' => $sekolah->id],
                    [
                        'listrik_status' => 'ada',
                        'listrik_sumber' => 'PLN',
                        'listrik_durasi' => '24 Jam',
                        'jumlah_kom' => rand(30, 100),
                        'labkom_status' => 'ada',
                        'internet_status' => 'ada',
                        'internet_sumber' => 'Fiber Optik (Indihome/Biznet)',
                        'internet_bandwith' => rand(50, 200) . ' Mbps',
                        'topologi_jaringan' => 'Star / Mesh',
                        'internet_kesesuaian' => 'Sangat Sesuai',
                        'internet_alasankuota' => 'Kuota Memadai',
                        'saran_pengembangan' => 'Pemeliharaan perangkat dan penambahan komputer untuk ujian berbasis CBT secara penuh.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } else {
                // Fasilitas TIK Belum Lengkap
                DB::table('sekolah_fasilitastik')->updateOrInsert(
                    ['sekolah_id' => $sekolah->id],
                    [
                        'listrik_status' => rand(0, 1) ? 'ada' : 'tidak', // Kadang ada kadang tidak
                        'listrik_sumber' => 'PLN / Genset Terbatas',
                        'listrik_durasi' => '6 - 12 Jam',
                        'jumlah_kom' => rand(0, 10),
                        'labkom_status' => 'tidak',
                        'internet_status' => 'tidak',
                        'internet_sumber' => '-',
                        'internet_bandwith' => '-',
                        'topologi_jaringan' => '-',
                        'internet_kesesuaian' => 'Tidak Sesuai / Terbatas',
                        'internet_alasankuota' => 'Keterbatasan sinyal / Ketersediaan BTS, dan anggaran kuota.',
                        'saran_pengembangan' => 'Membutuhkan bantuan VSAT / Starlink dan pengadaan Laboratorium Komputer.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            $i++;
        }

        $this->command->info("Data Fasilitas TIK Dummy berhasil dibuat! Total sekolah: {$sekolahs->count()} (Dibagi 2 jenis status).");
    }
}
