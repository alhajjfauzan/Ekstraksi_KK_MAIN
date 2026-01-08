// Modal Functions
function showSuccessModal(title = 'Berhasil!', message = 'Operasi berhasil dilakukan', redirectUrl = null) {
    const modal = document.getElementById('successModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalButton = document.getElementById('modalButton');

    if (modal) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modal.classList.add('active');

        if (redirectUrl) {
            modalButton.onclick = function() {
                window.location.href = redirectUrl;
            };
        }
    }
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

// Close modal when clicking the X button
document.addEventListener('DOMContentLoaded', function() {
    const closeBtn = document.getElementById('modalClose');
    const modal = document.getElementById('successModal');

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSuccessModal);
    }

    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeSuccessModal();
            }
        });
    }

    // Check if success message from session
    const successMessage = document.body.getAttribute('data-success');
    const successTitle = document.body.getAttribute('data-success-title');
    const redirectUrl = document.body.getAttribute('data-redirect-url');

    if (successMessage) {
        showSuccessModal(successTitle || 'Berhasil!', successMessage, redirectUrl);
    }
});
