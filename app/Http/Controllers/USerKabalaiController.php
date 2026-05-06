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
        return view('kabalai.dashboard', compact('jumlahSekolahWaitVerified','jumlahSekolahNotInput','jumlahSekolah', 'jumlahSekolahVerified'));
    }

    public function downloadDataset()
    {
        $path = base_path('scratch/dataset_knn_sekolah.csv');
        
        if (!file_exists($path)) {
            return back()->with('error', 'File dataset belum dibuat. Silakan hubungi Admin.');
        }

        return response()->download($path, 'dataset_knn_sekolah_' . date('Y-m-d') . '.csv');
    }
}
