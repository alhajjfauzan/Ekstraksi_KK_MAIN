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
                <input type="text" maxlength="16" class="nik-input" name="anggota[${memberCount}][nik]" placeholder="Isikan" value="${nik}"required>
                <div class="input-error" style="color:red; display:none;"></div>
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
                <input type="text" name="anggota[${memberCount}][pendidikan]" placeholder="Isikan" value="${pendidikan}">
                <div class="input-error" style="color:red; display:none; font-size:0.9em;"></div>
            </div>
            <div class="form-group">
                <label>Jenis Pekerjaan</label>
                <input type="text" name="anggota[${memberCount}][pekerjaan]" placeholder="Isikan" value="${pekerjaan}">
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
                <div id="kepala-keluarga-error" style="color:red; display:none; margin-top:10px; font-size:0.9em;"> Harus ada tepat 1 Kepala Keluarga. </div>
            </div>
        </div>

        <div class="form-row">
           <div class="form-group">
                <label>Kewarganegaraan</label>
                <select name="anggota[${memberCount}][kewarganegaraan]" required>
                    <option value="">Pilih Kewarganegaraan</option>
                    <option value="WNI" ${kewarganegaraan === 'WNI' ? 'selected' : ''}>WNI</option>
                    <option value="WNA" ${kewarganegaraan === 'WNA' ? 'selected' : ''}>WNA</option>
                </select>
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
        this.value = this.value.replace(/\D/g, '').slice(0, 16);

        if (!this.value) {
            hideError(this);
        } else if (this.value.length !== 16) {
            showError(this, 'NIK harus 16 digit angka.');
        } else {
            hideError(this);
            validateDuplicateNikAndKK();
        }
    });

}

function removeMember(memberId) {
    const memberCard = document.querySelector(`[data-member-id="${memberId}"]`);
    if (memberCard) {
        memberCard.remove();
    }
}

// function showConfirmationModal(event) {
//     event.preventDefault();
//     if (!validateForm()) {
//         const firstError = document.querySelector('.input-error[style*="block"]');
//         if (firstError) {
//             const el = firstError.previousElementSibling || firstError;
//             el.focus();
//             window.scrollTo({ top: firstError.offsetTop - 120, behavior: 'smooth' });
//         }
//         return;
//     }

//     const modal = document.getElementById('confirmationModal');
//     modal.classList.add('active');
// }





