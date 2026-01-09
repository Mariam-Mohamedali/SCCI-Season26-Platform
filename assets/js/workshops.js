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
});
