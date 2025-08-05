<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\SekolahBantuanDetail;
use App\Models\SekolahBantuanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BantuanSekolahController extends Controller
{
    public function index()
    {

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah); // ambil data sekolah
        $status = SekolahBantuanStatus::where('sekolah_id', $idsekolah)->first();
        $bantuan = $status && $status->status === 'ya'
            ? SekolahBantuanDetail::where('sekolah_bantuan_status_id', $status->id)->get()
            : [];

        return view('pages.operator-sekolah.sekolah.bantuan', compact('status', 'bantuan', 'sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:ya,tidak',
            'nama_lembaga.*' => 'required_if:status,ya',
            'keterangan_bantuan.*' => 'required_if:status,ya',
        ]);

        $sekolahId = Auth::user()->sekolah_id;

        // Cari atau buat status
        $status = SekolahBantuanStatus::firstOrNew(['sekolah_id' => $sekolahId]);
        $status->status = $request->status;
        $status->save();

        // Hapus bantuan sebelumnya
        SekolahBantuanDetail::where('sekolah_bantuan_status_id', $status->id)->delete();

        // Simpan ulang jika status = ya
        if ($request->status === 'ya') {
            foreach ($request->nama_lembaga as $i => $nama) {
                SekolahBantuanDetail::create([
                    'sekolah_bantuan_status_id' => $status->id,
                    'nama_lembaga' => $nama,
                    'keterangan_bantuan' => $request->keterangan_bantuan[$i],
                ]);
            }
        }

        return back()->with('success', 'Data bantuan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $bantuan = SekolahBantuanDetail::findOrFail($id);
        $bantuan->delete();

        return response()->json(['message' => 'Data bantuan berhasil dihapus.']);
    }
}
