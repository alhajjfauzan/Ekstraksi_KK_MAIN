<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Data Keluarga</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form.css')); ?>">
</head>
<body>
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <a href="/dashboard" class="back-link">◀ Kembali</a>
            <h1 class="form-title">PENGISIAN DATA KELUARGA</h1>
        </div>

        <!-- Form -->
        <form action="<?php echo e(route('tambah.store')); ?>" method="POST" id="formKeluarga">
            <?php echo csrf_field(); ?>

            <!-- Section: Data Kepala Keluarga -->
            <div class="form-section">
                <h2 class="section-title">Data Kepala Keluarga</h2>
                
                <div class="form-group">
                    <label>No Kartu Keluarga</label>
                    <input type="text" name="no_kk" placeholder="Isikan" value="<?php echo e(old('no_kk')); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" name="rt" placeholder="Isikan" value="<?php echo e(old('rt')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" name="rw" placeholder="Isikan" value="<?php echo e(old('rw')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Desa/Kelurahan</label>
                        <input type="text" name="kelurahan" placeholder="Isikan" value="<?php echo e(old('kelurahan')); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan" placeholder="Isikan" value="<?php echo e(old('kecamatan')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" placeholder="Isikan" value="<?php echo e(old('kabupaten')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="provinsi" placeholder="Isikan" value="<?php echo e(old('provinsi')); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Kartu Dikeluarkan</label>
                    <input type="date" name="tanggal_dikeluarkan" value="<?php echo e(old('tanggal_dikeluarkan')); ?>" required>
                </div>
            </div>

            <!-- Section: Data Anggota Keluarga -->
            <div id="members-container"></div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="button" class="btn-add-member" onclick="addMember()">
                    + Tambah Anggota Keluarga
                </button>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-confirm" onclick="showConfirmationModal(event)">
                    ✓ Konfirmasi Penambahan Data
                </button>
                <a href="/dashboard" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal-confirmation" id="confirmationModal">
        <div class="modal-confirmation-content">
            <h2 class="modal-confirmation-title">Peringatan!</h2>
            <p class="modal-confirmation-message">
                Apakah anda sudah yakin dengan data yang anda masukkan? Harap cek dengan seksama!
            </p>
            <div class="modal-confirmation-buttons">
                <button type="button" class="btn-tidak" onclick="closeConfirmationModal()">Tidak</button>
                <button type="button" class="btn-yakin" onclick="confirmSubmit()">Yakin</button>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/form.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\Ekstraksi_KK_MAIN\resources\views/keluarga/tambah.blade.php ENDPATH**/ ?>