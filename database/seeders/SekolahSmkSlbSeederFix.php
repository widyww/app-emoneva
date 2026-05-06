<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahSmkSlbSeederFix extends Seeder
{
    private function tambah(string $npsn, string $nama, string $tingkatan, string $namaKota, ?string $namaKec = null): void
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecId = $namaKec ? Kecamatan::firstOrCreate(['nama' => $namaKec, 'kota_id' => $kota->id])->id : null;

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => $tingkatan, 'kota_id' => $kota->id, 'kecamatan_id' => $kecId]
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
        // ── SLB FIX & ADD ────────────────────────────────────────────────────
        $this->tambah('60102579','SLB NEGERI BATU MERAH AMBON','SLB','Kota Ambon','Sirimau');
        $this->tambah('70006907','SLB NEGERI TUAL','SLB','Kota Tual','Pulau Dullah Selatan');

        // ── SMK KAB. BURU FIX ────────────────────────────────────────────────
        $k = 'Kabupaten Buru';
        $this->tambah('60100972','SMK ALHILAAL NAMLEA','SMK',$k,'Namlea');
        $this->tambah('60103598','SMK NEGERI 4 BURU','SMK',$k,'Namlea');
        $this->tambah('69859382','SMK NEGERI 6 BURU','SMK',$k,'Lilialy');
        $this->tambah('69950565','SMK NEGERI 8 BURU','SMK',$k,'Waplau');

        // ── SMK KAB. BURU SELATAN FIX ────────────────────────────────────────
        $k = 'Kabupaten Buru Selatan';
        $this->tambah('69902326','SMKN 10 BURU SELATAN','SMK',$k,'Namrole');
        $this->tambah('60103991','SMKN 4 BURU SELATAN','SMK',$k,'Waesama');
        $this->tambah('69725656','SMKN 7 BURU SELATAN','SMK',$k,'Namrole');

        // ── SMK KAB. MALUKU TENGGARA BARAT (TANIMBAR) FIX ────────────────────
        $k = 'Kabupaten Maluku Tenggara Barat';
        $this->tambah('60101461','SMKN 3 KEP TANIMBAR','SMK',$k,'Tanimbar Selatan');

        // ── SMK KAB. MALUKU BARAT DAYA FIX ───────────────────────────────────
        $k = 'Kabupaten Maluku Barat Daya';
        $this->tambah('60103850','SMKN PER & KEL MARSLA','SMK',$k,'Pulau-pulau Terselatan');

        // ── SMK KAB. MALUKU TENGAH FIX & ADD ─────────────────────────────────
        $k = 'Kabupaten Maluku Tengah';
        $this->tambah('69831986','SMKN 10 MALUKU TENGAH','SMK',$k,'Tehoru');
        $this->tambah('69831987','SMKN 11 MALUKU TENGAH','SMK',$k,'Seram Utara');
        $this->tambah('60100166','SMKN 1 MALUKU TENGAH','SMK',$k,'Masohi');
        $this->tambah('60100352','SMKN 4 MALUKU TENGAH','SMK',$k,'Tehoru');
        $this->tambah('60102251','SMKN 5 MALUKU TENGAH','SMK',$k,'Saparua');
        $this->tambah('60103663','SMKN 8 MALUKU TENGAH','SMK',$k,'Saparua');
        $this->tambah('60103612','SMKN 7 MALUKU TENGAH','SMK',$k,'Salahutu');
        $this->tambah('60103613','SMKS PAR PAMAHANUNUSA','SMK',$k,'Masohi');

        // ── SMK KAB. MALUKU TENGGARA FIX & ADD ───────────────────────────────
        $k = 'Kabupaten Maluku Tenggara';
        $this->tambah('69880238','SMK KESEHATAN LANGGUR','SMK',$k,'Kei Kecil');
        $this->tambah('60100823','SMKN 1 MLK TNGGR','SMK',$k,'Kei Kecil');
        $this->tambah('60100824','SMKN 2 MLK TNGGR','SMK',$k,'Kei Kecil');
        $this->tambah('60103633','SMKN 3 MLK TNGGR','SMK',$k,'Kei Kecil');
        $this->tambah('69921858','SMK TKNLZ ZZHR MSTR','SMK',$k,'Kei Kecil');

        // ── SMK KAB. SERAM BAGIAN BARAT FIX & ADD ────────────────────────────
        $k = 'Kabupaten Seram Bagian Barat';
        $this->tambah('60102760','SMKN 1 SERAM BARAT','SMK',$k,'Kairatu');
        $this->tambah('60102896','SMKN 5 SERAM BAG BART','SMK',$k,'Huamual');
    }
}
