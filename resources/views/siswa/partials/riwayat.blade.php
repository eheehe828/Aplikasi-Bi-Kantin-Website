<div class="table-wrap">
    <table class="tabel">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $p)
                <tr>
                    <td>{{ $p->created_at?->format('d/m H:i') }}</td>
                    <td>{{ $p->menu?->nama_menu ?? '(menu dihapus)' }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($p->metode_pembayaran)
                            {{ $p->metode_pembayaran }}
                            @if ($p->status === 'Menunggu Konfirmasi')
                                <br><a href="{{ route('siswa.bayar', $p) }}"><small>ubah</small></a>
                            @endif
                        @elseif ($p->status === 'Menunggu Konfirmasi')
                            <a class="button" href="{{ route('siswa.bayar', $p) }}">Bayar</a>
                        @else
                            -
                        @endif
                    </td>
                    <td><span class="badge">{{ $p->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>