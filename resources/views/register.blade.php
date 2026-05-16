<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nasabah - Bank Sampah Digital</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .register-card {
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            background: #fff;
        }
        .register-sidebar {
            background: linear-gradient(180deg, #064e3b 0%, #022c22 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 5px solid #d4af37; /* Aksen Emas */
        }
        .form-section {
            padding: 40px 50px;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #064e3b;
            background-color: #fff;
        }
        .btn-register {
            background-color: #064e3b;
            color: white;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
        }
        .btn-register:hover {
            background-color: #022c22;
            color: #d4af37;
            transform: translateY(-2px);
        }
        .text-gold {
            color: #d4af37;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-card row mx-auto">
        <div class="col-md-5 register-sidebar d-none d-md-flex text-center">
            <i class="bi bi-person-plus display-1 mb-4 text-gold"></i>
            <h2 class="fw-bold">Gabung <span class="text-gold">Nasabah</span></h2>
            <p class="opacity-75">Mulai langkah kecil Anda untuk bumi yang lebih hijau dan tabungan yang lebih sehat.</p>
        </div>

        <div class="col-md-7 form-section">
            <div class="mb-4">
                <h3 class="fw-bold text-dark">Buat Akun Baru</h3>
                <p class="text-muted small">Lengkapi data di bawah untuk mendaftar</p>
            </div>

            <form action="/post-register" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-register w-100 mb-3 shadow-sm">Daftar Sekarang</button>
                
                <div class="text-center mt-3">
                    <p class="small text-muted">Sudah punya akun? <a href="/" class="text-success fw-bold text-decoration-none">Masuk di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>