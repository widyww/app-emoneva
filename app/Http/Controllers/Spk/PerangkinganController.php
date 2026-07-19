<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Models\AhpRingkasan;
use App\Models\Periode;
use App\Models\SawHasil;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Services\Spk\SawService;
use Illuminate\Http\Request;

/**
 * PerangkinganController (peran Kabalai)
 * ------------------------------------------------------------------
 * Menjalankan perangkingan SAW dan menampilkan hasilnya untuk periode aktif.
 * Perhitungan hanya dijalankan bila bobot AHP periode ini konsisten (CR <= 0,1).
 */
class PerangkinganController extends Controller
{
    public function index(Request $request)
    {
        $periode   = Periode::where('status', 1)->firstOrFail();
        $ringkasan = AhpRingkasan::where('periode_id', $periode->id)->first();
        
        $kota_id = $request->input('kota_id');
        $kecamatan_id = $request->input('kecamatan_id');
        
        $query = SawHasil::with('sekolah')
            ->where('periode_id', $periode->id);
            
        if ($kota_id) {
            $query->whereHas('sekolah', function($q) use ($kota_id) {
                $q->where('kota_id', $kota_id);
            });
        }
        
        if ($kecamatan_id) {
            $query->whereHas('sekolah', function($q) use ($kecamatan_id) {
                $q->where('kecamatan_id', $kecamatan_id);
            });
        }
            
        $hasil = $query->orderBy('peringkat')->get();
        
        $kotas = Kota::all();
        $kecamatans = $kota_id ? Kecamatan::where('kota_id', $kota_id)->get() : collect();

        return view('spk.perangkingan.index', compact('periode', 'ringkasan', 'hasil', 'kotas', 'kecamatans', 'kota_id', 'kecamatan_id'));
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
