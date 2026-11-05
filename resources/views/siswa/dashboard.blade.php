@extends('layouts.app')

@section('title', 'Dashboard Siswa | Kantin Kita')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Ruang siswa</p>
            <h1>Hai, {{ auth()->user()->username }}.</h1>
            <span class="role-tag">Siswa</span>

            @if (session('sukses'))
                <div class="alert">{{ session('sukses') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <h2>Menu Hari Ini</h2>
            <div class="menu-grid">
                @forelse ($daftarMenu as $menu)
                    <article class="menu-card">
                        @if ($menu->foto)
                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}">
                        @else
                            <div class="foto-kosong">Tanpa foto</div>
                        @endif
                        <strong>{{ $menu->nama_menu }}</strong>
                        <small>{{ $menu->kategori }}</small>
                        @if ($menu->deskripsi)
                            <small>{{ $menu->deskripsi }}</small>
                        @endif
                        <span>Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                        <form method="POST" action="{{ route('siswa.pesan', $menu) }}">
                            @csrf
                            <input type="number" name="jumlah" value="1" min="1" max="20" required>
                            <button class="button" type="submit">Pesan</button>
                        </form>
                    </article>
                @empty
                    <p>Belum ada menu tersedia.</p>
                @endforelse
            </div>

            <h2>Pesanan Saya</h2>
            <div id="riwayat">
                @include('siswa.partials.riwayat')
            </div>

            <div class="dash-actions">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar</button>
                </form>
            </div>
        </section>
    </main>

    <script>
        // perbarui status pesanan tiap 10 detik tanpa reload halaman
        setInterval(async () => {
            try {
                const res = await fetch('{{ route('siswa.riwayat') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (res.ok) {
                    document.getElementById('riwayat').innerHTML = await res.text();
                }
            } catch (e) {}
        }, 10000);
    </script>
@endsection