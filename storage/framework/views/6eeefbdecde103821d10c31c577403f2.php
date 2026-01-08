<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil - Ekstraksi KK</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/modal.css')); ?>">
</head>
<body>
    <div style="display: none;">
        <!-- Halaman kosong, hanya untuk menampilkan modal -->
    </div>

    <!-- Success Modal - Auto show -->
    <div class="modal-overlay active" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">✓</div>
            <h2 class="modal-title" id="modalTitle"><?php echo e(session('success_title', 'Berhasil!')); ?></h2>
            <p class="modal-message" id="modalMessage"><?php echo e(session('success_message', 'Operasi berhasil dilakukan')); ?></p>
            <button class="modal-button" id="modalButton" onclick="redirectToDashboard()">Lanjut</button>
        </div>
    </div>

    <script>
        function redirectToDashboard() {
            const redirectUrl = "<?php echo e(session('redirect_url', '/dashboard')); ?>";
            window.location.href = redirectUrl;
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\Ekstraksi_KK_MAIN\resources\views/auth/success.blade.php ENDPATH**/ ?>