<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kota;
use Illuminate\Http\Request;

class FilterGuruPendidikanController extends Controller
{
    // urutan jenjang yang akan tampil di chart
    private $levels = [
        "SMA/SMK/Sederajat",
        "D2",
        "D3",
        "S1/D4",
        "S2",
        "S3",
    ];

    public function index()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);
        return view('kabalai.sort-guru.pendidikan', compact('kotas'));
    }

    /**
     * Kembalikan labels (jenjang) + series (jumlah per jenjang) untuk kab/kota yang dipilih
     * Query param: kota_id (optional)
     */
    public function getData(Request $request)
    {
        $kotaId = $request->query('kota_id');

        $series = [];
        foreach ($this->levels as $level) {
            $query = Guru::query();

            if ($kotaId) {
                $query->whereHas('sekolah', fn($q) => $q->where('kota_id', $kotaId));
            }

            $series[] = $query->where('pendidikan_terakhir', $level)->count();
        }

        return response()->json([
            'labels' => $this->levels,
            'series' => $series,
        ]);
    }

    /**
     * Kembalikan daftar guru untuk jenjang (level) dan kab/kota
     * Query params:
     *  - level (required)  -> salah satu dari $this->levels
     *  - kota_id (optional)
     */
    public function getDetail(Request $request)
    {
        $level  = $request->query('level');
        $kotaId = $request->query('kota_id');

        if (!in_array($level, $this->levels)) {
            return response()->json([], 200);
        }

        $query = Guru::query()->with(['sekolah.kota']);

        $query->where('pendidikan_terakhir', $level);

        if ($kotaId) {
            $query->whereHas('sekolah', fn($q) => $q->where('kota_id', $kotaId));
        }

        $data = $query->orderBy('nama')->get()->map(function ($g) {
            return [
                'npsn'       => $g->sekolah->npsn ?? '-',
                'nama'       => $g->nama ?? '-',
                'nip'        => $g->nip ?? '-',
                'nuptk'      => $g->nuptk ?? '-',
                'mapel'      => $g->mapel ?? '-',
                'tingkatan'  => $g->sekolah->tingkatan ?? '-',
                'alamat'     => $g->sekolah->alamat ?? '-',
                'sekolah'    => $g->sekolah->nama ?? '-',
                'pendidikan' => $g->pendidikan_terakhir ?? '-',
            ];
        });

        return response()->json($data);
    }
}
