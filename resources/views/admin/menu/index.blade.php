@extends('layouts.app')

@section('title', 'Kelola Menu | Bi-Kantin')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Panel pengelola</p>
            <h1>Kelola Menu</h1>

            @if (session('sukses'))
                <div class="alert">{{ session('sukses') }}</div>
            @endif

            <div class="dash-actions">
                <a class="button" href="{{ route('admin.menu.create') }}">+ Tambah Menu</a>
                <a class="logout-button" href="{{ route('admin.dashboard') }}">Kembali</a>
            </div>

            <div class="table-wrap">
                <table class="tabel">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarMenu as $menu)
                            <tr>
                                <td>
                                    @if ($menu->foto)
                                        <img class="thumb" src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}">
                                    @else
                                        <span class="thumb thumb-kosong">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $menu->nama_menu }}</strong>
                                    @if ($menu->deskripsi)
                                        <br><small>{{ $menu->deskripsi }}</small>
                                    @endif
                                </td>
                                <td>{{ $menu->kategori }}</td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td class="aksi">
                                    <a class="logout-button" href="{{ route('admin.menu.edit', $menu) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.menu.destroy', $menu) }}"
                                          onsubmit="return confirm('Hapus menu {{ $menu->nama_menu }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="logout-button" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5">Belum ada menu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection