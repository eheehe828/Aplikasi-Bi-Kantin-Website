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
            'email' => $credentials['username'],
            'password' => $credentials['password'],
        ])) {
            return back()
                ->withErrors(['username' => 'Nama pengguna atau kata sandi tidak sesuai.'])
                ->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        return to_route($request->user()->role === 'admin' ? 'admin.dashboard' : 'siswa.dashboard');
    }

    public function dashboard(Request $request): RedirectResponse
    {
        return to_route($request->user()->role === 'admin' ? 'admin.dashboard' : 'siswa.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
