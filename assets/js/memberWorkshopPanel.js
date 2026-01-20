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

// Sessions scroll
// ==============================================================


(function () {
  const initializedSelectors = new WeakSet();

  function initScrollButtons() {
    console.log("=== INITIALIZING SCROLL BUTTONS ===");
    
    const frames = document.querySelectorAll(".sessionsSelectorFrame");
    
    if (frames.length === 0) {
      console.warn("No sessionsSelectorFrame found");
      return;
    }

    console.log(`Found ${frames.length} session frames`);

    frames.forEach((frame, frameIndex) => {
      // Skip if already initialized
      if (initializedSelectors.has(frame)) {
        console.log(`Frame ${frameIndex + 1} already initialized, skipping`);
        return;
      }

      console.log(`\n--- Initializing Frame ${frameIndex + 1} ---`);
      
      const selector = frame.querySelector(".sessionsSelector");
      const leftBtn = frame.querySelector(".scrollLeft");
      const rightBtn = frame.querySelector(".scrollRight");

      if (!selector || !leftBtn || !rightBtn) {
        console.warn(`Frame ${frameIndex + 1}: Missing elements`);
        return;
      }

      const sessions = [...selector.querySelectorAll(".sessionBtn")];
      
      if (sessions.length === 0) {
        console.warn(`Frame ${frameIndex + 1}: No session buttons found`);
        return;
      }

      console.log(`Frame ${frameIndex + 1}: Found ${sessions.length} sessions`);

      // Create isolated scope for this frame
      let currentIndex = 0;

      function scrollToIndex(index) {
        console.log(`[Frame ${frameIndex + 1}] scrollToIndex:`, index);
        
        index = Math.max(0, Math.min(index, sessions.length - 1));
        currentIndex = index;

        const targetSession = sessions[index];
        
        // Calculate scroll position
        const scrollAmount = targetSession.offsetLeft - selector.offsetLeft;

        console.log(`[Frame ${frameIndex + 1}] Scrolling to:`, scrollAmount);

        selector.scrollTo({
          left: scrollAmount,
          behavior: "smooth"
        });
      }

      // Right button click handler - scroll by 2 sessions
      const handleRightClick = (e) => {
        console.log(`[Frame ${frameIndex + 1}] RIGHT BUTTON CLICKED`);
        e.preventDefault();
        e.stopPropagation();
        
        // Scroll forward by 2 sessions
        const newIndex = Math.min(currentIndex + 2, sessions.length - 1);
        if (newIndex !== currentIndex) {
          scrollToIndex(newIndex);
        }
      };

      // Left button click handler - scroll by 2 sessions
      const handleLeftClick = (e) => {
        console.log(`[Frame ${frameIndex + 1}] LEFT BUTTON CLICKED`);
        e.preventDefault();
        e.stopPropagation();
        
        // Scroll backward by 2 sessions
        const newIndex = Math.max(currentIndex - 2, 0);
        if (newIndex !== currentIndex) {
          scrollToIndex(newIndex);
        }
      };

      // Remove old listeners and add new ones
      rightBtn.removeEventListener("click", handleRightClick);
      leftBtn.removeEventListener("click", handleLeftClick);
      
      rightBtn.addEventListener("click", handleRightClick);
      leftBtn.addEventListener("click", handleLeftClick);

      // Manual scroll sync
      let scrollTimeout;
      selector.addEventListener("scroll", () => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
          const scrollPos = selector.scrollLeft;

          const closest = sessions.reduce((prev, curr, i) => {
            const prevDist = Math.abs(sessions[prev].offsetLeft - scrollPos);
            const currDist = Math.abs(curr.offsetLeft - scrollPos);
            return currDist < prevDist ? i : prev;
          }, 0);

          currentIndex = closest;
        }, 100);
      });

      // Check if scrollable
      console.log(`[Frame ${frameIndex + 1}] scrollWidth:`, selector.scrollWidth);
      console.log(`[Frame ${frameIndex + 1}] clientWidth:`, selector.clientWidth);
      console.log(`[Frame ${frameIndex + 1}] Is scrollable:`, selector.scrollWidth > selector.clientWidth);

      // Mark as initialized
      initializedSelectors.add(frame);
      
      console.log(`[Frame ${frameIndex + 1}] ✓ Initialization complete`);
    });
    
    console.log("\n=== ALL FRAMES INITIALIZED ===\n");
  }

  // Initialize with delay to ensure DOM is ready and visible
  function delayedInit() {
    setTimeout(() => {
      initScrollButtons();
    }, 200);
  }

  // Initialize when DOM is ready
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", delayedInit);
  } else {
    delayedInit();
  }

  // Re-initialize when panels become visible (for tabbed content)
  document.addEventListener("click", (e) => {
    // Check if a navigation link was clicked
    if (e.target.closest(".miniNav a")) {
      setTimeout(() => {
        console.log("Panel switched, checking for new session frames...");
        initScrollButtons();
      }, 300);
    }
  });

  // Also watch for class changes on panels
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.attributeName === "class") {
        const target = mutation.target;
        if (target.classList.contains("panelSectionActive")) {
          setTimeout(() => {
            console.log("Panel activated, re-initializing...");
            initScrollButtons();
          }, 100);
        }
      }
    });
  });

  // Observe all panel sections
  setTimeout(() => {
    document.querySelectorAll(".panelSection").forEach((panel) => {
      observer.observe(panel, { attributes: true });
    });
  }, 100);
})();
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
const defaultRating = 1;
const stars = document.querySelectorAll(".feedbackStarsInput .feedbackStars");

document.getElementById("ratingValue").value = defaultRating;
document.getElementById("star1").checked = true;

stars.forEach((star) => {
  const value = Number(star.dataset.rating);
  star.classList.toggle("fa-solid", value <= defaultRating);
  star.classList.toggle("fa-regular", value > defaultRating);
});

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
    const taskNameInput = form
      .querySelector("input[name='taskName'], input[type='text']")
      .value.trim();
    const taskNameMessage = form.querySelector("#taskNameMessage");

    // Description (only exists in task form)
    const descriptionInput =
      form.querySelector("textarea[name='description']")?.value.trim() || "";
    const descriptionMessage = form.querySelector("#descriptionMessage");

    // Deadline (only exists in task form)
    const deadlineInput =
      form.querySelector("input[name='dueDate']")?.value || "";
    const deadlineMessage = form.querySelector("#dueDateMessage");

    // File
    const taskFileInput = form.querySelector(".taskFileInput")?.files[0];
    const fileMessage = form.querySelector(".fileMessage");

    // Reset previous messages
    if (taskNameMessage) taskNameMessage.textContent = "";
    if (descriptionMessage) descriptionMessage.textContent = "";
    if (deadlineMessage) deadlineMessage.textContent = "";
    if (fileMessage) fileMessage.textContent = "";

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
