<?php
    include '../includes/db_connection.php';
    $table = $_GET['table'];
    $id = $_GET['id'];  // Assuming the image ID is passed as a GET parameter.
    $sql = "SELECT Picture FROM $table WHERE CourseID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($picture);
    $stmt->fetch();
    // header('Content-Type: ../image/jpeg');
    echo 'data:image/jpeg;base64,' . base64_encode($picture);
?>
