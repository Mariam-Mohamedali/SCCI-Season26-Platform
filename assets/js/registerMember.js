document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form');

    // Inputs
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const workshopSelect = document.getElementById('workshop');
    const committeeSelect = document.getElementById('committeeId');

    // Error Containers
    const errorName = document.getElementById('error-name');
    const errorEmail = document.getElementById('error-email');
    const errorPhone = document.getElementById('error-phone');
    const errorPassword = document.getElementById('error-password');
    const errorWorkshop = document.getElementById('error-workshop');
    const errorCommittee = document.getElementById('error-committee');

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
        // Egyptian phone validation (starts with 01, 11 digits)
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

        // Dropdown Validation
        if (workshopSelect.value === "") {
            showError(workshopSelect, errorWorkshop, 'Please select a workshop');
            valid = false;
        } else {
            clearError(workshopSelect, errorWorkshop);
        }

        if (committeeSelect.value === "") {
            showError(committeeSelect, errorCommittee, 'Please select a committee');
            valid = false;
        } else {
            clearError(committeeSelect, errorCommittee);
        }

        if (!valid) {
            e.preventDefault(); // Stop form submission
        }
    });

    // Real-time validation cleanup
    const inputs = [nameInput, emailInput, phoneInput, passwordInput, workshopSelect, committeeSelect];
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            input.parentElement.classList.remove('error');
            const errorDisplay = input.parentElement.querySelector('.error-text');
            if (errorDisplay) errorDisplay.style.display = 'none';
        });
    });
});
