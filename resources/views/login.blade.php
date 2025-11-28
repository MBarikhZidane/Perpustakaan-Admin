<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Perpustakaan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #e0f7ff, #d1e7f7);
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #fff;
            padding: 2.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-box img {
            width: 120px;
            margin-bottom: 1rem;
        }

        .login-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #0077b6;
            /* biru lembut */
            margin-bottom: 1.5rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-blue {
            background-color: #0077b6;
            color: white;
            font-weight: 600;
        }

        .btn-blue:hover {
            background-color: #005f91;
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        small.text-danger {
            font-size: 0.85rem;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <div class="login-title">Dashboard Perpustakaan</div>
        <img src="{{ asset('assets/img/Skarisa.png') }}" alt="Logo Perpustakaan">
        <p class="text-muted mb-3">Login System</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div class="mb-3 text-start">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" placeholder="Username"
                        class="form-control @error('username') is-invalid @enderror" required>
                </div>
                @error('username')
                    <small class="text-danger d-flex align-items-center mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                    </small>
                @enderror
                @if (session('gagal'))
                    <small class="text-danger d-flex align-items-center mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('gagal') }}
                    </small>
                @endif

            </div>

            <!-- Password -->
            <div class="mb-4 text-start">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" placeholder="Password"
                        class="form-control @error('password') is-invalid @enderror" required>
                </div>
                @error('password')
                    <small class="text-danger d-flex align-items-center mt-1">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- Tombol Login -->
            <div class="d-grid">
                <button type="submit" class="btn btn-blue">Masuk</button>
            </div>
        </form>
    </div>

</body>

</html>
