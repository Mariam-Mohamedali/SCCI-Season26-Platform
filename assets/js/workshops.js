// Workshop Journey Navigation
document.addEventListener('DOMContentLoaded', function () {
    const journeyBtns = document.querySelectorAll('.journeyBtn');
    const contentBlocks = document.querySelectorAll('.contentBlock');

    if (journeyBtns.length > 0 && contentBlocks.length > 0) {
        journeyBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove active class from all buttons
                journeyBtns.forEach(b => b.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Hide all content blocks
                contentBlocks.forEach(block => block.classList.remove('active'));

                // Show selected content
                const contentId = this.getAttribute('data-content');
                const targetContent = document.getElementById(contentId);
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
    }

    // Create Flying Icons for Journey Card
    createJourneyFlyingIcons();
});

// Function to create dynamic flying icons across the entire section background
function createJourneyFlyingIcons() {
    const journeySection = document.querySelector('.workshopJourneySection');
    if (!journeySection) return;

    // Expanded workshop-related icons for richer background
    const icons = [
        '💻', '🎯', '🚀', '✨', '📱', '🔧',
        '⚡', '🎨', '📊', '🔬', '💡', '🎓'
    ];
    const iconCount = 12; // Doubled from 6 to 12

    for (let i = 0; i < iconCount; i++) {
        const icon = document.createElement('div');
        icon.className = 'floating-journey-icon';
        icon.textContent = icons[i % icons.length];

        // Random positioning across the ENTIRE section
        const randomTop = Math.random() * 90 + 5; // 5% to 95%
        const randomLeft = Math.random() * 90 + 5; // 5% to 95%
        const randomDelay = Math.random() * 6; // 0s to 6s
        const randomDuration = 5 + Math.random() * 5; // 5s to 10s

        // Vary icon sizes for depth effect - MUCH MORE VISIBLE
        const iconSize = 2.5 + Math.random() * 1.5; // 2.5rem to 4rem (very large)
        const iconOpacity = 0.3 + Math.random() * 0.2; // 0.3 to 0.5 (very visible)

        icon.style.cssText = `
            position: absolute;
            top: ${randomTop}%;
            left: ${randomLeft}%;
            font-size: ${iconSize}rem;
            opacity: ${iconOpacity};
            z-index: 0;
            pointer-events: none;
            animation: floatJourneyRandom${i} ${randomDuration}s ease-in-out infinite;
            animation-delay: ${randomDelay}s;
            filter: none;
        `;

        journeySection.appendChild(icon);

        // Create unique animation for each icon with varied movement
        const styleSheet = document.styleSheets[0];
        const moveX = -30 + Math.random() * 60; // -30px to 30px (larger movement)
        const moveY = -30 + Math.random() * 60; // -30px to 30px
        const rotation = Math.random() * 40 - 20; // -20deg to 20deg

        const keyframes = `
            @keyframes floatJourneyRandom${i} {
                0%, 100% {
                    transform: translate(0, 0) rotate(0deg) scale(1);
                    opacity: ${iconOpacity};
                }
                50% {
                    transform: translate(${moveX}px, ${moveY}px) rotate(${rotation}deg) scale(${0.9 + Math.random() * 0.3});
                    opacity: ${Math.min(iconOpacity + 0.15, 0.6)};
                }
            }
        `;
        styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
    }
}
