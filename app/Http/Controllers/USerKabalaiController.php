<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class USerKabalaiController extends Controller
{
    public function index()
    {
        $jumlahSekolah = Sekolah::count();
        $jumlahSekolahNotInput = Sekolah::where('status_verifikasi', '0')->count();
        $jumlahSekolahWaitVerified = Sekolah::where('status_verifikasi', '1')->count();
        $jumlahSekolahVerified = Sekolah::where('status_verifikasi', '2')->count();

        return view('kabalai.dashboard', compact('jumlahSekolahNotInput', 'jumlahSekolahWaitVerified', 'jumlahSekolah', 'jumlahSekolahVerified'));
    }
}
