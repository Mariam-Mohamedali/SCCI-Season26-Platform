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

        // Password Validation
        if (passwordInput.value.length === 0) {
            showError(passwordInput, errorPassword, 'Password is required');
            valid = false;
        } else if (passwordInput.value.length < 6) {
            showError(passwordInput, errorPassword, 'Password must be at least 6 characters');
            valid = false;
        } else {
            clearError(passwordInput, errorPassword);
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
