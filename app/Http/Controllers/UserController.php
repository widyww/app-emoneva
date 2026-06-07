<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\SekolahSosekbud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 3)->with('sekolah')->get();
        $sekolah = Sekolah::all();
        return view('pages.operator-sekolah.index', compact('users', 'sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone' => 'nullable|string',
            'sekolah_id' => 'required|exists:sekolah,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 3,
            'sekolah_id' => $request->sekolah_id,
            'password' => Hash::make($request->email), // Password = email (hashed)
        ]);

        return redirect()->back()->with('success', 'Operator sekolah berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,' . $id,
            'phone' => 'nullable|string',
            'sekolah_id' => 'required|exists:sekolah,id',
            'password' => 'nullable|string|min:6', // tambahkan ini
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sekolah_id' => $request->sekolah_id,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Data operator diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data operator dihapus.');
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
            $name = trim($row['A'] ?? '');
            $npsn = trim($row['B'] ?? '');
            $phone = trim($row['C'] ?? '');

            // Skip baris kosong
            if (empty($name) || empty($npsn)) {
                $skipped++;
                continue;
            }

            // Find or create school
            $sekolah = Sekolah::firstOrCreate(
                ['npsn' => $npsn],
                [
                    'nama' => 'Sekolah ' . $npsn,
                    'tingkatan' => 'SMA', // default
                ]
            );

            // Ensure SekolahSosekbud exists
            SekolahSosekbud::firstOrCreate([
                'sekolah_id' => $sekolah->id,
            ]);

            // Find if operator with role 3 and email (NPSN) already exists
            $user = User::where('role', 3)->where('email', $npsn)->first();

            if ($user) {
                // Update
                $user->update([
                    'name' => $name,
                    'phone' => $phone,
                    'sekolah_id' => $sekolah->id,
                ]);
                $updated++;
            } else {
                // Insert
                User::create([
                    'name' => $name,
                    'email' => $npsn,
                    'phone' => $phone,
                    'role' => 3,
                    'sekolah_id' => $sekolah->id,
                    'password' => Hash::make($npsn), // Password = NPSN (hashed)
                ]);
                $inserted++;
            }
        }

        $message = "Import selesai! {$inserted} data baru ditambahkan, {$updated} diperbarui, {$skipped} dilewati.";
        return back()->with('success', $message);
    }
}
