// Make sure the DOM is fully loaded
window.addEventListener("load", function() {
    // Wait 3 seconds (3000ms)
    setTimeout(function() {
        // Optional: fade out
        document.body.style.transition = "opacity 0.8s";
        document.body.style.opacity = "0";

        // After fade, go to home.php
        setTimeout(function() {
            window.location.href = "home.php";
        }, 800); // match the fade duration
    }, 3000); // initial wait
});
