<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahLastBatchSeeder extends Seeder
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
        // ── KAB. SERAM BAGIAN BARAT (Page 18) ────────────────────────────────
        $k = 'Kabupaten Seram Bagian Barat';
        $this->tambah('60103906','SMKN 4 SERAM BARAT','SMK',$k,'Kairatu');
        $this->tambah('69854818','SMKN 10 SERAM BAGIAN BARAT','SMK',$k,'Huamual Belakang');
        $this->tambah('60102719','SMKN 1 SERAM BAGIAN BARAT','SMK',$k,'Kairatu');
        $this->tambah('60102720','SMKN 2 SERAM BAGIAN BARAT','SMK',$k,'Kairatu');
        $this->tambah('69991237','SMKN 2 TANIWEL','SMK',$k,'Taniwel');
        $this->tambah('69849625','SMK NEGERI 3 KAIRATU','SMK',$k,'Kairatu');
        $this->tambah('69857916','SMK NEGERI 4 KAIRATU','SMK',$k,'Kairatu');
        $this->tambah('60102782','SMKN 4 SERAM BAGIAN BARAT','SMK',$k,'Kairatu');
        $this->tambah('60103565','SMKN 6 SERAM BAGIAN BARAT','SMK',$k,'Kairatu');
        $this->tambah('60103905','SMKN 7 SERAM BAGIAN BARAT','SMK',$k,'Huamual');
        $this->tambah('60102761','SMKS KRISTEN SERAM BARAT','SMK',$k,'Kairatu');
        $this->tambah('60103952','SMKS TUNAS TIMUR PIRU','SMK',$k,'Kairatu');
        $this->tambah('70012127','SMK TEKNOLOGI INFORMATIKA SBB','SMK',$k,'Kairatu');

        // ── KAB. SERAM BAGIAN TIMUR (Page 18) ────────────────────────────────
        $k = 'Kabupaten Seram Bagian Timur';
        $this->tambah('60101662','SMKN 1 SERAM BAGIAN TIMUR','SMK',$k,'Bula');
        $this->tambah('60103540','SMKN 2 SERAM BAGIAN TIMUR','SMK',$k,'Bula');
        $this->tambah('60103627','SMKN 3 SERAM BAGIAN TIMUR','SMK',$k,'Bula');
        $this->tambah('60103634','SMKN 4 SERAM BAG TIMUR','SMK',$k,'Bula');
        $this->tambah('60103636','SMKN 5 SERAM BAGIAN TIMUR','SMK',$k,'Bula');
        $this->tambah('60103637','SMKN 6 SERAM BAGIAN TIMUR','SMK',$k,'Bula');
        $this->tambah('60103638','SMKN 7 SERAM BAGIAN TIMUR','SMK',$k,'Bula');
        $this->tambah('69725968','SMKN 8 SERAM BAGIAN TIMUR','SMK',$k,'Bula');

        // ── KOTA AMBON (Page 19) ─────────────────────────────────────────────
        $k = 'Kota Ambon';
        $this->tambah('69855682','SMK KESEHATAN FANYOSWER','SMK',$k,'Sirimau');
        $this->tambah('69933074','SMK KESEHATAN NUSANIWE AMBON','SMK',$k,'Nusaniwe');
        $this->tambah('60102779','SMK MUHAMMADIYAH AMBON','SMK',$k,'Sirimau');
        $this->tambah('60102001','SMKN 1 AMBON','SMK',$k,'Sirimau');
        $this->tambah('60101998','SMKN 2 AMBON','SMK',$k,'Nusaniwe');
        $this->tambah('60101987','SMKN 3 AMBON','SMK',$k,'Sirimau');
        $this->tambah('60101973','SMKN 4 AMBON','SMK',$k,'Sirimau');
        $this->tambah('60101983','SMKN 5 AMBON','SMK',$k,'Sirimau');
        $this->tambah('60103099','SMKN 6 AMBON','SMK',$k,'Sirimau');
        $this->tambah('60101997','SMKN 7 AMBON','SMK',$k,'Sirimau');
        $this->tambah('69860529','SMKN 8 AMBON','SMK',$k,'Teluk Ambon');
        $this->tambah('60103924','SMKN PERTANIAN PEMBANGUNAN','SMK',$k,'Nusaniwe');
        $this->tambah('69867984','SMKS PRIMADARMA AMBON','SMK',$k,'Sirimau');
        $this->tambah('60102778','SMKS AL WATHAN AMBON','SMK',$k,'Sirimau');
        $this->tambah('60103671','SMKS JAYANEGARA','SMK',$k,'Sirimau');
        $this->tambah('69761970','SMKS KESEHATAN AMBON','SMK',$k,'Sirimau');
        $this->tambah('69902359','SMKS KESEHATAN TRIMURTI HUSADA','SMK',$k,'Sirimau');
        $this->tambah('60102780','SMKS PGRI AMBON','SMK',$k,'Sirimau');
        $this->tambah('60104523','SUPM N WAIHERU AMBON','SMK',$k,'Baguala');

        // ── KOTA TUAL (Page 19 & 20) ─────────────────────────────────────────
        $k = 'Kota Tual';
        $this->tambah('69849370','SMKN 1 TUAL','SMK',$k,'Pulau Dullah Selatan');
        $this->tambah('69900145','SMKN 2 TUAL','SMK',$k,'Tayando Tam');
        $this->tambah('69824469','SMKN 3 TUAL','SMK',$k,'Kur Selatan');
        $this->tambah('60100825','SMKS PELAYARAN BAHARI NUSANTARA','SMK',$k,'Pulau Dullah Selatan');
        $this->tambah('60100828','SMKS PERIKANAN LUSWED TUAL','SMK',$k,'Pulau Dullah Selatan');
        $this->tambah('60105445','SMKS ROMEL TUAL','SMK',$k,'Pulau Dullah Selatan');
    }
}
