<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SekolahController extends Controller
{
    public function index()
    {
        $data = Sekolah::all();
        return view('pages.sekolah.index', compact('data'));
    }

    public function import(Request $request)
    {
        set_time_limit(600); // hindari timeout
        ini_set('memory_limit', '1024M'); // tambah limit memori

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:4096',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'File tidak valid. Pastikan format .xlsx, .xls, atau .csv');
        }

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $rows = collect($data)->skip(1); // lewati header baris pertama
        $inserted = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            $npsn = trim($row['B'] ?? '');
            $tingkatan = trim($row['C'] ?? '');
            $nama = trim($row['A'] ?? '');
            $alamat = trim($row['D'] ?? '');

            // Skip baris kosong
            if (empty($npsn) || empty($nama)) {
                $skipped++;
                continue;
            }

            $sekolah = Sekolah::updateOrCreate(
                ['npsn' => $npsn],
                [
                    'tingkatan' => $tingkatan,
                    'nama' => $nama,
                    'alamat' => $alamat,
                ]
            );

            if ($sekolah->wasRecentlyCreated) {
                $inserted++;

                // Buat data di tabel sosekbud
                SekolahSosekbud::firstOrCreate([
                    'sekolah_id' => $sekolah->id,
                ]);

                // Buat user operator sekolah
                User::firstOrCreate(
                    ['email' => $npsn],
                    [
                        'name' => 'Operator ' . $nama,
                        'password' => Hash::make($npsn),
                        'role' => 3,
                        'sekolah_id' => $sekolah->id,
                    ]
                );
            } else {
                $updated++;
            }
        }

        $message = "Import selesai! {$inserted} data baru ditambahkan, {$updated} diperbarui, {$skipped} dilewati.";
        return back()->with('success', $message);
    }
    public function store(Request $request)
    {
        $request->validate([
            'npsn' => 'required|string|unique:sekolah,npsn',
            'tingkatan' => 'required|string|in:SMK,SMA,SLB,SMALB',
            'nama' => 'required|string',
        ]);

        // Simpan ke tabel sekolah
        $sekolah = Sekolah::create([
            'npsn' => $request->npsn,
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,
        ]);

        // Simpan ke tabel sosekbud
        SekolahSosekbud::create([
            'sekolah_id' => $sekolah->id,

        ]);

        // Simpan user operator sekolah
        User::create([
            'name' => 'Operator ' . $request->nama,
            'email' => $request->npsn, // Email diganti jadi NPSN
            'password' => Hash::make($request->npsn),
            'role' => 3, // Operator Sekolah
            'sekolah_id' => $sekolah->id,
        ]);

        return redirect()->back()->with('success', 'Data sekolah dan user operator berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'npsn' => 'required|string|unique:sekolah,npsn,' . $id,
            'tingkatan' => 'required|string|in:SMK,SMA,SLB,SMALB',
            'nama' => 'required|string',
        ]);

        $sekolah = Sekolah::findOrFail($id);
        $oldNpsn = $sekolah->npsn;

        // Update data sekolah
        $sekolah->update([
            'npsn' => $request->npsn,
            'tingkatan' => $request->tingkatan,
            'nama' => $request->nama,

        ]);

        // Cari user berdasarkan sekolah_id
        $user = User::where('sekolah_id', $sekolah->id)->first();

        if ($user) {
            $user->update([
                'email' => $request->npsn,
            ]);
        }

        return redirect()->back()->with('success', 'Data sekolah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // Hapus user yang terkait jika ada
        User::where('sekolah_id', $sekolah->id)->delete();

        $sekolah->delete();

        return redirect()->back()->with('success', 'Data sekolah dan user terkait berhasil dihapus');
    }
}
