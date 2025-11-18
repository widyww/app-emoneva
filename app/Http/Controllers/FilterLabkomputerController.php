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

        // Query dasar sekolah
        $qSekolah = Sekolah::query();

        if ($kotaId) {
            $qSekolah->where('kota_id', $kotaId);
        }

        $total = $qSekolah->count();

        // Ambil sekolah yang punya lab
        $sekolahAdaLab = SekolahFasilitasLab::select('sekolah_id')
            ->distinct()
            ->when($kotaId, function ($q) use ($kotaId) {
                $q->whereIn('sekolah_id', Sekolah::where('kota_id', $kotaId)->pluck('id'));
            })
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

        $sekolahAdaLabIds = SekolahFasilitasLab::select('sekolah_id')->distinct()->pluck('sekolah_id');

        // Base query
        $query = Sekolah::with('kota');

        // Filter Kota
        if ($kotaId) {
            $query->where('kota_id', $kotaId);
        }

        // Filter status Lab Komputer
        if ($status === 'Ada') {
            $query->whereIn('id', $sekolahAdaLabIds)
                ->with(['labKomputers' => function ($q) {
                    $q->select('id', 'sekolah_id', 'nama_lab', 'kapasitas');
                }]);
        } elseif ($status === 'Tidak Ada') {
            $query->whereNotIn('id', $sekolahAdaLabIds);
        } else {
            return response()->json([]); // invalid status
        }

        $data = $query->get()->map(function ($s) use ($status) {
            return [
                'npsn'        => $s->npsn,
                'nama'        => $s->nama,
                'tingkatan'   => $s->tingkatan,
                'alamat'      => $s->alamat,
                'lab_details' => $status === 'Ada'
                    ? $s->labKomputers->toArray()
                    : [],
            ];
        });

        return response()->json($data);
    }
}
