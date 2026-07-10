<?php

namespace Database\Seeders;

use App\Models\SpkKriteria;
use Illuminate\Database\Seeder;

class SpkKriteriaSeeder extends Seeder
{
    /**
     * Seed kriteria SPK (C1-C7) beserta bobot AWAL.
     *
     * CATATAN: bobot di bawah adalah CONTOH dari docs/SPK-AHP-SAW.md Bagian 9.1
     * (total = 1.00). Bobot FINAL wajib dihitung ulang lewat AHP oleh pihak Balai
     * (AhpWeightService) dan hanya disimpan bila CR <= 10%.
     *
     * Idempoten: memakai updateOrCreate berdasarkan kode kriteria.
     */
    public function run(): void
    {
        $kriteria = [
            ['kode' => 'C1', 'nama' => 'Kondisi Listrik',                    'bobot' => 0.20],
            ['kode' => 'C2', 'nama' => 'Ketersediaan Lab & Rasio Komputer',  'bobot' => 0.20],
            ['kode' => 'C3', 'nama' => 'Kondisi Internet',                   'bobot' => 0.20],
            ['kode' => 'C4', 'nama' => 'Riwayat Bantuan',                    'bobot' => 0.15],
            ['kode' => 'C5', 'nama' => 'Keterpencilan / Aksesibilitas',      'bobot' => 0.10],
            ['kode' => 'C6', 'nama' => 'Jumlah Siswa Terdampak',             'bobot' => 0.10],
            ['kode' => 'C7', 'nama' => 'Urgensi UNBK & Akreditasi',          'bobot' => 0.05],
        ];

        foreach ($kriteria as $item) {
            SpkKriteria::updateOrCreate(
                ['kode' => $item['kode']],
                [
                    'nama' => $item['nama'],
                    'bobot' => $item['bobot'],
                    'tipe' => 'benefit',
                    'aktif' => true,
                ]
            );
        }
    }
}
