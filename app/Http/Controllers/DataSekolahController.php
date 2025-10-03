<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataSekolahController extends Controller
{
    public function index_identitas()
    {

        $kecamatanList = Kecamatan::with('kota')->orderBy('kota_id')->get(); // relasi dengan kota

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah);
        return view('pages.operator-sekolah.sekolah.identitas', compact('sekolah', 'kecamatanList'));
    }    

    public function update_identitas(Request $request)
    {
        $request->validate([
            'npsn' => 'required|string|max:20',
            'tingkatan' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:100',
            'sk_ijin' => 'nullable|string|max:100',
            'status_sekolah' => 'required|in:Negeri,Swasta',
            'status_akreditasi' => 'required|in:Terakreditasi A,Terakreditasi B,Terakreditasi C,Belum Terakreditasi,Tidak Terakreditasi',
            'status_tanah' => 'required|in:Sertifikat Hak Milik (SHM),Sertifikat Hak Guna Bangunan (SHGB),Tanah Wakaf,Tanah Negara',
            'jum_siswa_pria' => 'nullable|integer|min:0',
            'jum_siswa_wanita' => 'nullable|integer|min:0',
            'unbk_status' => 'nullable|in:Mandiri,Menumpang,Gabungan,Belum UNBK,Tidak Berlaku',
            'unbk_tahun' => 'nullable|digits:4',  
            'kecamatan_id' => 'required|exists:kecamatan,id',
        ]);

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah);

        $sekolah->update([
            'npsn' => $request->npsn,
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
            'sk_ijin' => $request->sk_ijin,
            'status_sekolah' => $request->status_sekolah,
            'status_akreditasi' => $request->status_akreditasi,
            'status_tanah' => $request->status_tanah,
            'jum_siswa_pria' => $request->jum_siswa_pria,
            'jum_siswa_wanita' => $request->jum_siswa_wanita,
            'unbk_status' => $request->unbk_status,
            'unbk_tahun' => $request->unbk_tahun,
            'status_verifikasi' => 0,
            'keterangan_verifikasi' => $request->keterangan_verifikasi,
            'kecamatan_id' => $request->kecamatan_id,
            'kota_id' => $request->kecamatan_id ? Kecamatan::find($request->kecamatan_id)->kota_id : null,
        ]);

        return redirect()->back()->with('success', 'Data sekolah berhasil diperbarui.');
    }

    public function index_sosekbud()
    {

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::with('sekolah_sosekbud')->find(Auth::user()->sekolah_id);

        return view('pages.operator-sekolah.sekolah.sosekbud', compact('sekolah'));
    }

    public function update_sosekbud(Request $request)
    {
        $request->validate([
            'kondisi_geografis' => 'required|string',
            'kondisi_sosekbud' => 'required|string',
            'akses_transportasi' => 'required|string',
        ]);

        $idsekolah = Auth::user()->sekolah_id;
        $sekolahSosekbud = SekolahSosekbud::where('sekolah_id', $idsekolah)->first();

        $sekolahSosekbud->update([
            'kondisi_geografis' => $request->kondisi_geografis,
            'kondisi_sosekbud' => $request->kondisi_sosekbud,
            'akses_transportasi' => $request->akses_transportasi,
        ]);

        return redirect()->back()->with('success','Data sekolah berhasil diperbarui');
    }

 
}
