<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Data Keluarga</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form_edit.css')); ?>">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <a href="/dashboard" class="back-link">◀ Kembali</a>
            <h1 class="form-title">PENGISIAN DATA KELUARGA</h1>
        </div>
        <form action="<?php echo e(route('kartu-keluarga.update', $kartuKeluarga->no_kk)); ?>" method="POST" id="formKeluarga">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-section">
                <h2 class="section-title">Data Kepala Keluarga</h2>
                
                <div class="form-group">
                    <label>No Kartu Keluarga</label>
                    <input type="text" name="no_kk" placeholder="Isikan" value="<?php echo e(old('no_kk', $kartuKeluarga->no_kk)); ?>" required readonly>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" maxlength = "3" name="rt" placeholder="Isikan" value="<?php echo e(old('rt', $kartuKeluarga->rt)); ?>" class ="only_number" required>
                        <div class="input-error" style="color:red; display:none;">RT harus diisi.</div>
                    </div>
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" maxlength = "3" name="rw" placeholder="Isikan" value="<?php echo e(old('rw', $kartuKeluarga->rw)); ?>" class ="only_number" required>
                        <div class="input-error" style="color:red; display:none;">RW harus diisi.</div>
                    </div>
                    <div class="form-group">
                        <label>Desa/Kelurahan</label>
                        <input type="text" name="kelurahan" placeholder="Isikan" value="<?php echo e(old('kelurahan', $kartuKeluarga->kelurahan)); ?>" required>
                        <div class="input-error" style="color:red; display:none;">Desa harus diisi.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan" placeholder="Isikan" value="<?php echo e(old('kecamatan', $kartuKeluarga->kecamatan)); ?>" required>
                        <div class="input-error" style="color:red; display:none;">Kecamatan harus diisi.</div>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" placeholder="Isikan" value="<?php echo e(old('kabupaten', $kartuKeluarga->kabupaten)); ?>" required>
                        <div class="input-error" style="color:red; display:none;">Kabupaten harus diisi.</div>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="provinsi" placeholder="Isikan" value="<?php echo e(old('provinsi', $kartuKeluarga->provinsi)); ?>" required>
                        <div class="input-error" style="color:red; display:none;">Provinsi harus diisi.</div>
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Kartu Dikeluarkan</label>
                    <input type="date" name="tanggal_dikeluarkan" value="<?php echo e(old('tanggal_dikeluarkan', $kartuKeluarga->tanggal_dikeluarkan)); ?>" required readonly>
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" maxlength = "5" name="kode_pos" value="<?php echo e(old('kode_pos', $kartuKeluarga->kode_pos)); ?>"class ="only_number" required>
                    <div class="input-error" style="color:red; display:none;">Kode Pos harus diisi.</div>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="<?php echo e(old('alamat', $kartuKeluarga->alamat)); ?>" required>
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
                <button type="button" class="btn-confirm" onclick="confirmSubmitEdit()">
                    ✏️ Ubah 
                </button>
              <button type="button" class="btn-delete" onclick="openDeleteModal()">
                🗑️ Hapus
            </button>
                <a href="/dashboard" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; background-color: #666;">
                    Batal
                </a>
            </div>
        </form>
        <form id="deleteForm"
         action="<?php echo e(route('kartu-keluarga.destroy', $kartuKeluarga->no_kk)); ?>"
         method="POST" style="display:none;">
         <?php echo csrf_field(); ?>
         <?php echo method_field('DELETE'); ?>
        </form>
    </div>
       <div class="modal-confirmation" id="deleteModal">
    <div class="modal-confirmation-content">
        <h3 class="modal-confirmation-title">Hapus Data?</h3>
        <p class="modal-confirmation-message">
            Data Kartu Keluarga akan dihapus permanen.
        </p>

        <div class="modal-confirmation-buttons">
            <button type="button" class="btn-tidak" onclick="closeDeleteModal()">Tidak</button>
            <button type="button" class="btn-yakin" onclick="submitDelete()">Ya, Hapus</button>
        </div>
    </div>
</div>
    </div>
    <script>
    const REQUIRED_FIELDS = {
    rt: 'RT harus diisi.',
    rw: 'RW harus diisi.',
    kelurahan: 'Desa/Kelurahan harus diisi.',
    kecamatan: 'Kecamatan harus diisi.',
    kabupaten: 'Kabupaten harus diisi.',
    provinsi: 'Provinsi harus diisi.',
    kode_pos: 'Kode Pos harus diisi.',
    alamat: 'Alamat harus diisi.',
    tanggal_dikeluarkan: 'Tanggal kartu dikeluarkan harus diisi.'
};
    const deleteUrl = "<?php echo e(route('kartu-keluarga.destroy', $kartuKeluarga->no_kk)); ?>";
    const csrfToken = "<?php echo e(csrf_token()); ?>";
        console.log("JS DELETE LOADED");
    let deletedMembers = [];
    anggotaKeluargaData = <?php echo json_encode($kartuKeluarga->anggota, 15, 512) ?> || [];  
    memberCount = 0;
