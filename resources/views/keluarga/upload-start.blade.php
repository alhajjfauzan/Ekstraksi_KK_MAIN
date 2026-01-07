<!DOCTYPE html>
<html lang="id">
<head>
    <title>Upload KK</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <div class="form-header">
            <a href="/dashboard" class="back-link">< Kembali</a>
            <h2 class="text-green">UPLOAD KARTU KELUARGA</h2>
        </div>

        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
            <div style="font-size: 50px; color: var(--primary-green); margin-bottom: 20px;">☁️</div>
            <h3 class="text-green">Pilih File atau Tarik Kesini</h3>
            <p style="color: gray;">Format: PNG, JPG (Maks. 5MB)</p>
            
            <input type="file" id="fileInput" style="display: none;" onchange="handleFileUpload(this)">
        </div>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>