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
    $title = $_POST['title'];
    $level = $_POST['level'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    // Handle the file upload
    if (isset($_FILES['course-img']) && $_FILES['course-img']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['course-img'];
        $imageData = file_get_contents($image['tmp_name']);

        // Edit the course in the database
        $sql = "UPDATE Courses SET Title = ?, Picture = ?, Level = ?, Description = ?, Duration = ?, Hide = ? WHERE CourseID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Failed to prepare statement: " . $conn->error);
        }
        $stmt->bind_param("sbssii", $title, $null, $level, $description, $duration, $visible, $_POST['course-id']);
        $stmt->send_long_data(1, $imageData);
    }
    else {
        // Edit the course in the database, but don't change the image
        $sql = "UPDATE Courses SET Title = ?, Level = ?, Description = ?, Duration = ?, Hide = ? WHERE CourseID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Failed to prepare statement: " . $conn->error);
        }
        $stmt->bind_param("sssii", $title, $level, $description, $duration, $visible, $_POST['course-id']);
    }
    $stmt->execute();

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Course modified successfully']);

} else {
    // Fetch the existing courses
    $sql = "SELECT * FROM Courses";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->execute();
    $courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch the levels
    $sql = "SELECT Title FROM Level";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->execute();
    $levelsTitle = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode(utf8ize(['courses' => $courses, 'levels' => $levelsTitle]));
}
