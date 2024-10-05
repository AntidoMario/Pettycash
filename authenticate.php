<?php
session_start();

// Dummy credentials (for demonstration purposes, you should use a database in a real application)
$admin_username = "admin";
$admin_password = "password";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify username and password
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Incorrect username or password.'); window.location.href='index.php';</script>";
    }
}
?>
