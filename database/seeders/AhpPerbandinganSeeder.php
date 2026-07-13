<?php

namespace Database\Seeders;

use App\Models\AhpPerbandingan;
use App\Models\Kriteria;
use App\Models\Periode;
use Illuminate\Database\Seeder;

/**
 * Menanam 10 nilai segitiga atas matriks perbandingan (Excel) untuk
 * periode aktif, plus sisi bawah (kebalikan) dan diagonal (1). Nilai ini
 * mereproduksi bobot Excel: C1=0.4011, C2=0.1051, C3=0.2681, C4=0.1631,
 * C5=0.0626 dengan CR = 0.019 (<= 0.10).
 */
class AhpPerbandinganSeeder extends Seeder
{
    public function run(): void
    {
        $periode = Periode::where('status', 1)->first()
                ?? Periode::first();

        if (! $periode) {
            $this->command?->warn('AhpPerbandinganSeeder dilewati: belum ada data periode.');
            return;
        }

        $k = Kriteria::pluck('id', 'kode');   // ['C1'=>1,...]

        // pasangan => nilai baris terhadap kolom
        $pasangan = [
            ['C1', 'C2', 3], ['C1', 'C3', 2], ['C1', 'C4', 3], ['C1', 'C5', 5],
            ['C2', 'C3', 1 / 3], ['C2', 'C4', 1 / 2], ['C2', 'C5', 2],
            ['C3', 'C4', 2], ['C3', 'C5', 4],
            ['C4', 'C5', 3],
        ];

        foreach ($pasangan as [$a, $b, $nilai]) {
            // sel atas
            AhpPerbandingan::updateOrCreate(
                ['periode_id' => $periode->id, 'kriteria_baris_id' => $k[$a], 'kriteria_kolom_id' => $k[$b]],
                ['nilai' => round($nilai, 4)]
            );
            // sel bawah (kebalikan)
            AhpPerbandingan::updateOrCreate(
                ['periode_id' => $periode->id, 'kriteria_baris_id' => $k[$b], 'kriteria_kolom_id' => $k[$a]],
                ['nilai' => round(1 / $nilai, 4)]
            );
        }

        // diagonal = 1
        foreach ($k as $id) {
            AhpPerbandingan::updateOrCreate(
                ['periode_id' => $periode->id, 'kriteria_baris_id' => $id, 'kriteria_kolom_id' => $id],
                ['nilai' => 1]
            );
        }
    }
}
