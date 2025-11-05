<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | TutorLagbe</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #0f0f0f;
      color: #f9f9f9;
      display: flex;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background-color: #111;
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      top: 0;
      left: 0;
      box-shadow: 2px 0 8px rgba(0,0,0,0.5);
    }

    .sidebar h2 {
      color: gold;
      text-align: center;
      margin-bottom: 30px;
      font-size: 22px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0 15px;
    }

    .sidebar ul li {
      margin: 20px 0;
    }

    .sidebar ul li a {
      color: #b7f1a1;
      text-decoration: none;
      display: flex;
      align-items: center;
      font-size: 16px;
      padding: 10px;
      transition: 0.3s;
      border-radius: 8px;
    }

    .sidebar ul li a:hover {
      background: #1a1a1a;
      color: gold;
    }

    .sidebar ul li a i {
      margin-right: 10px;
    }

    /* Topbar */
    .topbar {
      background: #1c1c1c;
      padding: 15px 25px;
      width: 100%;
      position: fixed;
      top: 0;
      left: 220px;
      height: 60px;
      z-index: 10;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #fff;
      box-shadow: 0 1px 5px rgba(0,0,0,0.2);
    }

    .topbar h1 {
      font-size: 22px;
      color: gold;
    }

    .topbar .admin-name {
      font-size: 16px;
      color: #aaffc3;
    }

    /* Main content */
    .main {
      margin-left: 220px;
      margin-top: 60px;
      padding: 30px;
    }

    .main h2 {
      font-size: 24px;
      color: #b7f1a1;
      margin-bottom: 20px;
    }

    .main p {
      font-size: 16px;
      line-height: 1.7;
      color: #ccc;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>📘 Admin Panel</h2>
    <ul>
      <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="admin_manage_tutors.php"><i class="fas fa-user-tie"></i> Manage Tutors</a></li>
      <li><a href="manage_students.php"><i class="fas fa-users"></i> Manage Students</a></li>
      <li><a href="create_course.php"><i class="fas fa-book"></i> Create Course</a></li>
      <li><a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

  <!-- Topbar -->
  <div class="topbar">
    <h1>Admin Dashboard</h1>
    <div class="admin-name">👋 Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></div>
  </div>

  <!-- Main content -->
  <div class="main">
    <h2>Dashboard Overview</h2>
    <p>Welcome to your secured admin panel. From here, you can manage tutors, students, and create or update available courses for the TutorLagbe platform.</p>
    <p>Use the sidebar to navigate through your tasks. Thank you for contributing to better education!</p>
  </div>

</body>
</html>
