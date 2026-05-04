<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahOperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // KABUPATEN SERAM BAGIAN TIMUR
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60101661', 'sekolah' => 'SMA NEGERI 1 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Bula', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60101667', 'sekolah' => 'SMA NEGERI 2 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Seram Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60101668', 'sekolah' => 'SMA NEGERI 3 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Werinama', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60101684', 'sekolah' => 'SMA NEGERI 4 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Pulau Gorom', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60102519', 'sekolah' => 'SMA NEGERI 5 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Bula Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60102520', 'sekolah' => 'SMA NEGERI 6 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Tutuk Tolu', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60102957', 'sekolah' => 'SMA NEGERI 7 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Wakate', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60102958', 'sekolah' => 'SMA NEGERI 8 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Gorom Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60102959', 'sekolah' => 'SMA NEGERI 9 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Kian Darat', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60102960', 'sekolah' => 'SMA NEGERI 10 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Gorom Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '60103879', 'sekolah' => 'SMA NEGERI 11 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Pulau Gorom', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '69725963', 'sekolah' => 'SMA NEGERI 12 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Siwalalat', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '69822777', 'sekolah' => 'SMA NEGERI 13 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Pulau Panjang', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '69872005', 'sekolah' => 'SMA NEGERI 14 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Teor', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Timur', 'npsn' => '69878241', 'sekolah' => 'SMA NEGERI 15 SERAM BAGIAN TIMUR', 'kecamatan' => 'Kec. Kilmury', 'status' => '1'],

            // KABUPATEN BURU SELATAN
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60100974', 'sekolah' => 'SMA NEGERI 1 BURU SELATAN', 'kecamatan' => 'Kec. Waesama', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60100976', 'sekolah' => 'SMA NEGERI 2 BURU SELATAN', 'kecamatan' => 'Kec. Ambalau', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60100978', 'sekolah' => 'SMA NEGERI 3 BURU SELATAN', 'kecamatan' => 'Kec. Leksula', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60100980', 'sekolah' => 'SMA NEGERI 4 BURU SELATAN', 'kecamatan' => 'Kec. Kepala Madan', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60100981', 'sekolah' => 'SMA NEGERI 5 BURU SELATAN', 'kecamatan' => 'Kec. Ambalau', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60101018', 'sekolah' => 'SMA NEGERI 6 BURU SELATAN', 'kecamatan' => 'Kec. Waesama', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60101019', 'sekolah' => 'SMA NEGERI 7 BURU SELATAN', 'kecamatan' => 'Kec. Namrole', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60103989', 'sekolah' => 'SMA NEGERI 8 BURU SELATAN', 'kecamatan' => 'Kec. Leksula', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '60725087', 'sekolah' => 'SMA NEGERI 9 BURU SELATAN', 'kecamatan' => 'Kec. Leksula', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '69728727', 'sekolah' => 'SMA NEGERI 10 BURU SELATAN', 'kecamatan' => 'Kec. Namrole', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '69728728', 'sekolah' => 'SMA NEGERI 11 BURU SELATAN', 'kecamatan' => 'Kec. Leksula', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '69886265', 'sekolah' => 'SMA NEGERI 12 BURU SELATAN', 'kecamatan' => 'Kec. Kepala Madan', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '69920547', 'sekolah' => 'SMA NEGERI 13 BURU SELATAN', 'kecamatan' => 'Kec. Kepala Madan', 'status' => '1'],
            ['kota' => 'Kabupaten Buru Selatan', 'npsn' => '69940652', 'sekolah' => 'SMA NEGERI 14 BURU SELATAN', 'kecamatan' => 'Kec. Namrole', 'status' => '1'],

            // KABUPATEN SERAM BAGIAN BARAT
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101529', 'sekolah' => 'SMA NEGERI 1 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kairatu', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101530', 'sekolah' => 'SMA NEGERI 2 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kairatu Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101540', 'sekolah' => 'SMA NEGERI 3 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Seram Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101541', 'sekolah' => 'SMA NEGERI 4 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Taniwel', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101542', 'sekolah' => 'SMA NEGERI 5 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101543', 'sekolah' => 'SMA NEGERI 6 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60101560', 'sekolah' => 'SMA NEGERI 7 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual Belakang', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102712', 'sekolah' => 'SMA NEGERI 8 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102713', 'sekolah' => 'SMA NEGERI 9 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual Belakang', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102716', 'sekolah' => 'SMA NEGERI 10 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kairatu', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102886', 'sekolah' => 'SMA NEGERI 11 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Amalatu', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102887', 'sekolah' => 'SMA NEGERI 12 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Seram Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102889', 'sekolah' => 'SMA NEGERI 13 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kepulauan Manipa', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102893', 'sekolah' => 'SMA NEGERI 14 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual Belakang', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60102894', 'sekolah' => 'SMA NEGERI 15 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Amalatu', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60103465', 'sekolah' => 'SMA NEGERI 16 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kepulauan Manipa', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60103902', 'sekolah' => 'SMA NEGERI 17 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual Belakang', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60103903', 'sekolah' => 'SMA NEGERI 18 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual Belakang', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60103904', 'sekolah' => 'SMA NEGERI 19 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Taniwel Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '60103939', 'sekolah' => 'SMA NEGERI 20 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Elpaputih', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '69772549', 'sekolah' => 'SMA NEGERI 21 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '69822775', 'sekolah' => 'SMA NEGERI 22 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kairatu', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '69867932', 'sekolah' => 'SMA NEGERI 23 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Kepulauan Manipa', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '69950985', 'sekolah' => 'SMA NEGERI 24 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '69955228', 'sekolah' => 'SMA NEGERI 25 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Taniwel', 'status' => '1'],
            ['kota' => 'Kabupaten Seram Bagian Barat', 'npsn' => '69972701', 'sekolah' => 'SMA NEGERI 26 SERAM BAGIAN BARAT', 'kecamatan' => 'Kec. Huamual Belakang', 'status' => '1'],

            // KOTA TUAL
            ['kota' => 'Kota Tual', 'npsn' => '60100819', 'sekolah' => 'SMA NEGERI 1 KOTA TUAL', 'kecamatan' => 'Kec. Pulau Dullah Selatan', 'status' => '1'],
            ['kota' => 'Kota Tual', 'npsn' => '60102292', 'sekolah' => 'SMA NEGERI 2 KOTA TUAL', 'kecamatan' => 'Kec. Kur Selatan', 'status' => '1'],
            ['kota' => 'Kota Tual', 'npsn' => '60103318', 'sekolah' => 'SMA NEGERI 3 KOTA TUAL', 'kecamatan' => 'Kec. Tayando Tam', 'status' => '1'],
            ['kota' => 'Kota Tual', 'npsn' => '60103463', 'sekolah' => 'SMA NEGERI 4 KOTA TUAL', 'kecamatan' => 'Kec. Pulau Dullah Utara', 'status' => '1'],
            ['kota' => 'Kota Tual', 'npsn' => '69761907', 'sekolah' => 'SMA NEGERI 5 KOTA TUAL', 'kecamatan' => 'Kec. Pulau Dullah Selatan', 'status' => '1'],
            ['kota' => 'Kota Tual', 'npsn' => '69849368', 'sekolah' => 'SMA NEGERI 6 KOTA TUAL', 'kecamatan' => 'Kec. Pulau Dullah Utara', 'status' => '1'],
            ['kota' => 'Kota Tual', 'npsn' => '69849369', 'sekolah' => 'SMA NEGERI 7 KOTA TUAL', 'kecamatan' => 'Kec. Pulau Dullah Selatan', 'status' => '1'],

            // KABUPATEN MALUKU TENGAH
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100153', 'sekolah' => 'SMA NEGERI 1 MALUKU TENGAH', 'kecamatan' => 'Kec. Banda', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100157', 'sekolah' => 'SMA NEGERI 2 MALUKU TENGAH', 'kecamatan' => 'Kec. Amahai', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100159', 'sekolah' => 'SMA NEGERI 3 MALUKU TENGAH', 'kecamatan' => 'Kec. Salahutu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100161', 'sekolah' => 'SMA NEGERI 4 MALUKU TENGAH', 'kecamatan' => 'Kec. Masohi', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100164', 'sekolah' => 'SMA NEGERI 5 MALUKU TENGAH', 'kecamatan' => 'Kec. Salahutu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100313', 'sekolah' => 'SMA NEGERI 6 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100315', 'sekolah' => 'SMA NEGERI 7 MALUKU TENGAH', 'kecamatan' => 'Kec. Saparua', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100316', 'sekolah' => 'SMA NEGERI 8 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100317', 'sekolah' => 'SMA NEGERI 9 MALUKU TENGAH', 'kecamatan' => 'Kec. Tehoru', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100319', 'sekolah' => 'SMA NEGERI 10 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100320', 'sekolah' => 'SMA NEGERI 11 MALUKU TENGAH', 'kecamatan' => 'Kec. Pulau Haruku', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100321', 'sekolah' => 'SMA NEGERI 12 MALUKU TENGAH', 'kecamatan' => 'Kec. Saparua Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100322', 'sekolah' => 'SMA NEGERI 13 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara Timur Seti', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100324', 'sekolah' => 'SMA NEGERI 14 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100325', 'sekolah' => 'SMA NEGERI 15 MALUKU TENGAH', 'kecamatan' => 'Kec. Masohi', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100326', 'sekolah' => 'SMA NEGERI 16 MALUKU TENGAH', 'kecamatan' => 'Kec. Pulau Haruku', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100327', 'sekolah' => 'SMA NEGERI 17 MALUKU TENGAH', 'kecamatan' => 'Kec. Teon Nila Serua', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60100346', 'sekolah' => 'SMA NEGERI 18 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60102240', 'sekolah' => 'SMA NEGERI 19 MALUKU TENGAH', 'kecamatan' => 'Kec. Pulau Haruku', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60102244', 'sekolah' => 'SMA NEGERI 20 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60102245', 'sekolah' => 'SMA NEGERI 21 MALUKU TENGAH', 'kecamatan' => 'Kec. Telutih', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60102249', 'sekolah' => 'SMA NEGERI 22 MALUKU TENGAH', 'kecamatan' => 'Kec. Salahutu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103505', 'sekolah' => 'SMA NEGERI 23 MALUKU TENGAH', 'kecamatan' => 'Kec. Amahai', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103506', 'sekolah' => 'SMA NEGERI 24 MALUKU TENGAH', 'kecamatan' => 'Kec. Amahai', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103509', 'sekolah' => 'SMA NEGERI 25 MALUKU TENGAH', 'kecamatan' => 'Kec. Tehoru', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103512', 'sekolah' => 'SMA NEGERI 26 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103513', 'sekolah' => 'SMA NEGERI 27 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103514', 'sekolah' => 'SMA NEGERI 28 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103517', 'sekolah' => 'SMA NEGERI 29 MALUKU TENGAH', 'kecamatan' => 'Kec. Telutih', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103518', 'sekolah' => 'SMA NEGERI 30 MALUKU TENGAH', 'kecamatan' => 'Kec. Banda', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103611', 'sekolah' => 'SMA NEGERI 31 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60103737', 'sekolah' => 'SMA NEGERI 32 MALUKU TENGAH', 'kecamatan' => 'Kec. Tehoru', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60104031', 'sekolah' => 'SMA NEGERI 33 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara Timur Seti', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60104032', 'sekolah' => 'SMA NEGERI 34 MALUKU TENGAH', 'kecamatan' => 'Kec. Nusa Laut', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '60104038', 'sekolah' => 'SMA NEGERI 35 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara Timur Kobi', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69770333', 'sekolah' => 'SMA NEGERI 36 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774664', 'sekolah' => 'SMA NEGERI 37 MALUKU TENGAH', 'kecamatan' => 'Kec. Masohi', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774665', 'sekolah' => 'SMA NEGERI 38 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774666', 'sekolah' => 'SMA NEGERI 39 MALUKU TENGAH', 'kecamatan' => 'Kec. Salahutu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774667', 'sekolah' => 'SMA NEGERI 40 MALUKU TENGAH', 'kecamatan' => 'Kec. Saparua Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774668', 'sekolah' => 'SMA NEGERI 41 MALUKU TENGAH', 'kecamatan' => 'Kec. Saparua', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774669', 'sekolah' => 'SMA NEGERI 42 MALUKU TENGAH', 'kecamatan' => 'Kec. Saparua', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69774670', 'sekolah' => 'SMA NEGERI 43 MALUKU TENGAH', 'kecamatan' => 'Kec. Pulau Haruku', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69775663', 'sekolah' => 'SMA NEGERI 44 MALUKU TENGAH', 'kecamatan' => 'Kec. Amahai', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69822771', 'sekolah' => 'SMA NEGERI 45 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69822772', 'sekolah' => 'SMA NEGERI 46 MALUKU TENGAH', 'kecamatan' => 'Kec. Telutih', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69822773', 'sekolah' => 'SMA NEGERI 47 MALUKU TENGAH', 'kecamatan' => 'Kec. Salahutu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69822774', 'sekolah' => 'SMA NEGERI 48 MALUKU TENGAH', 'kecamatan' => 'Kec. Amahai', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69831985', 'sekolah' => 'SMA NEGERI 49 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69832004', 'sekolah' => 'SMA NEGERI 50 MALUKU TENGAH', 'kecamatan' => 'Kec. Teluk Elpaputih', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69870670', 'sekolah' => 'SMA NEGERI 51 MALUKU TENGAH', 'kecamatan' => 'Kec. Tehoru', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69870898', 'sekolah' => 'SMA NEGERI 52 MALUKU TENGAH', 'kecamatan' => 'Kec. Banda', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69937935', 'sekolah' => 'SMA NEGERI 53 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69937940', 'sekolah' => 'SMA NEGERI 54 MALUKU TENGAH', 'kecamatan' => 'Kec. Teluk Elpaputih', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69937942', 'sekolah' => 'SMA NEGERI 55 MALUKU TENGAH', 'kecamatan' => 'Kec. Teluk Elpaputih', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69937943', 'sekolah' => 'SMA NEGERI 56 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69938216', 'sekolah' => 'SMA NEGERI 57 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69940233', 'sekolah' => 'SMA NEGERI 58 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara Timur Kobi', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69947368', 'sekolah' => 'SMA NEGERI 59 MALUKU TENGAH', 'kecamatan' => 'Kec. Tehoru', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69947434', 'sekolah' => 'SMA NEGERI 60 MALUKU TENGAH', 'kecamatan' => 'Kec. Seram Utara', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69947454', 'sekolah' => 'SMA NEGERI 61 MALUKU TENGAH', 'kecamatan' => 'Kec. Teon Nila Serua', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69947867', 'sekolah' => 'SMA NEGERI 62 MALUKU TENGAH', 'kecamatan' => 'Kec. Leihitu', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tengah', 'npsn' => '69949714', 'sekolah' => 'SMA NEGERI 63 MALUKU TENGAH', 'kecamatan' => 'Kec. Pulau Haruku', 'status' => '1'],

            // KABUPATEN MALUKU TENGGARA
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60100817', 'sekolah' => 'SMA NEGERI 1 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Besar', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60100818', 'sekolah' => 'SMA NEGERI 2 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Kecil', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60100820', 'sekolah' => 'SMA NEGERI 3 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Kecil', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60103317', 'sekolah' => 'SMA NEGERI 4 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Kecil Barat', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60103320', 'sekolah' => 'SMA NEGERI 5 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Kecil Timur Selatan', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60103632', 'sekolah' => 'SMA NEGERI 6 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Besar Utara Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60103646', 'sekolah' => 'SMA NEGERI 7 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Besar', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60103647', 'sekolah' => 'SMA NEGERI 8 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Besar Selatan', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '60103895', 'sekolah' => 'SMA NEGERI 9 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Besar Utara Timur', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '69893230', 'sekolah' => 'SMA NEGERI 10 MALUKU TENGGARA', 'kecamatan' => 'Kec. Hoat Sorbay', 'status' => '1'],
            ['kota' => 'Kabupaten Maluku Tenggara', 'npsn' => '69893231', 'sekolah' => 'SMA NEGERI 11 MALUKU TENGGARA', 'kecamatan' => 'Kec. Kei Kecil Timur', 'status' => '1'],

            // KABUPATEN KEPULAUAN TANIMBAR (formerly Maluku Tenggara Barat)
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60101330', 'sekolah' => 'SMA NEGERI 1 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Nirun Mas', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60101438', 'sekolah' => 'SMA NEGERI 2 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Tanimbar Selatan', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60101443', 'sekolah' => 'SMA NEGERI 3 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Nirun Mas', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60101465', 'sekolah' => 'SMA NEGERI 4 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Wer Tamrian', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60102374', 'sekolah' => 'SMA NEGERI 5 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Selaru', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60103079', 'sekolah' => 'SMA NEGERI 6 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Wuar Labobar', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60103400', 'sekolah' => 'SMA NEGERI 7 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Tanimbar Utara', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60103695', 'sekolah' => 'SMA NEGERI 8 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Tanimbar Selatan', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60103897', 'sekolah' => 'SMA NEGERI 9 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Yaru', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60105301', 'sekolah' => 'SMA NEGERI 10 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Tanimbar Selatan', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60105312', 'sekolah' => 'SMA NEGERI 11 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Kormomolin', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60105429', 'sekolah' => 'SMA NEGERI 12 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Tanimbar Utara', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60724705', 'sekolah' => 'SMA NEGERI 13 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Wer Maktian', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '60724708', 'sekolah' => 'SMA NEGERI 14 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Molu Maru', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '69949130', 'sekolah' => 'SMA NEGERI 15 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Nirun Mas', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Tanimbar', 'npsn' => '69989359', 'sekolah' => 'SMA NEGERI 16 KEPULAUAN TANIMBAR', 'kecamatan' => 'Kec. Wermaktian', 'status' => '1'],

            // KABUPATEN KEPULAUAN ARU
            ['kota' => 'Kabupaten Kepulauan Aru', 'npsn' => '60101787', 'sekolah' => 'SMA NEGERI 1 KEPULAUAN ARU', 'kecamatan' => 'Kec. Pulau-pulau Aru', 'status' => '1'],
            ['kota' => 'Kabupaten Kepulauan Aru', 'npsn' => '60101800', 'sekolah' => 'SMA NEGERI 2 KEPULAUAN ARU', 'kecamatan' => 'Kec. Aru Selatan', 'status' => '1'],
        ];

        foreach ($data as $item) {
            // Find or creat Kota
            $kota = Kota::firstOrCreate(
                ['nama' => strtoupper($item['kota'])]
            );

            // Find or create Kecamatan
            $kecamatan = Kecamatan::firstOrCreate(
                ['nama' => strtoupper($item['kecamatan']), 'kota_id' => $kota->id]
            );

            // Create or update Sekolah
            $sekolah = Sekolah::updateOrCreate(
                ['npsn' => $item['npsn']],
                [
                    'nama' => $item['sekolah'],
                    'status_sekolah' => $item['status'],
                    'kota_id' => $kota->id,
                    'kecamatan_id' => $kecamatan->id,
                    'tingkatan' => 'SMA',
                ]
            );

            // Create Operator User
            User::updateOrCreate(
                ['email' => $item['npsn']],
                [
                    'name' => 'Operator ' . $item['sekolah'],
                    'role' => '3',
                    'password' => Hash::make('12345678'),
                    'sekolah_id' => $sekolah->id,
                ]
            );
        }
    }
}
