<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilterAkreditasiController extends Controller
{
    public function sortAkreditasi()
    {
        $kotas = Kota::orderBy('nama')->get();
        return view('kabalai.sort-sekolah.akreditasi', compact('kotas'));
    }

    public function getAkreditasiData(Request $request)
    {
        $kotaId = $request->input('kota_id');

        $query = Sekolah::selectRaw("COALESCE(NULLIF(status_akreditasi, ''), 'Belum Terakreditasi') as status_akreditasi")
            ->selectRaw('count(*) as jumlah');

        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        $dataAkreditasi = $query->groupBy('status_akreditasi')
            ->orderBy('status_akreditasi')
            ->get();

        // Memformat data untuk ApexCharts
        $labels = $dataAkreditasi->pluck('status_akreditasi')->all();
        $series = $dataAkreditasi->pluck('jumlah')->all();

        return response()->json([
            'labels' => $labels,
            'series' => $series,
        ]);
    }

    public function getSekolahDetail(Request $request)
    {
        $kotaId = $request->input('kota_id');
        // Ambil nilai akreditasi, pastikan tidak ada spasi ekstra
        $akreditasiStatus = trim($request->input('akreditasi'));

        try {
            $query = Sekolah::select('nama', 'npsn', 'tingkatan', 'alamat', 'status_akreditasi');

            if ($akreditasiStatus === 'Belum Terakreditasi') {
                $query->where(function($q) {
                    $q->whereNull('status_akreditasi')
                      ->orWhere('status_akreditasi', '');
                });
            } else {
                $query->where('status_akreditasi', $akreditasiStatus);
            }

            if ($kotaId) {
                // Konversi $kotaId ke integer
                $query->where('kota_id', (int)$kotaId);
            }

            $sekolahs = $query->limit(50)->get();

            return response()->json($sekolahs);
        } catch (\Exception $e) {
            // Logging
            Log::error("Gagal getSekolahDetail (Filter Langsung): " . $e->getMessage() . " | Filter Digunakan: " . $akreditasiStatus);

            // Kirim respons error JSON
            return response()->json([
                'error' => 'Terjadi kesalahan server. Cek log Laravel untuk detail.'
            ], 500);
        }
    }
}
