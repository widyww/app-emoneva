<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class GuruDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil 10 sekolah secara acak untuk disisipkan dummy guru
        $sekolahs = Sekolah::inRandomOrder()->take(10)->get();

        if ($sekolahs->isEmpty()) {
            $this->command->info('Data sekolah kosong, harap jalankan seeder sekolah terlebih dahulu.');
            return;
        }

        foreach ($sekolahs as $sekolah) {
            // Kita buatkan 5 guru dummy per sekolah
            for ($i = 0; $i < 5; $i++) {
                
                // Format NIP Dummy
                $nip = $faker->numerify('19########## 200# ## 100#');
                
                $guru = Guru::create([
                    'nama' => $faker->name,
                    'status' => $faker->randomElement(['1', '2']), // 1 PNS, 2 PPPK
                    'nip' => $nip,
                    'nuptk' => $faker->numerify('################'),
                    'tempat' => $faker->city,
                    'tgl_lahir' => $faker->date('Y-m-d', '1995-01-01'),
                    'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                    'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                    'pendidikan_terakhir' => $faker->randomElement(['S1', 'S2']),
                    'tmt_pns_tahun' => $faker->date('Y-m-d', '2010-01-01'),
                    'telepon' => $faker->phoneNumber,
                    'mapel' => $faker->randomElement(['TIK', 'Bahasa Indonesia', 'Matematika', 'B. Inggris', 'Fisika']),
                    'sertifikasi_status' => $faker->randomElement(['Sudah', 'Belum']),
                    'sertifikasi_tahun' => '2020',
                    'sertifikasi_alasan' => 'Memenuhi Kuota',
                    'kompetensi_word' => $faker->randomElement(['Sangat Baik', 'Baik', 'Cukup']),
                    'kompetensi_powerpoin' => $faker->randomElement(['Sangat Baik', 'Baik', 'Cukup']),
                    'kompetensi_excel' => $faker->randomElement(['Sangat Baik', 'Baik', 'Cukup']),
                    'kompetensi_pemrogramman' => $faker->randomElement(['Sangat Baik', 'Baik', 'Cukup']),
                    'kompetensi_jaringan' => $faker->randomElement(['Sangat Baik', 'Baik', 'Cukup']),
                    'kompetensi_multimedia' => $faker->randomElement(['Sangat Baik', 'Baik', 'Cukup']),
                    'pelatihan_status' => '1',
                    'pelatihan_kebutuhan' => '1',
                    'sekolah_id' => $sekolah->id,
                ]);

                // Buatkan juga akun user login Guru
                User::create([
                    'name' => $guru->nama,
                    'email' => $guru->nip, // NIP digunakan sebagai email untuk login
                    'role' => '5', // Role 5 adalah Guru
                    'password' => Hash::make('12345678'), // Password Default
                    'sekolah_id' => $sekolah->id,
                    'guru_id' => $guru->id,
                ]);
            }
        }
        
        $this->command->info('Dummy Guru dan Akun User Guru berhasil dibuat!');
    }
}
