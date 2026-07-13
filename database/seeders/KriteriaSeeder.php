<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'C1', 'nama' => 'Ketersediaan komputer', 'sifat' => 'benefit', 'urutan' => 1,
             'definisi' => 'Rasio jumlah komputer layak pakai terhadap jumlah siswa (ideal 1:10).'],
            ['kode' => 'C2', 'nama' => 'Durasi/ketersediaan daya listrik', 'sifat' => 'benefit', 'urutan' => 2,
             'definisi' => 'Lama (durasi) pasokan listrik harian untuk operasional TIK.'],
            ['kode' => 'C3', 'nama' => 'Kapasitas jaringan internet', 'sifat' => 'benefit', 'urutan' => 3,
             'definisi' => 'Ketersediaan dan kecepatan koneksi internet (bandwidth).'],
            ['kode' => 'C4', 'nama' => 'Ketersediaan ruang laboratorium komputer', 'sifat' => 'benefit', 'urutan' => 4,
             'definisi' => 'Ada/tidaknya ruang laboratorium komputer.'],
            ['kode' => 'C5', 'nama' => 'Riwayat penerimaan bantuan', 'sifat' => 'benefit', 'urutan' => 5,
             'definisi' => 'Status pernah/belum pernah menerima bantuan fasilitas TIK.'],
        ];

        foreach ($data as $d) {
            Kriteria::updateOrCreate(['kode' => $d['kode']], $d);
        }
    }
}
