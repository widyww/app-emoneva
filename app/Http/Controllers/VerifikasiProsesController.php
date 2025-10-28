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
        $data = Sekolah::orderByRaw("CASE WHEN status_verifikasi = 1 THEN 0 ELSE 1 END")
            ->orderBy('status_verifikasi', 'asc')
            ->get();

        return view('verifikator.verifikasi-sekolah', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status_verifikasi' => 'required|in:Disetujui,Ditolak',
            'keterangan_verifikasi' => 'nullable|string',
        ]);

        // Ambil sekolah berdasarkan ID
        $sekolah = Sekolah::findOrFail($id);

        // Tentukan status baru berdasarkan input
        if ($request->status_verifikasi === 'Disetujui') {
            $sekolah->status_verifikasi = 2; // Disetujui
        } elseif ($request->status_verifikasi === 'Ditolak') {
            $sekolah->status_verifikasi = 3; // Ditolak
        }

        // Update keterangan verifikasi
        $sekolah->keterangan_verifikasi = $request->keterangan_verifikasi;

        // Simpan perubahan
        $sekolah->save();

        // Redirect dengan pesan sukses
        return redirect()->route('verifikasi-sekolah.index')->with('success', 'Status verifikasi berhasil diperbarui.');
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


        return view('verifikator.verifikasi-sekolah-detail', compact('identitasSekolah', 'sosekbudSekolah', 'sekolahBantuanStatus', 'sekolahFasilitas'));
    }
}
