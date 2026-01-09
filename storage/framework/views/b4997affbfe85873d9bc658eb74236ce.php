<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Data Keluarga</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form_edit.css')); ?>">
</head>
<body>
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <a href="/dashboard" class="back-link">◀ Kembali</a>
            <h1 class="form-title">PENGISIAN DATA KELUARGA</h1>
        </div>

        <!-- Form -->
        <form action="<?php echo e(route('kartu-keluarga.update', $kartuKeluarga->no_kk)); ?>" method="POST" id="formKeluarga">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Section: Data Kepala Keluarga -->
            <div class="form-section">
                <h2 class="section-title">Data Kepala Keluarga</h2>
                
                <div class="form-group">
                    <label>No Kartu Keluarga</label>
                    <input type="text" name="no_kk" placeholder="Isikan" value="<?php echo e(old('no_kk', $kartuKeluarga->no_kk)); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" name="rt" placeholder="Isikan" value="<?php echo e(old('rt', $kartuKeluarga->rt)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" name="rw" placeholder="Isikan" value="<?php echo e(old('rw', $kartuKeluarga->rw)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Desa/Kelurahan</label>
                        <input type="text" name="kelurahan" placeholder="Isikan" value="<?php echo e(old('kelurahan', $kartuKeluarga->kelurahan)); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan" placeholder="Isikan" value="<?php echo e(old('kecamatan', $kartuKeluarga->kecamatan)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" placeholder="Isikan" value="<?php echo e(old('kabupaten', $kartuKeluarga->kabupaten)); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="provinsi" placeholder="Isikan" value="<?php echo e(old('provinsi', $kartuKeluarga->provinsi)); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Tanggal Kartu Dikeluarkan</label>
                    <input type="date" name="tanggal_dikeluarkan" value="<?php echo e(old('tanggal_dikeluarkan', $kartuKeluarga->tanggal_dikeluarkan)); ?>" required>
                </div>
            </div>
            <div id="members-container"></div>
            <div class="form-actions">
                <button type="button" class="btn-add-member" onclick="addMember()">
                    + Tambah Anggota Keluarga
                </button>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-confirm" onclick="showConfirmationModalEdit(event)">
                    ✏️ Ubah
                </button>
                <button type="button" class="btn-cancel" onclick="showDeleteConfirmationModal(event)" style="background-color: #d32f2f;">
                    🗑️ Hapus
                </button>
                <a href="/dashboard" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; background-color: #666;">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Modal Konfirmasi Ubah -->
    <div class="modal-confirmation" id="confirmationModalEdit">
        <div class="modal-confirmation-content">
            <h2 class="modal-confirmation-title">Peringatan!</h2>
            <p class="modal-confirmation-message">
                Apakah anda sudah yakin dengan data yang anda masukkan? Harap cek dengan seksama!
            </p>
            <div class="modal-confirmation-buttons">
                <button type="button" class="btn-tidak" onclick="closeConfirmationModalEdit()">Tidak</button>
                <button type="button" class="btn-yakin" onclick="confirmSubmitEdit()">Yakin</button>
            </div>
        </div>
    </div>
    <div class="modal-confirmation" id="confirmationModalDelete">
        <div class="modal-confirmation-content">
            <h2 class="modal-confirmation-title">Peringatan!</h2>
            <p class="modal-confirmation-message">
                Apakah Anda yakin ingin menghapus Data Keluarga ini? Data yang dihapus tidak dapat dikembalikan!
            </p>
            <div class="modal-confirmation-buttons">
                <button type="button" class="btn-tidak" onclick="closeConfirmationModalDelete()">Tidak</button>
                <button type="button" class="btn-yakin" onclick="confirmDelete()" style="background-color: #d32f2f;">Hapus</button>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/form.js')); ?>"></script>
    <script>
        let kartuKeluargaId = <?php echo e($kartuKeluarga->no_kk); ?>;
        let anggotaKeluargaData = <?php echo json_encode($kartuKeluarga->anggota, 15, 512) ?>;
        document.addEventListener('DOMContentLoaded', function() {
            if (anggotaKeluargaData && anggotaKeluargaData.length > 0) {
                anggotaKeluargaData.forEach((anggota, index) => {
                    loadExistingMember(anggota, index);
                });
            }
        });

        function loadExistingMember(anggota, index) {
            const membersContainer = document.getElementById('members-container');
            const memberCard = document.createElement('div');
            memberCard.className = 'member-card';
            memberCard.id = 'member-' + index;
            
            memberCard.innerHTML = `
                <div class="member-header">
                    <h3 class="member-title">Anggota Keluarga ${index + 1}</h3>
                    <button type="button" class="close-btn" onclick="removeMember(${index})">✕</button>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="anggota[${index}][nama_lengkap]" placeholder="Isikan" value="${anggota.nama_lengkap || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Induk Kependudukan</label>
                        <input type="text" name="anggota[${index}][nik]" placeholder="Isikan" value="${anggota.nik || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <input type="text" name="anggota[${index}][jenis_kelamin]" placeholder="Isikan" value="${anggota.jenis_kelamin || ''}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="anggota[${index}][tempat_lahir]" placeholder="Isikan" value="${anggota.tempat_lahir || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="anggota[${index}][tanggal_lahir]" value="${anggota.tanggal_lahir || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <input type="text" name="anggota[${index}][agama]" placeholder="Isikan" value="${anggota.agama || ''}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Pendidikan</label>
                        <input type="text" name="anggota[${index}][pendidikan]" placeholder="Isikan" value="${anggota.pendidikan || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pekerjaan</label>
                        <input type="text" name="anggota[${index}][pekerjaan]" placeholder="Isikan" value="${anggota.pekerjaan || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Golongan Darah</label>
                        <input type="text" name="anggota[${index}][golongan_darah]" placeholder="Isikan" value="${anggota.golongan_darah || ''}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <input type="text" name="anggota[${index}][status_perkawinan]" placeholder="Isikan" value="${anggota.status_perkawinan || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Perkawinan</label>
                        <input type="date" name="anggota[${index}][tanggal_perkawinan]" value="${anggota.tanggal_perkawinan || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Status Hubungan Dalam Keluarga</label>
                        <input type="text" name="anggota[${index}][status_hubungan]" placeholder="Isikan" value="${anggota.status_hubungan || ''}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Kewarganegaraan</label>
                        <input type="text" name="anggota[${index}][kewarganegaraan]" placeholder="Isikan" value="${anggota.kewarganegaraan || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>No. pasport</label>
                        <input type="text" name="anggota[${index}][no_pasport]" placeholder="Isikan" value="${anggota.no_pasport || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>No. KITAP</label>
                        <input type="text" name="anggota[${index}][no_kitap]" placeholder="Isikan" value="${anggota.no_kitap || ''}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Ayah</label>
                        <input type="text" name="anggota[${index}][nama_ayah]" placeholder="Isikan" value="${anggota.nama_ayah || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Ibu</label>
                        <input type="text" name="anggota[${index}][nama_ibu]" placeholder="Isikan" value="${anggota.nama_ibu || ''}" required>
                    </div>
                </div>
            `;
            
            membersContainer.appendChild(memberCard);
        }

        function showConfirmationModalEdit(e) {
            e.preventDefault();
            document.getElementById('confirmationModalEdit').style.display = 'flex';
        }

        function closeConfirmationModalEdit() {
            document.getElementById('confirmationModalEdit').style.display = 'none';
        }

        function confirmSubmitEdit() {
            closeConfirmationModalEdit();
            document.getElementById('formKeluarga').submit();
        }

        function showDeleteConfirmationModal(e) {
            e.preventDefault();
            document.getElementById('confirmationModalDelete').style.display = 'flex';
        }

        function closeConfirmationModalDelete() {
            document.getElementById('confirmationModalDelete').style.display = 'none';
        }

        function confirmDelete() {
            closeConfirmationModalDelete();
            // Create a hidden form for DELETE request
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = `/kartu-keluarga/${kartuKeluargaId}`;
            deleteForm.innerHTML = `
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            `;
            document.body.appendChild(deleteForm);
            deleteForm.submit();
        }

        // Override removeMember to handle existing members
        function removeMember(index) {
            const memberCard = document.getElementById('member-' + index);
            if (memberCard) {
                memberCard.remove();
            }
        }

        // Override addMember to continue from existing members count
        let memberCount = anggotaKeluargaData ? anggotaKeluargaData.length : 0;
    </script>
</body>
</html><?php /**PATH C:\Users\LENOVO\Documents\GitHub\projek\Ekstraksi_KK_MAIN\resources\views/keluarga/edit.blade.php ENDPATH**/ ?>