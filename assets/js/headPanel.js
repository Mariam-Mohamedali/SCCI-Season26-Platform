// get nav links
const participantBtn = document.querySelector('.participant');
const memberBtn = document.querySelector('.member');

// get table sections
const participantsSchedule = document.getElementById('participantsSchedule');
const membersSchedule = document.getElementById('membersSchedule');

// get pagination controls
const participantsPagination = document.getElementById('participantsPagination');
const membersPagination = document.getElementById('membersPagination');

// get search input
const searchInput = document.getElementById('searchInput');

// get committee filter
const committeeFilter = document.getElementById('committeeFilter');
const workshopFilter = document.getElementById('workshopFilter');
const filterContainer = document.getElementById('filterContainer');

// get current section from URL parameter
const urlParams = new URLSearchParams(window.location.search);
let currentSection = urlParams.get('section') || 'participants';

let participantsManager;
let membersManager;

// Function to handle pagination AND search
function setupPagination(tableScrollId, paginationId, rowsPerPage = 10) {
    const tableScroll = document.getElementById(tableScrollId);
    const pagination = document.getElementById(paginationId);
    if (!tableScroll || !pagination) return null;

    const tableBody = tableScroll.querySelector('tbody');
    // Store original rows for filtering
    const originalRows = Array.from(tableBody.querySelectorAll('tr'));

    const prevBtn = pagination.querySelector('.prev-btn');
    const nextBtn = pagination.querySelector('.next-btn');
    const pageInfo = pagination.querySelector('.page-info');

    let currentPage = 1;
    // Current rows starts as all rows
    let currentRows = [...originalRows];
    let totalPages = Math.ceil(currentRows.length / rowsPerPage);

    function showPage(page) {
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // Hide ALL original rows first to be safe
        originalRows.forEach(row => row.style.display = 'none');

        // Show the slice of CURRENT (filtered) rows
        currentRows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            }
        });

        // Update PAGINATION INFO
        pageInfo.textContent = `Page ${page} of ${Math.max(1, totalPages)}`;

        // Update BUTTON STATES
        prevBtn.disabled = page <= 1;
        nextBtn.disabled = page >= totalPages || totalPages === 0;
    }

    // Filter Function
    function filter(searchQuery, filterValue) {
        searchQuery = searchQuery ? searchQuery.toLowerCase().trim() : '';
        filterValue = filterValue ? filterValue.toLowerCase().trim() : '';

        currentRows = originalRows.filter(row => {
            // Text Search Check
            const matchesSearch = !searchQuery || row.textContent.toLowerCase().includes(searchQuery);

            // Filter Check (Committee for members, Workshop for participants)
            let matchesFilter = true;
            if (filterValue) {
                let rowFilter = '';
                if (row.querySelector('[data-workshop]')) {
                    // Participants row - use workshop
                    rowFilter = row.querySelector('[data-workshop]').dataset.workshop || '';
                } else {
                    // Members row - use committee
                    rowFilter = row.querySelector('[data-committee]').dataset.committee || '';
                }
                rowFilter = rowFilter.toLowerCase().trim();
                matchesFilter = rowFilter === filterValue;
            }

            return matchesSearch && matchesFilter;
        });

        // Reset to page 1 after filter
        currentPage = 1;
        totalPages = Math.ceil(currentRows.length / rowsPerPage);
        showPage(currentPage);
    }

    // Event Listeners for Pagination
    prevBtn.onclick = () => {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    };

    nextBtn.onclick = () => {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    };

    // Initial show
    showPage(1);

    return { filter };
}

// Initialize pagination logic
document.addEventListener('DOMContentLoaded', () => {
    participantsManager = setupPagination('participantsSchedule', 'participantsPagination');
    membersManager = setupPagination('membersSchedule', 'membersPagination');

    function applyFilters() {
        const query = searchInput ? searchInput.value : '';
        const filterValue = currentSection === 'participants'
            ? (workshopFilter ? workshopFilter.value : '')
            : (committeeFilter ? committeeFilter.value : '');

        if (currentSection === 'participants' && participantsManager) {
            participantsManager.filter(query, filterValue);
        } else if (currentSection === 'members' && membersManager) {
            membersManager.filter(query, filterValue);
        }
    }

    // Listeners
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    if (committeeFilter) {
        committeeFilter.addEventListener('change', applyFilters);
    }
    if (workshopFilter) {
        workshopFilter.addEventListener('change', applyFilters);
    }
});


// show participants
participantBtn.addEventListener('click', () => {
    switchTab('participants');
});

// show members
memberBtn.addEventListener('click', () => {
    switchTab('members');
});

function switchTab(section) {
    currentSection = section; // Update global state

    // Clear Filters on Switch
    if (searchInput) searchInput.value = '';
    if (committeeFilter) committeeFilter.value = '';
    if (workshopFilter) workshopFilter.value = '';

    if (participantsManager) participantsManager.filter('', '');
    if (membersManager) membersManager.filter('', '');

    if (section === 'participants') {
        participantsSchedule.style.display = 'block';
        membersSchedule.style.display = 'none';

        participantsPagination.style.display = 'flex';
        membersPagination.style.display = 'none';

        if (workshopFilter) workshopFilter.style.display = 'block';
        if (committeeFilter) committeeFilter.style.display = 'none';

        participantBtn.classList.add('activePanelLine');
        memberBtn.classList.remove('activePanelLine');

        window.history.replaceState({}, '', 'headPanel.php?section=participants');

    } else {
        membersSchedule.style.display = 'block';
        participantsSchedule.style.display = 'none';

        membersPagination.style.display = 'flex';
        participantsPagination.style.display = 'none';

        if (workshopFilter) workshopFilter.style.display = 'none';
        if (committeeFilter) committeeFilter.style.display = 'block';

        memberBtn.classList.add('activePanelLine');
        participantBtn.classList.remove('activePanelLine');

        window.history.replaceState({}, '', 'headPanel.php?section=members');
    }
}

// Set initial active state based on URL parameter (on load)
if (currentSection === 'members') {
    switchTab('members');
} else {
    // Manually set initial state for participants
    participantsSchedule.style.display = 'block';
    membersSchedule.style.display = 'none';
    participantsPagination.style.display = 'flex';
    membersPagination.style.display = 'none';
    if (workshopFilter) workshopFilter.style.display = 'block';
    if (committeeFilter) committeeFilter.style.display = 'none';
    participantBtn.classList.add('activePanelLine');
}
