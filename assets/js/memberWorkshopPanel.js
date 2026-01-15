// Add Task Section

let taskNameMessage = document.getElementById('taskNameMessage');
let fileMessage = document.getElementById('fileMessage');
let descriptionMessage = document.getElementById('descriptionMessage');
let deadlineMessage = document.getElementById('dueDateMessage');

taskNameMessage.textContent = "";
fileMessage.textContent = "";
descriptionMessage.textContent = "";
deadlineMessage.textContent = "";

// file upload
const taskFileInput = document.getElementById('taskFile');
const fileState = document.getElementById('fileUploadState');
const fileUploadedName = document.getElementById('fileUploadedName');

taskFileInput.addEventListener('change', function () {
  if (this.files.length > 0) {
    const fileName = this.files[0].name;
    fileMessage.textContent = "";
    fileState.textContent = "File Uploaded Successfully!";
    fileState.style.color = "green";
    fileUploadedName.textContent = fileName;
    fileUploadedName.style.display = "block";

  } else {
    fileState.textContent = "Drag and drop or click to browse";
    fileState.style.color = "";
    fileUploadedName.textContent = "";
    fileUploadedName.style.display = "none";
  }
});

// validate form

const submitForm = document.getElementById('validForm');

submitForm.addEventListener('submit', (event) => {
    event.preventDefault(); 
    let taskNameInput = document.getElementById('taskName').value.trim();
    let descriptionInput = document.getElementById('descriptionInput').value.trim();
    let deadlineInput = document.getElementById('dueDate').value;
    let taskFileInput = document.getElementById('taskFile').files[0];

    
    taskNameMessage.textContent = "";
    fileMessage.textContent = "";
    descriptionMessage.textContent = "";
    deadlineMessage.textContent = "";

    var isValid = true;
    
    
    if (taskNameInput === "") {
        taskNameMessage.textContent = "Task Name is required.";
        taskNameMessage.style.color = "red";
        taskNameMessage.style.fontSize = "12px";
        isValid = false;
    }
    if (!taskFileInput) {
        fileMessage.textContent = "Please upload a file.";
        fileMessage.style.color = "red";
        fileMessage.style.fontSize = "12px";
        isValid = false;
    }
    if (deadlineInput === "") {
        deadlineMessage.textContent = "Deadline is required.";
        deadlineMessage.style.color = "red";
        deadlineMessage.style.fontSize = "12px";
        isValid = false;
    }
    if (descriptionInput === "") {
        descriptionMessage.textContent = "Description is required.";
        descriptionMessage.style.color = "red"; 
        descriptionMessage.style.fontSize = "12px";
        isValid = false;
    }

    if (isValid) {
        // alert("Form submitted successfully!");
        submitForm.submit();
    }
    
});


// Add Materials Section
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
