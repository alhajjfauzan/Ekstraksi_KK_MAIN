<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ekstraksi KK</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">REGISTER</h1>
            <p class="auth-subtitle">Buat akun baru untuk memulai</p>

            <form action="<?php echo e(route('register')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
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
                Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Login disini</a>
            </div>
        </div>
    </div>

</body>
</html><?php /**PATH C:\laragon\www\Ekstrasasi_KK_2\resources\views/auth/register.blade.php ENDPATH**/ ?>