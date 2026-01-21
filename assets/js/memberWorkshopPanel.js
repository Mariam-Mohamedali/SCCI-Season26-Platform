document.addEventListener("DOMContentLoaded", () => {
  /* =========================
     Mini Nav Tabs
  ========================= */
  const links = document.querySelectorAll(".miniNav a[data-page]");
  const pages = document.querySelectorAll(".panelSection");

  function activatePage(pageId) {
    links.forEach((link) => {
      link.classList.toggle("activePanelLine", link.dataset.page === pageId);
    });

    pages.forEach((page) => {
      page.classList.toggle("panelSectionActive", page.id === pageId);
    });

    // save + sync url
    localStorage.setItem("activePanel", pageId);
    const url = new URL(window.location.href);
    url.searchParams.set("tab", pageId);
    history.replaceState({}, "", url.toString());
  }

  // click tabs
  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      activatePage(link.dataset.page);
    });
  });

  // restore
  const urlTab = new URLSearchParams(window.location.search).get("tab");
  const savedPanel = localStorage.getItem("activePanel");
  const defaultTab = links.length ? links[0].dataset.page : null;
  const candidate = urlTab || savedPanel || defaultTab;

  if (candidate && document.getElementById(candidate)) activatePage(candidate);

  /* =========================
     Popups (open/close)
  ========================= */
  function openPopup(popupId) {
    const popup = document.getElementById(popupId);
    if (!popup) return;
    popup.classList.add("active");
    document.body.classList.add("no-scroll");
  }

  function closePopup(popupEl) {
    if (!popupEl) return;
    popupEl.classList.remove("active");
    document.body.classList.remove("no-scroll");
  }

  // open any popup from button[data-popup]
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".evaluateFeedback");
    if (!btn) return;

    const popupId = btn.dataset.popup;
    if (!popupId) return;

    // if opening feedback modal, set submission id
    if (popupId === "feedbackModal") {
      const submissionId = btn.dataset.submissionId || "0";
      const input = document.getElementById("submissionIdInput");
      if (input) input.value = submissionId;

      // reset fields + messages
      const txt = document.getElementById("feedback_text");
      const ratingValue = document.getElementById("ratingValue");
      if (txt) txt.value = "";
      if (ratingValue) ratingValue.value = "0";

      setErr("feedbackTextMsg", "");
      setErr("ratingMsg", "");
      setOk("feedbackOkMsg", "");
      resetStars();
    }

    openPopup(popupId);
  });

  // close popup by X / cancel
  document.addEventListener("click", (e) => {
    if (e.target.closest(".closeFeedback") || e.target.closest(".modalCancelBtn")) {
      const popup = e.target.closest(".reviewFeedbackPopup");
      closePopup(popup);
    }
  });

  // close by overlay
  document.querySelectorAll(".reviewFeedbackPopup").forEach((popup) => {
    popup.addEventListener("click", (e) => {
      if (e.target === popup) closePopup(popup);
    });
  });

  // close by Esc
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      document.querySelectorAll(".reviewFeedbackPopup.active").forEach((p) => p.classList.remove("active"));
      document.body.classList.remove("no-scroll");
    }
  });

  /* =========================
     Attendance auto-submit
  ========================= */
  document.addEventListener("change", (e) => {
    if (e.target?.type === "radio" && e.target.name === "status") {
      const form = e.target.closest("form");
      if (form) form.submit();
    }
  });

  /* =========================
     Feedback stars
  ========================= */
  function resetStars() {
    document.querySelectorAll(".feedbackStarsInput .feedbackStars").forEach((s) => {
      s.classList.remove("fa-solid");
      s.classList.add("fa-regular");
    });
  }

  document.addEventListener("click", (e) => {
    const star = e.target.closest(".feedbackStars");
    if (!star) return;

    const rating = Number(star.dataset.rating || 0);
    const ratingInput = document.getElementById("ratingValue");
    if (ratingInput) ratingInput.value = String(rating);

    // fill stars
    star.closest(".feedbackStarsInput")
      ?.querySelectorAll(".feedbackStars")
      .forEach((s) => {
        const val = Number(s.dataset.rating || 0);
        if (val <= rating) {
          s.classList.remove("fa-regular");
          s.classList.add("fa-solid");
        } else {
          s.classList.remove("fa-solid");
          s.classList.add("fa-regular");
        }
      });

    setErr("ratingMsg", "");
  });

  /* =========================
     Helpers: messages
  ========================= */
  function setErr(id, text) {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = text;
    el.style.color = text ? "red" : "";
    el.style.fontSize = "12px";
  }

  function setOk(id, text) {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = text;
    el.style.color = text ? "green" : "";
    el.style.fontSize = "12px";
  }

  /* =========================
     Feedback form validation
  ========================= */
  const feedbackForm = document.getElementById("feedbackForm");
  if (feedbackForm) {
    feedbackForm.addEventListener("submit", (e) => {
      let ok = true;

      const submissionId = Number(document.getElementById("submissionIdInput")?.value || 0);
      const feedbackText = (document.getElementById("feedback_text")?.value || "").trim();
      const rating = Number(document.getElementById("ratingValue")?.value || 0);

      setErr("feedbackTextMsg", "");
      setErr("ratingMsg", "");
      setOk("feedbackOkMsg", "");

      if (submissionId <= 0) {
        ok = false;
        setErr("feedbackTextMsg", "Submission id missing. Close & open the modal again.");
      }
      if (!feedbackText) {
        ok = false;
        setErr("feedbackTextMsg", "Feedback is required.");
      }
      if (rating < 1 || rating > 5) {
        ok = false;
        setErr("ratingMsg", "Rating must be 1 to 5.");
      }

      if (!ok) {
        e.preventDefault();
        return;
      }

      setOk("feedbackOkMsg", "Saving...");
    });
  }

  /* =========================
     Upload UI (Task + Material)
     - works per .fileUpload container
  ========================= */
  document.querySelectorAll(".fileUpload").forEach((container) => {
    const fileInput = container.querySelector(".taskFileInput");
    const fileState = container.querySelector(".uploadText");
    const fileUploadedName = container.querySelector(".fileUploadedName");
    const fileMessage = container.querySelector(".fileMessage");
    const uploadBtn = container.querySelector(".uploadBtn"); // ✅ FIX

    if (uploadBtn && fileInput) {
      uploadBtn.addEventListener("click", () => fileInput.click());
    }

    if (fileInput) {
      fileInput.addEventListener("change", function () {
        const file = this.files && this.files[0];

        if (file) {
          if (fileUploadedName) {
            fileUploadedName.textContent = file.name;
            fileUploadedName.style.display = "block";
          }
          if (fileState) {
            fileState.textContent = "File Uploaded Successfully!";
            fileState.style.color = "green";
          }
          if (fileMessage) fileMessage.textContent = "";
        } else {
          if (fileUploadedName) {
            fileUploadedName.textContent = "";
            fileUploadedName.style.display = "none";
          }
          if (fileState) {
            fileState.textContent = "Drag and drop or click to browse";
            fileState.style.color = "";
          }
        }
      });
    }
  });

  /* =========================
     Task Form validation
  ========================= */
  const taskForm = document.querySelector("form.validForm input[name='action'][value='add_task']")?.closest("form");
  if (taskForm) {
    taskForm.addEventListener("submit", (e) => {
      let ok = true;

      const name = (taskForm.querySelector("input[name='taskName']")?.value || "").trim();
      const deadline = (taskForm.querySelector("input[name='taskDeadline']")?.value || "").trim();
      const bio = (taskForm.querySelector("textarea[name='taskBio']")?.value || "").trim();

      const nameMsg = taskForm.querySelector("#taskNameMessage");
      const deadlineMsg = taskForm.querySelector("#taskDeadlineMessage");
      const bioMsg = taskForm.querySelector("#taskBioMessage");

      if (nameMsg) nameMsg.textContent = "";
      if (deadlineMsg) deadlineMsg.textContent = "";
      if (bioMsg) bioMsg.textContent = "";

      if (!name) { ok = false; if (nameMsg) { nameMsg.textContent = "Task name is required"; nameMsg.style.color="red"; nameMsg.style.fontSize="12px"; } }
      if (!deadline) { ok = false; if (deadlineMsg) { deadlineMsg.textContent = "Deadline is required"; deadlineMsg.style.color="red"; deadlineMsg.style.fontSize="12px"; } }
      if (!bio) { ok = false; if (bioMsg) { bioMsg.textContent = "Description is required"; bioMsg.style.color="red"; bioMsg.style.fontSize="12px"; } }

      if (!ok) e.preventDefault();
    });
  }

  /* =========================
     Material Form validation
  ========================= */
  const materialForm = document.querySelector("form.validForm input[name='action'][value='add_material']")?.closest("form");
  if (materialForm) {
    materialForm.addEventListener("submit", (e) => {
      const title = (materialForm.querySelector("input[name='material_title']")?.value || "").trim();
      const type = (materialForm.querySelector("select[name='material_type']")?.value || "");
      const file = materialForm.querySelector("input[name='material_file']")?.files?.[0];

      // simple validation using alerts (fast + واضح)
      if (!title) { e.preventDefault(); alert("Material title is required"); return; }
      if (!(type === "technical" || type === "soft")) { e.preventDefault(); alert("Choose valid type"); return; }
      if (!file) { e.preventDefault(); alert("Material file is required"); return; }
    });
  }

  /* =========================
     Material filter buttons
  ========================= */
  const filterButtons = document.querySelectorAll(".materialTypeButton");
  const materialSections = document.querySelectorAll(".materialCategorySection");

  filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const filter = button.dataset.filter;

      filterButtons.forEach((b) => b.classList.remove("active"));
      button.classList.add("active");

      materialSections.forEach((section) => {
        if (filter === "technical" && section.id === "techMaterials") section.style.display = "block";
        else if (filter === "soft" && section.id === "softMaterials") section.style.display = "block";
        else section.style.display = "none";
      });
    });
  });

  // default: show tech if exists else show soft
  if (filterButtons.length) filterButtons[0].click();

  console.log("memberWorkshopPanel.js Loaded ✅");
});

/* =========================
   Delete functions (global)
========================= */
function deleteTask(taskId) {
  if (!confirm("Are you sure you want to delete this task?")) return;
  const url = new URL(window.location.href);
  url.searchParams.set("delete_task_id", taskId);
  window.location.href = url.toString();
}

function deleteMaterial(materialId) {
  if (!confirm("Are you sure you want to delete this material?")) return;
  const url = new URL(window.location.href);
  url.searchParams.set("delete_material_id", materialId);
  window.location.href = url.toString();
}
