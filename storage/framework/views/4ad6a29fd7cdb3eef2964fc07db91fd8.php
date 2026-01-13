<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/modal.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form.css')); ?>">
</head>
<body>
    <!-- Navbar -->
    <nav class="dashboard-navbar">
        <div class="navbar-menu">
            <a href="<?php echo e(route('landing')); ?>">Home</a>
            <a href="<?php echo e(route('tambah')); ?>">Tambah Data (Manual)</a>
            <a href="/keluarga/upload">Upload Data (Otomatis)</a>
            <a href="#">Download Data</a>
        </div>
        <div class="navbar-profile" onclick="toggleProfileMenu()">
            <div class="profile-icon">👤</div>
            <span>Profil</span>
            
            <!-- Profile Dropdown Menu -->
            <div class="profile-dropdown" id="profileDropdown">
                <a href="#" class="dropdown-item" onclick="logout(event); return false;">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="dashboard-container">
        <!-- Title -->
        <h1 class="dashboard-title">EKSTRAKSI <span class="text-green">KARTU KELUARGA</span></h1>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Jumlah KK</h3>
                <div class="stat-number"><?php echo e($jumlahKK ?? 0); ?></div>
            </div>
            <div class="stat-card">
                <h3>Jumlah Warga</h3>
                <div class="stat-number"><?php echo e($jumlahWarga ?? 0); ?></div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-container">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Cari Data keluarga..." id="search-input">
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Kartu Keluarga</th>
                            <th>Nama Kepala Keluarga</th>
                            <th>Kecamatan</th>
                            <th>Kabupaten</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php $__empty_1 = true; $__currentLoopData = $kartuKeluargas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($kartuKeluargas->firstItem() + $index); ?></td>
                            <td><?php echo e($kk->no_kk); ?></td>
                            <td><?php echo e($kk->kepala_keluarga); ?></td>
                            <td><?php echo e($kk->kecamatan); ?></td>
                            <td><?php echo e($kk->kabupaten); ?></td>
                            <td>
                                <a href="<?php echo e(route('keluarga.detail', $kk->no_kk)); ?>" class="btn-action" title="Lihat Detail">👁️</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">📋</div>
                                    <p>Tidak ada data keluarga ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <?php if($kartuKeluargas->hasPages()): ?>
        <div class="pagination-container">
            <!-- Previous Button -->
            <?php if($kartuKeluargas->onFirstPage()): ?>
                <button class="pagination-item" disabled>◀ Sebelumnya</button>
            <?php else: ?>
                <a href="<?php echo e($kartuKeluargas->previousPageUrl()); ?>" class="pagination-item">◀ Sebelumnya</a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <div class="pagination-nav">
                <?php $__currentLoopData = $kartuKeluargas->getUrlRange(1, $kartuKeluargas->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $kartuKeluargas->currentPage()): ?>
                        <button class="pagination-item active"><?php echo e($page); ?></button>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" class="pagination-item"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Next Button -->
            <?php if($kartuKeluargas->hasMorePages()): ?>
                <a href="<?php echo e($kartuKeluargas->nextPageUrl()); ?>" class="pagination-item">Selanjutnya ▶</a>
            <?php else: ?>
                <button class="pagination-item" disabled>Selanjutnya ▶</button>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="modal-icon">✓</div>
            <h2 class="modal-title" id="modalTitle">Berhasil!</h2>
            <p class="modal-message" id="modalMessage">Operasi berhasil dilakukan</p>
            <button class="modal-button" id="modalButton" onclick="closeSuccessModal()">Lanjut</button>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal-confirmation" id="logoutConfirmModal">
        <div class="modal-confirmation-content">
            <h2 class="modal-confirmation-title">Peringatan!</h2>
            <p class="modal-confirmation-message">
                Apakah Anda yakin ingin logout? Anda akan kembali ke halaman login.
            </p>
            <div class="modal-confirmation-buttons">
                <button type="button" class="btn-tidak" onclick="closeLogoutModal()">Tidak</button>
                <button type="button" class="btn-yakin" onclick="confirmLogout()">Ya, Logout</button>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
    <script>
        // Profile dropdown toggle
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const navbar = document.querySelector('.navbar-profile');
            const dropdown = document.getElementById('profileDropdown');
            
            if (!navbar.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Logout function
        function logout(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function confirmLogout() {
            closeLogoutModal();
            
            // Create form for logout
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/logout';
            form.innerHTML = `<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">`;
            document.body.appendChild(form);
            form.submit();
        }

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#table-body tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });

        // Modal functions
        function showSuccessModal(title = 'Berhasil!', message = 'Operasi berhasil dilakukan') {
            const modal = document.getElementById('successModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalMessage = document.getElementById('modalMessage');

            if (modal) {
                modalTitle.textContent = title;
                modalMessage.textContent = message;
                modal.classList.add('active');
            }
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.classList.remove('active');
            }
        }

        // Check if there's a success message from session
        <?php if(session('success_message')): ?>
            showSuccessModal('<?php echo e(session('success_title', 'Berhasil!')); ?>', '<?php echo e(session('success_message')); ?>', '<?php echo e(session('redirect_url', '/dashboard')); ?>');
        <?php endif; ?>
    </script>
</body>
</html><?php /**PATH C:\laragon\www\Ekstraksi_KK_MAIN-main\resources\views/dashboard.blade.php ENDPATH**/ ?>