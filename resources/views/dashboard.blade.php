<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Multi-Role - Bank Sampah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            background:#f8f9fa;
            scroll-behavior:smooth;
        }

        .sidebar{
            width:280px;
            min-height:100vh;
            position:sticky;
            top:0;
            z-index:1000;
        }

        .card-balance{
            background:linear-gradient(135deg,#198754,#0d5032);
            color:white;
            border:none;
            border-radius:20px;
        }

        .nav-link{
            color:rgba(255,255,255,0.7);
            transition:0.3s;
            margin-bottom:5px;
        }

        .nav-link:hover,
        .nav-link.active{
            color:white;
            background:rgba(255,255,255,0.1);
            border-radius:10px;
        }

        .table td,
        .table th{
            vertical-align:middle;
        }

        .badge-status{
            padding:8px 14px;
            border-radius:30px;
            font-size:12px;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark sidebar p-4 shadow">

        <div class="text-center mb-4">

            <div class="bg-success d-inline-block p-3 rounded-circle mb-2 shadow">
                <i class="bi bi-shield-check fs-3 text-white"></i>
            </div>

            <h6 class="text-white fw-bold mb-0">
                {{ Auth::user()->nama }}
            </h6>

            <span class="badge bg-success text-uppercase mt-1"
                style="font-size:9px;">

                {{ Auth::user()->role }}

            </span>

        </div>

        <!-- MENU -->
        <nav class="nav flex-column gap-1">

            <a class="nav-link active px-3 py-2"
                href="{{ route('dashboard') }}">

                <i class="bi bi-grid-1x2-fill me-2"></i>
                Dashboard

            </a>

            @if(Auth::user()->role == 'admin')

                <a class="nav-link px-3 py-2"
                    href="#statistik-admin">

                    <i class="bi bi-graph-up me-2"></i>
                    Statistik

                </a>

                <a class="nav-link px-3 py-2"
                    href="#riwayat-section">

                    <i class="bi bi-check2-square me-2"></i>
                    Validasi

                </a>

                <a class="nav-link px-3 py-2"
                    href="{{ route('dashboard') }}">

                    <i class="bi bi-people me-2"></i>
                    Kelola Nasabah

                </a>

                <a class="nav-link px-3 py-2"
                    href="{{ route('admin.laporan.pdf') }}">

                    <i class="bi bi-file-earmark-pdf me-2"></i>
                    Cetak Laporan PDF

                </a>

            @else

                <a class="nav-link px-3 py-2"
                    href="{{ route('katalog') }}">

                    <i class="bi bi-book me-2"></i>
                    Katalog & Setor

                </a>

                <a class="nav-link px-3 py-2"
                    href="#riwayat-section">

                    <i class="bi bi-clock-history me-2"></i>
                    Riwayat Saya

                </a>

            @endif

            <hr class="text-white opacity-25">

            <form action="{{ route('logout') }}"
                method="POST">

                @csrf

                <button class="btn btn-outline-danger w-100 rounded-pill">

                    Keluar

                </button>

            </form>

        </nav>

    </div>

    <!-- MAIN CONTENT -->
    <div class="p-5 w-100">

        <!-- ALERT -->
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4">

                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4">

                {{ session('error') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        {{-- ================= ADMIN ================= --}}
        @if(Auth::user()->role == 'admin')

        <div id="statistik-admin">

            <div class="row g-4 mb-4">

                <!-- TOTAL NASABAH -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3 rounded-4 text-center">

                        <small class="text-muted fw-bold">
                            TOTAL NASABAH
                        </small>

                        <h2 class="fw-bold text-primary">

                            {{ $totalNasabah }}

                        </h2>

                    </div>
                </div>

                <!-- SAMPAH MASUK -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3 rounded-4 text-center">

                        <small class="text-muted fw-bold">
                            SAMPAH MASUK
                        </small>

                        <h2 class="fw-bold text-success">

                            {{ number_format($sampahMasuk,0,',','.') }}

                            <small class="fs-6">kg</small>

                        </h2>

                    </div>
                </div>

                <!-- PENDING -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3 rounded-4 text-center">

                        <small class="text-muted fw-bold">
                            PENDING VALIDASI
                        </small>

                        <h2 class="fw-bold text-warning">

                            {{ $transaksi->where('status','pending')->count() }}

                        </h2>

                    </div>
                </div>

                <!-- TOTAL PERPUTARAN -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm p-3 rounded-4 text-center">

                        <small class="text-muted fw-bold">
                            TOTAL PERPUTARAN
                        </small>

                        <h2 class="fw-bold text-danger">

                            Rp
                            {{ number_format($totalPerputaran,0,',','.') }}

                        </h2>

                    </div>
                </div>

            </div>

            <!-- CHART -->
            <div class="card border-0 shadow-sm p-4 rounded-4 mb-5">

                <h5 class="fw-bold mb-4">
                    Tren Setoran Sampah
                </h5>

                <canvas id="adminChart" height="100"></canvas>

            </div>

        </div>

        @endif

        {{-- ================= NASABAH ================= --}}
        @if(Auth::user()->role == 'nasabah')

        <div class="row g-4 mb-5">

            <div class="col-md-7">

                <div class="card card-balance p-4 shadow h-100">

                    <small class="opacity-75 fw-bold text-uppercase">
                        Saldo Aktif Nasabah
                    </small>

                    <h1 class="fw-bold my-2">

                        Rp
                        {{ number_format(Auth::user()->balance,0,',','.') }}

                    </h1>

                    <div class="mt-3">

                        <a href="{{ route('katalog') }}"
                            class="btn btn-light btn-sm rounded-pill px-3 fw-bold">

                            Setor Sekarang

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-5">

                <div class="card border-0 shadow-sm p-4 rounded-4 h-100 bg-white">

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-wallet2 me-2 text-success"></i>
                        Tarik Tunai

                    </h6>

                    <form action="{{ route('tarik.saldo') }}"
                        method="POST">

                        @csrf

                        <div class="mb-3">

                            <input type="number"
                                name="jumlah"
                                class="form-control bg-light border-0 py-2"
                                placeholder="Min. Rp 10.000"
                                required>

                        </div>

                        <button class="btn btn-dark w-100 rounded-pill py-2 shadow-sm fw-bold">

                            Proses Penarikan

                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endif

        {{-- ================= TABEL TRANSAKSI ================= --}}
        <div id="riwayat-section"
            class="bg-white p-4 rounded-4 shadow-sm">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="fw-bold mb-0">

                    {{ Auth::user()->role == 'admin'
                        ? 'Daftar Semua Transaksi'
                        : 'Riwayat Transaksi Saya'
                    }}

                </h5>

                @if(Auth::user()->role == 'admin')

                    <a href="{{ route('admin.laporan.pdf') }}"
                        class="btn btn-outline-danger btn-sm rounded-pill px-3">

                        <i class="bi bi-file-earmark-pdf me-1"></i>
                        Download PDF

                    </a>

                @endif

            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>Kode</th>

                            @if(Auth::user()->role == 'admin')
                                <th>Nasabah</th>
                            @endif

                            <th>Aktivitas</th>
                            <th>Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transaksi as $t)

                        <tr>

                            <td class="fw-bold small">
                                {{ $t->kode_booking }}
                            </td>

                            @if(Auth::user()->role == 'admin')

                                <td>
                                    {{ $t->user->nama ?? 'User' }}
                                </td>

                            @endif

                            <td>
                                {{ $t->jenis_sampah }}
                            </td>

                            {{-- ================= LOGIKA MINUS ADMIN VS PLUS NASABAH ================= --}}
                            @php
                                $isMinus = (
                                    Auth::user()->role == 'admin' ||
                                    $t->jenis_sampah == 'Tarik Tunai'
                                );
                            @endphp

                            <td class="fw-bold {{ $isMinus ? 'text-danger' : 'text-success' }}">

                                {{ $isMinus ? '-' : '+' }}

                                Rp {{ number_format($t->total_harga,0,',','.') }}

                            </td>

                            <!-- STATUS -->
                            <td class="text-center">

                                @if($t->status == 'pending')

                                    <span class="badge bg-warning text-dark badge-status">
                                        Pending
                                    </span>

                                @elseif($t->status == 'ditolak')

                                    <span class="badge bg-danger badge-status">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge bg-success badge-status">
                                        Selesai
                                    </span>

                                @endif

                            </td>

                            <!-- AKSI -->
                            <td class="text-center">

                                @if(Auth::user()->role == 'admin' && $t->status == 'pending')

                                    <!-- Tombol Aksi Admin -->
                                    <div class="d-flex gap-1 justify-content-center">

                                        <form action="{{ route('admin.konfirmasi', $t->id) }}"
                                            method="POST">

                                            @csrf

                                            <button class="btn btn-sm btn-success rounded-pill px-3">

                                                Terima

                                            </button>

                                        </form>

                                        <form action="{{ route('admin.tolak', $t->id) }}"
                                            method="POST">

                                            @csrf

                                            <button class="btn btn-sm btn-danger rounded-pill px-3">

                                                Tolak

                                            </button>

                                        </form>

                                    </div>

                                @elseif($t->status == 'selesai')

                                    <!-- Tombol Resi PDF -->
                                    <a href="{{ route('resi.pdf', $t->id) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-dark rounded-pill px-3">

                                        <i class="bi bi-file-pdf me-1"></i>
                                        Resi PDF

                                    </a>

                                @else

                                    <span class="text-muted small">
                                        Menunggu Validasi
                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                Tidak ada data transaksi ditemukan.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- CHART ADMIN --}}
@if(Auth::user()->role == 'admin')

<script>

const ctx = document.getElementById('adminChart').getContext('2d');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],

        datasets: [{

            label: 'Volume Sampah',

            data: [45,59,80,81,56,95,40],

            borderColor: '#198754',

            backgroundColor: 'rgba(25,135,84,0.1)',

            fill: true,

            tension: 0.4

        }]
    },

    options: {

        responsive: true,

        plugins: {
            legend: {
                display: false
            }
        }

    }

});

</script>

@endif

</body>
</html>