<!DOCTYPE html>
<html>
<head>
    <title>Resi Transaksi - {{ $t->kode_booking }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #198754; padding-bottom: 10px; mb-4: 20px; }
        .info { margin-top: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .table th { background-color: #f8f9fa; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
        .status-badge { padding: 5px 15px; border-radius: 15px; background: #198754; color: white; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>RESI BANK SAMPAH</h2>
        <p>Email: support@banksampah.com | Tanggal: {{ $t->created_at->format('d M Y H:i') }}</p>
    </div>

    <div class="info">
        <p><strong>Kode Transaksi:</strong> {{ $t->kode_booking }}</p>
        <p><strong>Nama Nasabah:</strong> {{ $t->user->nama }}</p>
        <p><strong>Status:</strong> <span class="status-badge">{{ strtoupper($t->status) }}</span></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Deskripsi Aktivitas</th>
                <th>Total Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $t->jenis_sampah }}</td>
                <td><strong>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Terima kasih telah berkontribusi menjaga lingkungan!</p>
        <p><em>Resi ini sah dihasilkan secara otomatis oleh sistem.</em></p>
    </div>
</body>
</html>