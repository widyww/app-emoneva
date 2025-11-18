<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class FilterListrikController extends Controller
{
    public function index()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);
        return view('kabalai.sort-sekolah.listrik', compact('kotas'));
    }

    /**
     * DATA CHART (Ada/Tidak)
     */
    public function getData(Request $request)
    {
        $kotaId = $request->query('kota_id');

        // Base query sekolah yang punya fasilitas
        $query = Sekolah::query()->whereHas('fasilitas');

        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        // Hitung tersedia / tidak
        $ada = (clone $query)->whereHas('fasilitas', function ($q) {
            $q->where('listrik_status', 'ada');
        })->count();

        $tidak = (clone $query)->whereHas('fasilitas', function ($q) {
            $q->where('listrik_status', 'tidak');
        })->count();

        return response()->json([
            'labels' => ['Ada', 'Tidak'],
            'series' => [$ada, $tidak]
        ]);
    }

    /**
     * DETAIL SEKOLAH
     */
    public function getDetail(Request $request)
    {
        $kotaId = $request->query('kota_id');
        $status = $request->query('status'); // Ada / Tidak

        $query = Sekolah::query()->with('fasilitas');

        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        if ($status === 'Ada') {
            $query->whereHas('fasilitas', fn($q) => $q->where('listrik_status', 'ada'));
        } else {
            $query->whereHas('fasilitas', fn($q) => $q->where('listrik_status', 'tidak'));
        }

        // Ambil data lengkap
        $data = $query->select('id', 'npsn', 'nama', 'tingkatan', 'alamat')
            ->orderBy('nama')
            ->get()
            ->map(function ($item) {
                return [
                    'npsn' => $item->npsn,
                    'nama' => $item->nama,
                    'tingkatan' => $item->tingkatan,
                    'alamat' => $item->alamat,
                    'sumber' => $item->fasilitas->listrik_sumber ?? '-',
                    'durasi' => $item->fasilitas->listrik_durasi ?? '-',
                ];
            });

        return response()->json($data);
    }
}
