<?php

namespace App\Http\Controllers;

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

        return view('operator.dashboard', compact(
            'statusSekolah'
        ));
    }
}

