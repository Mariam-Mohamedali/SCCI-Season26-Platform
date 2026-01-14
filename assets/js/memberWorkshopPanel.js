
// Select the necessary elements
const technicalBtn = document.querySelectorAll('.materialTypeButton')[0];
const softSkillsBtn = document.querySelectorAll('.materialTypeButton')[1];
const materialList = document.querySelector('.materialItemsList');
const uploadBtn = document.querySelector('.uploadContainer .btn');
const uploadText = document.querySelector('.uploadText');

// --- Functions ---

// Function to handle tab switching
function switchTab(type) {
    // 1.Change Button Colors
    if (type === 'technical') {
        technicalBtn.classList.add('active');
        softSkillsBtn.classList.remove('active');
    } else {
        softSkillsBtn.classList.add('active');
        technicalBtn.classList.remove('active');
    }

    // 2. Filter the List Items
    const items = document.querySelectorAll('.materialItem');
    let hasVisibleItems = false;

    items.forEach(item => {
        // Check if the item text contains "Soft" (case insensitive)
        const text = item.innerText.toLowerCase();
        const isSoftSkill = text.includes('soft') || text.includes('communication');

        if (type === 'soft') {
            if (isSoftSkill) {
                item.style.display = 'flex';
                hasVisibleItems = true;
            } else {
                item.style.display = 'none';
            }
        } else {
            // Technical Tab
            if (!isSoftSkill) {
                item.style.display = 'flex';
                hasVisibleItems = true;
            } else {
                item.style.display = 'none';
            }
        }
    });
}

// --- Event Listeners ---

// Tab Clicks
technicalBtn.addEventListener('click', () => {
    switchTab('technical');
});

softSkillsBtn.addEventListener('click', () => {
    switchTab('soft');
});

// Upload Button Click
uploadBtn.addEventListener('click', () => {
    fileInput.click();
});

// File Selected
fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
        uploadText.innerHTML = "File Selected:<br><strong>" + fileInput.files[0].name + "</strong>";
    }
});

// Initialize Default Tab
switchTab('technical');
