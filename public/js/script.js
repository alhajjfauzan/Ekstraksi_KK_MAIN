// Fungsi Navigasi Sederhana
function goTo(url) {
    window.location.href = url;
}

// Fungsi Modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Fungsi Preview Upload (Opsional, agar terlihat interaktif)
function handleFileUpload(input) {
    if (input.files && input.files[0]) {
        // Simulasi pindah ke halaman preview
        alert("File " + input.files[0].name + " dipilih. Pindah ke Preview...");
        // Di real project: window.location.href = '/preview';
    }
}