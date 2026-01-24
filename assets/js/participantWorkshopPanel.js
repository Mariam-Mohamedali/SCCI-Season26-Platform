// participantWorkshopPanel.js
document.addEventListener("DOMContentLoaded", () => {
  console.log("Workshop Panel JS Loaded ✅");

  /* =========================
     Tabs and General Config
  ========================= */
  const links = document.querySelectorAll(".miniNav a[data-page]");
  const pages = document.querySelectorAll(".panelSection");

  function activatePage(pageId) {
    links.forEach(link => link.classList.toggle("activePanelLine", link.dataset.page === pageId));
    pages.forEach(page => page.classList.toggle("panelSectionActive", page.id === pageId));
    localStorage.setItem("activePanel", pageId);
    const url = new URL(window.location.href);
    url.searchParams.set("tab", pageId);
    history.replaceState({}, "", url.toString());

    // NEW: Update all hidden tab inputs on the page to match active tab
    document.querySelectorAll('input[name="tab"]').forEach((input) => {
      input.value = pageId;
    });
  }

  links.forEach(link => link.addEventListener("click", (e) => {
    e.preventDefault();
    activatePage(link.dataset.page);
  }));

  const urlTab = new URLSearchParams(window.location.search).get("tab");
  const savedTab = localStorage.getItem("activePanel");
  const initialTab = urlTab || savedTab || (links[0]?.dataset.page);
  if (initialTab && document.getElementById(initialTab)) activatePage(initialTab);

  /* =========================
     Sessions Scroll & Persistence
  ========================= */
  const PERSIST_KEY_PAGE = "participant_scroll_page";
  const PERSIST_KEY_SESSIONS = "participant_scroll_sessions";

  const sessionsContainer = document.getElementById("sessionsContainer");
  const leftBtn = document.querySelector(".scrollBtn.leftBtn");
  const rightBtn = document.querySelector(".scrollBtn.rightBtn");

  if (sessionsContainer && leftBtn && rightBtn) {
    // Restore session scroll
    const savedSessionsScroll = localStorage.getItem(PERSIST_KEY_SESSIONS);
    if (savedSessionsScroll) {
      sessionsContainer.scrollLeft = parseInt(savedSessionsScroll, 10);
    }

    // Save session scroll on change
    sessionsContainer.addEventListener("scroll", () => {
      localStorage.setItem(PERSIST_KEY_SESSIONS, sessionsContainer.scrollLeft);
    });

    leftBtn.addEventListener("click", () => sessionsContainer.scrollBy({ left: -300, behavior: "smooth" }));
    rightBtn.addEventListener("click", () => sessionsContainer.scrollBy({ left: 300, behavior: "smooth" }));
  }

  // Restore Page Scroll
  const savedPageScroll = localStorage.getItem(PERSIST_KEY_PAGE);
  if (savedPageScroll) {
    setTimeout(() => {
      window.scrollTo({ top: parseInt(savedPageScroll, 10), behavior: "instant" });
    }, 50);
  }

  // Save Page Scroll
  window.addEventListener("scroll", () => {
    localStorage.setItem(PERSIST_KEY_PAGE, window.scrollY);
  });

  /* =========================
     Submit Task (AJAX)
  ========================= */
  const submitForm = document.getElementById("validForm");
  const fileInput = document.getElementById("submit_link");
  const fileMessage = document.getElementById("fileMessage");
  const fileState = document.getElementById("fileUploadState");
  const fileUploadedName = document.getElementById("fileUploadedName");
  const actionButtons = document.getElementById("actionButtons");
  const removeBtn = document.getElementById("removeFileBtn");
  const formLabel = document.getElementById("formLabel");
  const submitTaskBtn = document.getElementById("submitTaskBtn");

  function setFileMsg(text, color = "red") {
    if (!fileMessage) return;
    fileMessage.textContent = text;
    fileMessage.style.color = color;
  }

  function updateFileUI(file) {
    console.log("Updating UI for file:", file ? file.name : "null");
    if (fileState) {
      fileState.textContent = file ? "File Selected Successfully!" : "Drag and drop or click to browse";
      fileState.style.color = file ? "green" : "";
    }
    if (fileUploadedName) {
      fileUploadedName.textContent = file ? file.name : "";
      fileUploadedName.style.display = file ? "block" : "none";
    }

    // CRITICAL: SHOW/HIDE Buttons
    if (formLabel) formLabel.style.display = file ? "none" : "flex";
    if (actionButtons) {
      actionButtons.style.display = file ? "flex" : "none";
      console.log("ActionButtons display set to:", actionButtons.style.display);
    }

    if (fileMessage) fileMessage.textContent = "";
  }

  /* Custom Popup Logic */
  const popup = document.querySelector(".submitPopup");
  const popupMsg = document.getElementById("popupMessage");
  const popupClose = document.querySelector(".popupSubmitClose");
  let popupTimer;

  function showPopup(message, isError = false) {
    if (!popup || !popupMsg) {
      alert(message);
      return;
    }
    clearTimeout(popupTimer);
    popupMsg.textContent = message;
    popup.classList.toggle("error", isError);
    popup.classList.add("show");

    popupTimer = setTimeout(() => {
      popup.classList.remove("show");
    }, 10000); // 10 seconds per user request
  }

  // Make global
  window.showPopup = showPopup;

  if (popupClose) {
    popupClose.addEventListener("click", () => {
      popup.classList.remove("show");
      clearTimeout(popupTimer);
    });
  }

  // Reload survival logic (if any)
  if (localStorage.getItem("taskSubmitted") === "true") {
    showPopup("Your task has been submitted successfully!", false);
    localStorage.removeItem("taskSubmitted");
  }

  // Handle session messages from PHP
  if (window.sessionMessages) {
    if (window.sessionMessages.msg) showPopup(window.sessionMessages.msg, false);
    if (window.sessionMessages.err) showPopup(window.sessionMessages.err, true);
  }

  const MAX_FILE_SIZE = 20 * 1024 * 1024; // 20 MB
  const ALLOWED_EXT = ["pdf", "doc", "docx", "zip", "rar", "png", "jpg", "jpeg"];

  if (fileInput) {
    fileInput.addEventListener("change", () => {
      const file = fileInput.files[0];
      if (!file) {
        updateFileUI(null);
        return;
      }

      const ext = (file.name.split(".").pop() || "").toLowerCase();
      if (!ALLOWED_EXT.includes(ext)) {
        fileInput.value = "";
        updateFileUI(null);
        const msg = "This file type is not supported";
        setFileMsg(msg, "red");
        showPopup(msg, true);
        return;
      }

      if (file.size > MAX_FILE_SIZE) {
        fileInput.value = "";
        updateFileUI(null);
        const msg = "File size must be less than 20MB";
        setFileMsg(msg, "red");
        showPopup(msg, true);
        return;
      }

      updateFileUI(file);
    });
  }

  if (removeBtn) {
    removeBtn.addEventListener("click", () => {
      console.log("Remove button clicked");
      fileInput.value = "";
      updateFileUI(null);
      setFileMsg("file removed", "red");
    });
  }

  if (submitForm) {
    submitForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      console.log("Submission started...");

      const file = fileInput.files[0];
      if (!file) {
        setFileMsg("Please select a file.", "red");
        return;
      }

      const ext = (file.name.split(".").pop() || "").toLowerCase();
      if (!ALLOWED_EXT.includes(ext)) {
        const msg = "This file type is not supported";
        setFileMsg(msg, "red");
        showPopup(msg, true);
        return;
      }

      if (file.size > MAX_FILE_SIZE) {
        const msg = "File size must be less than 20MB";
        setFileMsg(msg, "red");
        showPopup(msg, true);
        return;
      }

      if (submitForm.dataset.submitted === "true") {
        const msg = "You have already submitted this task.";
        setFileMsg(msg, "red");
        showPopup(msg, true);
        return;
      }

      const deadlineStr = submitForm.dataset.deadline;
      if (deadlineStr) {
        const deadlineDate = new Date(deadlineStr);
        if (!isNaN(deadlineDate) && new Date() > deadlineDate) {
          const msg = "The deadline for this task has passed.";
          setFileMsg(msg, "red");
          showPopup(msg, true);
          return;
        }
      }

      if (submitTaskBtn) submitTaskBtn.disabled = true;
      if (removeBtn) removeBtn.disabled = true;

      try {
        const formData = new FormData(submitForm);
        const response = await fetch(window.location.href, {
          method: "POST",
          body: formData
        });

        // Safety: check if response is ok
        if (!response.ok) throw new Error("Server error (HTTP " + response.status + ")");

        // Check if redirected (session expired)
        if (response.redirected) {
          throw new Error("Session expired. Please refresh the page and try again.");
        }

        // Check if response is JSON
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
          throw new Error("Session expired or invalid response. Please refresh the page and try again.");
        }

        const data = await response.json();
        console.log("Server data:", data);

        if (data.status === "success") {
          localStorage.setItem("taskSubmitted", "true");
          setFileMsg("submitted", "green");
          window.scrollTo({ top: 0, behavior: "smooth" });
          window.location.reload();
        } else {
          throw new Error(data.message || "Upload failed");
        }
      } catch (err) {
        console.error("Submission failed:", err);
        if (submitTaskBtn) submitTaskBtn.disabled = false;
        if (removeBtn) removeBtn.disabled = false;

        const msg = err.message || "Upload failed";
        setFileMsg(msg, "red");
        showPopup(msg, true);
      }
    });
  }

  /* =========================
     Other logic (Materials / Feedback)
  ========================= */
  const categoryBtns = document.querySelectorAll(".materialCategoryBtn");
  categoryBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      categoryBtns.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      document.querySelectorAll(".materialsList").forEach(list => list.classList.remove("activeMaterialsList"));
      const target = document.getElementById(btn.dataset.category);
      if (target) target.classList.add("activeMaterialsList");
    });
  });

  const modal = document.getElementById("feedbackModal");
  window.closeFeedbackModal = () => modal?.classList.remove("show");
  document.querySelectorAll(".feedbackBtn").forEach(btn => {
    btn.addEventListener("click", () => {
      if (!modal) return;
      document.getElementById("feedbackSessionName").textContent = btn.dataset.session || "Session";
      document.getElementById("feedbackText").innerHTML = `<p>${btn.dataset.feedback || 'No feedback'}</p>`;
      const stars = document.getElementById("feedbackRatingStars");
      if (stars) {
        stars.innerHTML = "";
        const r = Number(btn.dataset.rating) || 0;
        for (let i = 1; i <= 5; i++) {
          const star = document.createElement("i");
          star.className = i <= r ? "fas fa-star" : "far fa-star";
          stars.appendChild(star);
        }
      }
      document.getElementById("feedbackInstructorName").textContent = btn.dataset.instructor || "-";
      modal.classList.add("show");
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });

  document.addEventListener("click", (e) => { if (e.target === modal) modal.classList.remove("show"); });

  /* =========================
     Delete Submission (Custom Confirm)
  ========================= */
  const deleteModal = document.getElementById("deleteConfirmPopup");
  const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
  let submissionToDelete = null;

  window.deleteSubmission = function (id) {
    if (!id) return;
    submissionToDelete = id;
    if (deleteModal) deleteModal.classList.add("show");
  };

  window.closeDeleteConfirm = function () {
    if (deleteModal) deleteModal.classList.remove("show");
    submissionToDelete = null;
  };

  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", () => {
      if (submissionToDelete) {
        const url = new URL(window.location.href);
        url.searchParams.set("delete_submission_id", submissionToDelete);
        window.location.href = url.toString();
      }
    });
  }

  // Close delete modal if clicking outside
  if (deleteModal) {
    deleteModal.addEventListener("click", (e) => {
      if (e.target === deleteModal) closeDeleteConfirm();
    });
  }
});