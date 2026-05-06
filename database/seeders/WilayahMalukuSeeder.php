<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Periode;
use Illuminate\Database\Seeder;

class WilayahMalukuSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------
        // PERIODE
        // -------------------------------------------------------
        $periodes = [
            ['tahun' => 2023, 'status' => 0],
            ['tahun' => 2024, 'status' => 0],
            ['tahun' => 2025, 'status' => 1], // Aktif
        ];

        foreach ($periodes as $p) {
            Periode::firstOrCreate(['tahun' => $p['tahun']], ['status' => $p['status']]);
        }

        // -------------------------------------------------------
        // KABUPATEN/KOTA DAN KECAMATAN DI MALUKU
        // -------------------------------------------------------
        $wilayah = [
            'Kota Ambon' => [
                'Sirimau',
                'Nusaniwe',
                'Teluk Ambon',
                'Teluk Ambon Baguala',
                'Leitimur Selatan',
            ],
            'Kota Tual' => [
                'Pulau-Pulau Kei Kecil',
                'Pulau-Pulau Kei Kecil Barat',
                'Pulau-Pulau Kei Kecil Timur',
                'Pulau-Pulau Kei Kecil Timur Selatan',
                'Tayando Tam',
                'PP. Kei Kecil Barat',
            ],
            'Kabupaten Maluku Tengah' => [
                'Pulau Ambon',
                'Leihitu',
                'Leihitu Barat',
                'Salahutu',
                'Seram Utara',
                'Seram Utara Barat',
                'Seram Utara Timur Seti',
                'Seram Utara Timur Kobi',
                'Tehoru',
                'Teluti',
                'Amahai',
                'Banda',
                'Nusalaut',
                'Pulau Haruku',
                'Saparua',
                'Saparua Timur',
                'Teon Nila Serua',
            ],
            'Kabupaten Maluku Tenggara' => [
                'Kei Kecil',
                'Kei Kecil Barat',
                'Kei Kecil Timur',
                'Kei Kecil Timur Selatan',
                'Kei Besar',
                'Kei Besar Selatan',
                'Kei Besar Selatan Barat',
                'Kei Besar Utara Timur',
                'Kei Besar Utara Barat',
                'Hoat Sorbay',
                'Manyeuw',
            ],
            'Kabupaten Maluku Tenggara Barat' => [
                'Tanimbar Selatan',
                'Wertamrian',
                'Wermaktian',
                'Selaru',
                'Tanimbar Utara',
                'Yaru',
                'Wuarlabobar',
                'Nirunmas',
                'Kormomolin',
                'Molu Maru',
            ],
            'Kabupaten Buru' => [
                'Namlea',
                'Waeapo',
                'Batabual',
                'Teluk Kaiely',
                'Lolong Guba',
                'Waplau',
                'Airbuaya',
                'Lilialy',
                'Fena Leisela',
                'Waelata',
                'Namlea',
            ],
            'Kabupaten Buru Selatan' => [
                'Leksula',
                'Kepala Madan',
                'Fena Fafan',
                'Ambalau',
                'Waesama',
                'Namrole',
            ],
            'Kabupaten Seram Bagian Barat' => [
                'Huamual',
                'Inamosol',
                'Kepulauan Manipa',
                'Kairatu',
                'Kairatu Barat',
                'Amalatu',
                'Taniwel',
                'Taniwel Timur',
                'Seram Barat',
                'Huamual Belakang',
                'Elpaputih',
            ],
            'Kabupaten Seram Bagian Timur' => [
                'Bula',
                'Seram Timur',
                'Tutuk Tolu',
                'Wakate',
                'Werinama',
                'Gorom Timur',
                'Pulau-pulau Gorom',
                'Teor',
                'Kilmury',
                'Kian Darat',
                'Siritaun Wida Timur',
                'Teluk Waru',
                'Opa',
                'Siwalalat',
            ],
            'Kabupaten Kepulauan Aru' => [
                'Pulau-pulau Aru',
                'Aru Tengah',
                'Aru Tengah Timur',
                'Aru Tengah Selatan',
                'Aru Selatan',
                'Aru Selatan Timur',
                'Aru Selatan Utara',
                'Aru Utara',
                'Aru Utara Timur Batuley',
                'Sir-Sir',
                'Trangan',
            ],
            'Kabupaten Maluku Barat Daya' => [
                'Wetar',
                'Wetar Barat',
                'Wetar Utara',
                'Wetar Timur',
                'Pulau Masela',
                'Damer',
                'Mdona Hyera',
                'Pulau-pulau Babar',
                'Babar Timur',
                'Pulau Wetang',
                'Lakor',
                'Letti',
                'Moa Lakor',
                'Kepulauan Romang',
                'Dawelor Dawera',
                'Pulau Perbatasan Kisar',
                'Pulau Liran',
            ],
        ];

        foreach ($wilayah as $namaKota => $kecamatanList) {
            $kota = Kota::firstOrCreate(['nama' => $namaKota]);

            foreach ($kecamatanList as $namaKecamatan) {
                Kecamatan::firstOrCreate([
                    'nama'    => $namaKecamatan,
                    'kota_id' => $kota->id,
                ]);
            }
        }
    }
}
