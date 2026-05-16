<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Sampah Digital</title>
    
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
        .login-card {
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            background: #fff;
        }
        .login-sidebar {
            background: linear-gradient(180deg, #064e3b 0%, #022c22 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-right: 5px solid #d4af37; /* Aksen Emas */
        }
        .form-section {
            padding: 50px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #064e3b;
            background-color: #fff;
        }
        .btn-login {
            background-color: #064e3b;
            color: white;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
        }
        .btn-login:hover {
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
    <div class="login-card row mx-auto">
        <div class="col-md-5 login-sidebar d-none d-md-flex text-center">
            <i class="bi bi-recycle display-1 mb-4 text-gold"></i>
            <h2 class="fw-bold">Bank <span class="text-gold">Sampah</span></h2>
            <p class="opacity-75">Ubah limbah menjadi berkat. Kelola tabungan masa depan Anda dengan lingkungan yang lebih bersih.</p>
        </div>

        <div class="col-md-7 form-section">
            <div class="mb-4">
                <h3 class="fw-bold text-dark">Selamat Datang</h3>
                <p class="text-muted small">Silakan masuk ke akun Anda</p>
            </div>

            @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>
                    {{ session('error') }}
                </div>
            </div>
            @endif

            <form action="/post-login" method="POST">
                @csrf
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
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 mb-3 shadow-sm">Masuk Sekarang</button>
                
                <div class="text-center mt-4">
                    <p class="small text-muted">Belum punya akun? <a href="/register" class="text-success fw-bold text-decoration-none">Daftar Nasabah</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>