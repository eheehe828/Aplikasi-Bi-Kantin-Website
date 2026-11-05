@extends('layouts.app')

@section('title', 'Pembayaran | Kantin Kita')

@section('content')
    <main class="dashboard">
        <section class="dash-panel">
            <p class="eyebrow">Pembayaran</p>
            <h1>Pesanan #{{ $pesanan->id }}</h1>

            <div class="ringkasan">
                <div><span>Menu</span><strong>{{ $pesanan->menu?->nama_menu }}</strong></div>
                <div><span>Jumlah</span><strong>{{ $pesanan->jumlah }}</strong></div>
                <div><span>Total bayar</span><strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong></div>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('siswa.bayar.simpan', $pesanan) }}">
                @csrf

                <h2>Pilih Metode Pembayaran</h2>
                <div class="metode-list">
                    @foreach ($daftarMetode as $kode => $label)
                        <label class="metode">
                            <input type="radio" name="metode_pembayaran" value="{{ $kode }}"
                                   @checked(old('metode_pembayaran', $pesanan->metode_pembayaran) === $kode) required>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="metode-info" data-metode="Cash" hidden>
                    <p>Bayar langsung di kasir sebesar <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>. Sebutkan nomor pesanan <strong>#{{ $pesanan->id }}</strong>.</p>
                </div>

                <div class="metode-info" data-metode="QRIS" hidden>
                    <img class="qris" src="{{ asset('images/qris.png') }}" alt="QRIS Kantin" onerror="this.style.display='none'">
                    <p>Scan kode QR di atas dengan aplikasi pembayaran Anda, lalu bayar <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>. Tunjukkan bukti ke kasir.</p>
                </div>

                <div class="metode-info" data-metode="E-Wallet" hidden>
                    <p>Transfer <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong> ke DANA / GoPay / OVO:</p>
                    <p><strong>0812-3456-7890</strong> a.n. Kantin Kita</p>
                    <p>Tunjukkan bukti transfer ke kasir.</p>
                </div>

                <div class="dash-actions">
                    <button class="button" type="submit">Konfirmasi Pembayaran</button>
                    <a class="logout-button" href="{{ route('siswa.dashboard') }}">Bayar Nanti</a>
                </div>
            </form>
        </section>
    </main>

    <script>
        const infos = document.querySelectorAll('.metode-info');
        const radios = document.querySelectorAll('input[name="metode_pembayaran"]');

        function tampil() {
            const dipilih = document.querySelector('input[name="metode_pembayaran"]:checked')?.value;
            infos.forEach(el => el.hidden = el.dataset.metode !== dipilih);
        }

        radios.forEach(r => r.addEventListener('change', tampil));
        tampil();
    </script>
@endsection