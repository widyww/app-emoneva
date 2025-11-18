<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kota;
use Illuminate\Http\Request;

class FilterGuruStatusController extends Controller
{
    public function index()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);
        return view('kabalai.sort-guru.status', compact('kotas'));
    }

    /**
     * DATA CHART STATUS GURU (PNS / PPPK / Honor)
     */
    public function getData(Request $request)
    {
        $kotaId = $request->query('kota_id');

        $query = Guru::query();

        if ($kotaId) {
            $query->whereHas('sekolah', function ($q) use ($kotaId) {
                $q->where('kota_id', $kotaId);
            });
        }

        // hitung per status
        $pns   = (clone $query)->where('status', 'PNS')->count();
        $pppk  = (clone $query)->where('status', 'PPPK')->count();
        $honor = (clone $query)->where('status', 'Honor')->count();

        return response()->json([
            'labels' => ['PNS', 'PPPK', 'Honor'],
            'series' => [$pns, $pppk, $honor]
        ]);
    }

    /**
     * DETAIL GURU PER STATUS
     */
    public function getDetail(Request $request)
    {
        $kotaId = $request->query('kota_id');
        $status = $request->query('status'); // PNS / PPPK / Honor

        $query = Guru::query()->with('sekolah');

        if ($kotaId) {
            $query->whereHas('sekolah', function ($q) use ($kotaId) {
                $q->where('kota_id', $kotaId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->orderBy('nama')
            ->get()
            ->map(function ($g) {
                return [
                    'nama'    => $g->nama,
                    'status'  => $g->status,
                    'nip'     => $g->nip ?? '-',
                    'nuptk'   => $g->nuptk ?? '-',
                    'mapel'   => $g->mapel ?? '-',
                    'sekolah' => $g->sekolah->nama ?? '-',
                ];
            });

        return response()->json($data);
    }
}
