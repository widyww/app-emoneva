<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kota;
use Illuminate\Http\Request;

class FilterSertifikasiStatusController extends Controller
{
    private $statusOptions = ['Ya', 'Tidak'];

    public function index()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);
        return view('kabalai.sort-guru.sertifikasi', compact('kotas'));
    }

    public function getData(Request $request)
    {
        $kotaId = $request->query('kota_id');

        $series = [];
        foreach ($this->statusOptions as $status) {
            $query = Guru::query();
            if ($kotaId) {
                $query->whereHas('sekolah', fn($q) => $q->where('kota_id', $kotaId));
            }
            $series[] = $query->where('sertifikasi_status', $status)->count();
        }

        return response()->json([
            'labels' => $this->statusOptions,
            'series' => $series,
        ]);
    }

    public function getDetail(Request $request)
    {
        $status  = $request->query('status');
        $kotaId  = $request->query('kota_id');

        if (!in_array($status, $this->statusOptions)) {
            return response()->json([], 200);
        }

        $query = Guru::query()->with(['sekolah.kota']);
        $query->where('sertifikasi_status', $status);

        if ($kotaId) {
            $query->whereHas('sekolah', fn($q) => $q->where('kota_id', $kotaId));
        }

        $data = $query->orderBy('nama')->get()->map(function ($g) use ($status) {
            return [
                'nama'       => $g->nama,
                'nip'        => $g->nip ?? '-',
                'nuptk'      => $g->nuptk ?? '-',
                'mapel'      => $g->mapel ?? '-',
                'sekolah'    => $g->sekolah->nama ?? '-',
                'kota'       => $g->sekolah->kota->nama ?? '-',
                'sertifikasi_status' => $g->sertifikasi_status,
                'sertifikasi_info'   => $g->sertifikasi_status === 'Ya' ? ($g->sertifikasi_tahun ?? '-') : ($g->sertifikasi_alasan ?? '-')
            ];
        });

        return response()->json($data);
    }
}
