<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resi Penarikan #{{ $t->kode_booking }}</title>

    <style>
        body {
            font-family: 'Courier', monospace;
            font-size: 13px;
            color: #000;
            width: 100%;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 320px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .center {
            text-align: center;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .dashed {
            border-top: 1px dashed #000;
            margin: 12px 0;
        }

        table {
            width: 100%;
            font-size: 12px;
        }

        table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .nominal-title {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .nominal {
            font-size: 24px;
            font-weight: bold;
        }

        .success {
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            font-size: 10px;
            margin-top: 15px;
            line-height: 1.5;
        }

        .thanks {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="center">

            <div class="logo">
                BANK SAMPAH DIGITAL
            </div>

            <p class="subtitle">
                STRUK PENARIKAN TUNAI
            </p>

        </div>

        <div class="dashed"></div>

        <!-- DETAIL -->
        <table>

            <tr>
                <td width="35%">Tanggal</td>
                <td width="5%">:</td>
                <td>{{ $tanggal }}</td>
            </tr>

            <tr>
                <td>Kode</td>
                <td>:</td>
                <td>{{ $t->kode_booking }}</td>
            </tr>

            <tr>
                <td>Nasabah</td>
                <td>:</td>
                <td>{{ strtoupper($user->nama) }}</td>
            </tr>

            <tr>
                <td>Status</td>
                <td>:</td>
                <td>BERHASIL</td>
            </tr>

        </table>

        <div class="dashed"></div>

        <!-- NOMINAL -->
        <div class="center">

            <p class="nominal-title">
                NOMINAL PENARIKAN
            </p>

            <div class="nominal">
                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
            </div>

        </div>

        <div class="dashed"></div>

        <!-- STATUS -->
        <div class="center">

            <p class="success">
                *** TRANSAKSI BERHASIL ***
            </p>

        </div>

        <!-- FOOTER -->
        <div class="footer center">

            <p>
                Simpan resi ini sebagai bukti transaksi resmi.
            </p>

            <p class="thanks">
                Terima kasih telah berkontribusi menjaga lingkungan 🌱
            </p>

        </div>

    </div>

</body>
</html>