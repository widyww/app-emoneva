<?php

namespace App\Services\Spk;

use App\Models\Sekolah;

/**
 * RubrikKebutuhan
 * ------------------------------------------------------------------
 * Mengubah data mentah sekolah menjadi skor kebutuhan 1-5 untuk tiap
 * kriteria (C1-C5). Semua kriteria bersifat BENEFIT terhadap tujuan
 * "prioritas bantuan": makin butuh => skor makin tinggi.
 *
 * Angka ambang di bawah PERSIS mengikuti Tabel 1.2 pada panduan
 * (docs/Panduan_Implementasi_AHP_SAW_emoNeva.md) agar hasil identik
 * dengan berkas Excel/skripsi. Jangan diubah bila ingin hasil sama.
 */
class RubrikKebutuhan
{
    /** @return array{C1:int,C2:int,C3:int,C4:int,C5:int} */
    public function skor(Sekolah $s): array
    {
        $f = $s->fasilitas;

        return [
            'C1' => $this->c1($s, $f),
            'C2' => $this->c2($f),
            'C3' => $this->c3($f),
            'C4' => $this->c4($f),
            'C5' => $this->c5($s),
        ];
    }

    private function c1(Sekolah $s, $f): int
    {
        $kom   = is_numeric($f?->jumlah_kom) ? (float) $f->jumlah_kom : null;
        $siswa = $s->jumlahSiswa();
        if ($kom === null || $siswa <= 0) {
            return 5;      // data kosong
        }
        $r = $kom / $siswa;

        return match (true) {
            $r >= 0.10   => 1,
            $r >= 0.075  => 2,
            $r >= 0.05   => 3,
            $r >= 0.025  => 4,
            default      => 5,
        };
    }

    private function c2($f): int
    {
        $d = is_numeric($f?->listrik_durasi) ? (float) $f->listrik_durasi : null;
        if ($d === null) {
            return 5;                       // kosong
        }
        if ($d > 24) {
            return 1;                       // anomali satuan VA => listrik penuh
        }

        return match (true) {
            $d <= 6   => 5,
            $d <= 11  => 4,
            $d <= 17  => 3,
            $d <= 23  => 2,
            default   => 1,                 // 24 jam
        };
    }

    private function c3($f): int
    {
        $bw = is_numeric($f?->internet_bandwith) ? (float) $f->internet_bandwith : null;
        if (($f?->internet_status ?? 'tidak') === 'tidak' || $bw === 0.0) {
            return 5;
        }
        if ($bw === null) {
            return 5;                        // kosong
        }

        return match (true) {
            $bw <= 9   => 4,
            $bw <= 24  => 3,
            $bw <= 49  => 2,
            default    => 1,                 // >= 50
        };
    }

    private function c4($f): int
    {
        return ($f?->labkom_status ?? 'tidak') === 'ada' ? 1 : 5;
    }

    private function c5(Sekolah $s): int
    {
        return ($s->bantuanStatus?->status === 'ya') ? 2 : 5;   // belum/kosong => 5
    }
}
