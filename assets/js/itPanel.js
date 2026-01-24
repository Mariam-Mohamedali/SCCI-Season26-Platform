console.log('--- IT Panel JS v5.0 Loaded ---');

let userManager;

/**
 * Handles table pagination and filtering
 */
function setupPagination(tableScrollId, paginationId, rowsPerPage = 10) {
    console.log(`Setting up pagination for: ${tableScrollId}`);
    const tableScroll = document.getElementById(tableScrollId);
    const pagination = document.getElementById(paginationId);
    if (!tableScroll || !pagination) {
        console.error('Missing required elements:', { tableScroll, pagination });
        return null;
    }

    const tableBody = tableScroll.querySelector('tbody');
    if (!tableBody) {
        console.error('tableBody not found in:', tableScrollId);
        return null;
    }

    // Capture ALL rows with class .tableRow
    const originalRows = Array.from(tableBody.querySelectorAll('.tableRow'));
    console.log(`Found ${originalRows.length} total data rows in the table.`);

    let currentRows = [...originalRows];
    let currentPage = 1;
    let totalPages = Math.ceil(currentRows.length / rowsPerPage);

    const prevBtn = pagination.querySelector('.prev-btn');
    const nextBtn = pagination.querySelector('.next-btn');
    const pageInfo = pagination.querySelector('.page-info');

    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        console.log(`Showing Page ${page}. Indices: ${start} to ${end}. Results to show: ${currentRows.length}`);

        // Hide all rows initially
        originalRows.forEach(row => row.style.display = 'none');

        // Show the filtered slice for the current page
        currentRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            }
        });

        // Update UI status
        if (pageInfo) pageInfo.textContent = `Page ${page} of ${Math.max(1, totalPages)}`;
        if (prevBtn) prevBtn.disabled = page <= 1;
        if (nextBtn) nextBtn.disabled = page >= totalPages || totalPages === 0;

        // Hide pagination if only one page exists
        pagination.style.display = (currentRows.length > rowsPerPage) ? 'flex' : 'none';
        console.log(`Pagination visibility: ${pagination.style.display}`);
    }

    function filter(searchQuery, workshopValue) {
        console.log(`Filter triggered: Query="${searchQuery}", Workshop="${workshopValue}"`);
        searchQuery = searchQuery ? searchQuery.toLowerCase().trim() : '';
        workshopValue = workshopValue ? workshopValue.trim() : '';

        currentRows = originalRows.filter(row => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = !searchQuery || text.includes(searchQuery);
            const rowWS = (row.getAttribute('data-workshop') || '').toLowerCase().trim();
            const workshopVal = workshopValue.toLowerCase().trim();
            const matchesWorkshop = !workshopVal || rowWS === workshopVal;

            // console.log(`Row check: MatchSearch=${matchesSearch}, MatchWorkshop=${matchesWorkshop}, Text="${text.substring(0,20)}..."`);
            return matchesSearch && matchesWorkshop;
        });

        console.log(`Filtered count: ${currentRows.length}`);

        // Handle no results message
        const noResultsRow = tableBody.querySelector('.no-results-row');
        if (currentRows.length === 0) {
            if (!noResultsRow) {
                const newNoResultsRow = document.createElement('tr');
                newNoResultsRow.className = 'no-results-row tableRow';
                newNoResultsRow.innerHTML = '<td colspan="5" class="tableData" style="text-align: center;">No pending participants found.</td>';
                tableBody.appendChild(newNoResultsRow);
            }
        } else {
            if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        currentPage = 1;
        totalPages = Math.ceil(currentRows.length / rowsPerPage);
        showPage(currentPage);
    }

    if (prevBtn) {
        prevBtn.onclick = () => {
            console.log('Prev button clicked');
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        };
    }

    if (nextBtn) {
        nextBtn.onclick = () => {
            console.log('Next button clicked');
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        };
    }

    showPage(1);
    console.log('Initial showPage(1) completed.');
    return { filter };
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded triggered.');
    userManager = setupPagination('userTableScroll', 'itPagination');

    const searchInput = document.getElementById('searchInput');
    const workshopFilter = document.getElementById('workshopFilter');

    function applyFilters() {
        console.log('applyFilters invoked via event.');
        if (userManager) {
            userManager.filter(searchInput?.value, workshopFilter?.value);
        } else {
            console.error('userManager is NOT initialized!');
        }
    }

    if (searchInput) {
        console.log('Hooking up searchInput listener.');
        searchInput.addEventListener('input', applyFilters);
    }
    if (workshopFilter) {
        console.log('Hooking up workshopFilter listener.');
        workshopFilter.addEventListener('change', applyFilters);
    }
});

// ===============================
// Custom Delete Popup (NO browser confirm)
// ===============================
let deletePopup, confirmDeleteBtn, cancelDeleteBtn;
let pendingDeleteUrl = null;

document.addEventListener("DOMContentLoaded", () => {
  deletePopup = document.getElementById("deleteConfirmPopup");
  confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
  cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

  // افتح البوب اب عند الضغط على أي Delete (باستخدام event delegation)
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("a.js-delete");
    if (!btn) return;

    e.preventDefault(); // يمنع الانتقال للرابط
    pendingDeleteUrl = btn.getAttribute("href");

    if (deletePopup) deletePopup.style.display = "flex";
  });

  // Confirm
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", () => {
      if (pendingDeleteUrl) window.location.href = pendingDeleteUrl;
    });
  }

  // Cancel
  function closePopup() {
    if (deletePopup) deletePopup.style.display = "none";
    pendingDeleteUrl = null;
  }

  if (cancelDeleteBtn) cancelDeleteBtn.addEventListener("click", closePopup);

  // Close when clicking outside card
  if (deletePopup) {
    deletePopup.addEventListener("click", (e) => {
      if (e.target === deletePopup) closePopup();
    });
  }
});

let acceptPopup, confirmAcceptBtn, cancelAcceptBtn;
let pendingAcceptUrl = null;

document.addEventListener("DOMContentLoaded", () => {
  acceptPopup = document.getElementById("acceptConfirmPopup");
  confirmAcceptBtn = document.getElementById("confirmAcceptBtn");
  cancelAcceptBtn = document.getElementById("cancelAcceptBtn");

  // افتح Accept popup عند الضغط على Accept
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("a.js-accept");
    if (!btn) return;

    e.preventDefault(); // يمنع الانتقال للرابط
    pendingAcceptUrl = btn.getAttribute("href");

    if (acceptPopup) acceptPopup.style.display = "flex";
  });

  function closeAcceptPopup() {
    if (acceptPopup) acceptPopup.style.display = "none";
    pendingAcceptUrl = null;
  }

  if (cancelAcceptBtn) cancelAcceptBtn.addEventListener("click", closeAcceptPopup);

  if (confirmAcceptBtn) {
    confirmAcceptBtn.addEventListener("click", () => {
      if (pendingAcceptUrl) window.location.href = pendingAcceptUrl;
    });
  }

  if (acceptPopup) {
    acceptPopup.addEventListener("click", (e) => {
      if (e.target === acceptPopup) closeAcceptPopup();
    });
  }
});