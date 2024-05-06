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

// Check if the user is already subscribed to the course
$sql = "SELECT * FROM UserCourses WHERE UserID = ? AND CourseID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $_SESSION['user_id'], $courseId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // User is already subscribed to the course
    $_SESSION['error'] = 'You are already subscribed to this course.';
    header("Location: ../pages/course.php?id=" . $courseId);
    exit();
}

// Insert a new subscription into the UserCourses table
$sql = "INSERT INTO UserCourses (UserID, CourseID, Status) VALUES (?, ?, 'In Progress')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $_SESSION['user_id'], $courseId);
$stmt->execute();

// Redirect to the course page
header("Location: ../pages/course.php?id=" . $courseId);
?>
