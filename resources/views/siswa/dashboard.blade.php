@extends('layouts.app')

@section('title', 'Dashboard Siswa | Kantin Kita')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Ruang siswa</p>
            <h1>Hai, {{ auth()->user()->username }}.</h1>
            <span class="role-tag">Siswa</span>
            <p>Anda berhasil masuk ke akun siswa kantin.</p>
            <div class="dash-actions">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar</button>
                </form>
            </div>
        </section>
    </main>
@endsection