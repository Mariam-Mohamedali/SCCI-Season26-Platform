document.addEventListener('DOMContentLoaded', () => {
  const settingsIcon = document.querySelector('.settingsIcon');
  const settingsMenu = document.querySelector('.settingsMenu');

  if (!settingsIcon || !settingsMenu) return;

  let isOpen = false;
  const animationDuration = 450; // نفس مدة الـ CSS

  const openMenu = (e) => {
    e.stopPropagation();
    if (isOpen) return;


    settingsMenu.classList.remove('closing');
    settingsMenu.classList.add('opening');
    isOpen = true;
  };

  const closeMenu = () => {
    if (!isOpen) return;

    settingsMenu.classList.remove('opening');
    settingsMenu.classList.add('closing');

    setTimeout(() => {
      settingsMenu.classList.remove('closing');
      isOpen = false;
    }, animationDuration);
  };

  settingsIcon.addEventListener('click', (e) => {
    isOpen ? closeMenu() : openMenu(e);
  });

  document.addEventListener('click', closeMenu);
});

// Profile Edit Popup and Inline Editing

document.addEventListener('DOMContentLoaded', () => {
  const saveBtn = document.querySelector('.saveProfile');

  saveBtn.addEventListener('click', () => {
    // Submit the form
    const form = document.querySelector('form[method="POST"]');
    form.submit();
  });


  const openEditBtn = document.getElementById('openEditProfile');
  const overlay = document.getElementById('editProfileOverlay');
  const closePopup = document.querySelector('.closePopup');

  if (!openEditBtn || !overlay) return;

  // Open popup
  openEditBtn.addEventListener('click', (e) => {
    e.preventDefault();   // 🔥 prevents 404
    e.stopPropagation();
    overlay.classList.add('active');

    // Scroll to top on mobile screens
    if (window.innerWidth <= 768) {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
  });

  // Close popup button
  closePopup.addEventListener('click', () => {
    overlay.classList.remove('active');
  });

  // Close on background click
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      overlay.classList.remove('active');
    }
  });

  // Inline edit toggle
  document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.closest('.editField').classList.toggle('editing');
    });
  });

});

