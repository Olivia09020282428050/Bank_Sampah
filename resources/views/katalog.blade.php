<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog & Setor Sampah - Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { width: 280px; min-height: 100vh; position: sticky; top: 0; }
        .card-hover { transition: 0.3s; border: none; }
        .card-hover:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .img-container { height: 160px; overflow: hidden; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- SIDEBAR -->
    <div class="bg-dark sidebar p-4 shadow">
        <div class="text-center mb-4">
            <div class="bg-success d-inline-block p-3 rounded-circle mb-3">
                <i class="bi bi-person-fill fs-3 text-white"></i>
            </div>
            <h6 class="fw-bold text-white mb-0">{{ Auth::user()->nama }}</h6>
            <small class="text-success fw-bold">ID Nasabah: #{{ Auth::id() }}</small>
        </div>
        
        <nav class="nav flex-column mt-4 text-white">
            <a class="nav-link text-white mb-2" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
            </a>
            <a class="nav-link text-white bg-success rounded-3 mb-2" href="{{ route('katalog') }}">
                <i class="bi bi-book me-2"></i> Katalog & Setor
            </a>
            <hr class="opacity-25">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger w-100 rounded-pill mt-5">Keluar</button>
            </form>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="p-5 w-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-success mb-1">Katalog Sampah Digital</h3>
                <p class="text-muted">Pilih kategori sampah yang ingin Anda setorkan hari ini.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Dashboard
            </a>
        </div>

        <div class="row g-4">
            @php
                $items = [
                    [
                        'name' => 'Plastik PET', 
                        'price' => 3000, 
                        'badge' => 'Botol Bening',
                        'img' => 'https://bioplast.co.id/wp-content/uploads/2025/04/Kemasan-PET_-Botol-Plastik-dari-Polyethylene-Terephthalate-PET.webp'
                    ],
                    [
                        'name' => 'Plastik HDPE', 
                        'price' => 2500, 
                        'badge' => 'Botol Sabun',
                        'img' => 'https://bioplast.co.id/wp-content/uploads/2025/04/Mengenal-Plastik-HDPE_-Kemasan-Berbahan-High-Density-Polyethylene-PP.webp'
                    ],
                    [
                        'name' => 'Kardus', 
                        'price' => 1500, 
                        'badge' => 'Karton Bekas',
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBhxE-RSDvAtX3YfK3H4djF04VDRGqEcjI_enu6RdU5w&s'
                    ],
                    [
                        'name' => 'Kertas HVS', 
                        'price' => 2000, 
                        'badge' => 'Dokumen/Buku',
                        'img' => 'https://udsregep.com/wp-content/uploads/2019/09/Beli-Kertas-Bekas-Rahasia-Dijamin-Tak-Akan-Bocor.jpg'
                    ],
                    [
                        'name' => 'Logam Besi', 
                        'price' => 5000, 
                        'badge' => 'Pipa/Besi Tua',
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQae5yyWfvOdUWkAMBIkWwVtEh8FIydDv8hbA&s'
                    ],
                    [
                        'name' => 'Aluminium', 
                        'price' => 10000, 
                        'badge' => 'Kaleng Minuman',
                        'img' => 'https://st2.depositphotos.com/1087278/12303/i/450/depositphotos_123038682-stock-photo-aluminum-waste-prepare-for-recycle.jpg'
                    ],
                    [
                        'name' => 'Minyak Jelantah', 
                        'price' => 6000, 
                        'badge' => 'Minyak Goreng',
                        'img' => 'https://d1y8dt4ho4tlr1.cloudfront.net/images/content/digital-content/image/bekas-tapi-berkelas-cara-tepat-mengelola-minyak-jelantah-1738643398.png'
                    ],
                    [
                        'name' => 'Elektronik', 
                        'price' => 15000, 
                        'badge' => 'E-Waste',
                        'img' => 'https://citarumharum.jabarprov.go.id/eusina/uploads/2022/07/rabuc1.jpeg'
                    ],
                ];
            @endphp

            @foreach($items as $item)
            <div class="col-md-3">
                <div class="card shadow-sm rounded-4 overflow-hidden h-100 card-hover" 
                     style="cursor: pointer;" 
                     onclick="openModal('{{ $item['name'] }}', '{{ $item['price'] }}')">
                    <div class="img-container">
                        <img src="{{ $item['img'] }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $item['name'] }}">
                    </div>
                    <div class="p-3">
                        <span class="badge bg-success-subtle text-success mb-2">{{ $item['badge'] }}</span>
                        <h6 class="fw-bold mb-1 text-dark">{{ $item['name'] }}</h6>
                        <span class="text-success small fw-bold">Rp {{ number_format($item['price']) }}/kg</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- MODAL SETOR -->
<div class="modal fade" id="modalSetor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-success text-white rounded-top-4 border-0">
                <h5 class="modal-title fw-bold">Kirim Setoran Sampah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">KATEGORI</label>
                        <input type="text" id="display_jenis" class="form-control border-0 bg-light fw-bold text-success" readonly>
                        <input type="hidden" id="input_jenis" name="jenis_sampah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ESTIMASI BERAT (KG)</label>
                        <input type="number" step="0.1" name="berat_kg" class="form-control shadow-sm" placeholder="Contoh: 1.5" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">FOTO BARANG</label>
                        <input type="file" name="foto_sampah" class="form-control shadow-sm" accept="image/*" required>
                        <small class="text-muted" style="font-size: 11px;">*Maksimal ukuran file 2MB (JPEG/PNG)</small>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm">
                        <i class="bi bi-send me-2"></i>Ajukan Setoran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openModal(jenis, harga) {
        document.getElementById('display_jenis').value = jenis + " - Rp " + harga + "/kg";
        document.getElementById('input_jenis').value = jenis;
        var myModal = new bootstrap.Modal(document.getElementById('modalSetor'));
        myModal.show();
    }
</script>
</body>
</html>