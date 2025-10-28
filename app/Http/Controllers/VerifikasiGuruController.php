<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class VerifikasiGuruController extends Controller
{
    public function index()
    {
        $data = Guru::with('sekolah.kecamatan.kota')
            ->orderByRaw("CASE WHEN status_verifikasi = 0 THEN 0 ELSE 1 END")
            ->orderBy('status_verifikasi', 'asc')
            ->get();

        return view('verifikator.verifikasi-guru', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string'
        ]);

        // Cari data guru
        $guru = Guru::findOrFail($id);

        // Jika disetujui
        if ($request->status_verifikasi === 'disetujui') {
            $guru->status_verifikasi = 1;
            $guru->catatan_verifikasi = null; // kosongkan catatan
        }
        // Jika ditolak
        else {
            $guru->status_verifikasi = 2;
            $guru->catatan_verifikasi = $request->catatan_verifikasi;
        }

        $guru->save();

        return redirect()->route('verifikasi-guru.index')->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function show($id)
    {

        // Ambil data guru lengkap dengan relasinya
        $guru = Guru::with([
            'sekolah.kecamatan.kota',
            'pelatihan',
            'kebutuhanPelatihan'
        ])->findOrFail($id);

        // Kirim ke view

        return view('verifikator.verifikasi-guru-detail', compact('guru'));
    }
}
