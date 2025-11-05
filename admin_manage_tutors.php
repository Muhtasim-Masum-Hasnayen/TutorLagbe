<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
require_once "db_config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tutor_id = $_POST['tutor_id'] ?? null;
    $new_status = $_POST['new_status'] ?? null;

    if ($tutor_id && in_array($new_status, ['pending', 'approved', 'rejected'])) {
        $stmt = $conn->prepare("UPDATE tutors SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $tutor_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: admin_manage_tutors.php?msg=updated"); // Change to actual list page
            exit();
        } else {
            echo "Status not updated. Maybe no changes.";
        }
    } else {
        echo "Invalid data.";
    }
} else {
    echo "Invalid request method.";
}

// Fetch all tutors
$tutors = [];
$result = $conn->query("SELECT * FROM tutors ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tutors[] = $row;
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Manage Tutors</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #121212;
            color: #fff;
        }
        .topbar {
            background: #1e1e1e;
            padding: 15px 30px;
            font-size: 20px;
            font-weight: bold;
            color: gold;
        }
        .sidebar {
            width: 200px;
            height: 100vh;
            background: #1a1a1a;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #ccc;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #333;
            color: gold;
        }
        .content {
            margin-left: 220px;
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e1e1e;
        }
        th, td {
            padding: 12px;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background: #333;
            color: lightgreen;
        }
        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        form select, form button {
            padding: 5px 10px;
            border-radius: 4px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="topbar">📚 Admin Dashboard - Manage Tutors</div>

<div class="sidebar">
    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="manage_tutors.php">👨‍🏫 Manage Tutors</a>
    <a href="manage_students.php">👨‍🎓 Manage Students</a>
    <a href="create_course.php">➕ Create Course</a>
    <a href="admin_logout.php">🚪 Logout</a>
</div>

<div class="content">
    <h2>All Tutor Profiles</h2>

    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>District</th>
                <th>Status</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($tutors) > 0): ?>
            <?php foreach ($tutors as $tutor): ?>
                <tr>
                    <td>
                        <?php if (!empty($tutor['profile_photo'])): ?>
                            <img src="<?= htmlspecialchars($tutor['profile_photo']) ?>" alt="Tutor Photo" style="width: 60px; height: 60px; border-radius: 50%;">
                        <?php else: ?>
                            <img src="default_profile.png" alt="Default" style="width: 60px; height: 60px; border-radius: 50%;">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($tutor['full_name']) ?></td>
                    <td><?= htmlspecialchars($tutor['email']) ?></td>
                    <td><?= htmlspecialchars($tutor['phone']) ?></td>
                    <td><?= htmlspecialchars($tutor['district']) ?></td>
                    <td>
                        <strong style="color:
                            <?= $tutor['status'] === 'approved' ? 'lightgreen' : ($tutor['status'] === 'rejected' ? 'red' : 'orange') ?>;">
                            <?= ucfirst($tutor['status']) ?>
                        </strong>
                    </td>
                    <td>
                        <form method="POST" action="admin_manage_tutors.php">
                            <input type="hidden" name="tutor_id" value="<?= $tutor['id'] ?>">
                            <select name="new_status">
                                <option value="pending" <?= $tutor['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="approved" <?= $tutor['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="rejected" <?= $tutor['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <button type="submit">✔ Update</button>
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No tutors found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>


</body>
</html>
