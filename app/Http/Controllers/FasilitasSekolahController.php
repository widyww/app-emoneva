<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\SekolahFasilitas;
use App\Models\SekolahFasilitasLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FasilitasSekolahController extends Controller
{
    public function index()
    {
        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah);
        // $fasilitas = SekolahFasilitas::with('sekolah_fasilitastik_lab')->where('sekolah_id', Auth::user()->sekolah_id)->first();

        $fasilitas = SekolahFasilitas::with('labs')
            ->where('sekolah_id', Auth::user()->sekolah_id)
            ->first();


        return view('pages.operator-sekolah.sekolah.fasilitas', compact('sekolah', 'fasilitas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'listrik_status' => 'required|in:ada,tidak',
            'listrik_sumber' => 'nullable|string',
            'listrik_durasi' => 'nullable|string',
            'jumlah_kom' => 'nullable|integer',
            'labkom_status' => 'required|in:ada,tidak',
            'internet_status' => 'required|in:ada,tidak',
            'internet_sumber' => 'nullable|string',
            'internet_bandwith' => 'nullable|string',
            'topologi_jaringan' => 'nullable|string',
            'internet_kesesuaian' => 'nullable|string',
            'internet_alasankuota' => 'nullable|string',
            'saran_pengembangan' => 'nullable|string',
            'labkom_nama' => 'nullable|array',
            'labkom_jumlah_pc' => 'nullable|array',
        ]);

        $sekolahId = Auth::user()->sekolah_id;

        // Simpan atau update fasilitas utama
        $fasilitas = SekolahFasilitas::updateOrCreate(
            ['sekolah_id' => $sekolahId],
            [
                'listrik_status' => $request->listrik_status,
                'listrik_sumber' => $request->listrik_sumber,
                'listrik_durasi' => $request->listrik_durasi,
                'jumlah_kom' => $request->jumlah_kom,
                'labkom_status' => $request->labkom_status,
                'internet_status' => $request->internet_status,
                'internet_sumber' => $request->internet_sumber,
                'internet_bandwith' => $request->internet_bandwith,
                'topologi_jaringan' => $request->topologi_jaringan,
                'internet_kesesuaian' => $request->internet_kesesuaian,
                'internet_alasankuota' => $request->internet_alasankuota,
                'saran_pengembangan' => $request->saran_pengembangan,
            ]
        );

        // Jika ada Lab Komputer
        if ($request->labkom_status === 'ada') {
            // Hapus labkom lama (biar data tidak duplikat saat update)
            SekolahFasilitasLab::where('sekolah_fasilitastik_id', $fasilitas->id)->delete();

            $namaLabs = $request->labkom_nama;
            $jumlahPCs = $request->labkom_jumlah_pc;

            // Simpan labkom baru
            if (is_array($namaLabs) && is_array($jumlahPCs)) {
                foreach ($namaLabs as $i => $nama) {
                    if ($nama || ($jumlahPCs[$i] ?? null)) {
                        SekolahFasilitasLab::create([
                            'sekolah_fasilitastik_id' => $fasilitas->id,
                            'labkom_nama' => $nama,
                            'labkom_jumlah_pc' => $jumlahPCs[$i] ?? 0,
                        ]);
                    }
                }
            }
        } else {
            // Jika status "tidak", hapus semua data labkom yang terkait
            SekolahFasilitasLab::where('sekolah_fasilitastik_id', $fasilitas->id)->delete();
        }

        return redirect()->back()->with('success', 'Data fasilitas sekolah berhasil disimpan.');
    }

    public function destroy($id) {}

    public function destroy_lab($id)
    {
        $lab = SekolahFasilitasLab::findOrFail($id);
        $lab->delete();

        return redirect()->back()->with('success', 'Data lab berhasil dihapus.');
    }
}
