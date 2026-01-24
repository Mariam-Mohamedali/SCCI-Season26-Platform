// Make sure the DOM is fully loaded
window.addEventListener("load", function () {
    console.log("Landing page loaded - animations starting");

    // Create Portal Overlay element dynamically
    const portal = document.createElement("div");
    portal.className = "portalOverlay";
    document.body.appendChild(portal);

    // Magic Cursor Effect
    document.addEventListener("mousemove", function (e) {
        if (Math.random() > 0.5) return; // Limit particles for performance
        const particle = document.createElement("div");
        particle.className = "magicParticle";
        particle.style.left = e.clientX + "px";
        particle.style.top = e.clientY + "px";
        document.body.appendChild(particle);

        // Remove particle after animation
        setTimeout(() => particle.remove(), 1000);
    });

    // Wait 5 seconds (5000ms) 
    setTimeout(function () {
        // Trigger Portal Close
        document.body.classList.add("fadeOut");

        console.log("Portal closing - redirecting to home");

        // After animation completes, redirect
        setTimeout(function () {
            window.location.href = "home.php";
        }, 1500); // 1.5s matches somewhat the heavy portal close
    }, 5000);
});