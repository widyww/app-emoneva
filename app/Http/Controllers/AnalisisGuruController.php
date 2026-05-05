<?php

namespace App\Http\Controllers;

use App\Models\GuruKebutuhan;
use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Throwable;

class AnalisisGuruController extends Controller
{
    public function index()
    {
        $kotas = Kota::orderBy('nama')->get(['id', 'nama']);

        return view('kabalai.analisis-guru.index', compact('kotas'));
    }

    public function analyze(Request $request)
    {
        $kotaId = $request->query('kota_id');

        $query = GuruKebutuhan::with(['guru.sekolah.kota'])
            ->whereNotNull('nama_pelatihan')
            ->where('nama_pelatihan', '!=', '');

        if ($kotaId) {
            $query->whereHas('guru.sekolah', fn ($q) => $q->where('kota_id', $kotaId));
        }

        $records = $query->orderBy('nama_pelatihan')->get()->map(function (GuruKebutuhan $kebutuhan) {
            $guru = $kebutuhan->guru;
            $sekolah = $guru?->sekolah;

            return [
                'id' => $kebutuhan->id,
                'guru_id' => $guru?->id,
                'nama' => $guru?->nama ?? '-',
                'mapel' => $guru?->mapel ?? '-',
                'sekolah' => $sekolah?->nama ?? '-',
                'kota' => $sekolah?->kota?->nama ?? '-',
                'kebutuhan' => $kebutuhan->nama_pelatihan,
            ];
        })->values();

        $script = base_path('scripts/teacher_random_forest.py');

        if (! file_exists($script)) {
            return response()->json([
                'error' => 'Script analisis Python tidak ditemukan.',
            ], 500);
        }

        $payload = json_encode(['records' => $records], JSON_UNESCAPED_UNICODE);
        $python = $this->pythonBinary();

        if (! $python) {
            return response()->json([
                'error' => 'Python belum ditemukan di server.',
                'detail' => 'Install Python atau set PYTHON_BINARY di file .env, misalnya PYTHON_BINARY=C:\\Python312\\python.exe.',
            ], 500);
        }

        $result = Process::timeout(60)
            ->input($payload)
            ->run([$python, $script]);

        if ($result->failed()) {
            return response()->json([
                'error' => 'Analisis Python gagal dijalankan.',
                'detail' => trim($result->errorOutput()) ?: trim($result->output()),
            ], 500);
        }

        $analysis = json_decode($result->output(), true);

        if (! is_array($analysis)) {
            return response()->json([
                'error' => 'Output analisis Python tidak valid.',
            ], 500);
        }

        return response()->json($analysis);
    }

    private function pythonBinary(): ?string
    {
        $configured = env('PYTHON_BINARY');

        if ($configured && $this->canRunPython($configured)) {
            return $configured;
        }

        foreach (['python', 'py', 'python3'] as $candidate) {
            if ($this->canRunPython($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private function canRunPython(string $binary): bool
    {
        try {
            return Process::timeout(5)->run([$binary, '--version'])->successful();
        } catch (Throwable) {
            return false;
        }
    }
}
