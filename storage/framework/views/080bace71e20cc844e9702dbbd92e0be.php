<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <h2 style="text-align: center; margin-bottom: 30px;">DASHBOARD <span class="text-green">KK</span></h2>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Jumlah KK</h3>
                <div class="stat-number"><?php echo e($jumlahKK ?? 0); ?></div> <!-- Fallback jika null -->
            </div>
            <div class="stat-card">
                <h3>Jumlah Warga</h3>
                <div class="stat-number"><?php echo e($jumlahWarga ?? 0); ?></div> <!-- Fallback jika null -->
            </div>
        </div>

        <div class="action-buttons">
    <button onclick="goTo('<?php echo e(route('tambah')); ?>')" class="btn btn-primary">+ Tambah Data Keluarga</button> <!-- Ganti dari 'tambah-data' ke 'tambah' -->
    <button onclick="goTo('/keluarga/upload')" class="btn btn-primary">↑ Tambah Data via Upload</button>
</div>

        <div class="table-container">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Cari Data Keluarga..." id="search-input">
            </div>
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
    <a href="<?php echo e(route('keluarga.detail', $kk->no_kk)); ?>" class="btn btn-primary" style="padding: 5px 10px;">Lihat</a>
</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data keluarga ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($kartuKeluargas->links()); ?>

        </div>
    </div>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#table-body tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\LENOVO\Documents\GitHub\projek\Ekstraksi_KK_MAIN\resources\views/dashboard.blade.php ENDPATH**/ ?>