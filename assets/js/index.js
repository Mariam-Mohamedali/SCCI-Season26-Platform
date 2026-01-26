

// Scroll To Top Functionality
document.addEventListener('DOMContentLoaded', () => {
  const scrollTopBtn = document.getElementById('scrollTopBtn');

  if (scrollTopBtn) {
    // Show button after scrolling down 300px
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        scrollTopBtn.classList.add('show');
      } else {
        scrollTopBtn.classList.remove('show');
      }
    });

    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});

// =============================================== NAVBAR HIDE/SHOW ON SCROLL ===============================================
// Hide navbar when scrolling down, show when scrolling up
const header = document.querySelector("header");

if (header) {
  let lastScrollTop = 0;
  let scrollTimeout;
  const scrollThreshold = 10; // Minimum scroll distance to trigger hide/show
  const hideDelay = 100; // Delay before hiding navbar (ms)

  window.addEventListener("scroll", () => {
    // Clear previous timeout
    clearTimeout(scrollTimeout);

    // Use requestAnimationFrame for smoother performance
    requestAnimationFrame(() => {
      const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

      // Add glassmorphism effect after scrolling
      if (currentScroll > 50) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }

      // Calculate scroll difference
      const scrollDifference = Math.abs(currentScroll - lastScrollTop);

      // Only proceed if scroll difference is significant enough
      if (scrollDifference > scrollThreshold) {
        if (currentScroll > lastScrollTop && currentScroll > 100) {
          // Scrolling DOWN - hide navbar with slight delay
          scrollTimeout = setTimeout(() => {
            header.classList.add("navbar-hidden");
          }, hideDelay);
        } else if (currentScroll < lastScrollTop) {
          // Scrolling UP - show navbar immediately
          header.classList.remove("navbar-hidden");
        }

        // Update last scroll position
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
      }

      // Always show navbar when at the very top
      if (currentScroll <= 10) {
        header.classList.remove("navbar-hidden");
      }
    });
  }, { passive: true }); // Use passive for better scroll performance
}

// =============================================== NAVBAR ===============================================
// variables
const body = document.querySelector("body");
const sideBtn = document.querySelector(".sideBtn");
const sideBg = document.querySelector(".sideNav");

// Toggle side navbar (open/close with burger button)
if (sideBtn && sideBg) {
  sideBtn.addEventListener("click", () => {
    const isActive = sideBg.classList.contains("active");

    if (isActive) {
      // Close menu
      body.classList.remove("no-scrolling");
      sideBg.classList.remove("active");
      sideBtn.classList.remove("active");
    } else {
      // Open menu
      body.classList.add("no-scrolling");
      sideBg.classList.add("active");
      sideBtn.classList.add("active");
    }
  });
}


// AOS
AOS.init({
  duration: 1000,
  easing: 'ease-in-sine',
  delay: 0,
  offset: 0, // Changed from 100 to 0 so elements already visible on screen animate immediately
  once: true,
  mirror: true,
  disable: function () {
    var maxWidth = 800;
    return window.innerWidth < maxWidth;
  }
});

// =============================================== GLOBAL FLYING ICONS ===============================================
// Global Flying Icons - Appears on all pages
document.addEventListener('DOMContentLoaded', function () {
  createGlobalFlyingIcons();
});

// Function to create dynamic flying icons across the page background
function createGlobalFlyingIcons() {
  // Target the body or main content area
  const targetElement = document.querySelector('body');
  if (!targetElement) return;

  // Create a container for the icons
  const iconsContainer = document.createElement('div');
  iconsContainer.className = 'global-flying-icons-container';
  iconsContainer.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 100;
        overflow: hidden;
    `;
  document.body.appendChild(iconsContainer);

  // Stars related icons
  const icons = [
    '✦', '★', '☆', '✨', '✴', '✶', '✷', '✸'
  ];
  const iconCount = 16; // 16 icons spread across the entire page

  for (let i = 0; i < iconCount; i++) {
    const icon = document.createElement('div');
    icon.className = 'global-flying-icon';
    icon.textContent = icons[i % icons.length];

    // Random positioning across the ENTIRE viewport
    const randomTop = Math.random() * 90 + 5; // 5% to 95%
    const randomLeft = Math.random() * 90 + 5; // 5% to 95%
    const randomDelay = Math.random() * 8; // 0s to 8s
    const randomDuration = 6 + Math.random() * 6; // 6s to 12s

    // Vary icon sizes for depth effect
    const iconSize = 2 + Math.random() * 2; // 2rem to 4rem
    const iconOpacity = 0.15 + Math.random() * 0.15; // 0.15 to 0.30 (subtle)

    icon.style.cssText = `
            position: absolute;
            top: ${randomTop}%;
            left: ${randomLeft}%;
            font-size: ${iconSize}rem;
            opacity: ${iconOpacity};
            z-index: 0;
            pointer-events: none;
            animation: globalFloatIcon${i} ${randomDuration}s ease-in-out infinite;
            animation-delay: ${randomDelay}s;
            filter: blur(0.5px);
        `;

    iconsContainer.appendChild(icon);

    // Create unique animation for each icon
    const styleSheet = document.styleSheets[0];
    const moveX = -40 + Math.random() * 80; // -40px to 40px
    const moveY = -40 + Math.random() * 80; // -40px to 40px
    const rotation = Math.random() * 50 - 25; // -25deg to 25deg

    const keyframes = `
            @keyframes globalFloatIcon${i} {
                0%, 100% {
                    transform: translate(0, 0) rotate(0deg) scale(1);
                    opacity: ${iconOpacity};
                }
                50% {
                    transform: translate(${moveX}px, ${moveY}px) rotate(${rotation}deg) scale(${0.85 + Math.random() * 0.4});
                    opacity: ${Math.min(iconOpacity + 0.1, 0.4)};
                }
            }
        `;

    try {
      styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
    } catch (e) {
      // Fallback if insertRule fails
      console.log('Could not insert animation rule');
    }
  }
}