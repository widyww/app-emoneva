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

        $query = \App\Models\GuruKebutuhan::whereHas('guru', function($q) use ($kotaId) {
            $q->where('pelatihan_kebutuhan', 'Ya');
            if ($kotaId) {
                $q->whereHas('sekolah', fn($sq) => $sq->where('kota_id', $kotaId));
            }
        });

        $stats = $query->select('nama_pelatihan', \DB::raw('count(*) as total'))
            ->groupBy('nama_pelatihan')
            ->orderBy('total', 'desc')
            ->take(10) // Batasi 10 besar agar chart tidak overload
            ->get();

        $labels = $stats->pluck('nama_pelatihan')->toArray();
        $series = $stats->pluck('total')->toArray();

        return response()->json([
            'labels' => $labels,
            'series' => $series
        ]);
    }

    public function getDetail(Request $request)
    {
        $kotaId = $request->query('kota_id');
        $pelatihan = $request->query('pelatihan');

        $query = Guru::with(['sekolah.kota', 'kebutuhanPelatihan'])
            ->where('pelatihan_kebutuhan', 'Ya');

        if ($kotaId) {
            $query->whereHas('sekolah', fn($q) => $q->where('kota_id', $kotaId));
        }

        if ($pelatihan) {
            $query->whereHas('kebutuhanPelatihan', fn($q) => $q->where('nama_pelatihan', $pelatihan));
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
