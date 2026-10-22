@extends('layouts.app')

@section('title', 'Masuk | Kantin Kita')

@section('content')
    <main class="login-grid">
        <section class="intro" aria-labelledby="welcome-title">
            <div>
                <p class="eyebrow">Ruang makan sekolah</p>
                <h1 id="welcome-title">Makan enak, hari lebih ringan.</h1>
                <p class="intro-note">Satu tempat untuk mengelola kebutuhan kantin dan aktivitas siswa.</p>
            </div>
            <span class="stamp">Segar setiap hari <span aria-hidden="true">&#8226;</span> Dibuat di kantin</span>
        </section>

        <section class="form-side" aria-labelledby="login-title">
            <div class="form-wrap">
                <p class="eyebrow">Selamat datang kembali</p>
                <h2 id="login-title">Masuk akun</h2>
                <p class="subcopy">Gunakan nama pengguna dan kata sandi akun kantinmu.</p>

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <label class="field" for="username">
                        Nama pengguna
                        <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" required autofocus>
                        @error('username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="field" for="password">
                        Kata sandi
                        <input id="password" name="password" type="password" autocomplete="current-password" required>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </label>

                    <button class="button button-full" type="submit">Masuk <span aria-hidden="true">&#8594;</span></button>
                </form>
            </div>
        </section>
    </main>
@endsection