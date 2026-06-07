<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ManajemenGuruController extends Controller
{
    public function index()
    {
        // Query data dari tabel guru, eager load sekolah dan user
        $guruList = Guru::with(['sekolah', 'user'])->get();
        $sekolah = Sekolah::orderBy('nama')->get();
        return view('pages.guru-mandiri.index', compact('guruList', 'sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nuptk' => 'nullable|string|max:50',
            'nip' => 'nullable|string|max:50',
            'telepon' => 'nullable|string|max:20',
            'sekolah_id' => 'required|exists:sekolah,id',
            // Jika admin ingin membuat akun user sekaligus
            'create_user' => 'nullable|string',
            'email' => 'required_if:create_user,1|nullable|string|email|max:255|unique:users,email',
            'password' => 'required_if:create_user,1|nullable|string|min:6',
        ], [
            'email.required_if' => 'Email wajib diisi jika membuat akun user.',
            'password.required_if' => 'Password wajib diisi jika membuat akun user.',
        ]);

        // Cek duplikasi NUPTK/NIP di tabel guru
        if ($request->filled('nuptk')) {
            $duplicate = Guru::where('nuptk', $request->nuptk)->first();
            if ($duplicate) {
                return redirect()->back()->withInput()->withErrors([
                    'nuptk' => 'Guru dengan NUPTK tersebut sudah terdaftar di database.'
                ]);
            }
        }

        if ($request->filled('nip')) {
            $duplicate = Guru::where('nip', $request->nip)->first();
            if ($duplicate) {
                return redirect()->back()->withInput()->withErrors([
                    'nip' => 'Guru dengan NIP tersebut sudah terdaftar di database.'
                ]);
            }
        }

        // Buat record guru baru
        $guru = Guru::create([
            'nama' => $request->nama,
            'nuptk' => $request->nuptk,
            'nip' => $request->nip,
            'telepon' => $request->telepon,
            'sekolah_id' => $request->sekolah_id,
            'status_verifikasi' => 0,
        ]);

        // Buat akun user jika dipilih
        if ($request->create_user == '1') {
            User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->telepon,
                'role' => 5,
                'sekolah_id' => $request->sekolah_id,
                'guru_id' => $guru->id,
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->back()->with('success', 'Data Guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nuptk' => 'nullable|string|max:50|unique:guru,nuptk,' . $id,
            'nip' => 'nullable|string|max:50|unique:guru,nip,' . $id,
            'telepon' => 'nullable|string|max:20',
            'sekolah_id' => 'required|exists:sekolah,id',
            // Update akun user
            'email' => 'nullable|string|email|max:255|unique:users,email,' . ($guru->user ? $guru->user->id : 'NULL'),
            'password' => 'nullable|string|min:6',
        ]);

        // Update data guru
        $guru->update([
            'nama' => $request->nama,
            'nuptk' => $request->nuptk,
            'nip' => $request->nip,
            'telepon' => $request->telepon,
            'sekolah_id' => $request->sekolah_id,
        ]);

        // Kelola Akun User
        if ($request->filled('email')) {
            if ($guru->user) {
                // Update user yang sudah ada
                $userData = [
                    'name' => $request->nama,
                    'email' => $request->email,
                    'phone' => $request->telepon,
                    'sekolah_id' => $request->sekolah_id,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $guru->user->update($userData);
            } else {
                // Buat user baru jika sebelumnya belum ada
                User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'phone' => $request->telepon,
                    'role' => 5,
                    'sekolah_id' => $request->sekolah_id,
                    'guru_id' => $guru->id,
                    'password' => Hash::make($request->password ?? 'password123'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        // Hapus user terasosiasi jika ada
        if ($guru->user) {
            $guru->user->delete();
        }

        // Hapus data pelatihan & kebutuhan
        $guru->pelatihan()->delete();
        $guru->kebutuhanPelatihan()->delete();
        
        // Hapus guru
        $guru->delete();

        return redirect()->back()->with('success', 'Data Guru berhasil dihapus.');
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
            $nama = trim($row['A'] ?? '');
            $nip = trim($row['B'] ?? '');
            $nuptk = trim($row['C'] ?? '');
            $telepon = trim($row['D'] ?? '');
            $npsn = trim($row['E'] ?? '');
            $email = trim($row['F'] ?? '');
            $password = trim($row['G'] ?? '');

            // Skip baris kosong
            if (empty($nama) || empty($npsn)) {
                $skipped++;
                continue;
            }

            // Find or create school
            $sekolah = Sekolah::firstOrCreate(
                ['npsn' => $npsn],
                [
                    'nama' => 'Sekolah ' . $npsn,
                    'tingkatan' => 'SMA',
                ]
            );

            // Ensure SekolahSosekbud exists
            \App\Models\SekolahSosekbud::firstOrCreate([
                'sekolah_id' => $sekolah->id,
            ]);

            // Find existing guru by NIP or NUPTK
            $guru = null;
            if (!empty($nip)) {
                $guru = Guru::where('nip', $nip)->first();
            }
            if (!$guru && !empty($nuptk)) {
                $guru = Guru::where('nuptk', $nuptk)->first();
            }

            if ($guru) {
                // Update
                $guru->update([
                    'nama' => $nama,
                    'nip' => $nip ?: $guru->nip,
                    'nuptk' => $nuptk ?: $guru->nuptk,
                    'telepon' => $telepon,
                    'sekolah_id' => $sekolah->id,
                ]);
                $updated++;
            } else {
                // Insert
                $guru = Guru::create([
                    'nama' => $nama,
                    'nip' => $nip ?: null,
                    'nuptk' => $nuptk ?: null,
                    'telepon' => $telepon,
                    'sekolah_id' => $sekolah->id,
                    'status_verifikasi' => 0,
                ]);
                $inserted++;
            }

            // Manage User Account if email is provided
            if (!empty($email)) {
                $user = User::where('email', $email)->first();
                $passVal = !empty($password) ? Hash::make($password) : Hash::make($nip ?: ($nuptk ?: 'password123'));

                if ($user) {
                    $user->update([
                        'name' => $nama,
                        'phone' => $telepon,
                        'sekolah_id' => $sekolah->id,
                        'guru_id' => $guru->id,
                    ]);
                    if (!empty($password)) {
                        $user->update(['password' => $passVal]);
                    }
                } else {
                    User::create([
                        'name' => $nama,
                        'email' => $email,
                        'phone' => $telepon,
                        'role' => 5, // Guru
                        'sekolah_id' => $sekolah->id,
                        'guru_id' => $guru->id,
                        'password' => $passVal,
                    ]);
                }
            }
        }

        $message = "Import selesai! {$inserted} data guru baru ditambahkan, {$updated} diperbarui, {$skipped} dilewati.";
        return back()->with('success', $message);
    }
}
