/**
 * Message Display System using SweetAlert2
 * Handles success, error, and info messages on both member and participant panels
 */

function showMessage(text, type = 'info', duration = 3000) {
    const typeMap = {
        'error': 'error',
        'success': 'success',
        'info': 'info'
    };

    const swalType = typeMap[type] || 'info';

    Swal.fire({
        title: type === 'error' ? 'Error' : type === 'success' ? 'Success' : 'Info',
        text: text,
        icon: swalType,
        timer: duration,
        timerProgressBar: true,
        showConfirmButton: false,
        toast: true,
        position: 'top-center',
        customClass: {
            container: 'message-toast-container'
        },
        background: swalType === 'error' ? '#f8d7da' : swalType === 'success' ? '#d4edda' : '#d1ecf1',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}

// Display messages from URL parameters on page load
document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const errorMsg = params.get('err');
    const successMsg = params.get('msg');

    if (errorMsg) {
        showMessage(errorMsg, 'error');
    }
    if (successMsg) {
        showMessage(successMsg, 'success');
    }
});
