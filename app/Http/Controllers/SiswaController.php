<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaController extends Controller
{
    private const METODE = [
        'Cash'     => 'Tunai (Cash)',
        'QRIS'     => 'QRIS',
        'E-Wallet' => 'E-Wallet (DANA / GoPay / OVO)',
    ];

    public function index(Request $request): View
    {
        $daftarMenu = Menu::orderBy('kategori')->orderBy('nama_menu')->get();
        $pesanan = $this->pesananSaya($request);

        return view('siswa.dashboard', compact('daftarMenu', 'pesanan'));
    }

    public function pesan(Request $request, Menu $menu): RedirectResponse
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $pesanan = Pesanan::create([
            'user_id'     => $request->user()->id,
            'menu_id'     => $menu->id,
            'jumlah'      => $data['jumlah'],
            'total_harga' => $menu->harga * $data['jumlah'],
            'status'      => 'Menunggu Konfirmasi',
        ]);

        return to_route('siswa.bayar', $pesanan);
    }

    public function bayar(Request $request, Pesanan $pesanan): View|RedirectResponse
    {
        abort_if($pesanan->user_id != $request->user()->id, 403);

        if ($pesanan->status !== 'Menunggu Konfirmasi') {
            return to_route('siswa.dashboard')
                ->withErrors(['status' => 'Pesanan ini sudah diproses, metode pembayaran tidak bisa diubah.']);
        }

        return view('siswa.pembayaran', [
            'pesanan'      => $pesanan->load('menu'),
            'daftarMetode' => self::METODE,
        ]);
    }

    public function simpanBayar(Request $request, Pesanan $pesanan): RedirectResponse
    {
        abort_if($pesanan->user_id != $request->user()->id, 403);

        if ($pesanan->status !== 'Menunggu Konfirmasi') {
            return to_route('siswa.dashboard')
                ->withErrors(['status' => 'Pesanan ini sudah diproses, metode pembayaran tidak bisa diubah.']);
        }

        $data = $request->validate([
            'metode_pembayaran' => ['required', 'in:' . implode(',', array_keys(self::METODE))],
        ]);

        $pesanan->update($data);

        $pesan = $data['metode_pembayaran'] === 'Cash'
            ? 'Metode tunai dipilih. Silakan bayar di kasir.'
            : 'Terima kasih! Kasir akan memverifikasi pembayaran Anda.';

        return to_route('siswa.dashboard')->with('sukses', $pesan);
    }

    // dipanggil JavaScript tiap beberapa detik (status real-time)
    public function riwayat(Request $request): View
    {
        return view('siswa.partials.riwayat', ['pesanan' => $this->pesananSaya($request)]);
    }

    private function pesananSaya(Request $request)
    {
        return Pesanan::with('menu')
            ->where('user_id', $request->user()->id)
            ->latest('id')
            ->get();
    }
}