<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ekstraksi KK</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">REGISTER</h1>
            <p class="auth-subtitle">Buat akun baru untuk memulai</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group" style="text-align: left;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama Anda" required>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="contoh@email.com" required>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    DAFTAR AKUN
                </button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
            </div>
        </div>
    </div>

</body>
</html>