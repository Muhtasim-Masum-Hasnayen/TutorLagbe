<?php
$success = '';
$error = '';

include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $success = "✅ Admin registered successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Registration - TutorLagbe</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .form-container {
      background-color: #1e1e2f;
      padding: 30px;
      border-radius: 12px;
      width: 400px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .form-container h2 {
      text-align: center;
      color: #82f5b4;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      color: #ccc;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 8px;
      background-color: #2e2e3f;
      color: #fff;
    }

    .form-group input:focus {
      outline: none;
      box-shadow: 0 0 5px #82f5b4;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background: #82f5b4;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .btn:hover {
      background: #63d89a;
    }

    .message {
      margin-top: 15px;
      text-align: center;
      font-weight: bold;
    }

    .message.success {
      color: #7fffd4;
    }

    .message.error {
      color: #ff6666;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
    }

    .login-link a {
      color: #82f5b4;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Admin Registration</h2>

  <?php if (!empty($success)) : ?>
    <div class="message success"><?= $success ?></div>
  <?php endif; ?>
  <?php if (!empty($error)) : ?>
    <div class="message error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <label><i class="fas fa-user"></i> Username</label>
      <input type="text" name="username" required>
    </div>
    <div class="form-group">
      <label><i class="fas fa-envelope"></i> Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label><i class="fas fa-lock"></i> Password</label>
      <input type="password" name="password" required>
    </div>
    <button class="btn" type="submit">Register</button>
  </form>

  <div class="login-link">
    Already have an account? <a href="admin_login.php">Login here</a>
  </div>
</div>

</body>
</html>
