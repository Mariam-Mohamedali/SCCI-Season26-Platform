    // get nav links
    const participantBtn = document.querySelector('.participant');
    const memberBtn = document.querySelector('.member');

    // get table sections
    const participantsSchedule = document.getElementById('participantsSchedule');
    const membersSchedule = document.getElementById('membersSchedule');

    // show participants
    participantBtn.addEventListener('click', () => {
        participantsSchedule.style.display = 'block';
    membersSchedule.style.display = 'none';
    });

    // show members
    memberBtn.addEventListener('click', () => {
        membersSchedule.style.display = 'block';
    participantsSchedule.style.display = 'none';
    });
