<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kota;
use Illuminate\Http\Request;

class FilterGuruKebutuhanPelatihanController extends Controller
{
    public function index()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);
        return view('kabalai.sort-guru.kebutuhanpelatihan', compact('kotas'));
    }

    public function getData(Request $request)
    {
        $kotaId = $request->query('kota_id');

        $query = Guru::with(['sekolah.kota', 'kebutuhanPelatihan'])
            ->where('pelatihan_kebutuhan', 'Ya'); // 🔥 filter

        if ($kotaId) {
            $query->whereHas('sekolah', fn($q) => $q->where('kota_id', $kotaId));
        }

        $data = $query->orderBy('nama')->get()->map(function ($g) {
            return [
                'nama'        => $g->nama,
                'nip'         => $g->nip ?? '-',
                'nuptk'       => $g->nuptk ?? '-',
                'sekolah'     => $g->sekolah->nama ?? '-',
                'kota'        => $g->sekolah->kota->nama ?? '-',
                'pelatihan'   => $g->kebutuhanPelatihan->pluck('nama_pelatihan')->implode(', ') ?: '-'
            ];
        });

        return response()->json($data);
    }
}
