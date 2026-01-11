<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekstraksi Kartu Keluarga - Digitalisasi Data KK dengan Mudah</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/landing.css')); ?>">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">EKSTRAKSI <br><span class="text-green">KARTU KELUARGA</span></h1>
            <p class="hero-desc">Ekstrak data dari foto atau PDF Kartu Keluarga menjadi<br>format Excel atau Teks secara otomatis dengan akurasi tinggi.</p>
            
            <div class="hero-buttons">
                <button onclick="window.location.href='/login'" class="btn-hero btn-primary">
                    📄 Mulai Sekarang
                    <span class="btn-arrow">→</span>
                </button>
                <button onclick="document.getElementById('features').scrollIntoView({behavior: 'smooth'})" class="btn-hero btn-outline">
                    ⋮⋮ Lihat Selengkapnya
                    <span class="btn-arrow">→</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Fitur Utama Section -->
    <section class="features-section" id="features">
        <div class="features-container">
            <h2 class="section-title">Fitur Utama</h2>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">📋</div>
                        <h3>Ekstraksi Multi-Format</h3>
                    </div>
                    <p>Mendukung unggahan berupa foto (JPG/PNG) hasil jepretan HP maupun file PDF.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">⬇️</div>
                        <h3>Output Siap Pakai</h3>
                    </div>
                    <p>Hasil konversi dapat berupa file .xlsx (Excel) yang rapi bisa langsung disalin (Copy-Paste)</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">🔍</div>
                        <h3>Deteksi Cardas (OCR)</h3>
                    </div>
                    <p>Teknologi yang mampu mengenali membaca tangan NIK, Nama, tanggal Lahir, dan hubungan keluarga secara otomatis</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon">📈</div>
                        <h3>Akurasi Tinggi</h3>
                    </div>
                    <p>Minim kesalahan input manual berkat teknologi AI terkini</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Penggunaan Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="how-it-works-container">
            <h2 class="section-title">Cara Penggunaan</h2>
            
            <div class="steps-container">
                <div class="step-item">
                    <div class="step-number-box">
                        <span>1</span>
                    </div>
                    <div class="step-content">
                        <h4>Unggah</h4>
                        <p>Pilih dan unggah foto atau file PDF Kartu Keluarga Anda dengan kualitas gambar yang jelas untuk hasil pemindaian terbaik</p>
                    </div>
                    <div class="step-icon-display">📤</div>
                </div>

                <div class="step-item">
                    <div class="step-number-box">
                        <span>2</span>
                    </div>
                    <div class="step-content">
                        <h4>Proses</h4>
                        <p>Pilih dan unggah foto atau file PDF Kartu Keluarga Anda dengan kualitas gambar yang jelas untuk hasil pemindaian terbaik</p>
                    </div>
                    <div class="step-icon-display">⚙️</div>
                </div>

                <div class="step-item">
                    <div class="step-number-box">
                        <span>3</span>
                    </div>
                    <div class="step-content">
                        <h4>Selesai</h4>
                        <p>Pilih dan unggah foto atau file PDF Kartu Keluarga Anda dengan kualitas gambar yang jelas untuk hasil pemindaian terbaik</p>
                    </div>
                    <div class="step-icon-display">✓</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="about-container">
            <h2 class="about-title">About Us</h2>
            <p class="about-desc">Hasil Kolaborasi antara Mahasiswa PKL<br>Universitas Mulawarman dan Dinas Komunikasi dan Informatika</p>
            
            <div class="about-logos">
                <div class="about-logo">🏫</div>
                <div class="about-logo">🌐</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-text">&copy; 2026 Ekstraksi Kartu Keluarga. All rights reserved.</div>
            <div class="footer-credits">Dibuat dengan ❤️ untuk mempermudah digitalisasi data</div>
        </div>
    </footer>

    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html><?php /**PATH C:\laragon\www\Ekstraksi_KK_MAIN-main\resources\views/landing.blade.php ENDPATH**/ ?>