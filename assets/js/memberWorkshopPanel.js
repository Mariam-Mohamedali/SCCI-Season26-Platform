document.addEventListener("DOMContentLoaded", () => {
  /* =========================================================
     1) MINI NAV TABS
  ========================================================= */
  const links = document.querySelectorAll(".miniNav a");
  const pages = document.querySelectorAll(".panelSection");

  function getActiveTab() {
    const urlTab = new URLSearchParams(window.location.search).get("tab");
    return (
      urlTab ||
      localStorage.getItem("activePanel") ||
      links[0]?.dataset.page ||
      "evaluate"
    );
  }

  function activatePage(pageId) {
    if (!pageId) return;

    // activate nav link
    links.forEach((link) => {
      link.classList.toggle("activePanelLine", link.dataset.page === pageId);
    });

    // activate panel section
    pages.forEach((page) => {
      page.classList.toggle("panelSectionActive", page.id === pageId);
    });

    // save active tab
    localStorage.setItem("activePanel", pageId);

    // update url without reload (keep session_id, etc.)
    const url = new URL(window.location.href);
    url.searchParams.set("tab", pageId);
    history.replaceState({}, "", url.toString());

    // NEW: Update all hidden tab inputs on the page to match active tab
    document.querySelectorAll('input[name="tab"]').forEach((input) => {
      input.value = pageId;
    });
  }

  // click handlers for tabs
  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      activatePage(link.dataset.page);
    });
  });

  // restore tab on load
  const candidate = getActiveTab();
  if (candidate && document.getElementById(candidate)) {
    activatePage(candidate);
  } else {
    const firstPage = links[0]?.dataset.page;
    if (firstPage) activatePage(firstPage);
  }

  /* =========================================================
     2) KEEP SAME TAB WHEN CLICKING SESSIONS
     - Your PHP makes href '?session_id=X&tab=evaluate'
     - We override it here to go with current active tab
  ========================================================= */
  document.querySelectorAll(".sessionBtn").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      // only handle anchors
      if (btn.tagName.toLowerCase() !== "a") return;

      e.preventDefault();

      const currentTab =
        localStorage.getItem("activePanel") ||
        new URLSearchParams(window.location.search).get("tab") ||
        "evaluate";

      // parse session_id from the button href
      const href = btn.getAttribute("href") || "";
      const tmp = new URL(href, window.location.origin);
      const sid = tmp.searchParams.get("session_id");

      // build new url keeping SAME TAB
      const url = new URL(window.location.href);
      if (sid) url.searchParams.set("session_id", sid);
      url.searchParams.set("tab", currentTab);

      window.location.href = url.toString();
    });
  });

  /* =========================================================
     3) POPUPS OPEN/CLOSE (Feedback modal + review popups)
  ========================================================= */
  // Open popup
  document.querySelectorAll(".evaluateFeedback").forEach((btn) => {
    btn.addEventListener("click", () => {
      const popupId = btn.dataset.popup;
      if (!popupId) return;

      const popup = document.getElementById(popupId);
      if (!popup) return;

      // if this button has submission id -> put it in hidden input
      const submissionId = btn.dataset.submissionId;
      const submissionInput = document.getElementById("submissionIdInput");
      if (submissionId && submissionInput) {
        submissionInput.value = submissionId;
      }

      popup.classList.add("active");
      document.body.classList.add("no-scroll");
    });
  });

  // Close popup (X button)
  document.addEventListener("click", (e) => {
    if (
      e.target.closest(".closeFeedback") ||
      e.target.closest(".modalCancelBtn")
    ) {
      const popup = e.target.closest(".reviewFeedbackPopup");
      if (!popup) return;

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

  // Escape key closes any active popup
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

  /* =========================================================
     4) SESSIONS SCROLL & PERSISTENCE
  ========================================================= */
  const PERSIST_KEY_PAGE = "member_scroll_page";
  const PERSIST_KEY_SESSIONS = "member_scroll_sessions";

  (function initSessionsScroll() {
    const frames = document.querySelectorAll(".sessionsSelectorFrame");
    if (!frames.length) return;

    frames.forEach((frame) => {
      const selector = frame.querySelector(".sessionsSelector");
      const leftBtn = frame.querySelector(
        ".scrollLeft, .scrollBtn.leftBtn, .scrollBtn.left",
      );
      const rightBtn = frame.querySelector(
        ".scrollRight, .scrollBtn.rightBtn, .scrollBtn.right",
      );

      if (!selector) return;

      // Restore session scroll
      const savedSessionsScroll = localStorage.getItem(PERSIST_KEY_SESSIONS);
      if (savedSessionsScroll) {
        selector.scrollLeft = parseInt(savedSessionsScroll, 10);
      }

      // Save session scroll on change
      selector.addEventListener("scroll", () => {
        localStorage.setItem(PERSIST_KEY_SESSIONS, selector.scrollLeft);
      });

      const scrollByAmount = 320;

      if (leftBtn) {
        leftBtn.addEventListener("click", (e) => {
          e.preventDefault();
          selector.scrollBy({ left: -scrollByAmount, behavior: "smooth" });
        });
      }

      if (rightBtn) {
        rightBtn.addEventListener("click", (e) => {
          e.preventDefault();
          selector.scrollBy({ left: scrollByAmount, behavior: "smooth" });
        });
      }
    });
  })();

  // Restore Page Scroll
  const savedPageScroll = localStorage.getItem(PERSIST_KEY_PAGE);
  if (savedPageScroll) {
    // We use a small timeout to ensure everything is rendered
    setTimeout(() => {
      window.scrollTo({ top: parseInt(savedPageScroll, 10), behavior: "instant" });
    }, 50);
  }

  // Save Page Scroll on scroll (debounced or constant)
  window.addEventListener("scroll", () => {
    localStorage.setItem(PERSIST_KEY_PAGE, window.scrollY);
  });

  /* =========================================================
     5) ATTENDANCE AUTO SUBMIT (AJAX)
  ========================================================= */

  // A helper to get dynamic parameters from URL (needed for UI reconstruction)
  function getUrlParam(name) {
    return new URLSearchParams(window.location.search).get(name) || "";
  }

  // Sync Review Tab without refresh
  function syncReviewTab(userId, status) {
    const row = document.querySelector(`.reviewRow[data-user-id="${userId}"]`);
    if (!row) return;

    // Update data attribute (for filters)
    row.dataset.attendance = status;

    // Find the attendance cell (usually second column)
    const cell = row.cells[1];
    if (!cell) return;

    if (status === 'present') {
      cell.innerHTML = `
        <div class="reviewAttended">
          <div class="reviewAttendBox">
            <div class="reviewAttendedSymbol">✓</div>
          </div>
          Attended
        </div>
      `;
    } else {
      cell.innerHTML = `
        <div class="reviewAbsent">
          <div class="reviewAttendBox">
            <div class="reviewAttendedSymbol">✗</div>
          </div>
          Absent
        </div>
      `;
    }
  }

  // 1. Mark Attendance AJAX
  document.addEventListener("change", (e) => {
    const input = e.target;
    if (input && input.type === "radio" && input.name === "status") {
      const form = input.closest("form");
      if (!form || !form.classList.contains("attendanceForm")) return;

      const formData = new FormData(form);
      formData.append("ajax", "1");

      const participantId = formData.get("participant_id");
      const status = formData.get("status");

      fetch("memberWorkshopPanel.php", {
        method: "POST",
        body: formData
      })
        .then(r => r.json())
        .then(data => {
          if (data.status === "success") {
            // Sync Review Tab
            syncReviewTab(participantId, status);
            // Success Feedback
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                icon: 'success',
                title: 'Saved!',
                timer: 1000,
                showConfirmButton: false
              });
            }

            // Reconstruct the "Attendance Saved" state in the cell
            const container = form.parentElement;
            container.innerHTML = `
            <div class="attendanceInfo">
              <span class="attendance-saved-text">Attendance Saved</span>
              <form action="" method="POST" class="attendanceResetForm">
                <input type="hidden" name="user_id" value="${participantId}">
                <button class="resetAttendance" type="submit" name="resetAttendance"><i class="fa-solid fa-arrow-rotate-left"></i> Reset Attendance</button>
              </form>
            </div>
          `;
          }
        })
        .catch(console.error);
    }
  });

  // 2. Reset Attendance AJAX
  document.addEventListener("click", (e) => {
    const resetBtn = e.target.closest(".resetAttendance");
    if (!resetBtn) return;

    const form = resetBtn.closest("form");
    if (!form) return;

    e.preventDefault();

    const formData = new FormData(form);
    formData.append("ajax", "1");
    // Ensure the key exists even if button name is used by PHP
    formData.append("resetAttendance", "1");

    const userId = formData.get("user_id");
    const sid = getUrlParam("session_id");
    const tab = getUrlParam("tab") || "evaluate";

    fetch("memberWorkshopPanel.php", {
      method: "POST",
      body: formData
    })
      .then(r => r.json())
      .then(data => {
        if (data.status === "success") {
          // Sync Review Tab (reset to absent)
          syncReviewTab(userId, 'absent');
          // Reconstruct the radio buttons form
          const cell = form.closest("td") || form.parentElement.parentElement;
          cell.innerHTML = `
          <form method="POST" class="attendanceForm">
            <input type="hidden" name="action" value="mark_attendance">
            <input type="hidden" name="participant_id" value="${userId}">
            <input type="hidden" name="tab" value="${tab}">
            <input type="hidden" name="session_id" value="${sid}">
            <div class="evaluateTaskRow">
              <label class="radioOption">
                <input type="radio" name="status" value="present" />
                <div class="evaluateAttendanceCircle evaluateCheckTask">
                  <i class="fa-solid fa-check"></i>
                </div>
              </label>

              <label class="radioOption">
                <input type="radio" name="status" value="absent" />
                <div class="evaluateAttendanceCircle evaluateXtask">
                  <i class="fa-solid fa-x"></i>
                </div>
              </label>
            </div>
            <button type="submit" class="btn btn-primary btn-sm attendanceSubmit"
              style="display: none;">Save</button>
          </form>
        `;
        }
      })
      .catch(console.error);
  });

  /* =========================================================
     6) FEEDBACK STARS (modal)
  ========================================================= */
  const ratingInput = document.getElementById("ratingValue");
  const stars = document.querySelectorAll(".feedbackStarsInput .feedbackStars");

  if (ratingInput && stars.length) {
    const defaultRating = 1;
    ratingInput.value = defaultRating;

    // render default
    stars.forEach((star) => {
      const value = Number(star.dataset.rating || 0);
      star.classList.toggle("fa-solid", value <= defaultRating);
      star.classList.toggle("fa-regular", value > defaultRating);
    });

    document.addEventListener("click", (e) => {
      const star = e.target.closest(".feedbackStars");
      if (!star) return;

      const rating = Number(star.dataset.rating || 0);
      ratingInput.value = rating;

      const wrapper = star.closest(".feedbackStarsInput");
      const all = wrapper.querySelectorAll(".feedbackStars");
      all.forEach((s) => {
        const v = Number(s.dataset.rating || 0);
        if (v <= rating) {
          s.classList.remove("fa-regular");
          s.classList.add("fa-solid");
        } else {
          s.classList.remove("fa-solid");
          s.classList.add("fa-regular");
        }
      });
    });
  }

  /* =========================================================
     7) FEEDBACK FORM VALIDATION
  ========================================================= */
  const feedbackForm = document.getElementById("feedbackForm");
  if (feedbackForm) {
    feedbackForm.addEventListener("submit", (event) => {
      const text = document.getElementById("feedback_text")?.value.trim() || "";
      const msg = document.getElementById("feedbackTextMsg");
      if (msg) msg.textContent = "";

      if (!text) {
        event.preventDefault();
        if (msg) {
          msg.textContent = "feedback is required";
          msg.style.color = "red";
          msg.style.fontSize = "12px";
        }
      }
    });
  }

  /* =========================================================
     8) FILE UPLOAD UI
  ========================================================= */

  // ✅ CHANGE: allowed extensions list (minimal)
  const MAX_FILE_SIZE = 20 * 1024 * 1024; // 20 MB

  const ALLOWED_EXT = ["pdf", "doc", "docx", "png", "jpg", "jpeg", "zip", "ppt", "pptx", "xls", "xlsx", "csv", "txt", "rar"];

  document.querySelectorAll(".fileUpload").forEach((container) => {
    const fileInput = container.querySelector("input[type='file']");
    const fileState = container.querySelector(".uploadText");
    const fileUploadedName = container.querySelector(".fileUploadedName");
    const fileUploadInfo = container.querySelector(".fileUploadInfo");
    const removeBtn = container.querySelector(".removeUpload");
    const fileMessage = container.querySelector(".fileMessage");
    const uploadBtn = container.querySelector(".uploadBtn");

    if (!fileInput) return;

    fileInput.addEventListener("change", function () {
      const file = this.files[0];

      if (!file) {
        reset();
        return;
      }

      // ✅ CHANGE: block unsupported file types + show message in .uploadText (red)
      const ext = (file.name.split(".").pop() || "").toLowerCase();
      if (!ALLOWED_EXT.includes(ext)) {
        this.value = ""; // clear invalid file
        reset();
        if (fileState) {
          fileState.textContent = "This file isn't supported";
          fileState.style.color = "red";
        }
        return;
      }

      // show uploaded info
      // ✅ check file extension
      const extT = (file.name.split(".").pop() || "").toLowerCase();
      if (!ALLOWED_EXT.includes(extT)) {
        this.value = "";
        reset();
        if (fileState) {
          fileState.textContent = "This file type is not supported";
          fileState.style.color = "red";
        }
        return;
      }

      // ✅ check file size
      if (file.size > MAX_FILE_SIZE) {
        this.value = "";
        reset();
        if (fileState) {
          fileState.textContent = "File size must be less than 20MB";
          fileState.style.color = "red";
        }
        return;
      }

      // ✅ show uploaded info
      if (fileUploadedName) {
        fileUploadedName.textContent = file.name;
        fileUploadedName.style.display = "block";
      }


      if (fileUploadInfo) fileUploadInfo.style.display = "flex";
      if (removeBtn) removeBtn.style.display = "inline-block";
      if (uploadBtn) uploadBtn.style.display = "none";

      if (fileState) {
        fileState.textContent = "File Uploaded Successfully!";
        fileState.style.color = "green";
      }

      if (fileMessage) fileMessage.textContent = "";
    });

    removeBtn?.addEventListener("click", () => {
      fileInput.value = "";
      reset();
    });

    function reset() {
      if (fileUploadedName) {
        fileUploadedName.textContent = "";
        fileUploadedName.style.display = "none";
      }

      if (fileUploadInfo) fileUploadInfo.style.display = "none";
      if (removeBtn) removeBtn.style.display = "none";
      if (uploadBtn) uploadBtn.style.display = "inline-block";

      if (fileState) {
        fileState.textContent = "Drag and drop or click to browse";
        fileState.style.color = "";
      }
    }
  });

  // ✅ Mutual Exclusivity: File OR URL (not both)
  document.querySelectorAll("form.validForm").forEach((form) => {
    const fileInput = form.querySelector("input[type='file']");
    const urlInput = form.querySelector("input[name='task_url']") || form.querySelector("input[name='material_url']");
    const uploadBtn = form.querySelector(".uploadBtn") || form.querySelector("label[for='material_file']");
    const uploadContainer = form.querySelector(".uploadContainer");

    if (!fileInput || !urlInput) return;

    // If typing in URL field -> clear and disable file input
    urlInput.addEventListener("input", function () {
      if (this.value.trim() !== "") {
        fileInput.value = "";
        // Reset file UI if exists
        const fileState = form.querySelector(".uploadText");
        const fileInfo = form.querySelector(".fileUploadInfo");
        if (fileState) fileState.textContent = "File upload disabled (URL provided)";
        if (fileInfo) fileInfo.style.display = "none";
        if (uploadContainer) uploadContainer.style.opacity = "0.5";
        if (uploadBtn) uploadBtn.style.pointerEvents = "none";
      } else {
        const fileState = form.querySelector(".uploadText");
        if (fileState) fileState.textContent = "Drag and drop or click to browse";
        if (uploadContainer) uploadContainer.style.opacity = "1";
        if (uploadBtn) uploadBtn.style.pointerEvents = "auto";
      }
    });

    // If selecting file -> clear and disable URL input
    fileInput.addEventListener("change", function () {
      if (this.files.length > 0) {
        urlInput.value = "";
        urlInput.placeholder = "URL disabled (File selected)";
        urlInput.style.backgroundColor = "#f0f0f0";
        urlInput.readOnly = true;
      } else {
        urlInput.placeholder = "https://example.com/...";
        urlInput.style.backgroundColor = "";
        urlInput.readOnly = false;
      }
    });

    // Reset button in your existing code for files should also re-enable URL
    const removeBtn = form.querySelector(".removeUpload");
    if (removeBtn) {
      removeBtn.addEventListener("click", () => {
        urlInput.placeholder = "https://example.com/...";
        urlInput.style.backgroundColor = "";
        urlInput.readOnly = false;
      });
    }
  });

  // Drag & Drop support
  document.querySelectorAll(".fileUpload").forEach((container) => {
    const fileInput = container.querySelector("input[type='file']");
    const dropArea = container.querySelector(".uploadContainer");
    const dropMessage = container.querySelector(".dragMessage");

    if (!fileInput || !dropArea) return;

    // prevent default browser behavior
    ["dragenter", "dragover", "dragleave", "drop"].forEach((event) => {
      dropArea.addEventListener(event, (e) => {
        e.preventDefault();
        e.stopPropagation();
      });
    });

    dropArea.addEventListener("dragover", () => {
      dropArea.classList.add("dragOver");
      dropMessage.style.display = "block";
    });

    dropArea.addEventListener("dragleave", () => {
      dropArea.classList.remove("dragOver");
      dropMessage.style.display = "none";
    });

    dropArea.addEventListener("drop", (e) => {
      dropArea.classList.remove("dragOver");
      dropMessage.style.display = "none";

      const files = e.dataTransfer.files;
      if (!files.length) return;

      fileInput.files = files;

      fileInput.dispatchEvent(new Event("change"));
    });
  });

  /* =========================================================
     9) FORMS VALIDATION (Add Task / Add Material)
  ========================================================= */
  document.querySelectorAll("form.validForm").forEach((form) => {
    form.addEventListener("submit", function (event) {
      let isValid = true;

      const nameEl =
        form.querySelector("input[name='taskName']") ||
        form.querySelector("input[name='material_title']");
      const nameVal = nameEl ? nameEl.value.trim() : "";

      // messages
      const taskNameMessage = form.querySelector("#taskNameMessage");
      const fileMessage = form.querySelector(".fileMessage");
      const taskBioMessage = form.querySelector("#taskBioMessage");
      const taskDeadlineMessage = form.querySelector("#taskDeadlineMessage");

      // reset
      if (taskNameMessage) taskNameMessage.textContent = "";
      if (taskBioMessage) taskBioMessage.textContent = "";
      if (taskDeadlineMessage) taskDeadlineMessage.textContent = "";

      if (!nameVal) {
        isValid = false;
        if (fileMessage) {
          taskNameMessage.textContent = "This field is required.";
          taskNameMessage.style.color = "red";
          taskNameMessage.style.fontSize = "12px";
        }
      }

      // file input validation (works for both forms)
      const fileInput = form.querySelector("input[type='file']");
      const urlInput = form.querySelector("input[name='task_url']") || form.querySelector("input[name='material_url']");
      const urlVal = urlInput ? urlInput.value.trim() : "";

      if (fileMessage) fileMessage.textContent = "";

      if (fileInput && fileInput.files.length === 0 && !urlVal) {
        isValid = false;
        if (fileMessage) {
          fileMessage.textContent = "Please upload a file or provide a URL.";
          fileMessage.style.color = "red";
          fileMessage.style.fontSize = "12px";
        }
      }

      // ✅ CHANGE: block submit if file type is unsupported (minimal)
      if (fileInput && fileInput.files.length > 0) {
        const f = fileInput.files[0];
        const ext = (f.name.split(".").pop() || "").toLowerCase();
        if (!ALLOWED_EXT.includes(ext)) {
          isValid = false;
          const fileState = form.querySelector(".uploadText");
          if (fileState) {
            fileState.textContent = "This file isn't supported";
            fileState.style.color = "red";
          }
        }
      }

      // task-only fields
      const deadlineEl = form.querySelector("input[name='taskDeadline']");
      const bioEl = form.querySelector("textarea[name='taskBio']");

      if (deadlineEl && !deadlineEl.value) {
        isValid = false;
        if (taskDeadlineMessage) {
          taskDeadlineMessage.textContent = "Deadline is required.";
          taskDeadlineMessage.style.color = "red";
          taskDeadlineMessage.style.fontSize = "12px";
        }
      }

      if (bioEl && !bioEl.value.trim()) {
        isValid = false;
        if (taskBioMessage) {
          taskBioMessage.textContent = "Description is required.";
          taskBioMessage.style.color = "red";
          taskBioMessage.style.fontSize = "12px";
        }
      }

      if (!isValid) event.preventDefault();
    });
  });


  /* =========================================================
     10) MATERIAL TYPE FILTERING
  ========================================================= */
  const filterButtons = document.querySelectorAll(".materialTypeButton");
  const materialSections = document.querySelectorAll(
    ".materialCategorySection",
  );

  if (filterButtons.length && materialSections.length) {
    filterButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const filter = button.dataset.filter;

        filterButtons.forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");

        materialSections.forEach((section) => {
          if (filter === "technical" && section.id === "techMaterials") {
            section.style.display = "block";
          } else if (filter === "soft" && section.id === "softMaterials") {
            section.style.display = "block";
          } else {
            section.style.display = "none";
          }
        });
      });
    });

    // default
    filterButtons[0].click();
  }

  /* =========================================================
     11) REVIEW TABLE FILTERS (Attendance + Task Status)
  ========================================================= */
  const reviewFilterBtns = document.querySelectorAll(".reviewFilters .filterBtn");
  const reviewRows = document.querySelectorAll(".reviewRow");

  if (reviewFilterBtns.length && reviewRows.length) {
    let attendanceFilter = "all";
    let taskFilter = "all";

    function applyReviewFilters() {
      reviewRows.forEach((row) => {
        const attStatus = row.dataset.attendance; // "present", "absent"
        const taskStatus = row.dataset.taskStatus; // "accepted", "pending"

        // check attendance
        const attMatch =
          attendanceFilter === "all" || attStatus === attendanceFilter;

        // check task
        const taskMatch = taskFilter === "all" || taskStatus === taskFilter;

        if (attMatch && taskMatch) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    }

    reviewFilterBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const group = btn.dataset.group; // "attendance" or "task"
        const value = btn.dataset.value;

        // update active class in this group
        const groupBtns = document.querySelectorAll(
          `.reviewFilters .filterBtn[data-group='${group}']`
        );
        groupBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        // update state
        if (group === "attendance") {
          attendanceFilter = value;
        } else if (group === "task") {
          taskFilter = value;
        }

        applyReviewFilters();
      });
    });
  }

  console.log("memberWorkshopPanel.js loaded ✅");
});

