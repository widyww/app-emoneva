<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function index()
    {

        $jumlahSekolah = Sekolah::count();
        $jumlahSekolahVerified = Sekolah::where('status_verifikasi', '2')->count();

        return view('administrator.dashboard',compact('jumlahSekolah','jumlahSekolahVerified') );
    }
}
