<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class FilterKuotaInternetController extends Controller
{
    public function sortInternet()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);
        return view('kabalai.sort-sekolah.internet', compact('kotas'));
    }


    public function getInternet(Request $request)
    {
        $kotaId = $request->query('kota_id');

        // Query base
        $query = Sekolah::query()
            ->whereHas('fasilitas');

        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        // Hitung "Sesuai"
        $sesuai = (clone $query)->whereHas('fasilitas', function ($q) {
            $q->where('internet_kesesuaian', 'Sesuai');
        })->count();

        // Hitung "Tidak Sesuai"
        $tidakSesuai = (clone $query)->whereHas('fasilitas', function ($q) {
            $q->where('internet_kesesuaian', 'Tidak Sesuai');
        })->count();

        return response()->json([
            'labels' => ['Sesuai', 'Tidak Sesuai'],
            'series' => [$sesuai, $tidakSesuai],
        ]);
    }



    public function getInternetDetail(Request $request)
    {
        $kotaId = $request->query('kota_id');
        $status = $request->query('status'); // "Sesuai" / "Tidak Sesuai"

        $query = Sekolah::query()->with('fasilitas');

        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        if ($status === 'Sesuai') {
            $query->whereHas(
                'fasilitas',
                fn($q) =>
                $q->where('internet_kesesuaian', 'Sesuai')
            );
        } elseif ($status === 'Tidak Sesuai') {
            $query->whereHas(
                'fasilitas',
                fn($q) =>
                $q->where('internet_kesesuaian', 'Tidak Sesuai')
            );
        }

        // Ambil kolom lengkap
        $data = $query->select('id', 'npsn', 'nama', 'tingkatan', 'alamat')
            ->orderBy('nama')
            ->get();

        return response()->json($data);
    }
}
