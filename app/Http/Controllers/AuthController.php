<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function home(): RedirectResponse
    {
        return Auth::check() ? to_route('dashboard') : to_route('login');
    }

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ])) {
            return back()
                ->withErrors(['username' => 'Nama pengguna atau kata sandi tidak sesuai.'])
                ->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        return to_route($this->tujuan($request->user()->role));
    }

    public function dashboard(Request $request): RedirectResponse
    {
        return to_route($this->tujuan($request->user()->role));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    private function tujuan(string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'kasir' => 'kasir.dashboard',
            default => 'siswa.dashboard',
        };
    }
}