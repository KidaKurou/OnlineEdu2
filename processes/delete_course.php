<?php
// Include the database connection file
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission here
    $course_id = $_POST['CourseID'];

    // Start a transaction
    $conn->begin_transaction();

    // Move the course to the DeletedCourses table
    $sql = "INSERT INTO DeletedCourses SELECT * FROM Courses WHERE CourseID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("i", $course_id);
    $stmt->execute();

    // Delete the course from the UserCourses table
    $sql = "DELETE FROM UserCourses WHERE CourseID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("i", $course_id);
    $stmt->execute();

    // Delete the course from the Courses table
    $sql = "DELETE FROM Courses WHERE CourseID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("i", $course_id);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Course deleted successfully']);
} else {
    echo "Invalid request";
}
