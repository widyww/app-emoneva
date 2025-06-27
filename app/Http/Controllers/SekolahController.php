<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SekolahController extends Controller
{
    public function index()
    {
        $data = Sekolah::all();
        return view('sekolah.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npsn' => 'required|string|unique:sekolah,npsn',
            'tingkatan' => 'required|string',
            'nama' => 'required|string',
        ]);


        // Simpan ke tabel sekolah
        $sekolah = Sekolah::create([
            'npsn' => $request->npsn,
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,
        ]);

        // Simpan user operator sekolah
        User::create([
            'name' => 'Operator ' . $request->nama,
            'email' => $request->npsn, // Email diganti jadi NPSN
            'password' => Hash::make('password'),
            'role' => 3, // Operator Sekolah
            'sekolah_id' => $sekolah->id,
        ]);

        return redirect()->back()->with('success', 'Data sekolah dan user operator berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'npsn' => 'required|string|unique:sekolah,npsn,' . $id,
            'tingkatan' => 'required|string',
            'nama' => 'required|string',
        ]);

        $sekolah = Sekolah::findOrFail($id);
        $oldNpsn = $sekolah->npsn;

        // Update data sekolah
        $sekolah->update([
            'npsn' => $request->npsn,
            'tingkatan' => $request->tingkatan,
            'nama' => $request->tingkatan,
        ]);

        // Cari user berdasarkan sekolah_id
        $user = User::where('sekolah_id', $sekolah->id)->first();

        if ($user) {
            $user->update([
                'email' => $request->npsn,
            ]);
        }

        return redirect()->back()->with('success', 'Data sekolah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // Hapus user yang terkait jika ada
        User::where('sekolah_id', $sekolah->id)->delete();

        $sekolah->delete();

        return redirect()->back()->with('success', 'Data sekolah dan user terkait berhasil dihapus');
    }
}
