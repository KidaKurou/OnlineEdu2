<?php
include '../includes/db_connection.php';

$order = $_GET['order'] ?? 'level';  // Get the order from the GET parameters, default to 'level'

// Determine the SQL order clause based on the selected order
if ($order === 'level') {
    $sqlOrder = "Level ASC, Title ASC";
} elseif ($order === 'alphabetical') {
    $sqlOrder = "Title ASC";
} else {
    die("Invalid order: " . htmlspecialchars($order));
}

$sql = "SELECT * FROM Courses ORDER BY $sqlOrder";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['Hide'] != 0) {
            include '../pages/course_block.php';
        }
    }
} else {
    echo "<p>No courses available.</p>";
}
?>
