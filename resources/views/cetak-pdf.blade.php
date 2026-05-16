<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bank Sampah</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; color: #15803d; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <h2>LAPORAN TRANSAKSI BANK SAMPAH</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Booking</th>
                <th>Jenis Sampah</th>
                <th>Berat</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $key => $t)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $t->kode_booking }}</td>
                <td>{{ $t->jenis_sampah }}</td>
                <td>{{ $t->berat_kg }} kg</td>
                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                <td>{{ strtoupper($t->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis oleh Sistem Bank Sampah Digital
    </div>
</body>
</html>