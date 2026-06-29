<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataSekolahController extends Controller
{
    public function index_identitas()
    {

        $kecamatanList = Kecamatan::with('kota')->orderBy('kota_id')->get(); // relasi dengan kota

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah);
        return view('pages.operator-sekolah.sekolah.identitas', compact('sekolah', 'kecamatanList'));
    }

    public function ajukanVerifikasi()
    {
        $user = Auth::user();

        // Pastikan relasi sekolah ada di model User
        if (!$user || !$user->sekolah) {
            return redirect()->back()->with('error', 'Data sekolah tidak ditemukan.');
        }

        $sekolah = $user->sekolah;

        // Update status jadi "0" = menunggu verifikasi
        $sekolah->update([
            'status_verifikasi' => 1           
            
        ]);

        return redirect()->back()->with('success', 'Data sekolah berhasil diajukan untuk verifikasi.');
    }

    public function update_identitas(Request $request)
    {
        $request->validate([
            'foto_sekolah' => 'nullable|image|mimes:jpg,jpeg,png|max:20048',
            'npsn' => 'required|string|max:20',
            'tingkatan' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|string|max:100',
            'kepsek_nama' => 'nullable|string|max:255',
            'kepsek_hp' => 'nullable|string|max:50',
            'kepsek_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:20048',
            'sk_ijin' => 'nullable|string|max:100',
            'status_sekolah' => 'required|in:Negeri,Swasta',
            'status_akreditasi' => 'nullable|in:Terakreditasi A,Terakreditasi B,Terakreditasi C,Belum Terakreditasi,Tidak Terakreditasi',
            'status_tanah' => 'nullable|in:Sertifikat Hak Milik (SHM),Sertifikat Hak Guna Bangunan (SHGB),Tanah Wakaf,Tanah Negara',
            'jum_siswa_pria' => 'nullable|integer|min:0',
            'jum_siswa_wanita' => 'nullable|integer|min:0',
            'jum_guru' => 'nullable|integer|min:0',
            'unbk_status' => 'required|in:Mandiri,Menumpang,Gabungan,Belum UNBK,Tidak Berlaku',
            'unbk_tahun' => 'nullable|digits:4',
            'kecamatan_id' => 'required|exists:kecamatan,id',
        ]);

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::findOrFail($idsekolah);

        // Upload foto sekolah
        if ($request->hasFile('foto_sekolah')) {
            if ($sekolah->foto_sekolah && Storage::exists('public/' . $sekolah->foto_sekolah)) {
                Storage::delete('public/' . $sekolah->foto_sekolah);
            }
            $pathFotoSekolah = $request->file('foto_sekolah')->store('foto_sekolah', 'public');
            $sekolah->foto_sekolah = $pathFotoSekolah;
        }

        // Upload foto kepala sekolah
        if ($request->hasFile('kepsek_foto')) {
            if ($sekolah->kepsek_foto && Storage::exists('public/' . $sekolah->kepsek_foto)) {
                Storage::delete('public/' . $sekolah->kepsek_foto);
            }
            $pathKepsekFoto = $request->file('kepsek_foto')->store('foto_kepsek', 'public');
            $sekolah->kepsek_foto = $pathKepsekFoto;
        }

        // Update data lainnya
        $sekolah->fill([
            'npsn' => $request->npsn,
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'website' => $request->website,
            'kepsek_nama' => $request->kepsek_nama,
            'kepsek_hp' => $request->kepsek_hp,
            'sk_ijin' => $request->sk_ijin,
            'status_sekolah' => $request->status_sekolah,
            'status_akreditasi' => $request->status_akreditasi,
            'status_tanah' => $request->status_tanah,
            'jum_siswa_pria' => $request->jum_siswa_pria,
            'jum_siswa_wanita' => $request->jum_siswa_wanita,
            'jum_guru' => $request->jum_guru,
            'unbk_status' => $request->unbk_status,
            'unbk_tahun' => $request->unbk_tahun,
            'status_verifikasi' => 0,
            'keterangan_verifikasi' => $request->keterangan_verifikasi,
            'kecamatan_id' => $request->kecamatan_id,
            'kota_id' => Kecamatan::find($request->kecamatan_id)->kota_id ?? null,
        ])->save();

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

        return redirect()->back()->with('success', 'Data sekolah berhasil diperbarui');
    }
}
