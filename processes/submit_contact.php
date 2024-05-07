<?php
// Include the database connection file
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission here
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Start a transaction
    $conn->begin_transaction();

    // Insert the contact form data into the database
    $sql = "INSERT INTO Feedback (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Send a JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'message' => 'Feedback submitted successfully']);
} else {
    echo "Invalid request";
}
?>
