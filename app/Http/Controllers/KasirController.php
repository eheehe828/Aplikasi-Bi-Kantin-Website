<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KasirController extends Controller
{
    public function index(): View
    {
        $pesanan = Pesanan::with(['user', 'menu'])->latest('id')->get();

        return view('kasir.dashboard', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Lunas,Siap Diambil,Selesai'],
        ]);

        $pesanan->update(['status' => $data['status']]);

        return to_route('kasir.dashboard')->with('sukses', "Pesanan #{$pesanan->id} diubah menjadi {$data['status']}.");
    }
}