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
});


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
