document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form");
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const messageInput = document.getElementById("message");

  if (!form) return;

  form.addEventListener("submit", (e) => {
    let isValid = true;

    // NAME
    if (nameInput.value.trim().length < 3) {
      showError(nameInput, "Name must be at least 3 characters");
      isValid = false;
    }

    // EMAIL
    if (!isValidEmail(emailInput.value.trim())) {
      showError(emailInput, "Enter a valid email address");
      isValid = false;
    }

    // MESSAGE
    if (messageInput.value.trim().length < 10) {
      showError(messageInput, "Message must be at least 10 characters");
      isValid = false;
    }

    if (!isValid) e.preventDefault();
  });

  [nameInput, emailInput, messageInput].forEach((input) => {
    input.addEventListener("input", () => clearError(input));
  });

  function showError(input, message) {
    const error = input.parentElement.querySelector(".error");
    error.textContent = message;
    input.classList.add("invalid");
  }

  function clearError(input) {
    const error = input.parentElement.querySelector(".error");
    error.textContent = "";
    input.classList.remove("invalid");
  }

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
});
