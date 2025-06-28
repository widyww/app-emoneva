<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $data = Periode::orderBy('tahun', 'desc')->get();
        return view('pages.periode.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|digits:4|integer',
        ]);

        Periode::create([
            'tahun' => $request->tahun,
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Periode berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|digits:4|integer',
        ]);

        $periode = Periode::findOrFail($id);
        $periode->update(['tahun' => $request->tahun]);

        return redirect()->back()->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Periode::destroy($id);
        return redirect()->back()->with('success', 'Periode berhasil dihapus.');
    }

    public function setAktif($id)
    {
        Periode::query()->update(['status' => 0]);
        Periode::where('id', $id)->update(['status' => 1]);

        return redirect()->back()->with('success', 'Periode berhasil diatur sebagai aktif.');
    }
}
