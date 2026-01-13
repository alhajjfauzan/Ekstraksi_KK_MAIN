<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Tambah Data Keluarga</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form.css')); ?>">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <a href="/dashboard" class="back-link">◀ Kembali</a>
            <h1 class="form-title">PENGISIAN DATA KELUARGA</h1>
        </div>
        <form action="<?php echo e(route('tambah.store')); ?>" method="POST" id="formKeluarga">
               <?php echo csrf_field(); ?>
        <script>
    window.scrollTo({ top: 0, behavior: 'smooth' });
</script>


    <div class="form-section">
        <h2 class="section-title">Data Kepala Keluarga</h2>
        
        <div class="form-group">
            <label>No Kartu Keluarga</label>
            <input type="text" id="no_kk" maxlength="16" name="no_kk" placeholder="Isikan" value="<?php echo e(old('no_kk')); ?>" required>
            <div id="no_kk_error" style="color: red; display: none;">No KK hanya boleh berisi angka.</div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>RT</label>
                <input type="text" maxlength="3" name="rt" placeholder="Isikan" value="<?php echo e(old('rt')); ?>" class ="only_number" required>
                <div class="input-error" style="color:red; display:none;">RT harus diisi.</div>
            </div>
            <div class="form-group">
                <label>RW</label>
                <input type="text" maxlength="3" name="rw" placeholder="Isikan" value="<?php echo e(old('rw')); ?>" class ="only_number" required>
                <div class="input-error" style="color:red; display:none;">RW harus diisi.</div>
            </div>
            <div class="form-group">
                <label>Desa/Kelurahan</label>
                <input type="text" name="kelurahan" placeholder="Isikan" value="<?php echo e(old('kelurahan')); ?>" required>
                <div class="input-error" style="color:red; display:none;">Desa/Kelurahan harus diisi.</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" placeholder="Isikan" value="<?php echo e(old('kecamatan')); ?>" required>
                <div class="input-error" style="color:red; display:none;">Kecamatan harus diisi.</div>
            </div>
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <input type="text" name="kabupaten" placeholder="Isikan" value="<?php echo e(old('kabupaten')); ?>" required>
                <div class="input-error" style="color:red; display:none;">Kabupaten harus diisi.</div>
            </div>
            <div class="form-group">
                <label>Provinsi</label>
                <input type="text" name="provinsi" placeholder="Isikan" value="<?php echo e(old('provinsi')); ?>" required>
                <div class="input-error" style="color:red; display:none;">Provinsi harus diisi.</div>
            </div>
        </div>
        <div class="form-row">
        <div class="form-group">
            <label>Tanggal Kartu Dikeluarkan</label>
            <input type="date" name="tanggal_dikeluarkan" value="<?php echo e(old('tanggal_dikeluarkan')); ?>" required>
            <div class="input-error" style="color:red; display:none;">Tanggal Dikeluarkan harus diisi.</div>
        </div>
        <div class="form-group">
            <label>Kode Pos</label>
            <input type="text" name="kode_pos" value="<?php echo e(old('kode_pos')); ?>" required inputmode="numeric" pattern="[0-9]{5}" maxlength="5" placeholder="Isikan">
            <div class="input-error" style="color:red; display:none;">Kode Pos harus diisi.</div>
        </div>
         <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?php echo e(old('alamat')); ?>" placeholder="Isikan" required>
            <div class="input-error" style="color:red; display:none;">Alamat harus diisi.</div>
        </div>
        </div>
    </div>
    <div id="members-container"></div>
    <div class="form-actions">
        <button type="button" class="btn-add-member" onclick="addMember()">
            + Tambah Anggota Keluarga
        </button>
    </div>

    <div class="form-actions">
        <button type="button" class="btn-confirm" onclick="showConfirmationModal(event)">
    ✓ Konfirmasi Penambahan Data
</button>
        <a href="/dashboard" class="btn-cancel">Batal</a>
    </div>
</form>

    </div>
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

    <script>
        <?php if(isset($aiData) && $aiData): ?>
            window.aiExtractedData = <?php echo json_encode($aiData, 15, 512) ?>;
            console.log('AI Data loaded from session:', window.aiExtractedData);
        <?php else: ?>
            window.aiExtractedData = null;
            console.log('No AI data found in session');
        <?php endif; ?>
    </script>
    <script src="<?php echo e(asset('js/form.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\LENOVO\Documents\GitHub\baru\Ekstraksi_KK_MAIN\resources\views/keluarga/tambah.blade.php ENDPATH**/ ?>