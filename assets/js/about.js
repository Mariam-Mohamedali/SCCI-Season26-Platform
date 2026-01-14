// Crew Cards Slider with Front-Only Rotation (Correct Init)

const cards = Array.from(document.querySelectorAll('.crewCard'));
const exitedStack = [];

const nextBtn = document.getElementById('nextBtn');
const prevBtn = document.getElementById('prevBtn');

// Detect rotated cards by filename (-r)
function shouldRotate(card) {
    return /-r\.(png|jpg|jpeg|webp)$/i.test(card.src);
}

// Orientation helpers
function setHorizontal(card) {
    card.style.transform = 'translateX(0) rotate(0deg)';
}

function setVertical(card) {
    card.style.transform = 'translateX(0) rotate(90deg)';
}

// ===============================
// INITIALIZE
// ===============================
cards.forEach((card, index) => {
    card.style.zIndex = index;
    card.classList.add('active');
    setHorizontal(card);
});

// ⭐ INITIAL FRONT FIX
const initialFront = cards[cards.length - 1];
if (shouldRotate(initialFront)) {
    requestAnimationFrame(() => setVertical(initialFront));
}

/* =========================
   RIGHT ARROW
========================= */
nextBtn.addEventListener('click', () => {
    const visibleCards = cards.filter(
        c => c.classList.contains('active') && !c.classList.contains('hidden')
    );

    if (visibleCards.length <= 1) return;

    const topCard = visibleCards[visibleCards.length - 1];
    const newFront = visibleCards[visibleCards.length - 2];

    // Rotate current front back to horizontal
    setHorizontal(topCard);

    // Slide out
    topCard.style.transform = 'translateX(120%) rotate(0deg)';
    topCard.classList.add('slide-right');

    topCard.addEventListener('transitionend', function handler() {
        topCard.classList.remove('active', 'slide-right');
        topCard.classList.add('hidden');
        exitedStack.push(topCard);
        topCard.removeEventListener('transitionend', handler);
    });

    // Rotate new front if needed
    if (shouldRotate(newFront)) {
        requestAnimationFrame(() => setVertical(newFront));
    }
});

/* =========================
   LEFT ARROW
========================= */
prevBtn.addEventListener('click', () => {
    if (exitedStack.length === 0) return;

    const visibleCards = cards.filter(
        c => c.classList.contains('active') && !c.classList.contains('hidden')
    );
    const currentFront = visibleCards[visibleCards.length - 1];

    // Rotate current front back to horizontal
    setHorizontal(currentFront);

    // Bring back previous card
    const card = exitedStack.pop();
    card.classList.remove('hidden');
    card.classList.add('active');

    // Start off-screen, horizontal
    card.style.transform = 'translateX(120%) rotate(0deg)';
    void card.offsetWidth; // force reflow

    // Slide in
    card.style.transform = 'translateX(0) rotate(0deg)';

    // Rotate to vertical ONLY when fully in front
    card.addEventListener('transitionend', function handler() {
        if (shouldRotate(card)) {
            setVertical(card);
        }
        card.removeEventListener('transitionend', handler);
    });
});