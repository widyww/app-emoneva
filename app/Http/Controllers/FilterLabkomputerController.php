<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Kota;
use App\Models\SekolahFasilitasLab;

class FilterLabkomputerController extends Controller
{
    /**
     * =============================
     * 1. Halaman Utama Filter
     * =============================
     */
    public function sortLabKomputer()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);

        return view('kabalai.sort-sekolah.labkomputer', compact('kotas'));
    }


    /**
     * =========================================================
     * 2. DATA UNTUK CHART (Ada / Tidak Ada Lab Komputer)
     * =========================================================
     */
    public function getLabKomputer(Request $request)
    {
        $kotaId = $request->query('kota_id');

        // Semua sekolah
        $qSekolah = Sekolah::query();
        if ($kotaId) {
            $qSekolah->where('kota_id', $kotaId);
        }
        $total = $qSekolah->count();

        // Ambil sekolah yang punya fasilitas dan punya lab
        $sekolahAdaLab = Sekolah::whereHas('fasilitas.labs')
            ->when($kotaId, fn($q) => $q->where('kota_id', $kotaId))
            ->count();

        $sekolahTidakAda = $total - $sekolahAdaLab;

        return response()->json([
            'labels' => ['Ada', 'Tidak Ada'],
            'series' => [$sekolahAdaLab, $sekolahTidakAda],
        ]);
    }


    /**
     * ===================================================================
     * 3. DATA DETAIL SEKOLAH (Untuk DataTables)
     * ===================================================================
     */
    public function getLabKomputerDetail(Request $request)
    {
        $kotaId = $request->query('kota_id');
        $status = $request->query('status'); // Ada / Tidak Ada

        $query = Sekolah::with('kota');

        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        if ($status === 'Ada') {
            $query->whereHas('fasilitas.labs');
        } elseif ($status === 'Tidak Ada') {
            $query->whereDoesntHave('fasilitas.labs');
        }

        $data = $query->get()->map(function ($s) use ($status) {
            return [
                'npsn'      => $s->npsn,
                'nama'      => $s->nama,
                'tingkatan' => $s->tingkatan,
                'alamat'    => $s->alamat,
                'lab_details' => $status === 'Ada'
                    ? $s->fasilitas->labs->map(function ($lab) {
                        return [
                            'nama_lab'     => $lab->labkom_nama,
                            'jumlah_pc'    => $lab->labkom_jumlah_pc,
                        ];
                    })
                    : [],
            ];
        });

        return response()->json($data);
    }
}
