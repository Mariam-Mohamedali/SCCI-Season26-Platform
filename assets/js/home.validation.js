document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form");
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const messageInput = document.getElementById("message");

  const successMessage = document.getElementById("successMessage");

  if (!form) return;

  // ======================
  // FORM VALIDATION
  // ======================
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

  // ======================
  // SUCCESS MESSAGE
  // ======================
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("success")) {
    successMessage.style.display = "block";

    const url = new URL(window.location);
    url.searchParams.delete("success");
    window.history.replaceState({}, document.title, url);
  }

  // ======================
  // FUNCTIONS
  // ======================
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
