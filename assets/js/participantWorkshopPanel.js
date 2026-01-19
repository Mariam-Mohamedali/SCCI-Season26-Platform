// Mini navbar change pages
const links = document.querySelectorAll(".miniNav a");
const pages = document.querySelectorAll(".panelSection");

function activatePage(pageId) {
  // activate nav link
  links.forEach((link) => {
    link.classList.toggle("activePanelLine", link.dataset.page === pageId);
  });

  // activate panel
  pages.forEach((page) => {
    page.classList.toggle("panelSectionActive", page.id === pageId);
  });
}

// prevent link default
links.forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();

    const targetId = link.dataset.page;

    // save to localStorage
    localStorage.setItem("activePanel", targetId);

    // activate immediately
    activatePage(targetId);
  });
});

// restore on page load
const savedPanel = localStorage.getItem("activePanel");

if (savedPanel) {
  activatePage(savedPanel);
} else {
  // fallback: first link
  const firstPage = links[0].dataset.page;
  activatePage(firstPage);
}

// ==============================================================
document.addEventListener('DOMContentLoaded', function () {

  /* ================== WEEK TABS SELECTION ================== */
  /* Handles switching between different workshop weeks */
  const weekTabs = document.querySelectorAll('.weekTab');

  weekTabs.forEach(tab => {
    tab.addEventListener('click', function () {
      // Remove active class from all tabs
      weekTabs.forEach(t => t.classList.remove('active'));
      // Add active class to clicked tab
      this.classList.add('active');

      const sessionNumber = this.getAttribute('data-week');
      updateTaskContent(sessionNumber);
    });
  });

  // Function to update task content based on selected session
  function updateTaskContent(sessionNum) {
    // Select elements to update
    const taskNameEl = document.querySelector('.cardBody .taskRow:nth-child(1) .taskValue');
    const deadlineEl = document.querySelector('.cardBody .taskRow:nth-child(2) .taskValue');
    const sessionEl = document.querySelector('.cardBody .taskRow:nth-child(3) .taskValue');
    const bioEl = document.querySelector('.taskBioContent');

    // Sample data for demonstration (In real app, fetch from backend)
    const sessionData = {
      '1': { name: 'Build your first website', deadline: '12/12/2025', bio: 'Create a simple personal portfolio website using HTML and CSS.' },
      '2': { name: 'JavaScript Basics', deadline: '19/12/2025', bio: 'Implement variables, loops, and functions to solve basic algorithms.' },
      '3': { name: 'DOM Manipulation', deadline: '26/12/2025', bio: 'Create an interactive to-do list application using JavaScript DOM API.' },
      '4': { name: 'Responsive Design', deadline: '02/01/2026', bio: 'Make your portfolio website fully responsive for mobile and tablet devices.' },
      '5': { name: 'Bootstrap Framework', deadline: '09/01/2026', bio: 'Rebuild your landing page within 2 hours using Bootstrap components.' },
      '6': { name: 'API Integration', deadline: '16/01/2026', bio: 'Fetch data from a public API and display it dynamically on your page.' },
      '7': { name: 'Final Project', deadline: '23/01/2026', bio: 'Plan and start developing your final course project with all learned skills.' }
    };

    const data = sessionData[sessionNum];

    if (data) {
      // Animate content change
      const cardBody = document.querySelector('.cardBody');
      cardBody.style.opacity = '0';

      setTimeout(() => {
        if (taskNameEl) taskNameEl.textContent = data.name;
        if (deadlineEl) deadlineEl.textContent = data.deadline;
        if (sessionEl) sessionEl.textContent = sessionNum;
        if (bioEl) bioEl.textContent = data.bio;

        cardBody.style.opacity = '1';
      }, 300);
    }
  }

  /* ================== FILE UPLOAD HANDLING ================== */
  /* Manages file selection, drag & drop, and validation */
  const uploadContainer = document.querySelector('.uploadContainer');
  const fileInput = document.getElementById('submit_link'); // Updated ID
  const fileMessage = document.getElementById('fileMessage');
  const fileState = document.getElementById('fileUploadState');
  const fileUploadedName = document.getElementById('fileUploadedName');
  const submitForm = document.getElementById('validForm');

  fileMessage.textContent = "";


  /* Event: Regular file input selection */
  /* Updates UI when a user selects a file via the browse dialog */
  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (this.files.length > 0) {
        fileState.textContent = "File Uploaded Successfully!";
        fileState.style.color = "green";
        fileUploadedName.textContent = this.files[0].name;
        fileUploadedName.style.display = "block";
        fileMessage.textContent = "";
      } else {
        fileState.textContent = "Drag and drop or click to browse";
        fileState.style.color = "";
        fileUploadedName.style.display = "none";
      }
    });
  }

  /* Event: Prevent default drag behaviors */
  /* Stops browser from opening files dropped outside the zone */
  ['dragover', 'drop'].forEach(eventName => {
    if (uploadContainer) {
      uploadContainer.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
      });
    }
  });

  /* Event: Drag Over */
  /* Adds visual cue when file is dragged over the drop zone */
  if (uploadContainer) {
    uploadContainer.addEventListener('dragover', () => {
      uploadContainer.classList.add('drag-over');
    });

    /* Event: File Drop */
    /* Handles the file drop, updates input, and triggers change event */
    uploadContainer.addEventListener('drop', (e) => {
      uploadContainer.classList.remove('drag-over');

      const files = e.dataTransfer.files;

      if (files.length > 0) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(files[0]);
        fileInput.files = dataTransfer.files;

        fileInput.dispatchEvent(
          new Event('change', { bubbles: true })
        );
      }
    });
  }

  /* ================== FORM SUBMIT VALIDATION & AJAX ================== */
  /* Ensures a file is selected before allowing form submission */
  if (submitForm) {
    submitForm.addEventListener('submit', (e) => {
      e.preventDefault();

      if (!fileInput || !fileInput.files.length) {
        fileMessage.textContent = "Please upload a file.";
        fileMessage.style.color = "red";
        return;
      }

      const formData = new FormData(submitForm);

      fetch(window.location.href, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            window.location.reload();
          } else {
            alert(data.message || 'Error uploading file.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred during upload.');
        });
    });
  }

  /* ================== MATERIAL CATEGORY SWITCHING ================== */
  /* Handles switching between Technical and Soft-skills materials */
  const categoryBtns = document.querySelectorAll('.materialCategoryBtn');
  const materialsLists = document.querySelectorAll('.materialsList');

  categoryBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      // Remove active class from all buttons
      categoryBtns.forEach(b => b.classList.remove('active'));

      // Add active class to clicked button
      this.classList.add('active');

      // Get target category
      const targetCategory = this.getAttribute('data-category');

      // Hide all materials lists
      materialsLists.forEach(list => {
        list.classList.remove('activeMaterialsList');
      });

      // Show target list
      const targetList = document.getElementById(targetCategory);
      if (targetList) {
        targetList.classList.add('activeMaterialsList');
      }
    });
  });

});