/* =========================================================
   DELETE FUNCTIONS (global)
========================================================= */
const deleteModal = document.getElementById("deleteConfirmPopup");
const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
const deleteConfirmTitle = document.getElementById("deleteConfirmTitle");
const deleteConfirmMsg = document.getElementById("deleteConfirmMsg");
let deleteId = null;
let deleteType = null;

window.deleteTask = function (taskId) {
  if (!taskId) return;
  deleteId = taskId;
  deleteType = "task";
  if (deleteConfirmTitle) deleteConfirmTitle.textContent = "Delete Task?";
  if (deleteConfirmMsg) deleteConfirmMsg.textContent = "This action cannot be undone. All task submissions will be affected.";
  if (deleteModal) {
    deleteModal.classList.add("show");
    document.body.classList.add("no-scroll");
  }
};

window.deleteMaterial = function (materialId) {
  if (!materialId) return;
  deleteId = materialId;
  deleteType = "material";
  if (deleteConfirmTitle) deleteConfirmTitle.textContent = "Delete Material?";
  if (deleteConfirmMsg) deleteConfirmMsg.textContent = "Are you sure you want to delete this material? This action cannot be undone.";
  if (deleteModal) {
    deleteModal.classList.add("show");
    document.body.classList.add("no-scroll");
  }
};

