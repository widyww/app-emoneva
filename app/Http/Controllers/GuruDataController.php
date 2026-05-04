<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\GuruKebutuhan;
use App\Models\GuruPelatihan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDataController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru_id ? Guru::with(['pelatihan', 'kebutuhanPelatihan', 'sekolah'])->find($user->guru_id) : null;

        return view('pages.guru-data.index', compact('guru'));
    }

    public function create()
    {
        $user = Auth::user();
        $sekolah = Sekolah::find($user->sekolah_id);

        return view('pages.guru-data.create', compact('sekolah'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Cek apakah guru sudah punya data lengkap
        $guru = Guru::find($user->guru_id);

        if ($guru) {
            // Update data guru yang sudah ada
            $guru->update([
                'nama' => $request->nama,
                'status' => $request->status,
                'nip' => $request->nip,
                'nuptk' => $request->nuptk,
                'tempat' => $request->tempat,
                'tgl_lahir' => $request->tgl_lahir,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'tmt_pns_tahun' => $request->tahun ? ($request->tahun . '-' . $request->bulan . '-01') : null,
                'telepon' => $request->telepon,

                'mapel' => $request->mapel,
                'sertifikasi_status' => $request->sertifikasi_status,
                'sertifikasi_tahun' => $request->sertifikasi_tahun,
                'sertifikasi_alasan' => $request->sertifikasi_alasan,

                'kompetensi_word' => $request->kompetensi_word,
                'kompetensi_powerpoin' => $request->kompetensi_powerpoin,
                'kompetensi_excel' => $request->kompetensi_excel,
                'kompetensi_pemrogramman' => $request->kompetensi_pemrogramman,
                'kompetensi_jaringan' => $request->kompetensi_jaringan,
                'kompetensi_multimedia' => $request->kompetensi_multimedia,

                'pelatihan_status' => $request->pelatihan_status,
                'pelatihan_kebutuhan' => $request->pelatihan_kebutuhan,
                'status_verifikasi' => 0, // Reset verifikasi saat update
            ]);
        } else {
            // Buat data baru
            $guru = Guru::create([
                'nama' => $request->nama,
                'status' => $request->status,
                'nip' => $request->nip,
                'nuptk' => $request->nuptk,
                'tempat' => $request->tempat,
                'tgl_lahir' => $request->tgl_lahir,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'tmt_pns_tahun' => $request->tahun ? ($request->tahun . '-' . $request->bulan . '-01') : null,
                'telepon' => $request->telepon,

                'mapel' => $request->mapel,
                'sertifikasi_status' => $request->sertifikasi_status,
                'sertifikasi_tahun' => $request->sertifikasi_tahun,
                'sertifikasi_alasan' => $request->sertifikasi_alasan,

                'kompetensi_word' => $request->kompetensi_word,
                'kompetensi_powerpoin' => $request->kompetensi_powerpoin,
                'kompetensi_excel' => $request->kompetensi_excel,
                'kompetensi_pemrogramman' => $request->kompetensi_pemrogramman,
                'kompetensi_jaringan' => $request->kompetensi_jaringan,
                'kompetensi_multimedia' => $request->kompetensi_multimedia,

                'pelatihan_status' => $request->pelatihan_status,
                'pelatihan_kebutuhan' => $request->pelatihan_kebutuhan,

                'sekolah_id' => $user->sekolah_id,
                'status_verifikasi' => 0,
            ]);

            // Link guru ke user
            $user->update(['guru_id' => $guru->id]);
        }

        // Simpan data pelatihan
        $guru->pelatihan()->delete();
        if ($request->pelatihan_status == 'Ya' && $request->has('nama_pelatihan')) {
            foreach ($request->nama_pelatihan as $i => $nama) {
                GuruPelatihan::create([
                    'guru_id' => $guru->id,
                    'nama_pelatihan' => $nama,
                    'tingkatan' => $request->tingkatan[$i] ?? null,
                    'level' => $request->level[$i] ?? null,
                    'tahun_pelatihan' => $request->tahun_pelatihan[$i] ?? null,
                    'jam_pelatihan' => $request->jam_pelatihan[$i] ?? null,
                ]);
            }
        }

        // Simpan data kebutuhan pelatihan
        $guru->kebutuhanPelatihan()->delete();
        if ($request->pelatihan_kebutuhan == 'Ya' && $request->has('nama_kebutuhan')) {
            foreach ($request->nama_kebutuhan as $nama) {
                GuruKebutuhan::create([
                    'guru_id' => $guru->id,
                    'nama_pelatihan' => $nama,
                ]);
            }
        }

        return redirect()->route('guru-data.index')->with('success', 'Data guru berhasil disimpan.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $guru = Guru::with(['pelatihan', 'kebutuhanPelatihan'])->findOrFail($id);

        // Pastikan guru hanya bisa edit data miliknya sendiri
        if ($user->guru_id != $guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

        return view('pages.guru-data.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $guru = Guru::findOrFail($id);

        // Pastikan guru hanya bisa update data miliknya sendiri
        if ($user->guru_id != $guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

        $request->validate([
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
            'nama_pelatihan.*' => 'required|string|max:255',
            'tingkatan.*' => 'required|string',
            'level.*' => 'required|string',
            'tahun_pelatihan.*' => 'required|integer',
            'jam_pelatihan.*' => 'required|integer',
            'nama_kebutuhan.*' => 'required|string|max:255',
        ]);

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
            'mapel' => $request->mapel,
            'sertifikasi_tahun' => $request->sertifikasi_tahun,
            'pelatihan_status' => $request->pelatihan_status,
            'pelatihan_kebutuhan' => $request->pelatihan_kebutuhan,
            'kompetensi_word' => $request->kompetensi_word,
            'kompetensi_powerpoin' => $request->kompetensi_powerpoin,
            'kompetensi_excel' => $request->kompetensi_excel,
            'kompetensi_pemrogramman' => $request->kompetensi_pemrogramman,
            'kompetensi_jaringan' => $request->kompetensi_jaringan,
            'kompetensi_multimedia' => $request->kompetensi_multimedia,
            'status_verifikasi' => 0,
        ]);

        // Update Pelatihan
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

        // Update Kebutuhan Pelatihan
        $guru->kebutuhanPelatihan()->delete();
        if ($request->pelatihan_kebutuhan == 'Ya' && $request->nama_kebutuhan) {
            foreach ($request->nama_kebutuhan as $nama) {
                $guru->kebutuhanPelatihan()->create([
                    'nama_pelatihan' => $nama,
                ]);
            }
        }

        return redirect()->route('guru-data.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function show($id) {}

    public function destroy($id) {}
}
