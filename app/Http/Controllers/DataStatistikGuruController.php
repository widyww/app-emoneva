<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataStatistikGuruController extends Controller
{
    public function sortAkreditasi()
    {
        return view('kabalai.sort-akreditasi');
    }
}
