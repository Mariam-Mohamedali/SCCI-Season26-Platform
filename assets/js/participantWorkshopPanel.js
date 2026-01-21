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
       Sessions Scroll
    ========================= */
    const sessionsContainer = document.getElementById("sessionsContainer");
    const leftBtn = document.querySelector(".scrollBtn.leftBtn");
    const rightBtn = document.querySelector(".scrollBtn.rightBtn");
    if (sessionsContainer && leftBtn && rightBtn) {
        leftBtn.addEventListener("click", () => sessionsContainer.scrollBy({ left: -300, behavior: "smooth" }));
        rightBtn.addEventListener("click", () => sessionsContainer.scrollBy({ left: 300, behavior: "smooth" }));
    }

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

    if (fileInput) {
        fileInput.addEventListener("change", () => {
            updateFileUI(fileInput.files[0] || null);
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

            if (!fileInput.files[0]) {
                setFileMsg("Please select a file.", "red");
                return;
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

                const data = await response.json();
                console.log("Server data:", data);

                if (data.status === "success") {
                    setFileMsg("submitted", "green");
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    throw new Error(data.message || "Upload failed");
                }
            } catch (err) {
                console.error("Submission failed:", err);
                if (submitTaskBtn) submitTaskBtn.disabled = false;
                if (removeBtn) removeBtn.disabled = false;

                const msg = err.message || "Upload failed";
                setFileMsg(msg, "red");

                if (typeof Swal !== "undefined") {
                    Swal.fire({ icon: "error", title: "Error", text: msg });
                } else {
                    alert("Error: " + msg);
                }
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
});