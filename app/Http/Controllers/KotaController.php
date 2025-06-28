<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function index()
    {
        $data = Kota::all();
        return view('pages.kota.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Kota::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Data kota berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kota = Kota::findOrFail($id);
        $kota->update([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Data kota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kota = Kota::findOrFail($id);
        $kota->delete();

        return redirect()->back()->with('success', 'Data kota berhasil dihapus.');
    }
}