async function showConfirmationModal(event) {
    event.preventDefault();
    
    if (!validateForm()) {
        // Scroll to first error
        const firstError = document.querySelector('.input-error[style*="block"], #no_kk_error[style*="block"]');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    // Check No KK first
    const noKKValid = await checkNoKKFromDatabase();
    if (!noKKValid) {
        document.getElementById('no_kk_error').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    
    // Check all NIKs
    const nikInputs = document.querySelectorAll('.nik-input');
    for (const input of nikInputs) {
        if (input.value && input.value.length === 16) {
            const nikValid = await checkNikFromDatabase(input);
            if (!nikValid) {
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
        }
    }
    
    // If all checks pass, show modal
    document.getElementById('confirmationModal').classList.add('active');
}

function closeConfirmationModal() {
    const modal = document.getElementById('confirmationModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

function isDuplicateNIK(currentInput) {
    const allNik = document.querySelectorAll('.nik-input');
    let values = [];

    for (let input of allNik) {
        if (!input.value) continue;
        if (values.includes(input.value)) {
            showError(input, 'NIK tidak boleh duplikat.');
            return true;
        }
        values.push(input.value);
    }
    return false;
}

function validateKepalaKeluargaRealtime() {
    const selects = document.querySelectorAll(
        'select[name$="[status_hubungan]"]'
    );
    let kepalaSelects = [];
    let valid = true;
    selects.forEach(select => {
        hideError(select);
        if (!select.value) {
            showError(select, 'Status hubungan wajib diisi.');
            valid = false;
            return;
        }
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

    return valid;
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
        if (aiData.kode_pos || aiData.kodePos || aiData['Kode Pos']) {
            const kodePosInput = document.querySelector('input[name="kode_pos"]');
            if (kodePosInput) {
                kodePosInput.value = aiData.kode_pos || aiData.kodePos || aiData['Kode Pos'] || '';
            }
        }
        if (aiData.alamat || aiData['Alamat']) {
            const alamatInput = document.querySelector('input[name="alamat"]');
            if (alamatInput) {
                alamatInput.value = aiData.alamat || aiData['Alamat'] || '';
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
                if (!value) return;
                const input = document.querySelector(`input[name="anggota[${memberIndex}][${name}]"]`);
                if (input) {
                    if (name === 'nik') {
                            input.value = String(value)
                                .replace(/\D/g, '')
                                .slice(0, 16);
                        } else {
                            input.value = value;
                        }
                    console.log(`Filled field anggota[${memberIndex}][${name}] =`, value);
                } else {
                    console.warn(`Field not found: anggota[${memberIndex}][${name}]`);
                }
            };
            
            const fillSelect = (name, value) => {
                if (!value) return;
                const select = document.querySelector(`select[name="anggota[${memberIndex}][${name}]"]`);
                if (select && value) {
                    let found = false;
                    Array.from(select.options).forEach(option => {
                        const optionValue = option.value.toLowerCase().trim();
                        const optionText = option.text.toLowerCase().trim();
                        const searchValue = String(value).toLowerCase().trim();
                        
                        if (optionValue === searchValue || optionText === searchValue || 
                            optionText.includes(searchValue) || searchValue.includes(optionText)) {
                            select.value = option.value;
                            found = true;
                            console.log(`Filled select anggota[${memberIndex}][${name}] =`, option.value, '(from:', value, ')');
                        }
                    });
                    if (!found) {
                        console.warn(`Select value not found: anggota[${memberIndex}][${name}] =`, value);
                    }
                } else if (!select) {
                    console.warn(`Select not found: anggota[${memberIndex}][${name}]`);
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
            if (anggota.tanggal_perkawinan || anggota.tanggalPerkawinan || anggota['Tanggal Perkawinan']) {
                const date = anggota.tanggal_perkawinan || anggota.tanggalPerkawinan || anggota['Tanggal Perkawinan'];
                const dateObj = new Date(date);
                if (!isNaN(dateObj.getTime())) {
                    fillField('tanggal_perkawinan', dateObj.toISOString().split('T')[0]);
                }
            }
        });
        if (anggotaArray.length === 0) {
            addMember();
        }

    } catch (error) {
        console.error('Error filling form with AI data:', error);
    }
}


function showError(input, message) {
    let error = input.parentElement.querySelector('.input-error');
    if (!error) {
        error = document.createElement('div');
        error.className = 'input-error';
        error.style.color = 'red';
        error.style.fontSize = '0.9em';
        input.parentElement.appendChild(error);
    }
    error.textContent = message;
    error.style.display = 'block';
}


function hideError(input) {
    const error = input.parentElement.querySelector('.input-error');
    if (error) error.style.display = 'none';
}
function clearErrorIfValid(input) {
    if (!input.hasAttribute('required')) return;

    if (input.disabled || input.readOnly) return;

    if (input.value && input.value.trim() !== '') {
        hideError(input);
    }
}
function validateRequiredFields(container) {
    let valid = true;

    container.querySelectorAll('input, select, textarea').forEach(input => {
           console.log(
            'FIELD:', input.name,
            'required:', input.hasAttribute('required'),
            'value:', input.value
        );
        if (!input.hasAttribute('required')) return;
        if (input.disabled || input.readOnly) return;

        hideError(input);

        if (!input.value || !input.value.trim()) {
            const label = input.closest('.form-group')
                ?.querySelector('label')
                ?.textContent
                ?.trim();

            showError(
                input,
                label ? `${label} harus diisi.` : 'Field ini wajib diisi.'
            );
            valid = false;
        }
    });

    return valid;
}

function validateForm() {
    let valid = true;
    const form = document.getElementById('formKeluarga');

    if (!validateRequiredFields(form)) {
        valid = false;
    }

    const inputs = form.querySelectorAll('input, select');

    inputs.forEach(input => {

        if (input.name === 'no_kk' && input.value && input.value.length !== 16) {
            showError(input, 'No KK harus 16 digit angka.');
            valid = false;
        }

        if (input.classList.contains('nik-input')) {
            if (input.value && input.value.length !== 16) {
                showError(input, 'NIK harus 16 digit angka.');
                valid = false;
            }
        }
        if (input.name === 'kode_pos' && input.value && !/^\d{5}$/.test(input.value)) {
            showError(input, 'Kode Pos harus 5 digit angka.');
            valid = false;
        }

        if (input.name?.includes('nama_lengkap')) {
            const value = input.value.trim();

            if (value && !/^[A-Za-z\s'.-]+$/.test(value)) {
                showError(input, 'Nama hanya boleh huruf dan tanda baca (-, .).');
                valid = false;
            }
        }
    });
    if (!validateKepalaKeluargaRealtime()) valid = false;
    if (!validateDuplicateNikAndKK()) valid = false;

    return valid;
}

// function confirmSubmit() {
//     document.getElementById('formKeluarga').submit();
// }
async function confirmSubmit() {
    const nikInputs = document.querySelectorAll('.nik-input');

    for (const input of nikInputs) {
        const valid = await checkNikFromDatabase(input);
        if (!valid) {
            input.focus();
            return;
        }
    }

    document.getElementById('formKeluarga').submit();
}


function validateDuplicateNikAndKK() {
    let valid = true;

    const noKKInput = document.getElementById('no_kk_error'); 
    const noKKValue = document.getElementById('no_kk')?.value || ''; 

    const nikInputs = document.querySelectorAll('.nik-input');
    const nikMap = {};

    nikInputs.forEach(input => {
        if (input.value) { 
            hideError(input); 
        }
    });
    if (noKKInput) noKKInput.style.display = 'none';

    nikInputs.forEach(input => {
        const nik = input.value;
        if (!nik) return; 
        if (noKKValue && nik === noKKValue) {
            showError(input, 'NIK tidak boleh sama dengan No KK.');
            if (noKKInput) {
                noKKInput.textContent = 'No KK tidak boleh sama dengan NIK anggota.';
                noKKInput.style.display = 'block';
            }
            valid = false;
        }
        if (nikMap[nik]) {
            showError(input, 'NIK tidak boleh duplikat.');
            showError(nikMap[nik], 'NIK tidak boleh duplikat.');
            valid = false;
        } else {
            nikMap[nik] = input;
        }
    });

    return valid;
}

const kodePosInput = document.querySelector('input[name="kode_pos"]');
kodePosInput.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0,5); 

    const errorEl = document.getElementById('kode_pos_error');
    if (this.value.length > 0 && this.value.length !== 5) {
        errorEl.textContent = 'Kode Pos harus 5 digit angka.';
        errorEl.style.display = 'block';
    } else {
        errorEl.style.display = 'none';
    }
});


document.addEventListener('input', function (e) {
    const target = e.target;

    if (
        target.matches('input[required]') ||
        target.classList.contains('nik-input')
    ) {
        clearErrorIfValid(target);
    }
});

document.addEventListener('change', function (e) {
    const target = e.target;
      if (e.target.matches('select[name$="[status_hubungan]"]')) {
        hideError(e.target);
        validateKepalaKeluargaRealtime();
    }
    if (target.matches('select[required]')) {
        if (target.value) {
            hideError(target);
        }
    }
});


 document.querySelectorAll('.only_number').forEach(input => {
    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    })
});
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmationModal');
    const form = document.getElementById("formKeluarga");
    const noKK = document.getElementById("no_kk");
    const newCard = document.querySelector(`[data-member-id="${memberCount}"]`);
    const noKKError = document.getElementById("no_kk_error");
    noKK.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0,16);

        if (this.value.length > 0 && this.value.length !== 16) {
            noKKError.style.display = "block";
            noKKError.textContent = "No KK harus 16 digit angka.";
        } else {
            noKKError.style.display = "none";
        }
        validateDuplicateNikAndKK();
    });
        if (noKK) {
        let noKKTimeout;
        noKK.addEventListener('input', function() {
            clearTimeout(noKKTimeout);
            noKKTimeout = setTimeout(() => {
                if (this.value.length === 16) {
                    checkNoKKFromDatabase();
                }
            }, 1000);
        });
    }

    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeConfirmationModal();
            }
        });
    }
    if (window.aiExtractedData) {
        console.log('Filling form with AI data:', window.aiExtractedData);
        fillFormWithAIData(window.aiExtractedData);
    } else if (anggotaKeluargaData && anggotaKeluargaData.length > 0) {
        anggotaKeluargaData.forEach((anggota) => {
            addMember(anggota); 
        });
    } else {
        addMember();
    }
     document.addEventListener('input', function(e) {
        if (e.target.classList.contains('nik-input')) {
            clearTimeout(e.target.dataset.nikTimeout);
            e.target.dataset.nikTimeout = setTimeout(() => {
                if (e.target.value && e.target.value.length === 16) {
                    checkNikFromDatabase(e.target);
                }
            }, 1000);
        }
    });
})
async function checkNoKKFromDatabase() {
    const noKKInput = document.getElementById('no_kk');
    const errorEl = document.getElementById('no_kk_error');
    if (!errorEl) {
        const newErrorEl = document.createElement('div');
        newErrorEl.id = 'no_kk_error';
        newErrorEl.style.color = 'red';
        newErrorEl.style.fontSize = '0.9em';
        newErrorEl.style.display = 'none';
        noKKInput.parentElement.appendChild(newErrorEl);
    }
    
    const currentErrorEl = errorEl || document.getElementById('no_kk_error');
    
    if (!noKKInput || noKKInput.value.length !== 16) {
        currentErrorEl.style.display = 'none';
        return true;
    }
    
    try {
        const res = await fetch('/cek-duplikat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({ 
                no_kk: noKKInput.value,
                check_type: 'no_kk' 
            })
        });
        
        const data = await res.json();
        
        if (data.exists || data.no_kk_exists) {
            currentErrorEl.textContent = 'No KK sudah terdaftar di database.';
            currentErrorEl.style.display = 'block';
            return false;
        }
        
        currentErrorEl.style.display = 'none';
        return true;
        
    } catch (e) {
        console.error('Error checking No KK:', e);
        currentErrorEl.textContent = 'Gagal mengecek No KK. Coba lagi.';
        currentErrorEl.style.display = 'block';
        return false;
    }
}
async function checkNikFromDatabase(nikInput) {
    let errorEl = nikInput.parentElement.querySelector('.input-error');
    if (!errorEl) {
        errorEl = document.createElement('div');
        errorEl.className = 'input-error';
        errorEl.style.color = 'red';
        errorEl.style.fontSize = '0.9em';
        errorEl.style.display = 'none';
        nikInput.parentElement.appendChild(errorEl);
    }
    
    if (!nikInput.value || nikInput.value.length !== 16) {
        errorEl.style.display = 'none';
        return true;
    }
    
    try {
        const res = await fetch('/cek-duplikat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({ 
                nik: nikInput.value,
                check_type: 'nik' 
            })
        });
        
        const data = await res.json();
        
        if (data.exists || data.nik_exists) {
            errorEl.textContent = 'NIK sudah terdaftar di database.';
            errorEl.style.display = 'block';
            return false;
        }
        
        errorEl.style.display = 'none';
        return true;
        
    } catch (err) {
        console.error('Error checking NIK:', err);
        errorEl.textContent = 'Gagal mengecek NIK. Coba lagi.';
        errorEl.style.display = 'block';
        return false;
    }
}

;
