// participantWorkshopPanel.js
document.addEventListener("DOMContentLoaded", () => {
  /* =========================
     Mini Nav (tabs)
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

    // save + sync url (no reload)
    localStorage.setItem("activePanel", pageId);
    const url = new URL(window.location.href);
    url.searchParams.set("tab", pageId);
    history.replaceState({}, "", url.toString());
  }

  links.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      activatePage(link.dataset.page);
    });
  });

  // restore tab
  const urlTab = new URLSearchParams(window.location.search).get("tab");
  const saved = localStorage.getItem("activePanel");
  const first = links[0]?.dataset.page;
  const candidate = urlTab || saved || first;

  if (candidate && document.getElementById(candidate)) {
    activatePage(candidate);
  }

  /* =========================
     Sessions scroll buttons
     (remove inline onclick usage)
  ========================= */
  const sessionsContainer = document.getElementById("sessionsContainer");
  const leftBtn = document.querySelector(".scrollBtn.leftBtn");
  const rightBtn = document.querySelector(".scrollBtn.rightBtn");

  function scrollSessions(direction) {
    if (!sessionsContainer) return;
    const scrollAmount = 300;
    sessionsContainer.scrollBy({
      left: direction === "left" ? -scrollAmount : scrollAmount,
      behavior: "smooth",
    });
  }

  if (leftBtn) leftBtn.addEventListener("click", (e) => { e.preventDefault(); scrollSessions("left"); });
  if (rightBtn) rightBtn.addEventListener("click", (e) => { e.preventDefault(); scrollSessions("right"); });

  /* =========================
     Submit Task (AJAX upload)
  ========================= */
  const submitForm = document.getElementById("validForm");
  const uploadContainer = document.getElementById("taskUploadContainer");
  const fileInput = document.getElementById("submit_link");

  const fileMessage = document.getElementById("fileMessage");
  const fileState = document.getElementById("fileUploadState");
  const fileUploadedName = document.getElementById("fileUploadedName");

  function setFileMsg(text, color = "red") {
    if (!fileMessage) return;
    fileMessage.textContent = text;
    fileMessage.style.color = color;
  }

  function updateFileUI(file) {
    if (fileState) {
      fileState.textContent = file ? "File Uploaded Successfully!" : "Drag and drop or click to browse";
      fileState.style.color = file ? "green" : "";
    }
    if (fileUploadedName) {
      fileUploadedName.textContent = file ? file.name : "";
      fileUploadedName.style.display = file ? "block" : "none";
    }
    if (fileMessage) fileMessage.textContent = "";
  }

  if (fileInput) {
    fileInput.addEventListener("change", () => {
      const file = fileInput.files?.[0];
      updateFileUI(file || null);
    });
  }

  // drag/drop
  if (uploadContainer && fileInput) {
    ["dragover", "drop"].forEach((ev) => {
      uploadContainer.addEventListener(ev, (e) => {
        e.preventDefault();
        e.stopPropagation();
      });
    });

    uploadContainer.addEventListener("dragover", () => uploadContainer.classList.add("drag-over"));
    uploadContainer.addEventListener("dragleave", () => uploadContainer.classList.remove("drag-over"));

    uploadContainer.addEventListener("drop", (e) => {
      uploadContainer.classList.remove("drag-over");
      const files = e.dataTransfer?.files;
      if (!files || !files.length) return;

      const dt = new DataTransfer();
      dt.items.add(files[0]);
      fileInput.files = dt.files;

      updateFileUI(files[0]);
    });
  }

  // submit via fetch
  if (submitForm) {
    submitForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const file = fileInput?.files?.[0];
      if (!file) {
        setFileMsg("Please upload a file.");
        return;
      }

      setFileMsg("sumbitted", "green");

      try {
        const formData = new FormData(submitForm);
        const res = await fetch(window.location.href, { method: "POST", body: formData });

        // لو السيرفر رجّع HTML بالغلط هتقع هنا
        const data = await res.json();

        if (data.status === "success") {
          Swal.fire({ icon: "success", title: "Done", text: data.message });
          setTimeout(() => window.location.reload(), 700);
        } else {
          Swal.fire({ icon: "error", title: "Error", text: data.message || "Upload failed" });
        }
      } catch (err) {
        console.error(err);
        Swal.fire({ icon: "error", title: "Error", text: "Upload failed (response is not JSON or server error)" });
      }
    });
  }

  /* =========================
     Materials tabs
  ========================= */
  const categoryBtns = document.querySelectorAll(".materialCategoryBtn");
  const materialsLists = document.querySelectorAll(".materialsList");

  categoryBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      categoryBtns.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      const target = btn.dataset.category; // technical / softskills
      materialsLists.forEach((list) => list.classList.remove("activeMaterialsList"));

      const targetList = document.getElementById(target);
      if (targetList) targetList.classList.add("activeMaterialsList");
    });
  });

  /* =========================
     Feedback Modal (review page)
  ========================= */
  const modal = document.getElementById("feedbackModal");

  function openFeedbackModal(sessionName, rating, feedbackText, instructor) {
    if (!modal) return;

    const sessionEl = document.getElementById("feedbackSessionName");
    const textEl = document.getElementById("feedbackText");
    const starsEl = document.getElementById("feedbackRatingStars");
    const instructorEl = document.getElementById("feedbackInstructorName");

    if (sessionEl) sessionEl.textContent = sessionName || "Session";
    if (textEl) textEl.innerHTML = `<p>${feedbackText || "No feedback yet."}</p>`;
    if (instructorEl) instructorEl.textContent = instructor || "—";

    if (starsEl) {
      starsEl.innerHTML = "";
      const r = Number(rating) || 0;
      for (let i = 1; i <= 5; i++) {
        const star = document.createElement("i");
        star.className = i <= r ? "fas fa-star" : "far fa-star";
        starsEl.appendChild(star);
      }
    }

    modal.classList.add("show");
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  function closeFeedbackModal() {
    if (!modal) return;
    modal.classList.remove("show");
  }

  // expose close to onclick button in HTML
  window.closeFeedbackModal = closeFeedbackModal;

  document.querySelectorAll(".feedbackBtn").forEach((btn) => {
    btn.addEventListener("click", () => {
      openFeedbackModal(
        btn.dataset.session,
        btn.dataset.rating,
        btn.dataset.feedback,
        btn.dataset.instructor
      );
    });
  });

  // click outside close
  document.addEventListener("click", (e) => {
    if (modal && e.target === modal) closeFeedbackModal();
  });

  // esc close
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeFeedbackModal();
  });

  console.log("participantWorkshopPanel.js loaded ✅");
});
