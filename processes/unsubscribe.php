<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Include the database connection file
include '../includes/db_connection.php';

// Get the course ID from the form data
$courseId = $_POST['course_id'];

// Delete the user's subscription to the course
$sql = "DELETE FROM UserCourses WHERE UserID = ? AND CourseID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $_SESSION['user_id'], $courseId);
$stmt->execute();

// Redirect to the profile page
header("Location: ../pages/profile.php");
?>
