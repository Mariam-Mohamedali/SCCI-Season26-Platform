document.addEventListener("DOMContentLoaded", () => {
    /* ================= CONSTANTS ================= */
    const COMING_SOON_EVENTS = ["outing", "comptition"];
    const DEFAULT_EVENT = "opening";

    const EVENT_NAMES = [
        "opening", "ushering", "firstSession", "57357", "outing",
        "midYear", "comptition", "league", "academic", "confrence", "closing"
    ];


    const eventsData = EVENT_NAMES.reduce((acc, name) => {
        acc[name] = {
            book: {
                left: `assets/img/${name}/book1.jpg`,
                right: `assets/img/${name}/book2.jpg`
            },
            slider: Array.from({ length: 6 }, (_, i) =>
                `assets/img/${name}/slider${i + 1}.jpg`
            ),
            cards: Array.from({ length: 6 }, (_, i) =>
                `assets/img/${name}/card${i + 1}.jpg`
            )
        };
        return acc;
    }, {});

    /* ================= DOM ================= */
    const DOM = {
        papers: document.querySelectorAll(".paper"),
        bookSection: document.querySelector(".bookSection"),
        bookLeft: document.getElementById("bookImageLeft"),
        bookRight: document.getElementById("bookImageRight"),
        eventsSection: document.querySelector(".eventsSection"),
        cardsContainer: document.getElementById("cardsContainer"),
        cardsDivider: document.getElementById("cardsDivider"),
        slots: document.querySelectorAll(".sliderCard"),
        prevBtn: document.querySelector(".sliderBtn.prev"),
        nextBtn: document.querySelector(".sliderBtn.next"),
        comingSoonModal: document.getElementById("comingSoonModal"),
        lightboxModal: document.getElementById("lightboxModal"),
        lightboxImg: document.getElementById("lightboxImage"),
        closeModalBtn: document.getElementById("closeModalBtn"),
        lightboxClose: document.querySelector(".lightboxClose")
    };

    /* ================= STATE ================= */
    let state = {
        currentEventKey: DEFAULT_EVENT,
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
        document.querySelectorAll(".flashOverlay").forEach(overlay => {
            overlay.classList.remove("flashActive");
            void overlay.offsetWidth;
            overlay.classList.add("flashActive");
        });
    };

    /* ================= UI UPDATES ================= */
    function updateCards(eventKey) {
        const data = eventsData[eventKey];
        if (!data?.cards) return;

        DOM.cardsContainer.innerHTML = data.cards
            .map(
                src => `
            <figure class="polaroidItem" style="--rotation:${Math.floor(Math.random() * 13 - 6)}deg">
                <img src="${src}" alt="Event Card" loading="lazy">
            </figure>
        `
            )
            .join("");
    }

    function updateSlider(direction = null) {
        if (!state.images.length) return;

        const offsets = [-2, -1, 0, 1, 2];

        DOM.slots.forEach((slot, i) => {
            const primary = slot.querySelector(".imgPrimary");
            const secondary = slot.querySelector(".imgSecondary");

            const index =
                (state.currentIndex + offsets[i] + state.images.length) %
                state.images.length;

            const src = state.images[index];

            primary.style.transition = secondary.style.transition = "none";

            // Initial load
            if (!direction) {
                primary.src = src;
                primary.style.opacity = "1";
                primary.style.transform = "translateX(0)";
                secondary.style.opacity = "0";
                return;
            }

            // Prepare animation
            secondary.src = src;
            secondary.style.transform =
                direction === "next" ? "translateX(100%)" : "translateX(-100%)";
            secondary.style.opacity = "0";
            secondary.style.zIndex = "3";
            primary.style.zIndex = "2";

            void secondary.offsetWidth;

            primary.style.transition = secondary.style.transition = "";

            requestAnimationFrame(() => {
                primary.style.transform =
                    direction === "next"
                        ? "translateX(-50%)"
                        : "translateX(50%)";
                primary.style.opacity = "0";

                secondary.style.transform = "translateX(0)";
                secondary.style.opacity = "1";
            });

            setTimeout(() => {
                primary.style.transition = secondary.style.transition = "none";
                primary.src = src;
                primary.style.transform = "translateX(0)";
                primary.style.opacity = "1";
                primary.style.zIndex = "2";

                secondary.style.opacity = "0";
                secondary.style.zIndex = "1";
            }, 600);
        });
    }

    /* ================= SLIDER CONTROLS ================= */
    const handleSlide = direction => {
        if (state.isAnimating || !state.images.length) return;
        state.isAnimating = true;

        state.currentIndex =
            (state.currentIndex +
                (direction === "next" ? 1 : -1) +
                state.images.length) %
            state.images.length;

        updateSlider(direction);
        setTimeout(() => (state.isAnimating = false), 650);
    };

    DOM.nextBtn.addEventListener("click", () => handleSlide("next"));
    DOM.prevBtn.addEventListener("click", () => handleSlide("prev"));

    /* ================= PAPER CLICKS ================= */
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

            DOM.bookLeft.src = data.book.left;
            DOM.bookRight.src = data.book.right;

            state.images = data.slider;
            state.currentIndex = 0;

            updateSlider();
            updateCards(key);

            DOM.bookSection.classList.add("bookVisible");
            DOM.eventsSection.classList.add("eventsVisible");
            DOM.cardsDivider.classList.add("visible");

            DOM.bookSection.scrollIntoView({ behavior: "smooth" });
        });
    });

    /* ================= MODALS ================= */
    const closeAllModals = () => {
        toggleModal(DOM.comingSoonModal, false);
        toggleModal(DOM.lightboxModal, false);
        if (DOM.lightboxImg) DOM.lightboxImg.src = "";
    };

    [DOM.closeModalBtn, DOM.lightboxClose].forEach(btn =>
        btn?.addEventListener("click", closeAllModals)
    );

    [DOM.comingSoonModal, DOM.lightboxModal].forEach(modal =>
        modal?.addEventListener("click", e => {
            if (e.target === modal) closeAllModals();
        })
    );

    document.addEventListener("dblclick", e => {
        const isCard = e.target.closest(".polaroidItem");
        const isSlider = e.target.closest(".sliderCard");

        // 1. Logic for Scroll and Sync
        if ((isCard || isSlider) && e.target.tagName === "IMG") {
            // Scroll to the events section to show the slider
            DOM.eventsSection.scrollIntoView({ behavior: "smooth", block: "center" });

            // If it's a card, also sync the slider index
            if (isCard) {
                const data = eventsData[state.currentEventKey];
                if (data?.cards) {
                    const index = data.cards.findIndex(src => src === e.target.getAttribute('src'));
                    if (index !== -1) {
                        state.currentIndex = index;
                        updateSlider();
                    }
                }
            }
        }

        // 2. Existing Lightbox/Zoom logic
        if (e.target.tagName === "IMG" && e.target.src) {
            DOM.lightboxImg.src = e.target.src;
            toggleModal(DOM.lightboxModal, true);
        }
    });

    /* ================= INITIAL LOAD ================= */
    (() => {
        const data = eventsData[DEFAULT_EVENT];
        if (!data) return;

        DOM.bookLeft.src = data.book.left;
        DOM.bookRight.src = data.book.right;

        state.images = data.slider;
        state.currentIndex = 0;

        updateSlider();
        updateCards(DEFAULT_EVENT);

        DOM.bookSection.classList.add("bookVisible");
        DOM.eventsSection.classList.add("eventsVisible");
        DOM.cardsDivider.classList.add("visible");
    })();
});
