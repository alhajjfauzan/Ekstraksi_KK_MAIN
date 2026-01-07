<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ekstraksi KK</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">LOGIN</h1>
            <p class="auth-subtitle">Masuk untuk mengelola data Kartu Keluarga</p>

            <form action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?> <div class="form-group" style="text-align: left;">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="contoh@email.com" required>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    MASUK SEKARANG
                </button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar disini</a>
            </div>
        </div>
    </div>

</body>
</html><?php /**PATH C:\laragon\www\Ekstrasasi_KK_2\resources\views/auth/login.blade.php ENDPATH**/ ?>