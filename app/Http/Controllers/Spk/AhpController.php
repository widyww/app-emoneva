<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\AhpBobot;
use App\Models\AhpPerbandingan;
use App\Models\AhpRingkasan;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Services\Spk\AhpService;
use Illuminate\Http\Request;

/**
 * AhpController (peran Administrator)
 * ------------------------------------------------------------------
 * Mengelola matriks perbandingan berpasangan AHP dan menghasilkan bobot
 * kriteria + nilai konsistensi (CR) untuk periode aktif.
 */
class AhpController extends Controller
{
    public function index()
    {
        $periode  = Periode::where('status', 1)->firstOrFail();
        $kriteria = Kriteria::orderBy('urutan')->get();
        $sel = AhpPerbandingan::where('periode_id', $periode->id)
            ->get()->keyBy(fn ($r) => $r->kriteria_baris_id . '-' . $r->kriteria_kolom_id);
        $ringkasan = AhpRingkasan::where('periode_id', $periode->id)->first();
        $bobot = AhpBobot::where('periode_id', $periode->id)->pluck('bobot', 'kriteria_id');

        return view('spk.ahp.index', compact('periode', 'kriteria', 'sel', 'ringkasan', 'bobot'));
    }

    // Simpan input matriks (hanya segitiga atas dari form) lalu hitung bobot
    public function hitung(Request $request, AhpService $ahp)
    {
        $periode  = Periode::where('status', 1)->firstOrFail();
        $kriteria = Kriteria::orderBy('urutan')->get();
        $ids      = $kriteria->pluck('id')->values();
        $n        = $ids->count();

        // request->nilai[i][j] hanya untuk i<j (segitiga atas)
        $input = $request->input('nilai', []);
        foreach ($ids as $i => $ida) {
            foreach ($ids as $j => $idb) {
                if ($i === $j) {
                    $val = 1;
                } elseif ($i < $j) {
                    $val = (float) ($input[$i][$j] ?? 1);
                } else {
                    $val = 1 / ((float) ($input[$j][$i] ?? 1));
                }
                AhpPerbandingan::updateOrCreate(
                    ['periode_id' => $periode->id, 'kriteria_baris_id' => $ida, 'kriteria_kolom_id' => $idb],
                    ['nilai' => round($val, 4)]
                );
            }
        }

        // Bangun matriks numerik & hitung
        $m = [];
        foreach ($ids as $i => $ida) {
            foreach ($ids as $j => $idb) {
                $m[$i][$j] = (float) AhpPerbandingan::where([
                    'periode_id' => $periode->id, 'kriteria_baris_id' => $ida, 'kriteria_kolom_id' => $idb,
                ])->value('nilai');
            }
        }
        $r = $ahp->hitung($m);

        // Simpan bobot & ringkasan
        foreach ($ids as $i => $id) {
            AhpBobot::updateOrCreate(
                ['periode_id' => $periode->id, 'kriteria_id' => $id],
                ['bobot' => round($r['bobot'][$i], 6)]
            );
        }
        AhpRingkasan::updateOrCreate(
            ['periode_id' => $periode->id],
            ['lambda_maks' => round($r['lambda_maks'], 4), 'ci' => round($r['ci'], 4),
             'ri' => $r['ri'], 'cr' => round($r['cr'], 4), 'konsisten' => $r['konsisten'], 'dihitung_pada' => now()]
        );

        $msg = $r['konsisten']
            ? 'Bobot berhasil dihitung. CR = ' . number_format($r['cr'], 4) . ' (konsisten).'
            : 'PERINGATAN: CR = ' . number_format($r['cr'], 4) . ' > 0,10. Perbaiki penilaian.';

        return back()->with('status', $msg);
    }
}
