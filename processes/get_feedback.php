<?php
// Include the database connection file
include '../includes/db_connection.php';

// Fetch the feedback messages from the database
$sql = "SELECT * FROM Feedback";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Failed to fetch feedback: " . $conn->error);
}

// Fetch the feedback messages as an associative array
$feedback = $result->fetch_all(MYSQLI_ASSOC);

// Send a JSON response back to the client
header('Content-Type: application/json');
echo json_encode(['feedback' => $feedback]);
?>
