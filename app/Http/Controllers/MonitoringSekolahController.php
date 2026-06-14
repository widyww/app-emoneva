<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Kecamatan;
use App\Models\Kota;
use Illuminate\Http\Request;

class MonitoringSekolahController extends Controller
{
    public function index()
    {
        $data = Sekolah::with(['kecamatan.kota'])->get();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $kota = Kota::orderBy('nama')->get();

        return view('pages.monitoring-sekolah.index', compact('data', 'kecamatan', 'kota'));
    }
}
