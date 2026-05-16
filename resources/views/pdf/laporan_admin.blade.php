<h2 style="text-align: center;">LAPORAN TRANSAKSI BANK SAMPAH</h2>
<table border="1" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>Tanggal</th><th>Nasabah</th><th>Aktivitas</th><th>Total</th><th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{ $t->created_at->format('d/m/Y') }}</td>
            <td>{{ $t->user->nama }}</td>
            <td>{{ $t->jenis_sampah }}</td>
            <td>Rp {{ number_format($t->total_harga) }}</td>
            <td>{{ $t->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>