<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class VerifikasiGuruController extends Controller
{
    public function index()
    {
        $data = Guru::all();
        return view('verifikator.verifikasi-guru', compact('data'));
    }
}
