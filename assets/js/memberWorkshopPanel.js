// Mini navbar change pages
const links = document.querySelectorAll(".miniNav a");
const pages = document.querySelectorAll(".panelSection");

function activatePage(pageId) {
  // activate nav link
  links.forEach((link) => {
    link.classList.toggle("activePanelLine", link.dataset.page === pageId);
  });

  // activate panel
  pages.forEach((page) => {
    page.classList.toggle("panelSectionActive", page.id === pageId);
  });
}

// prevent link default
links.forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();

    const targetId = link.dataset.page;

    // save to localStorage
    localStorage.setItem("activePanel", targetId);

    // activate immediately
    activatePage(targetId);
  });
});

// restore on page load
const savedPanel = localStorage.getItem("activePanel");

if (savedPanel) {
  activatePage(savedPanel);
} else {
  // fallback: first link
  const firstPage = links[0].dataset.page;
  activatePage(firstPage);
}

// ==============================================================

// Atendance local storage

// SAVE when changed
document.addEventListener("change", (e) => {
  if (e.target.type === "radio") {
    localStorage.setItem(e.target.name, e.target.value);
  }
});

// RESTORE on load
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("input[type='radio']").forEach((radio) => {
    const saved = localStorage.getItem(radio.name);
    if (saved === radio.value) {
      radio.checked = true;
    }
  });
});

// ==============================================================

// Add Task Section

let taskNameMessage = document.getElementById("taskNameMessage");
let fileMessage = document.getElementById("fileMessage");
let descriptionMessage = document.getElementById("descriptionMessage");
let deadlineMessage = document.getElementById("dueDateMessage");

taskNameMessage.textContent = "";
fileMessage.textContent = "";
descriptionMessage.textContent = "";
deadlineMessage.textContent = "";

// ==============================================================

// file upload
const taskFileInput = document.getElementById("taskFile");
const fileState = document.getElementById("fileUploadState");
const fileUploadedName = document.getElementById("fileUploadedName");

taskFileInput.addEventListener("change", function () {
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

// ==============================================================

// validate form

const submitForm = document.getElementById("validForm");

submitForm.addEventListener("submit", (event) => {
  event.preventDefault();
  let taskNameInput = document.getElementById("taskName").value.trim();
  let descriptionInput = document
    .getElementById("descriptionInput")
    .value.trim();
  let deadlineInput = document.getElementById("dueDate").value;
  let taskFileInput = document.getElementById("taskFile").files[0];
  console.log(taskFileInput, taskNameInput);

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

// ==============================================================

// Add Materials Section
const technicalBtn = document.querySelectorAll(".materialTypeButton")[0];
const softSkillsBtn = document.querySelectorAll(".materialTypeButton")[1];
const materialList = document.querySelector(".materialItemsList");
const uploadBtn = document.querySelector(".uploadContainer .btn");
const uploadText = document.querySelector(".uploadText");

function switchTab(type) {
  // Function to handle tab switching
  // 1.Change Button Colors
  if (type === "technical") {
    technicalBtn.classList.add("active");
    softSkillsBtn.classList.remove("active");
  } else {
    softSkillsBtn.classList.add("active");
    technicalBtn.classList.remove("active");
  }

  // 2. Filter the List Items
  const items = document.querySelectorAll(".materialItemJs");
  let hasVisibleItems = false;

  items.forEach((item) => {
    // Check if the item text contains "Soft" (case insensitive)
    const text = item.innerText.toLowerCase();
    const isSoftSkill = text.includes("soft") || text.includes("communication");

    if (type === "soft") {
      if (isSoftSkill) {
        item.style.display = "flex";
        hasVisibleItems = true;
      } else {
        item.style.display = "none";
      }
    } else {
      // Technical Tab
      if (!isSoftSkill) {
        item.style.display = "flex";
        hasVisibleItems = true;
      } else {
        item.style.display = "none";
      }
    }
  });
}

// --- Event Listeners ---

// Tab Clicks
technicalBtn.addEventListener("click", () => {
  switchTab("technical");
});

softSkillsBtn.addEventListener("click", () => {
  switchTab("soft");
});

// Upload Button Click
uploadBtn.addEventListener("click", () => {
  fileInput.click();
});

// File Selected
fileInput.addEventListener("change", () => {
  if (fileInput.files.length > 0) {
    uploadText.innerHTML =
      "File Selected:<br><strong>" + fileInput.files[0].name + "</strong>";
  }
});

// Initialize Default Tab
switchTab("technical");

// ==============================================================
