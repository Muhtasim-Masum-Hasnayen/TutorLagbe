<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];  // Must match input name in form
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;

            $update = $conn->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
            $update->bind_param("i", $id);
            $update->execute();
            $update->close();

            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location='admin_login.php';</script>";
        }
    } else {
        echo "<script>alert('Admin not found!'); window.location='admin_login.php';</script>";
    }

    $stmt->close();
}
?>
