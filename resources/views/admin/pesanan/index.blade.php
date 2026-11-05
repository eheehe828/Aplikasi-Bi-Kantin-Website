@extends('layouts.app')

@section('title', 'Pesanan Masuk | Bi-Kantin')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Panel pengelola</p>
            <h1>Pesanan Masuk</h1>

            @if (session('sukses'))
                <div class="alert">{{ session('sukses') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <div class="dash-actions">
                <a class="logout-button" href="{{ route('admin.dashboard') }}">Kembali</a>
            </div>

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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanan as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->created_at?->format('d/m H:i') }}</td>
                                <td>{{ $p->user?->username }}</td>
                                <td>{{ $p->menu?->nama_menu ?? '(menu dihapus)' }}</td>
                                <td>{{ $p->jumlah }}</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.pesanan.update', $p) }}" class="form-status">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status">
                                            @foreach ($daftarStatus as $s)
                                                <option value="{{ $s }}" @selected($p->status === $s)>{{ $s }}</option>
                                            @endforeach
                                        </select>
                                        <button class="button" type="submit">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection