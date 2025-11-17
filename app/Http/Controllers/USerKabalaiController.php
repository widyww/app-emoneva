<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class USerKabalaiController extends Controller
{
    public function index()
    {
        $jumlahSekolah = Sekolah::count();
        $jumlahGuru = Guru::count();
        $jumlahSekolahVerified = Sekolah::where('status_verifikasi', '2')->count();
        $jumlahGuruVerified = Guru::where('status_verifikasi', '1')->count();
        return view('kabalai.dashboard', compact('jumlahSekolah', 'jumlahGuru','jumlahGuruVerified','jumlahSekolahVerified'));
   
    }
}
