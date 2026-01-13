<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ekstraksi KK</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body
    @if(session('success_message'))
        data-success="{{ session('success_message') }}"
        data-success-title="{{ session('success_title') }}"
        data-redirect-url="/dashboard"
    @endif
>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">REGISTER</h1>
            <p class="auth-subtitle">Buat akun baru untuk memulai</p>

            @if ($errors->any())
                <div style="background-color: rgba(211, 47, 47, 0.1); border: 1px solid #d32f2f; color: #ff6b6b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group" style="text-align: left;">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Nama Anda" value="{{ old('name') }}" required>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                    <small style="color: var(--text-gray); display: block; margin-top: 5px;">
                        Minimal 8 karakter dan harus mengandung minimal 1 huruf besar (A-Z)
                    </small>
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

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <div class="modal-icon">✓</div>
            <h2 class="modal-title" id="modalTitle">Berhasil!</h2>
            <p class="modal-message" id="modalMessage">Anda telah berhasil melakukan Register</p>
            <button class="modal-button" id="modalButton">Lanjut</button>
        </div>
    </div>

    <script src="{{ asset('js/modal.js') }}"></script>
</body>
</html>