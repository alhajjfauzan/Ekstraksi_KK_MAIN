// Form Data Keluarga Script

let memberCount = 0;

let anggotaKeluargaData = []; 

function addMember(anggota = {}) {
    memberCount++;
    const namaLengkap = anggota.nama_lengkap || '';
    const nik = anggota.nik || '';
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
                <input type="text" class="nik-input" name="anggota[${memberCount}][nik]" placeholder="Isikan" value="${nik}" required>
                <div class="nik-error" style="color:red; display:none;">NIK harus 16 digit angka.</div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="anggota[${memberCount}][jenis_kelamin]" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" ${jenisKelamin === 'Laki-laki' ? 'selected' : ''}>Laki-laki</option>
                    <option value="Perempuan" ${jenisKelamin === 'Perempuan' ? 'selected' : ''}>Perempuan</option>
                </select>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="anggota[${memberCount}][tempat_lahir]" placeholder="Isikan" value="${tempatLahir}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="anggota[${memberCount}][tanggal_lahir]" value="${tanggalLahir}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
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
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pendidikan</label>
                <input type="text" name="anggota[${memberCount}][pendidikan]" placeholder="Isikan" value="${pendidikan}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>Jenis Pekerjaan</label>
                <input type="text" name="anggota[${memberCount}][pekerjaan]" placeholder="Isikan" value="${pekerjaan}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
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
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Status Perkawinan</label>
                <select name="anggota[${memberCount}][status_perkawinan]" required>
                    <option value="">Pilih Status</option>
                    <option value="Belum Kawin" ${statusPerkawinan === 'Belum Kawin' ? 'selected' : ''}>Belum Kawin</option>
                    <option value="Kawin" ${statusPerkawinan === 'Kawin' ? 'selected' : ''}>Kawin</option>
                    <option value="Cerai Hidup" ${statusPerkawinan === 'Cerai Hidup' ? 'selected' : ''}>Cerai Hidup</option>
                    <option value="Cerai Mati" ${statusPerkawinan === 'Cerai Mati' ? 'selected' : ''}>Cerai Mati</option>
                </select>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>Tanggal Perkawinan</label>
                <input type="date" name="anggota[${memberCount}][tanggal_perkawinan]" value="${tanggalPerkawinan}">
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
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
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Kewarganegaraan</label>
                <input type="text" name="anggota[${memberCount}][kewarganegaraan]" placeholder="Isikan" value="${kewarganegaraan}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>No. Paspor</label>
                <input type="text" name="anggota[${memberCount}][no_paspor]" placeholder="Isikan" value="${noPaspor}">
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>No. KITAP</label>
                <input type="text" name="anggota[${memberCount}][no_kitap]" placeholder="Isikan" value="${noKitap}">
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Nama Ayah</label>
                <input type="text" name="anggota[${memberCount}][nama_ayah]" placeholder="Isikan" value="${namaAyah}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>Nama Ibu</label>
                <input type="text" name="anggota[${memberCount}][nama_ibu]" placeholder="Isikan" value="${namaIbu}" required>
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
        </div>
    </div>
    `;
    
    document.getElementById('members-container').insertAdjacentHTML('beforeend', memberHTML);
   const newMemberCard = document.querySelector(`[data-member-id="${memberCount}"]`);
   const newNikInput = newMemberCard.querySelector('.nik-input');
   const nikError = newMemberCard.querySelector('.nik-error');

    newNikInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 0 && this.value.length !== 16) {
            nikError.style.display = 'block';
            nikError.textContent = "NIK harus 16 digit angka.";
        } else {
            nikError.style.display = 'none';
        }
    });
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

function fillFormWithAIData(aiData) {
    if (!aiData) return;

    try {
        if (aiData.no_kk || aiData.noKK || aiData['No. KK']) {
            document.getElementById('no_kk').value = aiData.no_kk || aiData.noKK || aiData['No. KK'] || '';
        }
        
        if (aiData.rt || aiData.RT) {
            document.querySelector('input[name="rt"]').value = aiData.rt || aiData.RT || '';
        }
        
        if (aiData.rw || aiData.RW) {
            document.querySelector('input[name="rw"]').value = aiData.rw || aiData.RW || '';
        }
        
        if (aiData.kelurahan || aiData.Kelurahan) {
            document.querySelector('input[name="kelurahan"]').value = aiData.kelurahan || aiData.Kelurahan || '';
        }
        
        if (aiData.kecamatan || aiData.Kecamatan) {
            document.querySelector('input[name="kecamatan"]').value = aiData.kecamatan || aiData.Kecamatan || '';
        }
        
        if (aiData.kabupaten || aiData.Kabupaten) {
            document.querySelector('input[name="kabupaten"]').value = aiData.kabupaten || aiData.Kabupaten || '';
        }
        
        if (aiData.provinsi || aiData.Provinsi) {
            document.querySelector('input[name="provinsi"]').value = aiData.provinsi || aiData.Provinsi || '';
        }
        
        if (aiData.tanggal_dikeluarkan || aiData.tanggalDikeluarkan) {
            const date = aiData.tanggal_dikeluarkan || aiData.tanggalDikeluarkan;
            if (date) {
                const dateObj = new Date(date);
                if (!isNaN(dateObj.getTime())) {
                    document.querySelector('input[name="tanggal_dikeluarkan"]').value = dateObj.toISOString().split('T')[0];
                }
            }
        }
        let anggotaArray = [];
        if (Array.isArray(aiData.anggota)) {
            anggotaArray = aiData.anggota;
        } else if (Array.isArray(aiData.members)) {
            anggotaArray = aiData.members;
        } else if (Array.isArray(aiData.data)) {
            anggotaArray = aiData.data;
        } else if (typeof aiData === 'object' && aiData.text) {
            console.warn('AI returned text format, parsing may be needed');
        }
        document.getElementById('members-container').innerHTML = '';
        memberCount = 0;

        anggotaArray.forEach((anggota, index) => {
            addMember();
            const memberIndex = memberCount;
            const fillField = (name, value) => {
                const input = document.querySelector(`input[name="anggota[${memberIndex}][${name}]"]`);
                if (input && value) input.value = value;
            };
            
            const fillSelect = (name, value) => {
                const select = document.querySelector(`select[name="anggota[${memberIndex}][${name}]"]`);
                if (select && value) {
                    Array.from(select.options).forEach(option => {
                        if (option.value.toLowerCase() === value.toLowerCase()) {
                            select.value = option.value;
                        }
                    });
                }
            };
            fillField('nama_lengkap', anggota.nama_lengkap || anggota.nama || anggota.name || anggota['Nama Lengkap']);
            fillField('nik', anggota.nik || anggota.NIK || anggota['Nomor Induk Kependudukan']);
            fillSelect('jenis_kelamin', anggota.jenis_kelamin || anggota.jenisKelamin || anggota.gender || anggota['Jenis Kelamin']);
            fillField('tempat_lahir', anggota.tempat_lahir || anggota.tempatLahir || anggota['Tempat Lahir']);
            
            if (anggota.tanggal_lahir || anggota.tanggalLahir || anggota['Tanggal Lahir']) {
                const date = anggota.tanggal_lahir || anggota.tanggalLahir || anggota['Tanggal Lahir'];
                const dateObj = new Date(date);
                if (!isNaN(dateObj.getTime())) {
                    fillField('tanggal_lahir', dateObj.toISOString().split('T')[0]);
                }
            }
            
            fillSelect('agama', anggota.agama || anggota['Agama']);
            fillField('pendidikan', anggota.pendidikan || anggota['Pendidikan']);
            fillField('pekerjaan', anggota.pekerjaan || anggota['Pekerjaan']);
            fillSelect('golongan_darah', anggota.golongan_darah || anggota.golonganDarah || anggota['Golongan Darah']);
            fillSelect('status_perkawinan', anggota.status_perkawinan || anggota.statusPerkawinan || anggota['Status Perkawinan']);
            fillSelect('status_hubungan', anggota.status_hubungan || anggota.statusHubungan || anggota['Status Hubungan']);
            fillField('kewarganegaraan', anggota.kewarganegaraan || anggota['Kewarganegaraan'] || 'WNI');
            fillField('no_paspor', anggota.no_paspor || anggota.noPaspor || anggota['No. Paspor']);
            fillField('no_kitap', anggota.no_kitap || anggota.noKitap || anggota['No. KITAP']);
            fillField('nama_ayah', anggota.nama_ayah || anggota.namaAyah || anggota['Nama Ayah']);
            fillField('nama_ibu', anggota.nama_ibu || anggota.namaIbu || anggota['Nama Ibu']);
        });
        if (anggotaArray.length === 0) {
            addMember();
        }

    } catch (error) {
        console.error('Error filling form with AI data:', error);
    }
}


document.getElementById('formKeluarga').addEventListener('submit', function(e) {
    e.preventDefault();
    if (validateForm()) {
        showConfirmationModal(e); 
    } else {
        const firstError = document.querySelector('.input-error[style*="display: block"]');
        if (firstError) {
            const el = firstError.previousElementSibling || firstError;
            el.focus();
            window.scrollTo({ top: firstError.offsetTop - 100, behavior: 'smooth' });
        }
    }
});
function validateForm() {
    let valid = true;
    const form = document.getElementById('formKeluarga');
    const allInputs = form.querySelectorAll('input, select');

    allInputs.forEach(input => {
        hideError(input);
        if (input.hasAttribute('required') && !input.value.trim()) {
            showError(input, `${input.previousElementSibling.textContent} harus diisi.`);
            valid = false;
        }
        if (input.name === 'no_kk' && input.value.length !== 16) {
            showError(input, 'No KK harus 16 digit angka.');
            valid = false;
        }

        if (input.classList.contains('nik-input') && input.value.length !== 16) {
            showError(input, 'NIK harus 16 digit angka.');
            valid = false;
        }

        if (input.name === 'kode_pos' && !/^\d{5}$/.test(input.value)) {
            showError(input, 'Kode Pos harus 5 digit angka.');
            valid = false;
        }
    });

    return valid;
}
function confirmSubmit() {
    const noKKInput = document.getElementById('no_kk');
    const noKKError = document.getElementById('no_kk_error');

    if (!/^\d+$/.test(noKKInput.value)) {
        noKKError.style.display = 'block';
        noKKInput.focus();
        return;
    } else {
        noKKError.style.display = 'none';
    }

    const form = document.getElementById('formKeluarga');
    if (form) form.submit();
}
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmationModal');
    const form = document.getElementById("formKeluarga");
    const noKK = document.getElementById("no_kk");
    const newCard = document.querySelector(`[data-member-id="${memberCount}"]`);
    const noKKError = document.getElementById("no_kk_error");

     noKK.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');

        if (this.value.length > 0 && this.value.length !== 16) {
            noKKError.style.display = "block";
            noKKError.textContent = "No KK harus 16 digit angka.";
        } else {
            noKKError.style.display = "none";
        }
    });

    const requiredInputs = form.querySelectorAll('input[required], select[required]');
    requiredInputs.forEach(input => {
        let errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = 'red';
        errorDiv.style.display = 'none';
        input.parentNode.appendChild(errorDiv);
        input.addEventListener('input', () => {
            errorDiv.style.display = 'none'; 
        });
    })
    const nikInputs = document.querySelectorAll('input[name^="nik"]');
    nikInputs.forEach((nik) => {
        const nikError = document.createElement("div");
        nikError.style.color = "red";
        nikError.style.display = "none";
        nik.parentNode.appendChild(nikError);

        nik.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 0 && this.value.length !== 16) {
                nikError.style.display = "block";
                nikError.textContent = "NIK harus 16 digit angka.";
            } else {
                nikError.style.display = "none";
            }
        });
    });
     form.addEventListener("submit", function (e) {
        e.preventDefault(); 
        let valid = true;
        const allNikInputs = document.querySelectorAll(".nik-input");
        allNikInputs.forEach((nik) => {
        const errorDiv = nik.nextElementSibling;
        if (nik.value.length !== 16) {
            errorDiv.style.display = "block";
            valid = false;
        } else {
            errorDiv.style.display = "none";
        }
         });
        if (noKK.value.length !== 16) {
            noKKError.style.display = "block";
            noKKError.textContent = "No KK harus 16 digit angka.";
            valid = false;
        }
        const kodePos = document.querySelector('input[name="kode_pos"]');
    if (!/^[0-9]{5}$/.test(kodePos.value)) {
        showError(kodePos, 'Kode Pos harus 5 digit angka.');
    }
    if (!valid) {
        const firstError = document.querySelector('.input-error[style*="display: block"], #no_kk_error[style*="display: block"]');
        if (firstError) {
            const el = firstError.previousElementSibling || firstError;
            el.focus();
            window.scrollTo({ top: firstError.offsetTop - 100, behavior: 'smooth' });
        }
        return;
    }
    const modal = document.getElementById('confirmationModal');
    if (modal) modal.classList.add('active');
        
    });
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeConfirmationModal();
            }
        });
    } if (window.aiExtractedData) {
        fillFormWithAIData(window.aiExtractedData);
    } else if (anggotaKeluargaData && anggotaKeluargaData.length > 0) {
        anggotaKeluargaData.forEach((anggota) => {
            addMember(anggota); 
        });
    } else {
        addMember();
    }
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            showConfirmationModal(e);
        }
    });
});
