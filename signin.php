<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Query to check user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();

        // Set session
        $_SESSION['user'] = $userData['email'];

        // Redirect to homepage
        header("Location: homepage.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password.'); window.location.href='login.php';</script>";
    }
}
?>
