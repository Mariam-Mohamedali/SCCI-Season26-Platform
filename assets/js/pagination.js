function setupPagination(tableScrollId, paginationId, rowsPerPage = 10) {
    const tableScroll = document.getElementById(tableScrollId);
    const pagination = document.getElementById(paginationId);
    if (!tableScroll || !pagination) return;

    const tableBody = tableScroll.querySelector('tbody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    // Create elements if not present in HTML, but here we expect them to be there
    const prevBtn = pagination.querySelector('.prev-btn');
    const nextBtn = pagination.querySelector('.next-btn');
    const pageInfo = pagination.querySelector('.page-info');

    let currentPage = 1;
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update Text
        if (pageInfo) pageInfo.textContent = `Page ${page} of ${Math.max(1, totalPages)}`;

        // Disable buttons if needed
        if (prevBtn) prevBtn.disabled = page === 1;
        if (nextBtn) nextBtn.disabled = page === totalPages || totalPages === 0;
    }

    // Event Listeners
    if (prevBtn) {
        // Clone to remove old listeners if re-initialized
        const newPrev = prevBtn.cloneNode(true);
        prevBtn.parentNode.replaceChild(newPrev, prevBtn);
        newPrev.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });
    }

    if (nextBtn) {
        const newNext = nextBtn.cloneNode(true);
        nextBtn.parentNode.replaceChild(newNext, nextBtn);
        newNext.addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });
    }

    // Initial show
    showPage(1);

    // Show pagination only if there are rows
    if (rows.length > 0) {
        pagination.style.display = 'flex';
    } else {
        pagination.style.display = 'none';
    }
}