//    function confirmDelete() {
//     const form = document.getElementById('deleteForm');
//     if (form) {
//         form.submit();
//     } else {
//         console.error('Delete form not found');
//     }
// }
    function openDeleteModal() {
    document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    function submitDelete() {
        document.getElementById('deleteForm').submit();
    }


    function removeMember(memberId) {
    const memberCard = document.querySelector(`[data-member-id="${memberId}"]`);
    if (!memberCard) return;

    const nikInput = memberCard.querySelector('input[name*="[nik]"]');
    const nik = nikInput?.value;

    if (nik) {
        deletedMembers.push(nik); 
    }
    memberCard.remove();
}

function confirmSubmitEdit() {
    let valid = true;

    if (!validateAllFields()) valid = false;
    if (!validateKepalaKeluargaRealtime()) valid = false;
    if (!valid) return;

    const form = document.getElementById('formKeluarga');

    deletedMembers.forEach(nik => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'deleted_members[]';
        input.value = nik;
        form.appendChild(input);
    });

    form.submit();
}

    function flattenAnggota(anggota) {
    return {
        nik: anggota.nik || '',
        nama_lengkap: anggota.nama_lengkap || '',

        jenis_kelamin: anggota.jenis_kelamin === 'LAKI-LAKI'
            ? 'Laki-laki'
            : anggota.jenis_kelamin === 'PEREMPUAN'
                ? 'Perempuan'
                : '',

        tempat_lahir: anggota.data_kelahiran?.tempat_lahir || '',
        tanggal_lahir: anggota.data_kelahiran?.tanggal_lahir || '',
        nama_ayah: anggota.data_kelahiran?.nama_ayah || '',
        nama_ibu: anggota.data_kelahiran?.nama_ibu || '',

        pekerjaan: anggota.data_status?.pekerjaan || '',
        golongan_darah: anggota.data_status?.golongan_darah || '',

        status_perkawinan: anggota.data_status?.status_perkawinan
    ? toTitleCase(
        anggota.data_status.status_perkawinan.replace(/_/g, ' ')
      )
    : '',

        kewarganegaraan: anggota.data_status?.kewarganegaraan || '',

        agama: toTitleCase(anggota.agama?.nama),
        pendidikan: anggota.pendidikan?.nama || '',

        no_paspor: anggota.data_dokumen?.no_paspor ?? null, 
        no_kitap: anggota.data_dokumen?.no_kitap ?? null,

        tanggal_perkawinan: anggota.tanggal_perkawinan || '',
        status_hubungan: anggota.status_hubungan
    ? toTitleCase(
        anggota.status_hubungan.replace(/_/g, ' ')
      )
    : '',
    };
}
    if (anggotaKeluargaData && anggotaKeluargaData.length > 0) {
        anggotaKeluargaData.forEach((anggota) => addMember(flattenAnggota(anggota)));
    }

    function toTitleCase(str) {
    if (!str) return '';
    return str
        .toLowerCase()
        .replace(/\b\w/g, char => char.toUpperCase());
}

    function addMember(anggota = {}) {
        memberCount++;
        const namaLengkap = anggota.nama_lengkap || '';
        const nik = anggota.nik || '';
        const isExisting = nik !== '';
        const jenisKelamin = anggota.jenis_kelamin || '';
        const tempatLahir = anggota.tempat_lahir || '';
        const tanggalLahir = anggota.tanggal_lahir || '';
        const agama = anggota.agama || '';
        const pendidikan = anggota.pendidikan || '';
        const pekerjaan = anggota.pekerjaan || '';
        const golonganDarah = anggota.golongan_darah || '';
        const statusPerkawinan = anggota.status_perkawinan || '';
        const tanggalPerkawinan = anggota.tanggal_perkawinan || '';
        const statusHubungan = anggota.status_hubungan || '';
        const kewarganegaraan = anggota.kewarganegaraan || '';
        const noPaspor = anggota.no_paspor || '';
        const noKitap = anggota.no_kitap || '';
        const namaAyah = anggota.nama_ayah || '';
        const namaIbu = anggota.nama_ibu || '';

        const memberHTML = `
        <div class="member-card" data-member-id="${memberCount}">
            <div class="member-header">
                <h3 class="member-title">Anggota Keluarga ${memberCount}</h3>
                <button type="button" class="member-close" onclick="removeMember(${memberCount})">×</button>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="anggota[${memberCount}][nama_lengkap]" placeholder="Isikan" value="${namaLengkap}" required>
                    <div class="input-error" style="color:red; display:none;">Nama Lengkap harus diisi.</div>
                </div>
                <div class="form-group">
                    <label>Nomor Induk Kependudukan</label>
                    <input type="text" name="anggota[${memberCount}][nik]" placeholder="Isikan" value="${nik}" ${isExisting ? 'readonly' : ''} required>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select disabled>
                    <option value="Laki-laki" selected>Laki-laki</option>
                    </select>
                    <input type="hidden"
                    name="anggota[${memberCount}][jenis_kelamin]"
                    value="${jenisKelamin}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="anggota[${memberCount}][tempat_lahir]" placeholder="Isikan" value="${tempatLahir}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="anggota[${memberCount}][tanggal_lahir]" value="${tanggalLahir}" ${isExisting ? 'readonly' : ''} required>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <select name="anggota[${memberCount}][agama]" required>
                        <option value="Islam" ${agama === 'Islam' ? 'selected' : ''}>Islam</option>
                        <option value="Kristen" ${agama === 'Kristen' ? 'selected' : ''}>Kristen</option>
                        <option value="Katolik" ${agama === 'Katolik' ? 'selected' : ''}>Katolik</option>
                        <option value="Hindu" ${agama === 'Hindu' ? 'selected' : ''}>Hindu</option>
                        <option value="Buddha" ${agama === 'Buddha' ? 'selected' : ''}>Buddha</option>
                        <option value="Konghucu" ${agama === 'Konghucu' ? 'selected' : ''}>Konghucu</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Pendidikan</label>
                    <input type="text" name="anggota[${memberCount}][pendidikan]" placeholder="Isikan" value="${pendidikan}" required>
                </div>
                <div class="form-group">
                    <label>Jenis Pekerjaan</label>
                    <input type="text" name="anggota[${memberCount}][pekerjaan]" placeholder="Isikan" value="${pekerjaan}" required>
                </div>
                <div class="form-group">
                    <label>Golongan Darah</label>
                    <select name="anggota[${memberCount}][golongan_darah]" required>
                        <option value="A" ${golonganDarah === 'A' ? 'selected' : ''}>A</option>
                        <option value="B" ${golonganDarah === 'B' ? 'selected' : ''}>B</option>
                        <option value="AB" ${golonganDarah === 'AB' ? 'selected' : ''}>AB</option>
                        <option value="O" ${golonganDarah === 'O' ? 'selected' : ''}>O</option>
                        <option value="TIDAK TAHU" ${golonganDarah === 'TIDAK TAHU' ? 'selected' : ''}>TIDAK TAHU</option>

                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Status Perkawinan</label>
                    <select name="anggota[${memberCount}][status_perkawinan]" required>
                        <option value="Belum Kawin" ${statusPerkawinan === 'Belum Kawin' ? 'selected' : ''}>Belum Kawin</option>
                        <option value="Kawin" ${statusPerkawinan === 'Kawin' ? 'selected' : ''}>Kawin</option>
                        <option value="Cerai Hidup" ${statusPerkawinan === 'Cerai Hidup' ? 'selected' : ''}>Cerai Hidup</option>
                        <option value="Cerai Mati" ${statusPerkawinan === 'Cerai Mati' ? 'selected' : ''}>Cerai Mati</option>
                    </select>
                    <div class="input-error" style="color:red; display:none;">Status Perkawinan harus diisi.</div>
                </div>
                <div class="form-group">
                    <label>Tanggal Perkawinan</label>
                    <input type="date" name="anggota[${memberCount}][tanggal_perkawinan]" value="${tanggalPerkawinan}">
                </div>
                <div class="form-group">
                    <label>Status Hubungan Dalam Keluarga</label>
                    <select name="anggota[${memberCount}][status_hubungan]" required>
                        <option value="Kepala Keluarga" ${statusHubungan === 'Kepala Keluarga' ? 'selected' : ''}>Kepala Keluarga</option>
                        <option value="Istri" ${statusHubungan === 'Istri' ? 'selected' : ''}>Istri</option>
                        <option value="Anak" ${statusHubungan === 'Anak' ? 'selected' : ''}>Anak</option>
                        <option value="Menantu" ${statusHubungan === 'Menantu' ? 'selected' : ''}>Menantu</option>
                        <option value="Cucu" ${statusHubungan === 'Cucu' ? 'selected' : ''}>Cucu</option>
                        <option value="Orang Tua" ${statusHubungan === 'Orang Tua' ? 'selected' : ''}>Orang Tua</option>
                        <option value="Mertua" ${statusHubungan === 'Mertua' ? 'selected' : ''}>Mertua</option>
                        <option value="Saudara" ${statusHubungan === 'Saudara' ? 'selected' : ''}>Saudara</option>
                        <option value="Lainnya" ${statusHubungan === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                    </select>
                    <div class="input-error" style="color:red; display:none;">Status Hubungan harus diisi.</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <select disabled>
                <option value="WNI" ${kewarganegaraan === 'WNI' ? 'selected' : ''}>WNI</option>
                <option value="WNA" ${kewarganegaraan === 'WNA' ? 'selected' : ''}>WNA</option>
            </select>

            <input type="hidden"
                name="anggota[${memberCount}][kewarganegaraan]"
                value="${kewarganegaraan}">
                </div>
                <div class="form-group">
                    <label>No. Pasport</label>
                    <input type="text" name="anggota[${memberCount}][no_paspor]" placeholder="Isikan" value="${noPaspor}">
                </div>
                <div class="form-group">
                    <label>No. KITAP</label>
                    <input type="text" name="anggota[${memberCount}][no_kitap]" placeholder="Isikan" value="${noKitap}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <input type="text" name="anggota[${memberCount}][nama_ayah]" placeholder="Isikan" value="${namaAyah}" required>
                    <div class="input-error" style="color:red; display:none;">Nama Ayah harus diisi.</div>
                </div>
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text" name="anggota[${memberCount}][nama_ibu]" placeholder="Isikan" value="${namaIbu}" required>
                    <div class="input-error" style="color:red; display:none;">Nama Ibu harus diisi.</div>
                </div>
            </div>
        </div>
        `;
        
        document.getElementById('members-container').insertAdjacentHTML('beforeend', memberHTML);
    }

    function showConfirmationModal(event) {
        event.preventDefault();
        const modal = document.getElementById('confirmationModal');
        if (modal) {
            modal.classList.add('active');
        }
    }

    function closeConfirmationModal() {
        const modal = document.getElementById('confirmationModal');
        if (modal) {
            modal.classList.remove('active');
        }
    }


    function showError(input, message) {
    const formGroup = input.closest('.form-group');
    if (!formGroup) return;

    let error = formGroup.querySelector('.input-error');
    if (!error) {
        error = document.createElement('div');
        error.className = 'input-error';
        error.style.color = 'red';
        error.style.fontSize = '0.9em';
        formGroup.appendChild(error);
    }

    error.textContent = message;
    error.style.display = 'block';
}

