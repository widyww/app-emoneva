<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserVerifikatorController extends Controller
{
    public function index()
    {
        return view('verifikator.dashboard');
    }
}
