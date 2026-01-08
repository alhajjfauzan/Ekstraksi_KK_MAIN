// Form Data Keluarga Script

let memberCount = 0;

function addMember() {
    memberCount++;
    
    const memberHTML = `
    <div class="member-card" data-member-id="${memberCount}">
        <div class="member-header">
            <h3 class="member-title">Anggota Keluarga ${memberCount}</h3>
            <button type="button" class="member-close" onclick="removeMember(${memberCount})">×</button>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="members[${memberCount}][nama_lengkap]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>Nomor Induk Kependudukan</label>
                <input type="text" name="members[${memberCount}][nik]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="members[${memberCount}][jenis_kelamin]" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="members[${memberCount}][tempat_lahir]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="members[${memberCount}][tanggal_lahir]" required>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <select name="members[${memberCount}][agama]" required>
                    <option value="">Pilih Agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pendidikan</label>
                <input type="text" name="members[${memberCount}][pendidikan]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>Jenis Pekerjaan</label>
                <input type="text" name="members[${memberCount}][pekerjaan]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>Golongan Darah</label>
                <select name="members[${memberCount}][golongan_darah]" required>
                    <option value="">Pilih Golongan Darah</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Status Perkawinan</label>
                <select name="members[${memberCount}][status_perkawinan]" required>
                    <option value="">Pilih Status</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Perkawinan</label>
                <input type="date" name="members[${memberCount}][tanggal_perkawinan]">
            </div>
            <div class="form-group">
                <label>Status Hubungan Dalam Keluarga</label>
                <select name="members[${memberCount}][status_hubungan]" required>
                    <option value="">Pilih Status</option>
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak">Anak</option>
                    <option value="Menantu">Menantu</option>
                    <option value="Cucu">Cucu</option>
                    <option value="Orang Tua">Orang Tua</option>
                    <option value="Mertua">Mertua</option>
                    <option value="Saudara">Saudara</option>
                    <option value="Pembantu">Pembantu</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kewarganegaraan</label>
                <input type="text" name="members[${memberCount}][kewarganegaraan]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>No. Pasport</label>
                <input type="text" name="members[${memberCount}][no_pasport]" placeholder="Isikan">
            </div>
            <div class="form-group">
                <label>No. KITAP</label>
                <input type="text" name="members[${memberCount}][no_kitap]" placeholder="Isikan">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nama Ayah</label>
                <input type="text" name="members[${memberCount}][nama_ayah]" placeholder="Isikan" required>
            </div>
            <div class="form-group">
                <label>Nama Ibu</label>
                <input type="text" name="members[${memberCount}][nama_ibu]" placeholder="Isikan" required>
            </div>
        </div>
    </div>
    `;
    
    document.getElementById('members-container').insertAdjacentHTML('beforeend', memberHTML);
}

function removeMember(memberId) {
    const memberCard = document.querySelector(`[data-member-id="${memberId}"]`);
    if (memberCard) {
        memberCard.remove();
    }
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
    closeConfirmationModal();
    const form = document.getElementById('formKeluarga');
    if (form) {
        form.submit();
    }
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

    // Add first member by default
    addMember();
});
