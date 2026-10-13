{{-- resources/views/partials/session_reminder_standalone.blade.php --}}

{{-- This div will hold the reminder, initially hidden --}}
<div class="session-reminder-popup" id="sessionReminder">
    <div class="session-reminder-content">
        <span class="close-btn" onclick="document.getElementById('sessionReminder').style.display='none'">&times;</span>
        <h4>Upcoming Session!</h4>
        <p>You have a session with <strong id="reminderTutorName"></strong> (Subject: <strong id="reminderSubjectName"></strong>) in:</p>
        <p class="countdown" id="countdownTimer"></p>
        <a href="#" target="_blank" class="join-session-btn" id="reminderJoinButton">Join Now</a>
    </div>
</div>

<style>
    /* Basic styling for the reminder popup */
    .session-reminder-popup {
        display: none; /* Hidden by default */
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 300px;
        background-color: #f8d7da; /* Light red for alert */
        border: 1px solid #dc3545; /* Darker red border */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        font-family: Arial, sans-serif;
        color: #721c24; /* Dark red text */
        padding: 15px;
    }

    .session-reminder-content {
        position: relative;
    }

    .session-reminder-popup h4 {
        margin-top: 0;
        color: #721c24;
    }

    .session-reminder-popup p {
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .session-reminder-popup .countdown {
        font-weight: bold;
        font-size: 1.1em;
        color: #721c24;
    }

    .session-reminder-popup .join-session-btn {
        display: none; /* Hidden by default, shown when session is near/live */
        background-color: #dc3545; /* Red button */
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 10px;
        font-weight: bold;
    }

    .session-reminder-popup .join-session-btn:hover {
        background-color: #c82333; /* Darker red on hover */
    }

    .session-reminder-popup .close-btn {
        position: absolute;
        top: 0px;
        right: 5px;
        font-size: 24px;
        cursor: pointer;
        color: #721c24;
    }

    .session-reminder-popup .close-btn:hover {
        color: #000;
    }
</style>

<script>
    // JavaScript for fetching data, countdown, and showing the reminder
    (function() {
        const reminderElement = document.getElementById('sessionReminder');
        const countdownElement = document.getElementById('countdownTimer');
        const tutorNameElement = document.getElementById('reminderTutorName');
        const subjectNameElement = document.getElementById('reminderSubjectName');
        const joinButton = document.getElementById('reminderJoinButton');

        let nextSessionData = null;
        let intervalId = null;

        const fetchNextSession = async () => {
            try {
                const response = await fetch('{{ route('api.student.next-session') }}');
                const data = await response.json();
                nextSessionData = data.nextSession;

                if (nextSessionData) {
                    // Populate reminder details
                    tutorNameElement.textContent = `${nextSessionData.get_tutor.f_name} ${nextSessionData.get_tutor.l_name}`;
                    subjectNameElement.textContent = nextSessionData.get_subject.subject;
                    joinButton.href = `{{ url('/class/session/link') }}/${nextSessionData.id}`;

                    // Start or restart the countdown
                    if (intervalId) clearInterval(intervalId);
                    intervalId = setInterval(updateCountdown, 1000);
                    updateCountdown(); // Initial call
                } else {
                    // No upcoming session, hide reminder and clear interval
                    reminderElement.style.display = 'none';
                    if (intervalId) clearInterval(intervalId);
                }
            } catch (error) {
                console.error('Error fetching next session:', error);
                reminderElement.style.display = 'none'; // Hide if API call fails
                if (intervalId) clearInterval(intervalId);
            }
        };

        const updateCountdown = () => {
            if (!nextSessionData) return;

            // Use the ISO string for robust Date object creation
            const sessionTime = new Date(nextSessionData.from_time_user_iso).getTime();
            const now = new Date().getTime();
            const distance = sessionTime - now;

            if (distance < 0) {
                // Session has started or passed
                // Check if it's within 30 minutes *after* start
                if (distance > -30 * 60 * 1000) {
                    countdownElement.innerHTML = "Session is Live!";
                    joinButton.style.display = 'inline-block';
                    reminderElement.style.display = 'block';
                } else {
                    // More than 30 mins past, hide reminder and stop updates
                    reminderElement.style.display = 'none';
                    clearInterval(intervalId);
                    intervalId = null; // Mark interval as cleared
                    nextSessionData = null; // Clear session data
                    // Optionally refetch in case another session is now the "next" one
                    setTimeout(fetchNextSession, 5 * 60 * 1000); // Try again in 5 mins
                }
            } else {
                // Session is in the future
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let countdownText = "";
                if (days > 0) countdownText += days + "d ";
                if (hours > 0) countdownText += hours + "h ";
                countdownText += minutes + "m " + seconds + "s";

                countdownElement.innerHTML = countdownText;

                // Show reminder only if session is within 1 hour
                if (distance < 60 * 60 * 1000) { // 1 hour = 60 minutes * 60 seconds * 1000 milliseconds
                    reminderElement.style.display = 'block';
                    joinButton.style.display = 'none'; // Hide join button until closer
                } else {
                    reminderElement.style.display = 'none';
                }
            }
        };

        // Fetch the next session initially
        fetchNextSession();

        // Refetch next session every 5 minutes to keep it updated
        setInterval(fetchNextSession, 5 * 60 * 1000); // 5 minutes
    })();
</script>