<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }

    public function menuIndex(): View
    {
        $daftarMenu = Menu::orderBy('kategori')->orderBy('nama_menu')->get();

        return view('admin.menu.index', compact('daftarMenu'));
    }

    public function menuCreate(): View
    {
        return view('admin.menu.form', ['menu' => new Menu()]);
    }

    public function menuStore(Request $request): RedirectResponse
    {
        $data = $this->validasi($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        Menu::create($data);

        return to_route('admin.menu.index')->with('sukses', 'Menu berhasil ditambahkan.');
    }

    public function menuEdit(Menu $menu): View
    {
        return view('admin.menu.form', compact('menu'));
    }

    public function menuUpdate(Request $request, Menu $menu): RedirectResponse
    {
        $data = $this->validasi($request);

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update($data);

        return to_route('admin.menu.index')->with('sukses', 'Menu berhasil diperbarui.');
    }

    public function menuDestroy(Menu $menu): RedirectResponse
    {
        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return to_route('admin.menu.index')->with('sukses', 'Menu berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama_menu' => ['required', 'string', 'max:100'],
            'harga'     => ['required', 'integer', 'min:0'],
            'kategori'  => ['required', 'in:Makanan,Minuman'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
            'foto'      => ['nullable', 'image', 'max:2048'],
        ]);
    }
}