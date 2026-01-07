<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container hero-section">
        <h1 class="hero-title">EKSTRAKSI <br> <span class="text-green">KARTU KELUARGA</span></h1>
        <p class="hero-desc">Ekstrak data dari foto Kartu Keluarga Anda menjadi format digital dengan mudah dan cepat.</p>
        
        <div class="hero-buttons">
            <button onclick="goTo('/login')" class="btn btn-primary">Mulai Sekarang</button>
            <button class="btn btn-outline">Lihat Selengkapnya</button>
        </div>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>