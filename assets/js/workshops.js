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