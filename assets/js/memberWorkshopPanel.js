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

// Open popup
document.querySelectorAll(".evaluateFeedback").forEach((btn) => {
  btn.addEventListener("click", () => {
    const popupId = btn.dataset.popup;
    const popup = document.getElementById(popupId);

    popup.classList.add("active");
    document.body.classList.add("no-scroll");
  });
});

// Close popup (X button or Cancel)
document.addEventListener("click", (e) => {
  if (
    e.target.closest(".closeFeedback") ||
    e.target.closest(".modalCancelBtn")
  ) {
    const popup = e.target.closest(".reviewFeedbackPopup");
    popup.classList.remove("active");
    document.body.classList.remove("no-scroll");
  }
});

// Close when clicking overlay
document.querySelectorAll(".reviewFeedbackPopup").forEach((popup) => {
  popup.addEventListener("click", (e) => {
    if (e.target === popup) {
      popup.classList.remove("active");
      document.body.classList.remove("no-scroll");
    }
  });
});

// Escape key
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    document
      .querySelectorAll(".reviewFeedbackPopup.active")
      .forEach((popup) => {
        popup.classList.remove("active");
      });
    document.body.classList.remove("no-scroll");
  }
});

// ==============================================================

// Sessions
(function () {
  const ACTIVE_COLOR = "#1f184e";
  const DEFAULT_FILL = "var(--color-white-gradient)";

  const sessionButtons = document.querySelectorAll(".sessionBtn");

  function deactivateAllSessions() {
    sessionButtons.forEach((btn) => {
      btn.classList.remove("sessionActive");

      // reset panel body
      const body = btn.querySelector(".panelBody");
      if (body) {
        body.classList.remove("sessionBlue");
        body.classList.add("sessionWhite");
      }

      // reset svg edges
      btn.querySelectorAll("svg path").forEach((path) => {
        path.setAttribute("fill", DEFAULT_FILL);
        path.setAttribute("stroke", DEFAULT_FILL);
      });
    });
  }

  function activateSession(button) {
    button.classList.add("sessionActive");

    // activate panel body
    const body = button.querySelector(".panelBody");
    if (body) {
      body.classList.remove("sessionWhite");
      body.classList.add("sessionBlue");
    }

    // activate svg edges
    button.querySelectorAll("svg path").forEach((path) => {
      path.setAttribute("fill", ACTIVE_COLOR);
      path.setAttribute("stroke", ACTIVE_COLOR);
    });
  }

  sessionButtons.forEach((btn) => {
    btn.addEventListener("click", function () {
      deactivateAllSessions();
      activateSession(this);
    });
  });
})();

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

// Add Feedback form popup
document.addEventListener("click", (e) => {
  const star = e.target.closest(".feedbackStars");
  if (!star) return;

  const rating = Number(star.dataset.rating);

  const starsWrapper = star.closest(".feedbackStarsInput");
  const stars = starsWrapper.querySelectorAll(".feedbackStars");

  // update hidden input
  document.getElementById("ratingValue").value = rating;

  // update star icons
  stars.forEach((s) => {
    const value = Number(s.dataset.rating);

    if (value <= rating) {
      s.classList.remove("fa-regular");
      s.classList.add("fa-solid");
    } else {
      s.classList.remove("fa-solid");
      s.classList.add("fa-regular");
    }
  });
});

// ==========================

const submitFeedback = document.getElementById("feedbackForm");
submitFeedback.addEventListener("submit", (event) => {
  event.preventDefault(event);

  let addFeedback = document.getElementById("addFeedback").value.trim();
  let addFeedbackMessage = document.getElementById("addFeedbackMessage");

  addFeedbackMessage.textContent = "";
  var isValidFeedback = true;
  if (addFeedback == "") {
    addFeedbackMessage.textContent = "feedback is required";
    addFeedbackMessage.style.color = "red";
    addFeedbackMessage.style.fontSize = "12px";
    isValidFeedback = false;
  }
  if (!isValidFeedback) {
    event.preventDefault();
  }
  if (isValidFeedback) {
    // alert("Form submitted successfully!");
    submitFeedback.submit();
  }
});

// ==============================================================

// ================= File Upload Handling =================
document.querySelectorAll(".fileUpload").forEach((container) => {
  const fileInput = container.querySelector(".taskFileInput");
  const fileState = container.querySelector(".uploadText");
  const fileUploadedName = container.querySelector(".fileUploadedName");
  const fileMessage = container.querySelector(".fileMessage");
  const uploadBtn = container.querySelector("#uploadBtn");

  // Click the hidden input when upload button is clicked
  if (uploadBtn && fileInput) {
    uploadBtn.addEventListener("click", () => {
      fileInput.click();
    });
  }

  // File change event
  if (fileInput) {
    fileInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        fileUploadedName.textContent = file.name;
        fileUploadedName.style.display = "block";

        fileState.textContent = "File Uploaded Successfully!";
        fileState.style.color = "green";

        if (fileMessage) fileMessage.textContent = "";
      } else {
        fileUploadedName.textContent = "";
        fileUploadedName.style.display = "none";

        fileState.textContent = "Drag and drop or click to browse";
        fileState.style.color = "";
      }
    });
  }
});

// ================= Form Validation =================
document.querySelectorAll("form#validForm").forEach((form) => {
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    let isValid = true;

    // Task Name / Material Name
    const taskNameInput = form.querySelector("input[name='taskName'], input[type='text']").value.trim();
    const taskNameMessage = form.querySelector("#taskNameMessage");

    // Description (only exists in task form)
    const descriptionInput = form.querySelector("textarea[name='description']")?.value.trim() || "";
    const descriptionMessage = form.querySelector("#descriptionMessage");

    // Deadline (only exists in task form)
    const deadlineInput = form.querySelector("input[name='dueDate']")?.value || "";
    const deadlineMessage = form.querySelector("#dueDateMessage");

    // File
    const taskFileInput = form.querySelector(".taskFileInput")?.files[0];
    const fileMessage = form.querySelector(".fileMessage");

    // Reset previous messages
    if(taskNameMessage) taskNameMessage.textContent = "";
    if(descriptionMessage) descriptionMessage.textContent = "";
    if(deadlineMessage) deadlineMessage.textContent = "";
    if(fileMessage) fileMessage.textContent = "";

    // Validate Task/Material Name
    if (taskNameInput === "") {
      taskNameMessage.textContent = "This field is required.";
      taskNameMessage.style.color = "red";
      taskNameMessage.style.fontSize = "12px";
      isValid = false;
    }

    // Validate File
    if (!taskFileInput) {
      fileMessage.textContent = "Please upload a file.";
      fileMessage.style.color = "red";
      fileMessage.style.fontSize = "12px";
      isValid = false;
    }

    // Validate Deadline (only for task form)
    if (deadlineMessage && deadlineInput === "") {
      deadlineMessage.textContent = "Deadline is required.";
      deadlineMessage.style.color = "red";
      deadlineMessage.style.fontSize = "12px";
      isValid = false;
    }

    // Validate Description (only for task form)
    if (descriptionMessage && descriptionInput === "") {
      descriptionMessage.textContent = "Description is required.";
      descriptionMessage.style.color = "red";
      descriptionMessage.style.fontSize = "12px";
      isValid = false;
    }

    if (isValid) {
      form.submit();
    }
  });
});


// ==============================================================

console.log(
  "Stars found:",
  document.querySelectorAll(".feedbackStarsInput i").length,
);
