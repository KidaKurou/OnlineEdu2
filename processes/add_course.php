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
    $image = $_FILES['course-img'];

    // echo json_encode(['status' => 'success', 'message' => `{$title}, {$level}, {$description}, {$duration}, {$visible}, {$image}`]);

    // Validate the data
    if (empty($title) || empty($level) || empty($description) || empty($duration) || empty($image)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields']);
        exit();
    }

    // Handle the file upload
    if ($image['error'] !== UPLOAD_ERR_OK) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'File upload error']);
        exit();
    }
    $imageData = file_get_contents($image['tmp_name']);
    
    // Add the new course to the database
    $sql = "INSERT INTO Courses (Title, Picture, Level, Description, Duration, Hide) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("sbssii", $title, $null, $level, $description, $duration, $visible);
    $stmt->send_long_data(1, $imageData);
    $stmt->execute();

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Course added successfully']);
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
