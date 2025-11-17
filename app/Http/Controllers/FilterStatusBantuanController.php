<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahBantuanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilterStatusBantuanController extends Controller
{
    /**
     * Menampilkan halaman utama statistik bantuan (view dengan dropdown kota).
     */
    public function sortBantuan()
    {
        // Memuat semua Kota/Kabupaten untuk dropdown filter
        $kotas = Kota::orderBy('nama')->get();
        // Path view BARU: 'kabalai.sort-sekolah.statusbantuan'
        return view('kabalai.sort-sekolah.statusbantuan', compact('kotas'));
    }

    /**
     * Mengambil data agregasi (jumlah) sekolah berdasarkan status bantuan ('Ya' atau 'Tidak') per Kota.
     */
    public function getBantuanData(Request $request)
    {
        $kotaId = $request->input('kota_id');

        try {
            // Kita mulai dari Model SekolahBantuanStatus karena di sana ada kolom 'status'
            $query = SekolahBantuanStatus::select('status')
                ->selectRaw('count(*) as jumlah')
                ->groupBy('status');

            if ($kotaId) {
                // Filter menggunakan whereHas pada relasi 'sekolah'
                $query->whereHas('sekolah', function ($q) use ($kotaId) {
                    $q->where('kota_id', (int)$kotaId);
                });
            }

            $dataBantuan = $query->get();

            // Memformat data untuk ApexCharts
            $labels = $dataBantuan->pluck('status')->all();
            $series = $dataBantuan->pluck('jumlah')->all();

            return response()->json([
                'labels' => $labels,
                'series' => $series,
            ]);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error("Gagal getBantuanData: " . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data chart'], 500);
        }
    }

    /**
     * Mengambil data detail sekolah (Sekolah dan Detail Bantuan).
     * Memperbaiki masalah di mana detail bantuan tidak muncul karena struktur relasi
     * tidak sesuai dengan ekspektasi frontend.
     */
    public function getSekolahBantuanDetail(Request $request)
    {
        $kotaId = $request->input('kota_id');
        $statusBantuan = $request->input('status');

        try {
            $query = Sekolah::select('id', 'nama', 'npsn', 'tingkatan', 'alamat')
                // Eager load bantuanStatus, dan di dalamnya, eager load details
                ->with(['bantuanStatus' => function ($query) {
                    $query->with('details');
                }])
                ->whereHas('bantuanStatus', function ($q) use ($statusBantuan) {
                    $q->where('status', $statusBantuan);
                });

            if ($kotaId) {
                $query->where('kota_id', intval($kotaId));
            }

            $sekolahs = $query->get();

            // --- BAGIAN PENTING UNTUK MEMPERBAIKI: Mapping Data ---
            // Kita memetakan hasil untuk menampakkan detail bantuan 
            // ke properti 'bantuan_details' yang diharapkan oleh frontend (Blade JS).
            $formattedSekolahs = $sekolahs->map(function ($sekolah) {
                // Dapatkan koleksi detail dari relasi bertingkat: sekolah.bantuanStatus.details
                $bantuanDetails = $sekolah->bantuanStatus->details ?? collect();

                // Ambil semua atribut sekolah
                $data = $sekolah->toArray();

                // Tambahkan 'bantuan_details' ke root object sekolah (seperti yang diharapkan JS)
                $data['bantuan_details'] = $bantuanDetails->map(function ($detail) {
                    return [
                        'nama_lembaga' => $detail->nama_lembaga,
                        'keterangan_bantuan' => $detail->keterangan_bantuan,
                    ];
                })->toArray();

                // Hapus relasi 'bantuanStatus' dari output JSON agar lebih bersih
                unset($data['bantuan_status']);

                return $data;
            });
            // --- AKHIR BAGIAN PENTING ---

            return response()->json($formattedSekolahs);
        } catch (\Exception $e) {
            Log::error("Gagal getSekolahBantuanDetail: " . $e->getMessage());
            return response()->json([
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
