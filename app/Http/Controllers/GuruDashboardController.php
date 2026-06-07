<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\GuruKebutuhan;
use App\Models\GuruPelatihan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = Guru::with(['pelatihan', 'kebutuhanPelatihan'])->findOrFail($user->guru_id);
        $sekolah = Sekolah::find($user->sekolah_id);

        return view('guru.dashboard', compact('guru', 'sekolah'));
    }

    public function editProfil()
    {
        $user = Auth::user();
        $guru = Guru::with(['pelatihan', 'kebutuhanPelatihan'])->findOrFail($user->guru_id);
        return view('guru.profil', compact('guru'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::findOrFail($user->guru_id);

        // Validasi
        $rules = [
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'tempat' => 'nullable|string|max:100',
            'agama' => 'nullable|string',
            'pendidikan_terakhir' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'sertifikasi_status' => 'nullable|string',
            'sertifikasi_alasan' => 'nullable|string',
            'status' => 'nullable|string',
            'nuptk' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'bulan' => 'nullable|string',
            'tahun' => 'nullable|integer',
            'mapel' => 'nullable|string|max:100',
            'sertifikasi_tahun' => 'nullable|string|max:10',
            'pelatihan_status' => 'nullable|string',
            'pelatihan_kebutuhan' => 'nullable|string',
        ];

        if ($request->pelatihan_status === 'Ya') {
            $rules['nama_pelatihan.*'] = 'required|string|max:255';
            $rules['tingkatan.*'] = 'required|string';
            $rules['level.*'] = 'required|string';
            $rules['tahun_pelatihan.*'] = 'required|integer';
            $rules['jam_pelatihan.*'] = 'required|integer';
        }

        if ($request->pelatihan_kebutuhan === 'Ya') {
            $rules['nama_kebutuhan.*'] = 'required|string|max:255';
        }

        $request->validate($rules);

        // Update data guru
        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'tempat' => $request->tempat,
            'agama' => $request->agama,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'telepon' => $request->telepon,
            'sertifikasi_status' => $request->sertifikasi_status,
            'sertifikasi_alasan' => $request->sertifikasi_alasan,
            'status' => $request->status,
            'nuptk' => $request->nuptk,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'mapel' => $request->mapel,
            'sertifikasi_tahun' => $request->sertifikasi_tahun,
            
            // Kompetensi TIK
            'kompetensi_word' => $request->kompetensi_word,
            'kompetensi_powerpoin' => $request->kompetensi_powerpoin,
            'kompetensi_excel' => $request->kompetensi_excel,
            'kompetensi_pemrogramman' => $request->kompetensi_pemrogramman,
            'kompetensi_jaringan' => $request->kompetensi_jaringan,
            'kompetensi_multimedia' => $request->kompetensi_multimedia,
            
            // Set status verifikasi menjadi 0 (Menunggu Verifikasi Ulang) jika diubah
            'status_verifikasi' => 0, 
        ]);

        // Update data user agar sinkron
        $user->update([
            'name' => $request->nama,
            'phone' => $request->telepon,
        ]);

        // ===== Update Pelatihan =====
        $guru->pelatihan()->delete();

        if ($request->pelatihan_status == 'Ya' && $request->nama_pelatihan) {
            foreach ($request->nama_pelatihan as $index => $nama) {
                $guru->pelatihan()->create([
                    'nama_pelatihan' => $nama,
                    'tingkatan' => $request->tingkatan[$index],
                    'level' => $request->level[$index],
                    'tahun_pelatihan' => $request->tahun_pelatihan[$index],
                    'jam_pelatihan' => $request->jam_pelatihan[$index],
                ]);
            }
        }

        // ===== Update Kebutuhan Pelatihan =====
        $guru->kebutuhanPelatihan()->delete();

        if ($request->pelatihan_kebutuhan == 'Ya' && $request->nama_kebutuhan) {
            foreach ($request->nama_kebutuhan as $nama) {
                $guru->kebutuhanPelatihan()->create([
                    'nama_pelatihan' => $nama,
                ]);
            }
        }

        return redirect()->route('guru.dashboard')->with('success', 'Profil dan data kompetensi TIK Anda berhasil diperbarui.');
    }
}
