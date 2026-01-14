// Upload File Handler

const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB (increased for PDF)
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'application/pdf'];
const ALLOWED_EXTENSIONS = ['.jpg', '.jpeg', '.png', '.pdf'];

let uploadedFile = null;

const fileInput = document.getElementById('fileInput');
const uploadArea = document.getElementById('uploadArea');
const errorMessage = document.getElementById('errorMessage');
const errorText = document.getElementById('errorText');
const uploadSection = document.getElementById('uploadSection');
const previewSection = document.getElementById('previewSection');

uploadArea.addEventListener('click', () => {
    fileInput.click();
});
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('drag-over');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        processFile(e.dataTransfer.files[0]);
    }
});

fileInput.addEventListener('change', (e) => {
    if (e.target.files && e.target.files[0]) {
        processFile(e.target.files[0]);
    }
});

function processFile(file) {
    hideErrorMessage();
    const validation = validateFile(file);
    
    if (!validation.valid) {
        showErrorMessage(validation.error);
        return;
    }
    
    uploadedFile = file;
    showPreview(file);
}
function validateFile(file) {
    const fileName = file.name.toLowerCase();
    const hasValidExtension = ALLOWED_EXTENSIONS.some(ext => fileName.endsWith(ext));
    if (!ALLOWED_TYPES.includes(file.type) && !hasValidExtension) {
        return {
            valid: false,
            error: '❌ Format file tidak didukung. Gunakan JPG, PNG, atau PDF.'
        };
    }
    if (file.size > MAX_FILE_SIZE) {
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        return {
            valid: false,
            error: `❌ Ukuran file terlalu besar (${sizeMB}MB). Maksimal 10MB.`
        };
    }
    
    return { valid: true };
}
function showErrorMessage(message) {
    errorText.textContent = message;
    errorMessage.classList.add('show');
    errorMessage.style.display = 'block';
}
function hideErrorMessage() {
    errorMessage.classList.remove('show');
    errorMessage.style.display = 'none';
}

function showPreview(file) {
    const reader = new FileReader();
    
    reader.onload = (e) => {
        const previewImage = document.getElementById('previewImage');
        if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')) {
            previewImage.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHg9IjUwIiB5PSI1NSIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzMzMyIgdGV4dC1hbmNob3I9Im1pZGRsZSI+UERGPC90ZXh0Pjwvc3ZnPg==';
            previewImage.alt = 'PDF Preview';
        } else {
            previewImage.src = e.target.result;
        }
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);

        uploadSection.style.display = 'none';
        previewSection.style.display = 'block';
        showKkReminder();
        previewSection.scrollIntoView({ behavior: 'smooth' });
    };
    
    reader.onerror = () => {
        showErrorMessage('❌ Gagal membaca file. Coba lagi.');
    };
    
    reader.readAsDataURL(file);
}


function showKkReminder() {
    const reminderId = 'kkReminder';
    let reminder = document.getElementById(reminderId);
    if (!reminder) {
        reminder = document.createElement('div');
        reminder.id = reminderId;
        reminder.style.cssText = `
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #e6ffed;
            border-left: 5px solid var(--primary-green);
            color: var(--primary-green);
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            position: relative;
        `;

        reminder.innerHTML = `
            <strong>Periksa ulang Kartu Keluarga (KK)</strong><br>
            Pastikan foto KK jelas, No KK, nama kepala keluarga, dan semua data anggota terlihat dengan benar.
            <span id="closeKkReminder" style="
                position: absolute;
                top: 5px;
                right: 10px;
                cursor: pointer;
                font-weight: normal;
                color: var(--primary-green);
                font-size: 16px;">✖</span>
        `;
        previewSection.insertBefore(reminder, previewSection.firstChild);
        setTimeout(() => {
            reminder.style.opacity = 1;
        }, 50);
        const closeBtn = document.getElementById('closeKkReminder');
        closeBtn.addEventListener('click', () => {
            reminder.style.opacity = 0;
            setTimeout(() => {
                reminder.remove();
            }, 500);
        });

    } else {
        reminder.style.display = 'block';
        setTimeout(() => {
            reminder.style.opacity = 1;
        }, 50);
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

function changeFile() {
    uploadedFile = null;
    fileInput.value = '';
    
    uploadSection.style.display = 'block';
    previewSection.style.display = 'none';
    
    hideErrorMessage();
    
    uploadSection.scrollIntoView({ behavior: 'smooth' });
}

function confirmUpload(event) {
    if (event) {
        event.preventDefault();
    }
    
    if (!uploadedFile) {
        showErrorMessage('❌ Tidak ada file yang dipilih.');
        return;
    }
    const confirmBtn = event ? event.target : document.querySelector('.btn-success');
    const originalText = confirmBtn ? confirmBtn.textContent : '✓ Konfirmasi Penambahan Data';
    if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.textContent = '⏳ Memproses dengan AI...';
    }
    const loadingMessage = document.createElement('div');
    loadingMessage.id = 'loadingMessage';
    loadingMessage.style.cssText = 'text-align: center; padding: 20px; color: var(--primary-green); font-weight: bold; margin-top: 20px;';
    loadingMessage.textContent = '⏳ Sedang memproses file dengan AI, mohon tunggu...';
    previewSection.insertBefore(loadingMessage, previewSection.firstChild);
    const formData = new FormData();
    formData.append('file', uploadedFile);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    console.log('Mengirim file ke server...', {
        fileName: uploadedFile.name,
        fileSize: uploadedFile.size,
        fileType: uploadedFile.type
    });
    fetch('/api/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => {
                console.error('Error response:', err);
                throw new Error(err.message || 'Upload failed');
            }).catch(() => {
                throw new Error('Gagal mengunggah file. Status: ' + response.status);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            const loadingMsg = document.getElementById('loadingMessage');
            if (loadingMsg) {
                loadingMsg.style.color = 'var(--primary-green)';
                loadingMsg.textContent = '✓ File berhasil diproses! Mengarahkan ke form...';
            }
            setTimeout(() => {
                const redirectUrl = data.redirect_url || '/tambah';
                console.log('Redirecting to:', redirectUrl);
                window.location.href = redirectUrl;
            }, 1000);
        } else {
            throw new Error(data.message || 'Upload gagal');
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        const loadingMsg = document.getElementById('loadingMessage');
        if (loadingMsg) loadingMsg.remove();
        
        showErrorMessage('❌ ' + (error.message || 'Gagal mengunggah file. Coba lagi.'));
        if (confirmBtn) {
            confirmBtn.disabled = false;
            confirmBtn.textContent = originalText;
        }
    });
}
function handleFileUpload(input) {
    if (input.files && input.files[0]) {
        processFile(input.files[0]);
    }
}