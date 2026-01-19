document.addEventListener("DOMContentLoaded", () => {
  // Initialize AOS
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: false,
    mirror: true
  });

  const flipCards = document.querySelectorAll(".flipCard");

  flipCards.forEach(card => {
    card.addEventListener("mouseenter", () => {
      card.classList.toggle("isFlipped");
    });
  });

  // Create Flying Icons for Paper Scroll
  createFlyingIcons();
});

// Function to create dynamic flying icons behind paper scroll
function createFlyingIcons() {
  const paperScroll = document.querySelector('.paperScroll');
  if (!paperScroll) return;

  // Workshop-related icons
  const icons = ['💻', '🎯', '🚀', '✨', '📱', '🔧'];
  const iconCount = 6;

  for (let i = 0; i < iconCount; i++) {
    const icon = document.createElement('div');
    icon.className = 'floating-icon';
    icon.textContent = icons[i % icons.length];
    
    // Random positioning
    const randomTop = Math.random() * 80 + 10; // 10% to 90%
    const randomLeft = Math.random() * 100; // 0% to 100%
    const randomDelay = Math.random() * 5; // 0s to 5s
    const randomDuration = 6 + Math.random() * 4; // 6s to 10s
    
    icon.style.cssText = `
      position: absolute;
      top: ${randomTop}%;
      left: ${randomLeft}%;
      font-size: ${2 + Math.random()}rem;
      opacity: 0.1;
      z-index: 0;
      pointer-events: none;
      animation: floatRandom${i} ${randomDuration}s ease-in-out infinite;
      animation-delay: ${randomDelay}s;
      filter: blur(1px);
    `;
    
    paperScroll.appendChild(icon);
    
    // Create unique animation for each icon
    const styleSheet = document.styleSheets[0];
    const keyframes = `
      @keyframes floatRandom${i} {
        0%, 100% {
          transform: translate(0, 0) rotate(0deg);
          opacity: 0.08;
        }
        50% {
          transform: translate(${-20 + Math.random() * 40}px, ${-20 + Math.random() * 40}px) rotate(${Math.random() * 30 - 15}deg);
          opacity: 0.15;
        }
      }
    `;
    styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
  }
}


/* ===== Modal Logic ===== */

function openModal(element) {
  const modal = document.getElementById("crewModal");
  const modalContent = modal.querySelector(".modalContent");
  const overlay = document.querySelector(".pageOverlay");

  // Clear previous content
  modalContent.innerHTML = "";

  // Clone Content from the clicked Board Item
  // 1. Title
  const title = element.querySelector(".roleTitle").cloneNode(true);
  // 2. Main Card
  const mainCard = element.querySelector(".flipCard").cloneNode(true);
  // 3. Sub Grid (Make it visible in clone by removing display:none logic hidden in class)
  const subGrid = element.querySelector(".subCrewGrid").cloneNode(true);
  subGrid.style.display = "grid"; // Force display in modal
  subGrid.style.maxHeight = "500px";
  subGrid.style.opacity = "1";

  // Append to Modal
  modalContent.appendChild(title);
  modalContent.appendChild(mainCard);
  modalContent.appendChild(subGrid);

  // Re-attach Flip Event Listeners for Cloned Cards
  const modalFlipCards = modalContent.querySelectorAll(".flipCard");
  modalFlipCards.forEach(card => {
    card.addEventListener("mouseenter", () => {
      card.classList.add("isFlipped");
    });
    card.addEventListener("mouseleave", () => {
      card.classList.remove("isFlipped");
    });
  });

  // Activate
  overlay.classList.add("active");
  modal.classList.add("active");
}

function closeModal() {
  const modal = document.getElementById("crewModal");
  const overlay = document.querySelector(".pageOverlay");

  if (modal && overlay) {
    modal.classList.remove("active");
    overlay.classList.remove("active");

    // Cleanup content after animation
    setTimeout(() => {
      const modalContent = modal.querySelector(".modalContent");
      if (modalContent) modalContent.innerHTML = "";
    }, 300);
  }
}
