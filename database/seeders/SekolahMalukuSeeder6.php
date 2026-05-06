<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SekolahMalukuSeeder6 extends Seeder
{
    private function tambah(string $npsn, string $nama, string $namaKota, ?string $namaKec = null): void
    {
        $kota = Kota::firstOrCreate(['nama' => $namaKota]);
        $kecId = null;
        if ($namaKec) {
            $kecId = Kecamatan::firstOrCreate(['nama' => $namaKec, 'kota_id' => $kota->id])->id;
        }

        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => $npsn],
            ['nama' => $nama, 'tingkatan' => 'SMA', 'kota_id' => $kota->id, 'kecamatan_id' => $kecId]
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
        // ── KOTA AMBON (SMA Swasta tambahan) ────────────────────────────────
        $kota = 'Kota Ambon';
        $this->tambah('60102019','SMA MUHAMMADIYAH AMBON',$kota,'Sirimau');
        $this->tambah('60102023','SMAS ADVENT MALUKU',$kota,'Sirimau');
        $this->tambah('60103030','SMAS AL HILAAL AMBON',$kota,'Nusaniwe');
        $this->tambah('60102048','SMA ANGKASA PATTIMURA AMBON',$kota,'Teluk Ambon Baguala');
        $this->tambah('60102061','SMAS GEMAH 7 AMBON',$kota,'Sirimau');
        $this->tambah('60102963','SMAS KARTIKA XIII-1 AMBON',$kota,'Sirimau');
        $this->tambah('60102064','SMAS KRISTEN OIKUMENE',$kota,'Nusaniwe');
        $this->tambah('60102022','SMAS KRISTEN REHOBOTH',$kota,'Sirimau');
        $this->tambah('60102021','SMAS KRISTEN YPKPM',$kota,'Sirimau');
        $this->tambah('60102062','SMAS KR KALAM KUDUS',$kota,'Nusaniwe');
        $this->tambah('60103095','SMAS LKND LAHA',$kota,'Leitimur Selatan');
        $this->tambah('60102020','SMAS MARIA MEDIATRIX',$kota,'Nusaniwe');
        $this->tambah('60102028','SMAS PERTIWI AMBON',$kota,'Sirimau');
        $this->tambah('60102017','SMAS PGRI 2 AMBON',$kota,'Sirimau');

        // ── KOTA TUAL (SMA Swasta tambahan) ─────────────────────────────────
        $kota = 'Kota Tual';
        $this->tambah('60100795','SMAS KRISTEN TUAL',$kota,'Pulau Dullah Selatan');
        $this->tambah('60100815','SMAS RONEVAN TUAL',$kota,'Pulau Dullah Selatan');

        // ── KAB. SERAM BAGIAN TIMUR (SMA tambahan) ──────────────────────────
        $kota = 'Kabupaten Seram Bagian Timur';
        $this->tambah('69867919','SMA PERSIAPAN LOULEAN',$kota,'Kilmury');
        $this->tambah('69822776','SMA PERSIAPAN ALAHMATLEAN',$kota,'Seram Timur');
        $this->tambah('60725964','SMA PERSIAPAN TAMHER BARAT',$kota,'Seram Timur');
    }
}
