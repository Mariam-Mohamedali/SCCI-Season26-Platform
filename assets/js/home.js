/* ===============================
   HOME PAGE SCRIPT
   - AOS Scroll Animations
   - Stats Counter on Scroll
================================ */

document.addEventListener("DOMContentLoaded", () => {

  /* ===============================
     AOS INITIALIZATION
  ================================ */
  if (typeof AOS !== "undefined") {
    AOS.init({
      startEvent: 'load',
      duration: 1000,
      easing: "ease-in-out",
      once: true,
      offset: 0,
      anchorPlacement: 'top-bottom'
    });
  }

  /* ===============================
     STAT COUNTER ANIMATION
  ================================ */
  const counters = document.querySelectorAll(".statNumber");

  if ("IntersectionObserver" in window && counters.length > 0) {
    const counterObserver = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;

          const counter = entry.target;
          const target = Number(counter.dataset.target);
          const duration = 4500; // ms
          const startTime = performance.now();

          function animateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            counter.textContent = Math.floor(progress * target);

            if (progress < 1) {
              requestAnimationFrame(animateCounter);
            } else {
              counter.textContent = target;
            }
          }

          requestAnimationFrame(animateCounter);
          observer.unobserve(counter); // run only once
        });
      },
      { threshold: 0.6 }
    );

    counters.forEach(counter => counterObserver.observe(counter));
  }

});
