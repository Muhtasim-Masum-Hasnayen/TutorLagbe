<!-- admin_login.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - TutorLagbe</title>
  <style>
    body { font-family: Arial; background: #111; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; }
    form { background: #1e1e1e; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px gold; }
    input[type="text"], input[type="password"] { padding: 10px; width: 100%; margin-bottom: 15px; border: none; border-radius: 5px; }
    input[type="submit"] { background: gold; color: #000; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; }
  </style>
</head>
<body>
  <form method="post" action="admin_login_process.php">
    <h2>🔒 Admin Login</h2>
    <!-- admin_login.php -->
    <input type="text" name="email" placeholder="Enter Email" required>

    <input type="password" name="password" placeholder="Enter Password" required><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
