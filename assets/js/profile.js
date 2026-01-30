document.addEventListener('DOMContentLoaded', () => {
  // === Settings Menu Logic ===
  const settingsIcon = document.querySelector('.settingsIcon');
  const settingsMenu = document.querySelector('.settingsMenu');

  if (settingsIcon && settingsMenu) {
    let isOpen = false;
    const animationDuration = 450;

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
  }

  // === Profile Edit Popup Logic ===
  const openEditBtn = document.getElementById('openEditProfile');
  const overlay = document.getElementById('editProfileOverlay');
  const closeBtn = document.querySelector('.closePopup');
  const saveBtn = document.getElementById('saveChangesBtn');
  const form = document.querySelector('.editProfileSection form');

  if (!openEditBtn || !overlay) return;

  const inputs = {
    user_name: document.getElementById('user_name'),
    email: document.getElementById('email'),
    phone: document.getElementById('phone'),
    githup: document.getElementById('githup'),
    linkedin: document.getElementById('linkedin'),
    password: document.getElementById('password'),
    confirm_password: document.getElementById('confirm_password')
  };

  let initialValues = {};

  function captureInitialValues() {
    initialValues = {};
    Object.keys(inputs).forEach(key => {
      if (inputs[key]) {
        if (key === 'password' || key === 'confirm_password') {
          initialValues[key] = '';
        } else {
          initialValues[key] = inputs[key].value.trim();
        }
      }
    });
  }

  function checkChanges() {
    let hasChanged = false;
    Object.keys(inputs).forEach(key => {
      const input = inputs[key];
      if (!input) return;

      const currentVal = input.value.trim();
      const initVal = initialValues[key] || '';

      if (currentVal !== initVal) {
        hasChanged = true;
      }
    });

    if (saveBtn) {
      saveBtn.disabled = !hasChanged;
    }
  }

  // Attach input listeners to all fields
  Object.keys(inputs).forEach(key => {
    const input = inputs[key];
    if (input) {
      input.addEventListener('input', checkChanges);
      input.addEventListener('change', checkChanges);
    }
  });

  // Opening Modal
  openEditBtn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    overlay.classList.add('active');
    document.body.classList.add('no-scroll');

    // Always refresh baseline when opening
    captureInitialValues();
    if (saveBtn) saveBtn.disabled = true;
  });

  // Closing Modal
  const closePopupAction = () => {
    overlay.classList.remove('active');
    document.body.classList.remove('no-scroll');
  };

  if (closeBtn) closeBtn.addEventListener('click', closePopupAction);
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) closePopupAction();
  });

  // Toggle Password Visibility
  document.querySelectorAll('.toggle-password-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const wrapper = this.closest('.passwordWrapper');
      const input = wrapper ? wrapper.querySelector('input') : this.previousElementSibling;

      if (!input) return;

      const type = input.type === 'password' ? 'text' : 'password';
      input.type = type;

      // Use innerHTML to ensure compatibility with FontAwesome SVG replacement
      this.innerHTML = type === 'text' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
  });

  // === Auto-open if errors exist ===
  if (document.body.dataset.hasErrors === 'true') {
    overlay.classList.add('active');
    document.body.classList.add('no-scroll');
    captureInitialValues();
  }
});
