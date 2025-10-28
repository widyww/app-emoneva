<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\GuruKebutuhan;
use App\Models\GuruPelatihan;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {
        $data = Guru::all();
        return view('pages.operator-sekolah.guru.index', compact('data'));
    }
    public function store(Request $request)
    {


        // 1. Simpan data ke tabel guru
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

            'sekolah_id' => Auth::user()->sekolah_id, // ambil dari user login
        ]);

        // 2. Simpan data pelatihan ke tabel guru_pelatihan
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

        // 3. Simpan data kebutuhan pelatihan ke tabel guru_kebutuhan
        if ($request->pelatihan_kebutuhan == 'Ya' && $request->has('nama_kebutuhan')) {
            foreach ($request->nama_kebutuhan as $nama) {
                GuruKebutuhan::create([
                    'guru_id' => $guru->id,
                    'nama_pelatihan' => $nama,
                ]);
            }
        }

        return redirect()->route('data-guru.index')->with('success', 'Data guru berhasil disimpan.');
    }

    public function create()
    {
        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah);


        return view('pages.operator-sekolah.guru.create', compact('sekolah'));
    }

    public function edit($id)
    {
        $guru = Guru::with(['pelatihan', 'kebutuhanPelatihan'])->findOrFail($id);
        return view('pages.operator-sekolah.guru.edit', compact('guru'));
    }


    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        // Validasi
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

            // Pelatihan
            'nama_pelatihan.*' => 'required|string|max:255',
            'tingkatan.*' => 'required|string',
            'level.*' => 'required|string',
            'tahun_pelatihan.*' => 'required|integer',
            'jam_pelatihan.*' => 'required|integer',

            // Kebutuhan Pelatihan
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
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'mapel' => $request->mapel,
            'sertifikasi_tahun' => $request->sertifikasi_tahun,
            'status_verifikasi' => 0,
        ]);

        // ===== Update Pelatihan =====
        // Hapus dulu semua pelatihan lama
        $guru->pelatihan()->delete();

        // Simpan ulang
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
        // Hapus dulu yang lama
        $guru->kebutuhanPelatihan()->delete();

        if ($request->pelatihan_kebutuhan == 'Ya' && $request->nama_kebutuhan) {
            foreach ($request->nama_kebutuhan as $nama) {
                $guru->kebutuhanPelatihan()->create([
                    'nama_pelatihan' => $nama,
                ]);
            }
        }

        return redirect()->route('data-guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }


    public function destroy($id)
    {
        try {
            $guru = Guru::with(['pelatihan', 'kebutuhanPelatihan'])->findOrFail($id);
            $guru->pelatihan()->delete();
            $guru->kebutuhanPelatihan()->delete();
            $guru->delete();

            return response()->json(['message' => 'Data guru berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
    public function show() {}
}
