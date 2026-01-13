
// Scroll To Top Functionality
const scrollTopBtn = document.getElementById('scrollTopBtn');

if (scrollTopBtn) {
  // Get the first section to determine when to show the button
  const firstSection = document.querySelector('.workshopsHero');

  window.addEventListener('scroll', () => {
    if (firstSection) {
      const firstSectionHeight = firstSection.offsetHeight;

      if (window.pageYOffset > firstSectionHeight) {
        scrollTopBtn.classList.add('show');
      } else {
        scrollTopBtn.classList.remove('show');
      }
    }
  });

  scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

// =============================================== NAVBAR HIDE/SHOW ON SCROLL ===============================================
// Hide navbar when scrolling down, show when scrolling up
const header = document.querySelector("header");

if (header) {
  let lastScrollTop = 0;
  const scrollThreshold = 5; // Minimum scroll distance to trigger hide/show

  window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    // Add glassmorphism effect after scrolling
    if (currentScroll > 50) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }

    // Hide/Show navbar based on scroll direction
    if (currentScroll > lastScrollTop && currentScroll > 100) {
      // Scrolling DOWN - hide navbar
      header.classList.add("navbar-hidden");
    } else if (currentScroll < lastScrollTop) {
      // Scrolling UP - show navbar
      header.classList.remove("navbar-hidden");
    }

    // Update last scroll position
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
  }, false);
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
  delay: 100,
  offset: 100,
  once: true,
  mirror: true,
  disable: function () {
    var maxWidth = 800;
    return window.innerWidth < maxWidth;
  }
});