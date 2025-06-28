<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sekolah_id' => $request->sekolah_id,
        ]);

        return redirect()->back()->with('success', 'Data operator diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data operator dihapus.');
    }
}
