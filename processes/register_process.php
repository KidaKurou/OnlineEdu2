<?php
// Start the session
session_start();
// Include the database connection file
include '../includes/db_connection.php';
// Get form data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$login = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
// Insert into database
$sql = "INSERT INTO Users (FirstName, LastName, Email, Login, Password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("sssss", $fname, $lname, $email, $login, $password);
if ($stmt->execute() === false) {
    // Registration failed
    $_SESSION['error'] = 'Registration failed: ' . $stmt->error;
    header("Location: ../pages/register.php");
} else {
    // Registration successful
    header("Location: ../pages/login.php");
}
// Close connection
$stmt->close();
?>
