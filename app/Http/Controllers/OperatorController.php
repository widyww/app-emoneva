<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sekolah = Sekolah::find($user->sekolah_id);

        // Ambil status verifikasi sekolah
        $statusSekolah = $sekolah ? $sekolah->status_verifikasi : null;

        // Pastikan $sekolah ada dulu
        $sekolahId = $sekolah ? $sekolah->id : null;

        // Ambil total semua guru
        $totalGuru = Guru::where('sekolah_id', $sekolahId)->count();

        // Ambil jumlah berdasarkan status_verifikasi
        $terverifikasi = Guru::where('status_verifikasi', 1)->where('sekolah_id', $sekolahId)->count();
        $perluPerbaikan = Guru::where('status_verifikasi', 2)->where('sekolah_id', $sekolahId)->count();
        $menunggu = Guru::where('status_verifikasi', 0)->where('sekolah_id', $sekolahId)->count();

        return view('operator.dashboard', compact(
            'totalGuru',
            'terverifikasi',
            'perluPerbaikan',
            'menunggu',
            'statusSekolah'
        ));
    }
}