window.closeDeleteConfirm = function () {
  if (deleteModal) {
    deleteModal.classList.remove("show");
    document.body.classList.remove("no-scroll");
  }
  deleteId = null;
  deleteType = null;
};

if (confirmDeleteBtn) {
  confirmDeleteBtn.addEventListener("click", () => {
    if (deleteId && deleteType) {
      const url = new URL(window.location.href);
      if (deleteType === "task") {
        url.searchParams.set("delete_task_id", deleteId);
      } else {
        url.searchParams.set("delete_material_id", deleteId);
      }
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

/* =========================================================
   FORM MESSAGE
========================================= */

/* =========================================================
   12) GLOBAL CUSTOM POPUP
   ========================================================= */
window.displayCustomPopup = function (message, isError = false) {
  const popup = document.querySelector(".submitPopup");
  if (!popup) return;

  // Clear children but preserve the close button
  const closeBtn = popup.querySelector('.popupSubmitClose');
  popup.textContent = message;

  if (closeBtn) {
    popup.appendChild(closeBtn);
    // Ensure event listener is attached
    closeBtn.onclick = function () {
      popup.style.display = 'none';
    };
  }

  if (isError) {
    popup.style.borderColor = "#d64141";
  } else {
    popup.style.borderColor = "#73e081";
  }

  popup.style.display = "flex";

  // Clear any existing timeout to prevent early closing
  if (popup.dataset.timeoutId) {
    clearTimeout(popup.dataset.timeoutId);
  }

  const timeoutId = setTimeout(() => {
    popup.style.display = "none";
  }, 2000);

  popup.dataset.timeoutId = timeoutId;
};
