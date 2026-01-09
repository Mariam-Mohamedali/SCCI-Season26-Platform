const form = document.getElementById("form");
const inputs = form.querySelectorAll("input, select");

// Clear error on input change
inputs.forEach(input => {
    input.addEventListener("input", () => clearError(input));
    input.addEventListener("change", () => clearError(input)); // for select and file
});

form.addEventListener("submit", function (e) {
    // Clear all errors first
    clearAllErrors();

    // Prevent default initially to validte. If valid, we verify and submit.
    // NOTE: If we set isValid = false, we keep preventDefault.
    // If isValid = true, we allow submission inside the logic? 
    // Actually the current code does e.preventDefault() at top.

    let isValid = true;

    // ... inputs fetching ...
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const passwordInput = document.getElementById("password");
    const workshopSelect = document.getElementById("workshop");
    const imageInput = document.getElementById("image");

    // Check validation (if invalid, set isValid=false)
    // ... [Original Validation Logic preserved but wrapped] ...
    // Since I'm replacing the whole file content or block, I need to be careful.
    // I will use ReplaceFileContent on the whole file or large block to inject the clearing helper.

    e.preventDefault(); // Always prevent default first to validate

    // Name validation
    const nameValue = nameInput.value.trim();
    const nameParts = nameValue.split(" ").filter(part => part !== "");

    if (nameValue === "") {
        showError(nameInput, "Name is required");
        isValid = false;
    }
    else if (nameParts.length < 2) {
        showError(nameInput, "Please enter your full name (first and last name)");
        isValid = false;
    }

    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailInput.value.trim() === "") {
        showError(emailInput, "Email is required");
        isValid = false;
    }
    else if (!emailPattern.test(emailInput.value)) {
        showError(emailInput, "Enter a valid email");
        isValid = false;
    }

    // Phone validation
    const phonePattern = /^01[0-2,5][0-9]{8}$/;
    if (phoneInput.value.trim() === "") {
        showError(phoneInput, "Phone number is required");
        isValid = false;
    }
    else if (!phonePattern.test(phoneInput.value)) {
        showError(phoneInput, "Enter a valid Egyptian phone number");
        isValid = false;
    }

    // Password validation
    const passwordValue = passwordInput.value.trim();
    const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,}$/;

    if (passwordValue === "") {
        showError(passwordInput, "Password is required");
        isValid = false;
    }
    else if (passwordValue.length < 6) {
        showError(passwordInput, "Password must be at least 6 characters");
        isValid = false;
    }
    else if (!passwordPattern.test(passwordValue)) {
        showError(passwordInput, "Password must contain letters, numbers, and symbols (!@#$%^&*)");
        isValid = false;
    }

    // Workshop validation
    if (workshopSelect.value === "") {
        showError(workshopSelect, "Please select a workshop");
        isValid = false;
    }

    // Image validation
    if (imageInput.files.length === 0) {
        showError(imageInput, "Please choose an image");
        isValid = false;
    }
    else {
        const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!allowedTypes.includes(imageInput.files[0].type)) {
            showError(imageInput, "Only JPEG, PNG, GIF are allowed");
            isValid = false;
        }
    }

    if (isValid) {
        form.submit();
    }
});

function showError(input, message) {
    if (input.parentElement.querySelector(".error-msg")) return;

    const error = document.createElement("div");
    error.className = "error-msg";
    error.style.color = "red"; // Changed to red for visibility, user asked for solving issue
    error.style.fontSize = "0.9rem";
    error.style.marginTop = "5px";
    error.textContent = message;
    input.parentElement.appendChild(error);
}

function clearError(input) {
    const error = input.parentElement.querySelector(".error-msg");
    if (error) {
        error.remove();
    }
}

function clearAllErrors() {
    const errors = document.querySelectorAll(".error-msg");
    errors.forEach(error => error.remove());
}
