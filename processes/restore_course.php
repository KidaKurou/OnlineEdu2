<?php
// Include the database connection file
include '../includes/db_connection.php';

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } else if (is_string($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission here
    $course_id = $_POST['CourseID'];

    // Start a transaction
    $conn->begin_transaction();

    // Move the course to the Courses table
    $sql = "INSERT INTO Courses SELECT * FROM DeletedCourses WHERE CourseID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("i", $course_id);
    $stmt->execute();

    // Delete the course from the DeletedCourses table
    $sql = "DELETE FROM DeletedCourses WHERE CourseID = ?";
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
    // Fetch the existing courses
    $sql = "SELECT * FROM DeletedCourses";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->execute();
    $courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode(utf8ize(['courses' => $courses]));
}
