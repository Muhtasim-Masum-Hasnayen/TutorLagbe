<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_config.php';

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    echo "Student data not found.";
    exit();
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $district = $_POST['district'];
    $address = $_POST['address'];

    // Handle profile photo
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $filename = basename($_FILES["profile_photo"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename;
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file);
    } else {
        $target_file = $student['profile_photo']; // Keep existing
    }

    $update = $conn->prepare("UPDATE students SET full_name = ?, phone = ?, district = ?, address = ?, profile_photo = ? WHERE user_id = ?");
    $update->bind_param("sssssi", $full_name, $phone, $district, $address, $target_file, $user_id);
    $update->execute();

    header("Location: Student_Profile.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Profile - TutorLagbe</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600;700&display=swap" rel="stylesheet" />
  <style>
    * { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background: linear-gradient(to right, #f0f4f8, #dbe9f4);
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background: #1d3557;
      color: white;
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .logo { height: 45px; }
    .logout-btn {
      background: #e63946;
      border: none;
      padding: 10px 16px;
      color: white;
      border-radius: 6px;
      cursor: pointer;
    }
    .wrapper { display: flex; flex: 1; }
    #sidebar {
      background: #1d3557;
      color: white;
      width: 250px;
      padding-top: 20px;
    }
    #sidebar ul { list-style: none; padding: 0; }
    #sidebar ul li { margin-bottom: 10px; }
    #sidebar ul li a {
      color: white;
      display: flex;
      align-items: center;
      padding: 12px 25px;
      text-decoration: none;
    }
    #sidebar ul li a:hover { background: #457b9d; border-radius: 6px; }

    main.content {
      flex: 1;
      padding: 40px;
    }

    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 14px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    .form-container h2 {
      margin-bottom: 25px;
      color: #1d3557;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    textarea { resize: vertical; }
    button {
      background: #1d3557;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover { background: #0e2a4d; }

    .success-message {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background: #f8f8f8;
    }
  </style>
</head>
<body>

<header>
  <img src="TutorLagbe.png" alt="TutorLagbe Logo" class="logo" />
  <div>Welcome, <?php echo htmlspecialchars($name); ?></div>
  <a href="logout.php"><button class="logout-btn">Logout</button></a>
</header>

<div class="wrapper">
  <nav id="sidebar">
    <ul>
      <li><a href="student_home.php"><i class="fas fa-home"></i>&nbsp; Dashboard</a></li>
      <li><a href="#"><i class="fas fa-bullhorn"></i>&nbsp; My Posts</a></li>
      <li><a href="Student_Profile.php"><i class="fas fa-user"></i>&nbsp; My Profile</a></li>
    </ul>
  </nav>

  <main class="content">
    <div class="form-container">
      <h2>Edit Profile</h2>

      <?php if (isset($_GET['success'])): ?>
        <div class="success-message">✅ Profile updated successfully!</div>
      <?php endif; ?>

      <div style="text-align: center; margin-bottom: 20px;">
        <img src="<?= htmlspecialchars($student['profile_photo'] ?? 'uploads/default-profile.png') ?>" alt="Profile Photo"
             style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #ccc;">
      </div>

      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="profile_photo">Change Profile Photo</label>
          <input type="file" name="profile_photo" accept="image/*">
        </div>

        <div class="form-group">
          <label for="full_name">Full Name</label>
          <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" required>
        </div>

        <div class="form-group">
          <label for="district">District</label>
          <input type="text" name="district" value="<?= htmlspecialchars($student['district']) ?>" required>
        </div>

        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address" rows="3"><?= htmlspecialchars($student['address']) ?></textarea>
        </div>

        <button type="submit">Update Profile</button>
      </form>
    </div>
  </main>
</div>

<footer>
  &copy; <?= date("Y") ?> TutorLagbe. All rights reserved.
</footer>

</body>
</html>
