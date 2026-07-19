<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Periode;
use App\Models\SawHasil;
use Illuminate\Http\Request;

class USerKabalaiController extends Controller
{
    public function index()
    {
        $jumlahSekolah = Sekolah::count();
        $jumlahSekolahNotInput = Sekolah::where('status_verifikasi', '0')->count();
        $jumlahSekolahWaitVerified = Sekolah::where('status_verifikasi', '1')->count();
        $jumlahSekolahVerified = Sekolah::where('status_verifikasi', '2')->count();

        // Ambil periode aktif
        $periode = Periode::where('status', 1)->first();
        $hasilSpk = collect();
        if ($periode) {
            // Ambil top 10 prioritas (atau semua, di sini kita ambil 10 teratas untuk dashboard)
            $hasilSpk = SawHasil::with('sekolah')
                ->where('periode_id', $periode->id)
                ->orderBy('peringkat')
                ->take(10)
                ->get();
        }

        return view('kabalai.dashboard', compact('jumlahSekolahNotInput', 'jumlahSekolahWaitVerified', 'jumlahSekolah', 'jumlahSekolahVerified', 'hasilSpk', 'periode'));
    }
}
