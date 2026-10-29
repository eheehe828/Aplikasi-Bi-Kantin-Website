@extends('layouts.app')

@section('title', 'Dashboard Admin | Bi-Kantin')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Panel pengelola</p>
            <h1>Halo, {{ auth()->user()->username }}.</h1>
            <span class="role-tag">Administrator</span>
            <div class="dash-actions">
                <a class="button" href="{{ route('admin.menu.index') }}">Kelola Menu</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar</button>
                </form>
            </div>
        </section>
    </main>
@endsection