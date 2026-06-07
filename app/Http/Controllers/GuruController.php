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
        // $data = Guru::all();
        $data = Guru::where('sekolah_id', auth()->user()->sekolah_id)->get();
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
        // dd($guru);

        return view('pages.operator-sekolah.guru.edit', compact('guru'));
    }


    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nuptk' => 'nullable|string|max:50',
        ]);

        // Update data guru (hanya Nama, NIP, dan NUPTK)
        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'nuptk' => $request->nuptk,
        ]);

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
