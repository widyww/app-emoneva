<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\SekolahBantuanDetail;
use App\Models\SekolahBantuanStatus;
use App\Models\SekolahFasilitas;
use App\Models\SekolahSosekbud;
use Illuminate\Http\Request;

class VerifikasiProsesController extends Controller
{
    public function index()
    {
        $data = Sekolah::all();
        return view('verifikator.verifikasi-sekolah', compact('data'));
    }

    public function approve(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update([
            'status_verifikasi' => 1
        ]);

        return redirect()->back()->with('success', 'Sekolah berhasil diverifikasi!');
    }

    public function show($id)
    {
        $identitasSekolah = Sekolah::findOrFail($id);
        $sosekbudSekolah = SekolahSosekbud::where('sekolah_id', $id)->firstOrFail();

        // Ambil status bantuan + relasi detailnya
        $sekolahBantuanStatus = SekolahBantuanStatus::with('details')
            ->where('sekolah_id', $id)
            ->first();

        $sekolahFasilitas = SekolahFasilitas::with('labs')
            ->where('sekolah_id', $id)
            ->first();

        // dd($sekolahFasilitas->toArray());



        // dd($sekolahFasilitas);


        return view('verifikator.verifikasi-detail', compact('identitasSekolah', 'sosekbudSekolah', 'sekolahBantuanStatus', 'sekolahFasilitas'));
    }
}
