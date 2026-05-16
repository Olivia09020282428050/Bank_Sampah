<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 0px; }
        .header h1 { color: #28a745; margin: 0; font-size: 28px; }
        .header p { margin: 2px 0; font-size: 12px; color: #666; }
        .line { border-bottom: 3px solid #28a745; margin: 15px 0; }
        .content-title { text-align: center; font-weight: bold; margin: 20px 0; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        table th { background-color: #f8f9fa; padding: 10px; border: 1px solid #dee2e6; }
        table td { padding: 10px; border: 1px solid #dee2e6; text-align: center; }
        .footer-total { text-align: right; margin-top: 20px; font-weight: bold; font-size: 16px; }
        .total-amount { color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h1>RESI LAPORAN BANK SAMPAH</h1>
        <p>Jl. Lingkungan Digital No. 123, Kota Ekosistem</p>
        <p>Tanggal Cetak: {{ date('d/m/Y') }} | Dicetak Oleh: {{ Auth::user()->nama }}</p>
    </div>
    <div class="line"></div>
    <div class="content-title">DATA TRANSAKSI MASUK</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Jenis Sampah</th>
                <th>Berat</th>
                <th>Total (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($data as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->created_at->format('d/m/Y') }}</td>
                <td>{{ $t->user->nama }}</td>
                <td>{{ $t->jenis_sampah }}</td>
                <td>{{ $t->berat_kg ?? 0 }} Kg</td>
                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            </tr>
            @php $total += $t->total_harga; @endphp
            @endforeach
        </tbody>
    </table>
    <div class="footer-total">
        Total Perputaran Uang: <span class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
    </div>
</body>
</html>