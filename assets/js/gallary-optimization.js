// ================================================
// 🚀 Gallery Performance Optimization
// ================================================
// Add this at the END of gallary.js

/* ================= LAZY LOADING OPTIMIZATION ================= */
// Intersection Observer for lazy loading images
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;

            // Load the image
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }

            // Add fade-in effect
            img.classList.add('loaded');

            // Stop observing this image
            observer.unobserve(img);
        }
    });
}, {
    rootMargin: '50px', // Start loading 50px before image enters viewport
    threshold: 0.01
});

// Observe all images with data-src attribute
function observeImages() {
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Call after cards are updated
const originalUpdateCards = updateCards;
updateCards = function (eventKey) {
    originalUpdateCards(eventKey);
    setTimeout(observeImages, 100); // Observe new images after DOM update
};

/* ================= PRELOAD CRITICAL IMAGES ================= */
// Preload first event images for faster initial load
function preloadCriticalImages() {
    const critical = [
        eventsData[DEFAULT_EVENT].book.left,
        eventsData[DEFAULT_EVENT].book.right,
        eventsData[DEFAULT_EVENT].slider[0]
    ];

    critical.forEach(src => {
        const img = new Image();
        img.src = src;
    });
}

// Run on page load
preloadCriticalImages();

/* ================= DEBOUNCE SLIDER ================= */
// Prevent rapid clicking on slider buttons
let sliderTimeout;
const originalHandleSlide = handleSlide;
handleSlide = function (dir) {
    clearTimeout(sliderTimeout);
    sliderTimeout = setTimeout(() => originalHandleSlide(dir), 50);
};
