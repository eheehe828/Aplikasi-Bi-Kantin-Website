@extends('layouts.app')

@section('title', 'Dashboard Admin | Kantin Kita')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Panel pengelola</p>
            <h1>Halo, {{ auth()->user()->name }}.</h1>
            <span class="role-tag">Administrator</span>
            <p>Anda masuk sebagai admin kantin.</p>
            <div class="dash-actions">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar</button>
                </form>
            </div>
        </section>
    </main>
@endsection