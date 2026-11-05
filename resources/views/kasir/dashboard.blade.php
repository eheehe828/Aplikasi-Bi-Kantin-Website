@extends('layouts.app')

@section('title', 'Dashboard Kasir | Bi-Kantin')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Petugas pembayaran</p>
            <h1>Halo, {{ auth()->user()->username }}.</h1>
            <span class="role-tag">Kasir</span>

            @if (session('sukses'))
                <div class="alert">{{ session('sukses') }}</div>
            @endif

            <h2>Pesanan Masuk</h2>
            <div class="table-wrap">
                <table class="tabel">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Waktu</th>
                            <th>Siswa</th>
                            <th>Menu</th>
                            <th>Jml</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan as $p)
                            @php
                                $berikut = match ($p->status) {
                                    'Menunggu Konfirmasi' => 'Lunas',
                                    'Lunas', 'Sedang Dimasak' => 'Siap Diambil',
                                    'Siap Diambil' => 'Selesai',
                                    default => null,
                                };
                            @endphp
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->created_at?->format('d/m H:i') }}</td>
                                <td>{{ $p->user?->username }}</td>
                                <td>{{ $p->menu?->nama_menu ?? '(menu dihapus)' }}</td>
                                <td>{{ $p->jumlah }}</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $p->metode_pembayaran ?? 'Belum memilih' }}</td>
                                <td><span class="badge">{{ $p->status }}</span></td>
                                <td>
                                    @if ($berikut)
                                        <form method="POST" action="{{ route('kasir.pesanan.status', $p) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $berikut }}">
                                            <button class="button" type="submit">{{ $berikut === 'Lunas' ? 'Tandai Lunas' : $berikut }}</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="dash-actions">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar</button>
                </form>
            </div>
        </section>
    </main>
@endsection