/* ================== FEEDBACK MODAL CONTROL ================== */
/* Functions to open and close the feedback modal popup */

function openFeedbackModal(sessionName, rating, feedbackText, instructor) {
  const modal = document.getElementById('feedbackModal');

  // 1. Set Session Name
  const sessionEl = document.getElementById('feedbackSessionName');
  if (sessionEl) sessionEl.textContent = sessionName;

  // 2. Set Feedback Text
  const textEl = document.getElementById('feedbackText');
  if (textEl) textEl.innerHTML = `<p>${feedbackText}</p>`;

  // 3. Render Stars
  const starsContainer = document.querySelector('#feedbackModal .feedbackStars');
  if (starsContainer) {
    starsContainer.innerHTML = ''; // clear existing
    const r = parseInt(rating) || 0;
    for (let i = 1; i <= 5; i++) {
      const star = document.createElement('i');
      if (i <= r) {
        star.className = 'fas fa-star';
      } else {
        star.className = 'far fa-star';
      }
      starsContainer.appendChild(star);
    }
  }

  // 4. Set Instructor Name
  const instructorEl = document.getElementById('feedbackInstructorName');
  if (instructorEl) instructorEl.textContent = instructor;

  modal.classList.add('show');
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function closeFeedbackModal() {
  const modal = document.getElementById('feedbackModal');
  modal.classList.remove('show');
}

// Close modal when clicking outside
document.addEventListener('click', function (event) {
  const modal = document.getElementById('feedbackModal');
  if (event.target === modal) {
    closeFeedbackModal();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function (event) {
  if (event.key === 'Escape') {
    closeFeedbackModal();
  }
});

// Attach click handlers to feedback buttons
document.addEventListener('DOMContentLoaded', function () {
  const feedbackBtns = document.querySelectorAll('.feedbackBtn');

  feedbackBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const session = this.getAttribute('data-session') || 'Session';
      const rating = this.getAttribute('data-rating') || 0;
      const feedback = this.getAttribute('data-feedback') || 'No feedback available.';
      const instructor = this.getAttribute('data-instructor') || 'Instructor';

      openFeedbackModal(session, rating, feedback, instructor);
    });
  });
});
