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
