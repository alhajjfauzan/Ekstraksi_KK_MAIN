<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Data Keluarga</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <div class="form-header">
            <a href="/dashboard" class="back-link">< Kembali</a>
            <h2 class="text-green">TAMBAH DATA KELUARGA</h2>
        </div>

        <form action="<?php echo e(route('tambah.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

            <div class="form-group">
                <label>No Kartu Keluarga</label>
               <input type="text" name="no_kk" placeholder="Masukkan No Kartu Keluarga">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>RT</label>
                  <input type="text" name="rt" placeholder="001">
                </div>
                <div class="form-group">
                    <label>RW</label>
                    <input type="text" name="rw" placeholder="002">

                </div>
                <div class="form-group">
                    <label>Desa/Kelurahan</label>
                    <input type="text" name="kelurahan" placeholder="Nama Desa/Kelurahan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan" placeholder="Nama Kecamatan">
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <input type="text" name="kabupaten" placeholder="Nama Kabupaten">
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="/dashboard" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\Ekstrasasi_KK_2\resources\views/keluarga/tambah.blade.php ENDPATH**/ ?>