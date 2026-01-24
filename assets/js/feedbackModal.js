// ===============================================================================
// FEEDBACK MODAL FUNCTIONS
// ===============================================================================


// Open Feedback Modal
function openFeedbackModal(participantName, participantId) {
    const modal = document.getElementById('feedbackModal');
    const participantNameEl = document.getElementById('participantName');

    // Update participant name
    if (participantNameEl && participantName) {
        participantNameEl.textContent = participantName;
    }

    // Store participant ID for later use
    modal.dataset.participantId = participantId || '';

    // Reset form
    document.getElementById('feedbackForm').reset();
    document.getElementById('ratingValue').value = '0';

    // Reset stars
    const stars = document.querySelectorAll('.feedbackStarsInput i');
    stars.forEach(star => {
        star.classList.remove('fas');
        star.classList.add('far');
    });

    // Show modal
    modal.classList.add('show');

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Close Feedback Modal
function closeFeedbackModal() {
    const modal = document.getElementById('feedbackModal');
    modal.classList.remove('show');
}

// Save Feedback
function saveFeedback() {
    const form = document.getElementById('feedbackForm');
    const sessionSelect = document.getElementById('sessionSelect');
    const ratingValue = document.getElementById('ratingValue');
    const feedbackMessage = document.getElementById('feedbackMessage');

    // Validate form
    if (!sessionSelect.value) {
        alert('Please select a session');
        sessionSelect.focus();
        return;
    }

    if (ratingValue.value === '0') {
        alert('Please select a rating');
        return;
    }

    if (!feedbackMessage.value.trim()) {
        alert('Please enter feedback message');
        feedbackMessage.focus();
        return;
    }

    // Collect form data
    const feedbackData = {
        participantId: document.getElementById('feedbackModal').dataset.participantId,
        participantName: document.getElementById('participantName').textContent,
        session: sessionSelect.value,
        sessionName: sessionSelect.options[sessionSelect.selectedIndex].text,
        rating: ratingValue.value,
        message: feedbackMessage.value,
        instructor: 'Dr. Ahmed Mohamed', // This should come from session/backend
        timestamp: new Date().toISOString()
    };

    console.log('Feedback Data:', feedbackData);

    // TODO: Send to backend via AJAX/Fetch
    // Example:
    // fetch('api/saveFeedback.php', {
    //   method: 'POST',
    //   headers: { 'Content-Type': 'application/json' },
    //   body: JSON.stringify(feedbackData)
    // })
    // .then(response => response.json())
    // .then(data => {
    //   if (data.success) {
    //     alert('Feedback saved successfully!');
    //     closeFeedbackModal();
    //   }
    // });

    // For now, just show success message
    alert('Feedback saved successfully!\\n\\nSession: ' + feedbackData.sessionName + '\\nRating: ' + feedbackData.rating + ' stars');
    closeFeedbackModal();
}

// Event Listeners for Modal
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('feedbackModal');

    if (!modal) return;

    // Star Rating Interaction
    const stars = document.querySelectorAll('.feedbackStarsInput i');
    const ratingInput = document.getElementById('ratingValue');

    stars.forEach((star, index) => {
        star.addEventListener('click', function () {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;

            // Update star display
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });

        // Hover effect
        star.addEventListener('mouseenter', function () {
            const rating = this.getAttribute('data-rating');
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });

    // Reset hover effect on mouse leave
    document.querySelector('.feedbackStarsInput').addEventListener('mouseleave', function () {
        stars.forEach(s => s.classList.remove('active'));
    });

    // Close on overlay click
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeFeedbackModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            closeFeedbackModal();
        }
    });

    // Attach openFeedbackModal to all "Add Feedback" buttons
    const feedbackButtons = document.querySelectorAll('.addFeedbackBtn');
    feedbackButtons.forEach(button => {
        button.addEventListener('click', function () {
            const participantName = this.closest('tr').querySelector('.tableParticipantName').textContent;
            const participantId = this.dataset.participantId || '';
            openFeedbackModal(participantName, participantId);
        });
    });
});
