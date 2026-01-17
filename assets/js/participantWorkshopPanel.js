// Week tab switching functionality
document.addEventListener('DOMContentLoaded', function () {
    const weekTabs = document.querySelectorAll('.weekTab');

    weekTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            // Remove active class from all tabs
            weekTabs.forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Here you can add code to load different week data
            const weekNumber = this.getAttribute('data-week');
            console.log('Switched to Week ' + weekNumber);
        });
    });
});