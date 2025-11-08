<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    http_response_code(403);
    exit('Unauthorized');
}

$student_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $class_level = $_POST['class_level'];
    $medium = $_POST['medium'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $stmt = $conn->prepare("INSERT INTO tuition_posts (student_id, title, subject, class_level, medium, location, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $student_id, $title, $subject, $class_level, $medium, $location, $description, $image);
    $stmt->execute();
}

// Fetch posts by student
$result = $conn->query("SELECT * FROM tuition_posts WHERE student_id = $student_id ORDER BY posted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Tuition Post</title>
    <style>
        body { font-family: Arial; margin: 0; display: flex; }
        #sidebar {
            background: #081c15; color: white; width: 250px;
            transition: width 0.3s ease; overflow: hidden; height: 100vh;
        }
        #sidebar ul { list-style: none; padding: 20px 0; }
        #sidebar ul li a {
            color: white; display: block; padding: 10px 25px;
            text-decoration: none;
        }
        #sidebar ul li a:hover { background: #0077b6; border-radius: 6px; }
        .main { flex: 1; padding: 20px; background: #f4f4f4; height: 100vh; overflow-y: auto; }
        .topbar { background: #003c32; color: white; padding: 15px; font-size: 24px; }
        .post-form, .post { background: white; padding: 20px; margin-bottom: 20px; border-radius: 10px; }
        .comment { margin-left: 20px; font-size: 14px; color: #333; }
    </style>
</head>
<body>
    <div id="sidebar">
        <ul>
            <li><a href="#">📌 Dashboard</a></li>
            <li><a href="#">📝 My Posts</a></li>
            <li><a href="#">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="topbar">📢 Tuition Post Board</div>

        <div class="post-form">
            <h3>Create New Tuition Post</h3>
            <form method="POST" enctype="multipart/form-data">
                <input name="title" placeholder="Title" required><br><br>
                <input name="subject" placeholder="Subject" required><br><br>
                <input name="class_level" placeholder="Class Level" required><br><br>
                <input name="medium" placeholder="Medium (English/Bangla)" required><br><br>
                <input name="location" placeholder="Location" required><br><br>
                <textarea name="description" placeholder="Description" rows="4"></textarea><br><br>
                <input type="file" name="image"><br><br>
                <button type="submit">Post</button>
            </form>
        </div>

        <?php while($row = $result->fetch_assoc()): ?>
            <div class="post">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><strong>Subject:</strong> <?= $row['subject'] ?> | <strong>Class:</strong> <?= $row['class_level'] ?> | <strong>Medium:</strong> <?= $row['medium'] ?> | <strong>Location:</strong> <?= $row['location'] ?></p>
                <p><?= $row['description'] ?></p>
                <?php if ($row['image']): ?>
                    <img src="<?= $row['image'] ?>" width="200">
                <?php endif; ?>

                <?php
                $post_id = $row['id'];
                $comments = $conn->query("SELECT tuition_comments.comment, tutors.full_name FROM tuition_comments JOIN tutors ON tuition_comments.tutor_id = tutors.id WHERE tuition_comments.post_id = $post_id ORDER BY commented_at DESC");
                while ($c = $comments->fetch_assoc()):
                ?>
                    <div class="comment"><strong><?= $c['full_name'] ?>:</strong> <?= $c['comment'] ?></div>
                <?php endwhile; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
