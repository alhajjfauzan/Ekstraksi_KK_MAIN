<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ekstraksi KK</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/modal.css')); ?>">
</head>
<body
    <?php if(session('success_message')): ?>
        data-success="<?php echo e(session('success_message')); ?>"
        data-success-title="<?php echo e(session('success_title')); ?>"
        data-redirect-url="/dashboard"
    <?php endif; ?>
>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h1 class="auth-title">LOGIN</h1>
            <p class="auth-subtitle">Masuk untuk mengelola data Kartu Keluarga</p>

            <?php if($errors->any()): ?>
                <div style="background-color: rgba(211, 47, 47, 0.1); border: 1px solid #d32f2f; color: #ff6b6b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>• <?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>   

                <div class="form-group" style="text-align: left;">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="contoh@email.com" value="<?php echo e(old('email')); ?>" required>
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

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">&times;</button>
            <div class="modal-icon">✓</div>
            <h2 class="modal-title" id="modalTitle">Berhasil!</h2>
            <p class="modal-message" id="modalMessage">Anda telah berhasil melakukan Login</p>
            <button class="modal-button" id="modalButton">Lanjut</button>
        </div>
    </div>

    <script src="<?php echo e(asset('js/modal.js')); ?>"></script>
</body>
</html><?php /**PATH C:\laragon\www\Ekstraksi_KK_MAIN-main\resources\views/auth/login.blade.php ENDPATH**/ ?>