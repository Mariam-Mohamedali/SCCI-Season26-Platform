document.addEventListener("DOMContentLoaded", () => {
    /* ================= CONSTANTS & STATE ================= */
    const COMING_SOON_EVENTS = ["outing", "comptition"];
    const EVENT_NAMES = [
        "opening", "ushering", "firstSession", "57357", "outing",
        "midYear", "comptition", "league", "academic", "confrence", "closing"
    ];

    const DEFAULT_EVENT = "opening"; // ← default event

    const eventsData = EVENT_NAMES.reduce((acc, name) => {
        acc[name] = {
            book: { left: `assets/img/${name}/book1.jpg`, right: `assets/img/${name}/book2.jpg` },
            slider: Array.from({ length: 6 }, (_, i) => `assets/img/${name}/slider${i + 1}.jpg`),
            cards: Array.from({ length: 6 }, (_, i) => `assets/img/${name}/card${i + 1}.jpg`)
        };
        return acc;
    }, {});

    const DOM = {
        papers: document.querySelectorAll(".paper"),
        bookSection: document.querySelector(".bookSection"),
        bookLeft: document.getElementById("bookImageLeft"),
        bookRight: document.getElementById("bookImageRight"),
        eventsSection: document.querySelector(".eventsSection"),
        cardsContainer: document.getElementById("cardsContainer"),
        slots: document.querySelectorAll(".sliderCard"),
        prevBtn: document.querySelector(".sliderBtn.prev"),
        nextBtn: document.querySelector(".sliderBtn.next"),
        comingSoonModal: document.getElementById("comingSoonModal"),
        lightboxModal: document.getElementById("lightboxModal"),
        lightboxImg: document.getElementById("lightboxImage"),
        closeModalBtn: document.getElementById("closeModalBtn"),
        lightboxClose: document.querySelector(".lightboxClose"),
        cardsDivider: document.getElementById("cardsDivider")
    };

    let state = {
        currentEventKey: null,
        images: [],
        currentIndex: 0,
        isAnimating: false
    };

    /* ================= HELPERS ================= */
    const toggleModal = (modal, show) => {
        if (!modal) return;
        modal.classList.toggle("active", show);
        modal.setAttribute("aria-hidden", !show);
    };

    const triggerFlash = () => {
        document.querySelectorAll('.flashOverlay').forEach(overlay => {
            overlay.classList.remove('flashActive');
            void overlay.offsetWidth; // Force reflow
            overlay.classList.add('flashActive');
        });
    };

    /* ================= EVENT HANDLERS ================= */
    // Paper Clicks
    DOM.papers.forEach(paper => {
        paper.addEventListener("click", e => {
            e.preventDefault();
            const key = paper.dataset.event;

            if (COMING_SOON_EVENTS.includes(key)) {
                toggleModal(DOM.comingSoonModal, true);
                return;
            }

            const data = eventsData[key];
            if (!data) return;

            state.currentEventKey = key;
            triggerFlash();

            // Book images
            DOM.bookLeft.src = data.book.left;
            DOM.bookRight.src = data.book.right;
            DOM.bookSection.classList.add("bookVisible");

            // Slider & Cards ← التعديل هنا: نملأ السلايدر والكروت مباشرة عند تغيير event
            state.images = data.slider;
            state.currentIndex = 0;
            updateSlider();
            updateCards(key);

            DOM.eventsSection.classList.add("eventsVisible");
            DOM.cardsDivider.classList.add("visible");
        });
    });

    // Book Click
    [DOM.bookLeft, DOM.bookRight].forEach(img => {
        img.addEventListener("click", () => {
            if (!state.currentEventKey) return;
            const data = eventsData[state.currentEventKey];

            state.images = data.slider;
            state.currentIndex = 0;
            updateSlider();
            updateCards(state.currentEventKey);

            DOM.eventsSection.classList.add("eventsVisible");
            DOM.cardsDivider.classList.add("visible");
            DOM.eventsSection.scrollIntoView({ behavior: "smooth" });
        });
    });

    // Modals Close
    const closeAllModals = () => {
        toggleModal(DOM.comingSoonModal, false);
        toggleModal(DOM.lightboxModal, false);
        setTimeout(() => { if (DOM.lightboxImg) DOM.lightboxImg.src = ""; }, 300);
    };

    [DOM.closeModalBtn, DOM.lightboxClose].forEach(btn =>
        btn?.addEventListener("click", closeAllModals)
    );

    [DOM.comingSoonModal, DOM.lightboxModal].forEach(modal => {
        modal?.addEventListener("click", (e) => {
            if (e.target === modal) closeAllModals();
        });
    });

    // Lightbox Double Click
    // Lightbox Double Click
document.addEventListener("dblclick", (e) => {
    if (e.target.tagName === "IMG" && e.target.src) {
        DOM.lightboxImg.src = e.target.src;
        toggleModal(DOM.lightboxModal, true);
    }
});

// Back button in Lightbox
const lightboxBackBtn = document.getElementById("lightboxBackBtn");
lightboxBackBtn.addEventListener("click", () => {
    toggleModal(DOM.lightboxModal, false);
    DOM.lightboxImg.src = "";
});

    /* ================= UI UPDATES ================= */
    function updateCards(eventKey) {
        const data = eventsData[eventKey];
        if (!data?.cards) return;

        DOM.cardsContainer.innerHTML = data.cards.map(src => `
            <figure class="polaroidItem" style="--rotation: ${Math.floor(Math.random() * 13 - 6)}deg">
                <img src="${src}" alt="Event Card" loading="lazy">
            </figure>
        `).join('');
    }

    function updateSlider(direction = null) {
        if (!state.images.length) return;
        const offsets = [-2, -1, 0, 1, 2];

        DOM.slots.forEach((slot, i) => {
            const primary = slot.querySelector(".imgPrimary");
            const secondary = slot.querySelector(".imgSecondary");
            const index = (state.currentIndex + offsets[i] + state.images.length) % state.images.length;
            const src = state.images[index];

            primary.style.transition = secondary.style.transition = "none";

            if (!direction) {
                primary.src = src;
                Object.assign(primary.style, { opacity: "1", transform: "translateX(0)" });
                secondary.style.opacity = "0";
                return;
            }

            // Animation Logic
            secondary.src = src;
            Object.assign(secondary.style, {
                transform: direction === "next" ? "translateX(100%)" : "translateX(-100%)",
                opacity: "0", zIndex: "3"
            });
            Object.assign(primary.style, { zIndex: "2", transform: "translateX(0)", opacity: "1" });

            void secondary.offsetWidth; // Force Reflow

            primary.style.transition = secondary.style.transition = "";

            requestAnimationFrame(() => {
                primary.style.transform = direction === "next" ? "translateX(-50%)" : "translateX(50%)";
                primary.style.opacity = "0";
                secondary.style.transform = "translateX(0)";
                secondary.style.opacity = "1";
            });

            setTimeout(() => {
                primary.style.transition = secondary.style.transition = "none";
                primary.src = src;
                Object.assign(primary.style, { transform: "translateX(0)", opacity: "1", zIndex: "2" });
                Object.assign(secondary.style, { opacity: "0", zIndex: "1" });
            }, 600);
        });
    }

    /* ================= CONTROLS ================= */
    const handleSlide = (dir) => {
        if (state.isAnimating || !state.images.length) return;
        state.isAnimating = true;
        state.currentIndex = (state.currentIndex + (dir === "next" ? 1 : -1) + state.images.length) % state.images.length;
        updateSlider(dir);
        setTimeout(() => state.isAnimating = false, 650);
    };

    DOM.nextBtn.addEventListener("click", () => handleSlide("next"));
    DOM.prevBtn.addEventListener("click", () => handleSlide("prev"));

    /* ================= INIT DEFAULT EVENT ================= */
    (function initDefaultEvent() {
        const key = DEFAULT_EVENT;
        const data = eventsData[key];
        if (!data) return;

        state.currentEventKey = key;

        // Book images
        DOM.bookLeft.src = data.book.left;
        DOM.bookRight.src = data.book.right;
        DOM.bookSection.classList.add("bookVisible");

        // Slider & Cards
        state.images = data.slider;
        state.currentIndex = 0;
        updateSlider();
        updateCards(key);

        DOM.eventsSection.classList.add("eventsVisible");
        DOM.cardsDivider.classList.add("visible");
    })();

});