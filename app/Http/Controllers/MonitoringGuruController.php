<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class MonitoringGuruController extends Controller
{
    public function index()
    {
        $data = Sekolah::with(['guru', 'kecamatan.kota'])->get();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $kota = Kota::orderBy('nama')->get();

        return view('pages.monitoring-guru.index', compact('data', 'kecamatan', 'kota'));
        
    }
}
