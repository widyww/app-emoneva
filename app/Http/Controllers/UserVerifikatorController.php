<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class UserVerifikatorController extends Controller
{
    public function index()
    {
         $jumlahSekolah = Sekolah::count();
        $jumlahGuru = Guru::count();
        $jumlahSekolahNotInput = Sekolah::where('status_verifikasi', '0')->count();
        $jumlahSekolahWaitVerified = Sekolah::where('status_verifikasi', '1')->count();
        $jumlahSekolahVerified = Sekolah::where('status_verifikasi', '2')->count();
        $jumlahGuruWaitVerified = Guru::where('status_verifikasi', '0')->count();
        $jumlahGuruVerified = Guru::where('status_verifikasi', '1')->count();
        return view('verifikator.dashboard', compact('jumlahGuruWaitVerified','jumlahSekolahWaitVerified','jumlahSekolahNotInput','jumlahSekolah', 'jumlahGuru','jumlahGuruVerified','jumlahSekolahVerified'));
    }
}
