<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bank Sampah</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #28a745; pb: 10px; mb: 20px; }
        .logo { color: #28a745; font-size: 28px; font-weight: bold; margin-bottom: 5px; }
        .info { font-size: 12px; color: #666; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 12px; }
        .table th { background-color: #f8f9fa; color: #333; font-weight: bold; }
        .total-section { margin-top: 30px; text-align: right; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #aaa; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; background: #d4edda; color: #155724; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">RESI LAPORAN BANK SAMPAH</div>
        <div class="info">
            Jl. Lingkungan Digital No. 123, Kota Ekosistem <br>
            Tanggal Cetak: {{ $date }} | Dicetak Oleh: Admin System
        </div>
    </div>

    <h3 style="text-align: center; color: #444;">DATA TRANSAKSI MASUK</h3>

    <table class="table">
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
            @php $no = 1; @endphp
            @foreach($transaksi as $t)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $t->created_at->format('d/m/Y') }}</td>
                <td>{{ $t->user->nama }}</td>
                <td>{{ $t->jenis_sampah }}</td>
                <td>{{ $t->berat_kg }} Kg</td>
                <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Total Perputaran Uang:</strong> <span style="font-size: 18px; color: #28a745;">Rp {{ number_format($total_perputaran, 0, ',', '.') }}</span></p>
    </div>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Bank Sampah Digital &copy; {{ date('Y') }}
    </div>

</body>
</html>