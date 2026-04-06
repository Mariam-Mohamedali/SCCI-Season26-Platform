/**
 * itResetPassword.js — IT Password Reset Panel
 * Handles: table search/filter, pagination, modal open/close,
 *          eye-toggle for passwords, client-side validation, toast auto-dismiss.
 */

'use strict';

/* ===============================
   PAGINATION HELPER
================================ */
function setupPagination(tableScrollId, paginationId, rowsPerPage = 12) {
    const tableScroll = document.getElementById(tableScrollId);
    const pagination = document.getElementById(paginationId);
    if (!tableScroll || !pagination) return null;

    const tableBody = tableScroll.querySelector('tbody');
    if (!tableBody) return null;

    const originalRows = Array.from(tableBody.querySelectorAll('.tableRow'));
    let currentRows = [...originalRows];
    let currentPage = 1;
    let totalPages = Math.ceil(currentRows.length / rowsPerPage);

    const prevBtn = pagination.querySelector('.prev-btn');
    const nextBtn = pagination.querySelector('.next-btn');
    const pageInfo = pagination.querySelector('.page-info');

    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        originalRows.forEach(row => (row.style.display = 'none'));
        currentRows.forEach((row, idx) => {
            if (idx >= start && idx < end) row.style.display = '';
        });

        if (pageInfo) pageInfo.textContent = `Page ${page} of ${Math.max(1, totalPages)}`;
        if (prevBtn) prevBtn.disabled = page <= 1;
        if (nextBtn) nextBtn.disabled = page >= totalPages || totalPages === 0;

        pagination.style.display = currentRows.length > rowsPerPage ? 'flex' : 'none';
    }

    function applyFilter(searchQuery, roleValue, workshopValue) {
        searchQuery = (searchQuery || '').toLowerCase().trim();
        roleValue = (roleValue || '').trim();
        workshopValue = (workshopValue || '').trim();

        currentRows = originalRows.filter(row => {
            const text = row.textContent.toLowerCase();
            const rowRole = (row.getAttribute('data-role') || '').trim();
            const rowWS = (row.getAttribute('data-workshop') || '').toLowerCase().trim();

            const matchSearch = !searchQuery || text.includes(searchQuery);
            const matchRole = !roleValue || rowRole === roleValue;
            const matchWorkshop = !workshopValue || rowWS === workshopValue.toLowerCase();

            return matchSearch && matchRole && matchWorkshop;
        });

        // No-results row
        const noRow = tableBody.querySelector('.no-results-row');
        if (currentRows.length === 0) {
            if (!noRow) {
                const tr = document.createElement('tr');
                tr.className = 'no-results-row';
                tr.innerHTML = '<td colspan="7" class="tableData" style="text-align:center;">No users match your search.</td>';
                tableBody.appendChild(tr);
            }
        } else {
            if (noRow) noRow.remove();
        }

        currentPage = 1;
        totalPages = Math.ceil(currentRows.length / rowsPerPage);
        showPage(currentPage);
    }

    if (prevBtn) prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; showPage(currentPage); } };
    if (nextBtn) nextBtn.onclick = () => { if (currentPage < totalPages) { currentPage++; showPage(currentPage); } };

    showPage(1);
    return { applyFilter };
}

/* ===============================
   INIT ON DOM READY
================================ */
document.addEventListener('DOMContentLoaded', () => {

    /* --- Pagination & Filters --- */
    const manager = setupPagination('userTableScroll', 'resetPagination');
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const workshopFilter = document.getElementById('workshopFilter');

    function runFilters() {
        if (manager) {
            manager.applyFilter(
                searchInput?.value,
                roleFilter?.value,
                workshopFilter?.value
            );
        }
    }

    searchInput?.addEventListener('input', runFilters);
    roleFilter?.addEventListener('change', runFilters);
    workshopFilter?.addEventListener('change', runFilters);

    /* --- Modal Elements --- */
    const overlay = document.getElementById('resetModalOverlay');
    const resetForm = document.getElementById('resetForm');
    const resetUserId = document.getElementById('resetUserId');
    const modalTitle = document.getElementById('resetModalTitle');
    const modalSubtitle = document.getElementById('resetModalSubtitle');
    const cancelBtn = document.getElementById('cancelResetBtn');

    const newPassInput = document.getElementById('new_password');
    const confPassInput = document.getElementById('confirm_password');
    const errNew = document.getElementById('err-new-password');
    const errConf = document.getElementById('err-confirm-password');

    /* --- Open Modal --- */
    document.addEventListener('click', e => {
        const btn = e.target.closest('.js-open-reset');
        if (!btn) return;

        const uid = btn.getAttribute('data-userid');
        const name = btn.getAttribute('data-username');

        resetUserId.value = uid;
        modalTitle.textContent = `Reset Password`;
        modalSubtitle.textContent = `Setting a new password for: ${name}`;

        // Clear previous errors & inputs
        newPassInput.value = '';
        confPassInput.value = '';
        errNew.textContent = '';
        errConf.textContent = '';

        overlay.classList.add('open');
    });

    /* --- Close Modal --- */
    function closeModal() {
        overlay.classList.remove('open');
        resetUserId.value = '';
        newPassInput.value = '';
        confPassInput.value = '';
        errNew.textContent = '';
        errConf.textContent = '';
    }

    cancelBtn?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', e => { if (e.target === overlay) closeModal(); });

    /* --- Client-side Validation --- */
    resetForm?.addEventListener('submit', e => {
        let valid = true;
        const pwd = newPassInput.value;
        const conf = confPassInput.value;

        errNew.textContent = '';
        errConf.textContent = '';

        if (pwd.length < 8) {
            errNew.textContent = 'Password must be at least 8 characters.';
            valid = false;
        } else if (!/[A-Z]/.test(pwd) || !/[a-z]/.test(pwd) || !/[0-9]/.test(pwd)) {
            errNew.textContent = 'Must contain uppercase, lowercase, and a digit.';
            valid = false;
        }

        if (!valid) { e.preventDefault(); return; }

        if (pwd !== conf) {
            errConf.textContent = 'Passwords do not match.';
            e.preventDefault();
        }
    });

    /* --- Password Eye Toggles --- */
    function setupToggle(btnId, inputId) {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        if (!btn || !input) return;

        btn.addEventListener('click', () => {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            const icon = btn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye-slash', !isHidden);
                icon.classList.toggle('fa-eye', isHidden);
            }
        });
    }

    setupToggle('toggleNewPass', 'new_password');
    setupToggle('toggleConfirmPass', 'confirm_password');

    /* --- Toast Auto-dismiss --- */
    const toast = document.getElementById('toastMsg');
    if (toast) {
        setTimeout(() => {
            toast.style.transition = 'opacity 0.5s ease';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }, 4500);
    }

    /* --- Scroll-to-top Button --- */
    const scrollBtn = document.getElementById('scrollTopBtn');
    if (scrollBtn) {
        window.addEventListener('scroll', () => {
            scrollBtn.classList.toggle('visible', window.scrollY > 300);
        });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }
});
