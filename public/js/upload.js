// Upload File Handler

const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB (increased for PDF)
const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'application/pdf'];
const ALLOWED_EXTENSIONS = ['.jpg', '.jpeg', '.png', '.pdf'];

let uploadedFile = null;

// Get elements
const fileInput = document.getElementById('fileInput');
const uploadArea = document.getElementById('uploadArea');
const errorMessage = document.getElementById('errorMessage');
const errorText = document.getElementById('errorText');
const uploadSection = document.getElementById('uploadSection');
const previewSection = document.getElementById('previewSection');

// Click to upload
uploadArea.addEventListener('click', () => {
    fileInput.click();
});

// Drag and drop events
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

// File input change event
fileInput.addEventListener('change', (e) => {
    if (e.target.files && e.target.files[0]) {
        processFile(e.target.files[0]);
    }
});

// Process file
function processFile(file) {
    // Reset error message
    hideErrorMessage();
    
    // Validate file
    const validation = validateFile(file);
    
    if (!validation.valid) {
        showErrorMessage(validation.error);
        return;
    }
    
    // Save file and show preview
    uploadedFile = file;
    showPreview(file);
}

// Validate file
function validateFile(file) {
    // Check file extension
    const fileName = file.name.toLowerCase();
    const hasValidExtension = ALLOWED_EXTENSIONS.some(ext => fileName.endsWith(ext));
    
    // Check file type or extension
    if (!ALLOWED_TYPES.includes(file.type) && !hasValidExtension) {
        return {
            valid: false,
            error: '❌ Format file tidak didukung. Gunakan JPG, PNG, atau PDF.'
        };
    }
    
    // Check file size
    if (file.size > MAX_FILE_SIZE) {
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        return {
            valid: false,
            error: `❌ Ukuran file terlalu besar (${sizeMB}MB). Maksimal 10MB.`
        };
    }
    
    return { valid: true };
}

// Show error message
function showErrorMessage(message) {
    errorText.textContent = message;
    errorMessage.classList.add('show');
    errorMessage.style.display = 'block';
}

// Hide error message
function hideErrorMessage() {
    errorMessage.classList.remove('show');
    errorMessage.style.display = 'none';
}

// Show preview
function showPreview(file) {
    const reader = new FileReader();
    
    reader.onload = (e) => {
        // Set preview image or PDF icon
        const previewImage = document.getElementById('previewImage');
        if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')) {
            // For PDF, show a PDF icon or placeholder
            previewImage.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHg9IjUwIiB5PSI1NSIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzMzMyIgdGV4dC1hbmNob3I9Im1pZGRsZSI+UERGPC90ZXh0Pjwvc3ZnPg==';
            previewImage.alt = 'PDF Preview';
        } else {
            previewImage.src = e.target.result;
        }
        
        // Set file info
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);
        
        // Toggle sections
        uploadSection.style.display = 'none';
        previewSection.style.display = 'block';
        
        // Scroll to preview
        previewSection.scrollIntoView({ behavior: 'smooth' });
    };
    
    reader.onerror = () => {
        showErrorMessage('❌ Gagal membaca file. Coba lagi.');
    };
    
    reader.readAsDataURL(file);
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

// Change file
function changeFile() {
    uploadedFile = null;
    fileInput.value = '';
    
    uploadSection.style.display = 'block';
    previewSection.style.display = 'none';
    
    hideErrorMessage();
    
    uploadSection.scrollIntoView({ behavior: 'smooth' });
}

// Confirm upload
function confirmUpload(event) {
    // Prevent default if event is provided
    if (event) {
        event.preventDefault();
    }
    
    if (!uploadedFile) {
        showErrorMessage('❌ Tidak ada file yang dipilih.');
        return;
    }
    
    // Get button element
    const confirmBtn = event ? event.target : document.querySelector('.btn-success');
    const originalText = confirmBtn ? confirmBtn.textContent : '✓ Konfirmasi Penambahan Data';
    
    // Disable button
    if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.textContent = '⏳ Memproses dengan AI...';
    }
    
    // Show loading indicator
    const loadingMessage = document.createElement('div');
    loadingMessage.id = 'loadingMessage';
    loadingMessage.style.cssText = 'text-align: center; padding: 20px; color: var(--primary-green); font-weight: bold; margin-top: 20px;';
    loadingMessage.textContent = '⏳ Sedang memproses file dengan AI, mohon tunggu...';
    previewSection.insertBefore(loadingMessage, previewSection.firstChild);
    
    // Create FormData
    const formData = new FormData();
    formData.append('file', uploadedFile);
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    
    console.log('Mengirim file ke server...', {
        fileName: uploadedFile.name,
        fileSize: uploadedFile.size,
        fileType: uploadedFile.type
    });
    
    // Send file to server
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
            // Update loading message to success
            const loadingMsg = document.getElementById('loadingMessage');
            if (loadingMsg) {
                loadingMsg.style.color = 'var(--primary-green)';
                loadingMsg.textContent = '✓ File berhasil diproses! Mengarahkan ke form...';
            }
            
            // Redirect to tambah page (AI data will be in session)
            // Small delay to show success message
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
        // Remove loading message
        const loadingMsg = document.getElementById('loadingMessage');
        if (loadingMsg) loadingMsg.remove();
        
        showErrorMessage('❌ ' + (error.message || 'Gagal mengunggah file. Coba lagi.'));
        if (confirmBtn) {
            confirmBtn.disabled = false;
            confirmBtn.textContent = originalText;
        }
    });
}

// Handle file upload (legacy function for compatibility)
function handleFileUpload(input) {
    if (input.files && input.files[0]) {
        processFile(input.files[0]);
    }
}