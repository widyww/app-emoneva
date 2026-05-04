<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserGuruController extends Controller
{
    public function index()
    {
        $users = User::where('role', 5)->with('guru')->get();
        $sekolah = Sekolah::all();
        return view('pages.user-guru.index', compact('users', 'sekolah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'nip' => 'required|string|unique:users,email',
            'sekolah_id' => 'required|exists:sekolah,id',
        ]);

        // 1. Buat record guru di tabel guru
        $guru = Guru::create([
            'nama' => $request->name,
            'nip' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
            'status_verifikasi' => 0,
        ]);

        // 2. Buat user account (login pakai NIP)
        User::create([
            'name' => $request->name,
            'email' => $request->nip, // NIP sebagai email untuk login
            'role' => 5,
            'sekolah_id' => $request->sekolah_id,
            'guru_id' => $guru->id,
            'password' => Hash::make($request->nip), // Password default = NIP
        ]);

        return redirect()->back()->with('success', 'Akun guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'nip' => 'required|string|unique:users,email,' . $id,
            'sekolah_id' => 'required|exists:sekolah,id',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->nip,
            'sekolah_id' => $request->sekolah_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Update juga data guru terkait
        if ($user->guru_id) {
            $guru = Guru::find($user->guru_id);
            if ($guru) {
                $guru->update([
                    'nama' => $request->name,
                    'nip' => $request->nip,
                    'sekolah_id' => $request->sekolah_id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data guru diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus juga data guru terkait
        if ($user->guru_id) {
            $guru = Guru::find($user->guru_id);
            if ($guru) {
                $guru->pelatihan()->delete();
                $guru->kebutuhanPelatihan()->delete();
                $guru->delete();
            }
        }

        $user->delete();
        return redirect()->back()->with('success', 'Data guru dihapus.');
    }
}
