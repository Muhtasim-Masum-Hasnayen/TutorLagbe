<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    exit('Unauthorized');
}

$student_id = $_SESSION['user_id'];
$tutor_id = isset($_GET['tutor_id']) ? intval($_GET['tutor_id']) : 0;

// Get list of tutors the student has chatted with
$tutorListQuery = $conn->prepare("SELECT DISTINCT tutors.id, tutors.full_name FROM messages
    JOIN tutors ON messages.tutor_id = tutors.id
    WHERE messages.student_id = ?");
$tutorListQuery->bind_param("i", $student_id);
$tutorListQuery->execute();
$tutorList = $tutorListQuery->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Messages</title>
    <style>
        body {
            font-family: Arial;
            display: flex;
            height: 100vh;
            margin: 0;
            font-size: 1.5rem; /* 👈 makes all text roughly 3x bigger */
        }
        .sidebar { width: 250px; background: #1c1f26; color: white; padding: 10px; overflow-y: auto; }
        .chat-area { flex: 1; display: flex; flex-direction: column; }
        .messages { flex: 1; padding: 15px; overflow-y: auto; background: #f0f0f0; }
        .message-input { display: flex; padding: 10px; background: #fff; }
        .message-input input { flex: 1; padding: 10px; border: 1px solid #ccc; }
        .message-input button { padding: 10px; background: #3b82f6; color: white; border: none; }
        .message { margin: 5px 0; }
        .student { text-align: right; color: green; }
        .tutor { text-align: left; color: #222; }
        a { color: white; display: block; margin: 8px 0; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Your Tutors</h3>
        <?php while($row = $tutorList->fetch_assoc()): ?>
            <a href="?tutor_id=<?= $row['id'] ?>"><?= htmlspecialchars($row['full_name']) ?></a>
        <?php endwhile; ?>
    </div>
    <div class="chat-area">
        <div class="messages" id="messages">
            <?php
            if ($tutor_id) {
                $msgQuery = $conn->prepare("SELECT * FROM messages WHERE student_id = ? AND tutor_id = ? ORDER BY sent_at");
                $msgQuery->bind_param("ii", $student_id, $tutor_id);
                $msgQuery->execute();
                $messages = $msgQuery->get_result();
                while ($msg = $messages->fetch_assoc()) {
                    $cls = $msg['sender_role'] === 'student' ? 'student' : 'tutor';
                    echo "<div class='message $cls'><strong>{$msg['sender_role']}:</strong> {$msg['message_text']}</div>";
                }
            } else {
                echo "<p>Select a tutor to start chatting.</p>";
            }
            ?>
        </div>
        <?php if ($tutor_id): ?>
        <form class="message-input" id="sendForm">
            <input type="hidden" name="tutor_id" value="<?= $tutor_id ?>">
            <input type="text" name="message_text" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
        <?php endif; ?>
    </div>

    <script>
        const form = document.getElementById('sendForm');
        const messagesDiv = document.getElementById('messages');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                const res = await fetch('message_send.php', {
                    method: 'POST',
                    body: formData
                });
                if (res.ok) {
                    form.message_text.value = '';
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>
