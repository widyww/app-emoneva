<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru_id ? Guru::find($user->guru_id) : null;

        // Status verifikasi data guru
        $statusVerifikasi = $guru ? $guru->status_verifikasi : null;
        $catatanVerifikasi = $guru ? $guru->catatan_verifikasi : null;
        $hasData = $guru ? true : false;

        return view('guru.dashboard', compact(
            'guru',
            'statusVerifikasi',
            'catatanVerifikasi',
            'hasData'
        ));
    }
}
