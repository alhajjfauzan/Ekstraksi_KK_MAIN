<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Data Keluarga</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form_edit.css') }}">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <a href="/dashboard" class="back-link">◀ Kembali</a>
            <h1 class="form-title">PENGISIAN DATA KELUARGA</h1>
        </div>
        <form action="{{ route('kartu-keluarga.update', $kartuKeluarga->no_kk) }}" method="POST" id="formKeluarga">
            @csrf
            @method('PUT')
            <div class="form-section">
                <h2 class="section-title">Data Kepala Keluarga</h2>
                
                <div class="form-group">
                    <label>No Kartu Keluarga</label>
                    <input type="text" name="no_kk" placeholder="Isikan" value="{{ old('no_kk', $kartuKeluarga->no_kk) }}" required readonly>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>RT</label>
                        <input type="text" name="rt" placeholder="Isikan" value="{{ old('rt', $kartuKeluarga->rt) }}" required>
                    </div>
                    <div class="form-group">
                        <label>RW</label>
                        <input type="text" name="rw" placeholder="Isikan" value="{{ old('rw', $kartuKeluarga->rw) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Desa/Kelurahan</label>
                        <input type="text" name="kelurahan" placeholder="Isikan" value="{{ old('kelurahan', $kartuKeluarga->kelurahan) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <input type="text" name="kecamatan" placeholder="Isikan" value="{{ old('kecamatan', $kartuKeluarga->kecamatan) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <input type="text" name="kabupaten" placeholder="Isikan" value="{{ old('kabupaten', $kartuKeluarga->kabupaten) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="provinsi" placeholder="Isikan" value="{{ old('provinsi', $kartuKeluarga->provinsi) }}" required>
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Kartu Dikeluarkan</label>
                    <input type="date" name="tanggal_dikeluarkan" value="{{ old('tanggal_dikeluarkan', $kartuKeluarga->tanggal_dikeluarkan) }}" required>
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $kartuKeluarga->kode_pos) }}" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $kartuKeluarga->alamat) }}" required>
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
                <button type="button" class="btn-delete" onclick="confirmDelete()">
                    🗑️ Hapus
                </button>
                <a href="/dashboard" class="btn-cancel" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; background-color: #666;">
                    Batal
                </a>
            </div>
        </form>
        <form id="deleteForm"
         action="{{ route('kartu-keluarga.destroy', $kartuKeluarga->no_kk) }}"
         method="POST" style="display:none;">
         @csrf
         @method('DELETE')
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
            <button type="button" class="btn-yakin" onclick="confirmDelete()">Hapus</button>
        </div>
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
    <script>
    const deleteUrl = "{{ route('kartu-keluarga.destroy', $kartuKeluarga->no_kk) }}";
    const csrfToken = "{{ csrf_token() }}";
        console.log("JS DELETE LOADED");
    let deletedMembers = [];
    anggotaKeluargaData = @json($kartuKeluarga->anggota) || [];  
    memberCount = 0;


   function confirmDelete() {
    const form = document.getElementById('deleteForm');
    if (form) {
        form.submit();
    } else {
        console.error('Delete form not found');
    }
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
                </div>
                <div class="form-group">
                    <label>Nomor Induk Kependudukan</label>
                    <input type="text"
    name="anggota[${memberCount}][nik]"
    placeholder="Isikan"
    value="${nik}"
    ${isExisting ? 'readonly' : ''}
    required>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="anggota[${memberCount}][jenis_kelamin]" required readonly>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" ${jenisKelamin === 'Laki-laki' ? 'selected' : ''}>Laki-laki</option>
                        <option value="Perempuan" ${jenisKelamin === 'Perempuan' ? 'selected' : ''}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="anggota[${memberCount}][tempat_lahir]" placeholder="Isikan" value="${tempatLahir}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date"
    name="anggota[${memberCount}][tanggal_lahir]"
    value="${tanggalLahir}"
    ${isExisting ? 'readonly' : ''}
    required>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <select name="anggota[${memberCount}][agama]" required>
                        <option value="">Pilih Agama</option>
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
                        <option value="">Pilih Golongan Darah</option>
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
                    <select name="anggota[${memberCount}][status_perkawinan]" required readonly>
                        <option value="">Pilih Status</option>
                        <option value="Belum Kawin" ${statusPerkawinan === 'Belum Kawin' ? 'selected' : ''}>Belum Kawin</option>
                        <option value="Kawin" ${statusPerkawinan === 'Kawin' ? 'selected' : ''}>Kawin</option>
                        <option value="Cerai Hidup" ${statusPerkawinan === 'Cerai Hidup' ? 'selected' : ''}>Cerai Hidup</option>
                        <option value="Cerai Mati" ${statusPerkawinan === 'Cerai Mati' ? 'selected' : ''}>Cerai Mati</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Perkawinan</label>
                    <input type="date" name="anggota[${memberCount}][tanggal_perkawinan]" value="${tanggalPerkawinan}">
                </div>
                <div class="form-group">
                    <label>Status Hubungan Dalam Keluarga</label>
                    <select name="anggota[${memberCount}][status_hubungan]" required>
                        <option value="">Pilih Status</option>
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
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <input type="text" name="anggota[${memberCount}][kewarganegaraan]" placeholder="Isikan" value="${kewarganegaraan}" required>
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
                </div>
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <input type="text" name="anggota[${memberCount}][nama_ibu]" placeholder="Isikan" value="${namaIbu}" required>
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

    function confirmSubmit() {
        const noKKInput = document.getElementById('no_kk');
        const noKKError = document.getElementById('no_kk_error');

        if (!/^\d+$/.test(noKKInput.value)) {
            noKKError.style.display = 'block';
            noKKInput.focus();
            return; // Hentikan submit
        } else {
            noKKError.style.display = 'none';
        }

        const form = document.getElementById('formKeluarga');
        if (form) form.submit();
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('confirmationModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeConfirmationModal();
                }
            });
        }

        // Jika belum ada anggota (untuk halaman tambah baru), tambah anggota pertama kosong
        if (!anggotaKeluargaData || anggotaKeluargaData.length === 0) {
            addMember(); // Tambah anggota pertama kosong
        }
    });
</script>
<!-- <script src="{{ asset('js/form.js') }}"></script> -->
</body>
</html>