function validateAllFields() {
    let valid = true;

    Object.entries(REQUIRED_FIELDS).forEach(([name, message]) => {
        const input = document.querySelector(`[name="${name}"]`);
        if (!input) return;

        if (input.value.trim() === '') {
            showError(input, message);
            valid = false;
        } else {
            hideError(input);
        }
    });

    return valid;
}


function hideError(input) {
    const formGroup = input.closest('.form-group');
    if (!formGroup) return;

    const error = formGroup.querySelector('.input-error');
    if (error) error.style.display = 'none';
}

function validateKodePos() {
    const input = document.querySelector('input[name="kode_pos"]');
    if (!input) return true;

    if (input.value.trim() === '') {
        showError(input, 'Kode Pos harus diisi.');
        return false;
    }

    hideError(input);
    return true;
}

function validateKepalaKeluargaRealtime() {
    const selects = document.querySelectorAll(
        'select[name$="[status_hubungan]"]'
    );

    let kepalaSelects = [];

    selects.forEach(select => {
        const errorEl = select
            .closest('.form-group')
            .querySelector('.input-error');

        if (errorEl) errorEl.style.display = 'none';

        if (select.value === 'Kepala Keluarga') {
            kepalaSelects.push(select);
        }
    });
    if (kepalaSelects.length === 0) {
        selects.forEach(select => {
            showError(select, 'Harus ada 1 Kepala Keluarga.');
        });
        return false;
    }
    if (kepalaSelects.length > 1) {
        kepalaSelects.forEach((select, index) => {
            if (index > 0) {
                showError(select, 'Kepala Keluarga hanya boleh satu.');
            }
        });
        return false;
    }
    return true;
}
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('confirmationModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeConfirmationModal();
                }
            });
        }
        if (!anggotaKeluargaData || anggotaKeluargaData.length === 0) {
            addMember();
        }
    });

    document.querySelectorAll('.only_number').forEach(input => {
    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    })
});
 document.addEventListener('change', function (e) {
    if (e.target.name && e.target.name.endsWith('[status_hubungan]')) {
        validateKepalaKeluargaRealtime();
    }
});

Object.keys(REQUIRED_FIELDS).forEach(name => {
    const input = document.querySelector(`[name="${name}"]`);
    if (!input) return;

    const eventType = input.type === 'date' ? 'change' : 'input';

    input.addEventListener(eventType, () => {
        if (input.value.trim() !== '') {
            hideError(input);
        }
    });
});

</script>
<!-- <script src="<?php echo e(asset('js/form.js')); ?>"></script> -->
</body>
</html><?php /**PATH C:\Users\LENOVO\Documents\GitHub\baru\Ekstraksi_KK_MAIN\resources\views/keluarga/edit.blade.php ENDPATH**/ ?>