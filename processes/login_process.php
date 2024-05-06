<?php

// Start the session
session_start();

// Include the database connection file
include '../includes/db_connection.php';

// Get form data
$login = $_POST['username'];
$password = $_POST['password'];

// Check credentials
$sql = "SELECT * FROM Users WHERE Login = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if ($user && password_verify($password, $user['Password'])) {
    // Login successful
    $_SESSION['user_id'] = $user['UserID'];
    if ($user['job_title'] == 'admin') {
        $_SESSION['admin'] = true;
    }
    header("Location: ../pages/index.php");
} else {
    // Login failed
    $_SESSION['error'] = 'Invalid username or password.';
    header("Location: ../pages/login.php");
}

// Close connection
$stmt->close();
