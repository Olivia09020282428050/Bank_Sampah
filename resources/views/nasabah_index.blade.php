<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Nasabah - Bank Sampah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #f5f7fb;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transition: 0.3s;
        }

        .card {
            border: none;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .sidebar {
            width: 280px;
            min-height: 100vh;
            position: sticky;
            top: 0;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-4 shadow sidebar">

        <h4 class="fw-bold text-success mb-5">
            <i class="bi bi-recycle"></i>
            BANK SAMPAH
        </h4>

        <nav class="nav flex-column gap-2">

            <!-- DASHBOARD -->
            <a class="nav-link text-white"
                href="{{ route('dashboard') }}">

                <i class="bi bi-house-door me-2"></i>
                Dashboard
            </a>

            <!-- DATA NASABAH -->
            <a class="nav-link text-white bg-success rounded-3 px-3 py-2"
                href="{{ route('nasabah.index') }}">

                <i class="bi bi-people me-2"></i>
                Data Nasabah
            </a>

            <!-- CETAK PDF -->
            <a class="nav-link text-white"
                href="{{ route('laporan.cetak') }}">

                <i class="bi bi-file-earmark-pdf me-2"></i>
                Cetak Laporan PDF
            </a>

            <hr class="opacity-25">

            <!-- LOGOUT -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button class="btn btn-outline-danger w-100 rounded-pill mt-5">

                    <i class="bi bi-box-arrow-left me-2"></i>
                    Keluar

                </button>
            </form>

        </nav>
    </div>

    <!-- CONTENT -->
    <div class="p-5 w-100">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">

                    <i class="bi bi-people-fill me-2 text-success"></i>
                    Data Nasabah

                </h3>

                <p class="text-muted mb-0">
                    Kelola seluruh data nasabah bank sampah digital.
                </p>

            </div>

            <div class="d-flex gap-3 align-items-center">

                <!-- TOMBOL KEMBALI -->
                <a href="{{ route('dashboard') }}"
                    class="btn btn-outline-success rounded-pill px-4">

                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali

                </a>

                <!-- TOTAL NASABAH -->
                <div class="bg-white shadow-sm rounded-4 px-4 py-3 border-start border-success border-4">

                    <small class="text-muted d-block text-uppercase fw-bold"
                        style="font-size: 10px;">

                        Total Nasabah

                    </small>

                    <h4 class="fw-bold text-success mb-0">
                        {{ $nasabah->count() }}
                    </h4>

                </div>

            </div>

        </div>

        <!-- CARD TABEL -->
        <div class="card shadow-sm rounded-4 p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Saldo</th>
                            <th class="text-center">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($nasabah as $n)

                        <tr>

                            <td class="fw-bold">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $n->nama }}
                            </td>

                            <td>
                                {{ $n->email }}
                            </td>

                            <td class="fw-bold text-success">
                                Rp {{ number_format($n->balance,0,',','.') }}
                            </td>

                            <td class="text-center">

                                <form action="{{ route('nasabah.destroy', $n->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus nasabah ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger border-0">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center text-muted py-4">

                                Belum ada data nasabah.

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

</body>
</html>