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
        $data = Guru::with(['sekolah.kecamatan'])->get();
        $kecamatan = Kecamatan::orderBy('nama')->get();
        $sekolah = Sekolah::orderBy('nama')->get();

        return view('pages.monitoring-guru.index', compact('data', 'kecamatan', 'sekolah'));
    }
}
