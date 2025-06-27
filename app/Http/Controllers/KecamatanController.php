<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kota;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $data = Kecamatan::with('kota')->get(); // relasi dengan kota
        $kotaList = Kota::all(); // untuk select option
        return view('kecamatan.index', compact('data', 'kotaList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota_id' => 'required|exists:kota,id',
        ]);

        Kecamatan::create([
            'nama' => $request->nama,
            'kota_id' => $request->kota_id,
        ]);

        return redirect()->back()->with('success', 'Data kecamatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kota_id' => 'required|exists:kota,id',
        ]);

        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->update([
            'nama' => $request->nama,
            'kota_id' => $request->kota_id,
        ]);

        return redirect()->back()->with('success', 'Data kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->delete();

        return redirect()->back()->with('success', 'Data kecamatan berhasil dihapus.');
    }
}
