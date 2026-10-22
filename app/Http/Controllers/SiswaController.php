<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->role === 'siswa', 403);

        return view('siswa.dashboard');
    }
}
