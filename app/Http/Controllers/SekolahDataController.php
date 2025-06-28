<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekolahDataController extends Controller
{
    public function index()
    {

        $sekolah = Auth::user()->sekolah; // langsung dari relasi
        $kecamatanList = Kecamatan::with('kota')->orderBy('nama')->get();
        return view('operator.index-data',compact('kecamatanList','sekolah'));
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
