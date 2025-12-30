// Initialize AOS
AOS.init({
  duration: 1000,
  once: true,
});

// Scroll To Top Functionality
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
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