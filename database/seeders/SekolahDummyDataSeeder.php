<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\SekolahFasilitas;
use App\Models\SekolahFasilitasLab;
use App\Models\SekolahBantuanStatus;
use App\Models\SekolahBantuanDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahDummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing related data safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sekolah_sosekbud')->truncate();
        DB::table('sekolah_fasilitastik')->truncate();
        DB::table('sekolah_fasilitastik_lab')->truncate();
        DB::table('sekolah_bantuan_status')->truncate();
        DB::table('sekolah_bantuan_detail')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sekolahs = Sekolah::all()->shuffle(); // Shuffle for variety
        $total = $sekolahs->count();
        $third = ceil($total / 3);

        foreach ($sekolahs as $index => $sekolah) {
            if ($index < $third) {
                $kondisi = 'baik';
            } elseif ($index < $third * 2) {
                $kondisi = 'sedang';
            } else {
                $kondisi = 'buruk';
            }

            // 1. Update Identitas Sekolah
            $sekolah->update([
                'alamat' => 'Jl. Pendidikan No. ' . ($index + 1) . ', Maluku',
                'telepon' => '0911' . rand(100000, 999999),
                'email' => strtolower(str_replace([' ', '.', ','], '', $sekolah->nama)) . '@sekolah.id',
                'website' => 'https://' . strtolower(str_replace([' ', '.', ','], '', $sekolah->nama)) . '.sch.id',
                'kepsek_nama' => 'Drs. ' . ['Ahmad', 'Budi', 'Chandra', 'Deddy', 'Eko'][rand(0, 4)] . ' ' . ['Malawat', 'Latuconsina', 'Pattimura', 'Wattimena', 'Ohorella'][rand(0, 4)],
                'kepsek_hp' => '0812' . rand(10000000, 99999999),
                'status_akreditasi' => ($kondisi == 'baik' ? 'A' : ($kondisi == 'sedang' ? 'B' : 'C')),
                'jum_siswa_pria' => ($kondisi == 'baik' ? rand(300, 600) : ($kondisi == 'sedang' ? rand(150, 300) : rand(20, 100))),
                'jum_siswa_wanita' => ($kondisi == 'baik' ? rand(300, 600) : ($kondisi == 'sedang' ? rand(150, 300) : rand(20, 100))),
                'jum_guru' => ($kondisi == 'baik' ? rand(40, 70) : ($kondisi == 'sedang' ? rand(20, 40) : rand(5, 15))),
                'unbk_status' => ($kondisi == 'baik' ? 'Mandiri' : ($kondisi == 'sedang' ? 'Menumpang' : 'Belum Melaksanakan')),
                'unbk_tahun' => '2023',
                'status_verifikasi' => ($kondisi == 'buruk' ? 'Belum Diverifikasi' : 'Sudah Diverifikasi'),
                'status_sekolah' => ($index % 3 == 0 ? 'Swasta' : 'Negeri'),
                'status_tanah' => 'Milik Sendiri (Sertifikat)',
            ]);

            // 2. Kondisi Sosekbud
            SekolahSosekbud::create([
                'sekolah_id' => $sekolah->id,
                'kondisi_geografis' => ($kondisi == 'baik' ? 'Perkotaan (Mudah dijangkau)' : ($kondisi == 'sedang' ? 'Pedesaan (Akses Terbatas)' : 'Daerah Terpencil/3T')),
                'kondisi_sosekbud' => ($kondisi == 'baik' ? 'Masyarakat Mampu' : ($kondisi == 'sedang' ? 'Masyarakat Menengah' : 'Masyarakat Kurang Mampu')),
                'akses_transportasi' => ($kondisi == 'baik' ? 'Jalan Aspal (Kendaraan Roda 4)' : ($kondisi == 'sedang' ? 'Jalan Tanah/Berbatu' : 'Hanya Jalur Laut/Jalan Kaki')),
            ]);

            // 3. Fasilitas Listrik & Internet
            $fasilitas = SekolahFasilitas::create([
                'sekolah_id' => $sekolah->id,
                'listrik_status' => ($kondisi == 'buruk' ? 'tidak' : 'ada'),
                'listrik_sumber' => ($kondisi == 'baik' ? 'PLN' : ($kondisi == 'sedang' ? 'PLN & Surya' : 'Genset')),
                'listrik_durasi' => ($kondisi == 'baik' ? '24 Jam' : ($kondisi == 'sedang' ? '12 Jam' : '6 Jam')),
                'jumlah_kom' => ($kondisi == 'baik' ? rand(50, 100) : ($kondisi == 'sedang' ? rand(20, 40) : rand(0, 15))),
                'labkom_status' => ($kondisi == 'buruk' ? 'tidak' : 'ada'),
                'internet_status' => ($kondisi == 'buruk' ? 'tidak' : 'ada'),
                'internet_sumber' => ($kondisi == 'baik' ? 'Fiber Optic (Indihome)' : ($kondisi == 'sedang' ? 'Satelit/VSAT' : 'Modem Seluler')),
                'internet_bandwith' => ($kondisi == 'baik' ? '100 Mbps' : ($kondisi == 'sedang' ? '10-20 Mbps' : '2 Mbps')),
                'topologi_jaringan' => ($kondisi == 'baik' ? 'Mikrotik (WLAN/LAN)' : ($kondisi == 'sedang' ? 'WiFi Router Standard' : 'Personal Hotspot')),
                'internet_kesesuaian' => ($kondisi == 'baik' ? 'Sangat Sesuai' : ($kondisi == 'sedang' ? 'Cukup Sesuai' : 'Tidak Sesuai')),
                'internet_alasankuota' => ($kondisi == 'buruk' ? 'Sinyal tidak stabil dan biaya tinggi' : 'Kebutuhan Administrasi & Belajar'),
                'saran_pengembangan' => 'Perlu peningkatan kapasitas bandwidth dan peremajaan perangkat.',
            ]);

            // 3b. Labs
            if ($kondisi == 'baik') {
                SekolahFasilitasLab::create(['sekolah_fasilitastik_id' => $fasilitas->id, 'labkom_nama' => 'Lab Komputer Utama', 'labkom_jumlah_pc' => 40]);
                SekolahFasilitasLab::create(['sekolah_fasilitastik_id' => $fasilitas->id, 'labkom_nama' => 'Lab Multimedia', 'labkom_jumlah_pc' => 30]);
            } elseif ($kondisi == 'sedang') {
                SekolahFasilitasLab::create(['sekolah_fasilitastik_id' => $fasilitas->id, 'labkom_nama' => 'Lab Komputer', 'labkom_jumlah_pc' => 20]);
            }

            // 4. Data Bantuan
            $bantuanStatus = SekolahBantuanStatus::create([
                'sekolah_id' => $sekolah->id,
                'status' => ($kondisi == 'baik' ? 'Sudah Terverifikasi' : ($kondisi == 'sedang' ? 'Dalam Proses' : 'Belum Terverifikasi'))
            ]);

            if ($kondisi != 'buruk') {
                SekolahBantuanDetail::create([
                    'sekolah_bantuan_status_id' => $bantuanStatus->id,
                    'nama_lembaga' => ($kondisi == 'baik' ? 'Pusdatin Kemendikbud' : 'Dinas Pendidikan Provinsi'),
                    'keterangan_bantuan' => ($kondisi == 'baik' ? 'Bantuan Lab Komputer Lengkap (2022)' : 'Bantuan Chromebook 15 Unit (2023)'),
                ]);
            }
        }

        echo "Successfully populated detailed dummy data for $total schools.\n";
    }
}
