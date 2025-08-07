<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {

        $idsekolah = Auth::user()->sekolah_id;
        $sekolah = Sekolah::find($idsekolah);


        return view('pages.operator-sekolah.guru.index', compact('sekolah'));
    }
    public function store()
    {

    }
    public function update()
    {

    }
    public function destroy()
    {

    }

}
