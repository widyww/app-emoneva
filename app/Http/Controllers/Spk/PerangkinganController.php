<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\AhpRingkasan;
use App\Models\Periode;
use App\Models\SawHasil;
use App\Services\Spk\SawService;

/**
 * PerangkinganController (peran Kabalai)
 * ------------------------------------------------------------------
 * Menjalankan perangkingan SAW dan menampilkan hasilnya untuk periode aktif.
 * Perhitungan hanya dijalankan bila bobot AHP periode ini konsisten (CR <= 0,1).
 */
class PerangkinganController extends Controller
{
    public function index()
    {
        $periode   = Periode::where('status', 1)->firstOrFail();
        $ringkasan = AhpRingkasan::where('periode_id', $periode->id)->first();
        $hasil = SawHasil::with('sekolah')
            ->where('periode_id', $periode->id)->orderBy('peringkat')->get();

        return view('spk.perangkingan.index', compact('periode', 'ringkasan', 'hasil'));
    }

    public function hitungUlang(SawService $saw)
    {
        $periode = Periode::where('status', 1)->firstOrFail();
        if (! AhpRingkasan::where('periode_id', $periode->id)->where('konsisten', true)->exists()) {
            return back()->with('status', 'Bobot AHP belum konsisten. Hitung AHP dulu (CR <= 0,1).');
        }
        $r = $saw->hitungDanSimpan($periode);

        return back()->with('status', 'Perangkingan selesai untuk ' . $r['jumlah'] . ' sekolah.');
    }
}
