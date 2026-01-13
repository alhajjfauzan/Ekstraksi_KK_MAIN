<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Upload KK</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/upload.css')); ?>">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <div class="form-header">
            <a href="/dashboard" class="back-link">< Kembali</a>
            <h2 class="text-green">EKSTRAKSI KARTU KELUARGA</h2>
        </div>

        <!-- Upload Section -->
        <div id="uploadSection" class="upload-section">
            <div class="upload-area" id="uploadArea">
                <div style="font-size: 50px; color: var(--primary-green); margin-bottom: 20px;">☁️</div>
                <h3 class="text-green">Pilih File atau Tarik Kesini</h3>
                <p style="color: var(--text-gray);">Format: PNG, JPG, PDF | Ukuran Maksimal: 10MB</p>
                
                <input type="file" id="fileInput" style="display: none;" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileUpload(this)">
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="error-message" style="display: none;">
                <span id="errorText"></span>
            </div>
        </div>

        <!-- Preview Section -->
        <div id="previewSection" class="preview-section" style="display: none;">
            <h2 class="preview-title">PREVIEW GAMBAR KK</h2>
            
            <div class="preview-container">
                <img id="previewImage" src="" alt="Preview" class="preview-image">
            </div>

            <div class="preview-info">
                <p><strong>Nama File:</strong> <span id="fileName"></span></p>
                <p><strong>Ukuran:</strong> <span id="fileSize"></span></p>
            </div>

            <div class="action-buttons">
                <button class="btn btn-warning" onclick="changeFile()">📝 Ubah</button>
                <button class="btn btn-success" onclick="confirmUpload(event)">✓ Konfirmasi Penambahan Data</button>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/upload.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\LENOVO\Documents\GitHub\baru\Ekstraksi_KK_MAIN\resources\views/keluarga/upload-start.blade.php ENDPATH**/ ?>