// Update file name display when file is selected
const imageInput = document.getElementById('image');
if (imageInput) {
    imageInput.addEventListener('change', function () {
        const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        const fileNameDisplay = document.getElementById('fileName');
        if (fileNameDisplay) {
            fileNameDisplay.textContent = fileName;
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form');

    // Inputs
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const workshopSelect = document.getElementById('workshop');
    const imageInput = document.getElementById('image');

    const cpasswordInput = document.getElementById('cpassword');
    const errorCPassword = document.getElementById('error-cpassword');

    // Password Toggle
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Toggle Icon
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
        });
    }

    // Confirm Password Toggle
    const toggleCPasswordBtn = document.getElementById('toggleCPasswordBtn');
    if (toggleCPasswordBtn) {
        toggleCPasswordBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const type = cpasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            cpasswordInput.setAttribute('type', type);
            // Toggle Icon
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
        });
    }

    // Error Containers
    const errorName = document.getElementById('error-name');
    const errorEmail = document.getElementById('error-email');
    const errorPhone = document.getElementById('error-phone');
    const errorPassword = document.getElementById('error-password');
    const errorWorkshop = document.getElementById('error-workshop');
    const errorImage = document.getElementById('error-image');

    function showError(input, element, message) {
        element.textContent = message;
        element.style.display = 'block';
        input.parentElement.classList.add('error');
    }

    function clearError(input, element) {
        element.textContent = '';
        element.style.display = 'none';
        input.parentElement.classList.remove('error');
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(phone) {
        const re = /^01[0-2,5]{1}[0-9]{8}$/;
        return re.test(phone);
    }

    form.addEventListener('submit', (e) => {
        let valid = true;

        // Name Validation
        if (nameInput.value.trim().length === 0) {
            showError(nameInput, errorName, 'Name is required');
            valid = false;
        } else if (nameInput.value.trim().length < 3) {
            showError(nameInput, errorName, 'Name must be at least 3 characters');
            valid = false;
        } else {
            clearError(nameInput, errorName);
        }

        // Email Validation
        if (emailInput.value.trim().length === 0) {
            showError(emailInput, errorEmail, 'Email is required');
            valid = false;
        } else if (!validateEmail(emailInput.value.trim())) {
            showError(emailInput, errorEmail, 'Please enter a valid email');
            valid = false;
        } else {
            clearError(emailInput, errorEmail);
        }

        // Phone Validation
        if (phoneInput.value.trim().length === 0) {
            showError(phoneInput, errorPhone, 'Phone is required');
            valid = false;
        } else if (!validatePhone(phoneInput.value.trim())) {
            showError(phoneInput, errorPhone, 'Phone must be a valid 11-digit number');
            valid = false;
        } else {
            clearError(phoneInput, errorPhone);
        }

        // ✅ Strong Password Validation
        const password = passwordInput.value;
        const passwordErrors = [];

        if (password.length === 0) {
            showError(passwordInput, errorPassword, 'Password is required');
            valid = false;
        } else {
            // Check minimum length
            if (password.length < 8) {
                passwordErrors.push('at least 8 characters');
            }

            // Check for uppercase letter
            if (!/[A-Z]/.test(password)) {
                passwordErrors.push('one uppercase letter');
            }

            // Check for lowercase letter
            if (!/[a-z]/.test(password)) {
                passwordErrors.push('one lowercase letter');
            }

            // Check for special character
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                passwordErrors.push('one special character');
            }

            if (passwordErrors.length > 0) {
                showError(passwordInput, errorPassword, 'Password must contain ' + passwordErrors.join(', '));
                valid = false;
            } else {
                clearError(passwordInput, errorPassword);
            }
        }

        // Confirm Password Validation
        if (cpasswordInput.value.length === 0) {
            showError(cpasswordInput, errorCPassword, 'Confirm Password is required');
            valid = false;
        } else if (cpasswordInput.value !== passwordInput.value) {
            showError(cpasswordInput, errorCPassword, 'Passwords do not match');
            valid = false;
        } else {
            clearError(cpasswordInput, errorCPassword);
        }

        // Dropdown Validation
        if (workshopSelect.value === "") {
            showError(workshopSelect, errorWorkshop, 'Please select a workshop');
            valid = false;
        } else {
            clearError(workshopSelect, errorWorkshop);
        }
// ✅ Password Strength Indicator - Add this at the end of registerParticipant.js

// Show password requirements when user focuses on password field
passwordInput.addEventListener('focus', function () {
    document.getElementById('passwordRequirements').style.display = 'block';
});

// Real-time password strength checking
passwordInput.addEventListener('input', function () {
    const password = this.value;

    // Check each requirement
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    // Update visual indicators
    updateRequirement('req-length', hasLength);
    updateRequirement('req-uppercase', hasUppercase);
    updateRequirement('req-lowercase', hasLowercase);
    updateRequirement('req-special', hasSpecial);
});

// Helper function to update requirement status
function updateRequirement(elementId, isMet) {
    const element = document.getElementById(elementId);
    const icon = element.querySelector('i');

    if (isMet) {
        element.style.color = '#4CAF50'; // Green
        icon.className = 'fas fa-check-circle';
        icon.style.fontSize = '12px';
    } else {
        element.style.color = '#999'; // Gray
        icon.className = 'fas fa-circle';
        icon.style.fontSize = '6px';
    }
}

// Hide requirements when user leaves password field (optional)
passwordInput.addEventListener('blur', function () {
    // Keep it visible if password is not empty
    if (this.value.length === 0) {
        document.getElementById('passwordRequirements').style.display = 'none';
    }
});

        // Image Validation
        if (imageInput.files.length === 0) {
            showError(imageInput, errorImage, 'Please upload an image');
            valid = false;
        } else {
            const fileName = imageInput.files[0].name.toLowerCase();
            const allowedExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.bmp'];
            const isValid = allowedExtensions.some(ext => fileName.endsWith(ext));

            if (!isValid) {
                showError(imageInput, errorImage, 'Only Image files (JPG, PNG, GIF, WEBP) are allowed');
                valid = false;
            } else {
                clearError(imageInput, errorImage);
            }
        }


        if (!valid) {
            e.preventDefault(); // Stop form submission
        }
    });

    // Real-time validation
    const inputs = [nameInput, emailInput, phoneInput, passwordInput, cpasswordInput, workshopSelect, imageInput];
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            input.parentElement.classList.remove('error');
            const errorDisplay = input.parentElement.querySelector('.error-text');
            if (errorDisplay) errorDisplay.style.display = 'none';
        });
        // For select change event
        input.addEventListener('change', () => {
            input.parentElement.classList.remove('error');
            const errorDisplay = input.parentElement.querySelector('.error-text');
            if (errorDisplay) errorDisplay.style.display = 'none';
        });
    });
});
