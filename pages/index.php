<?php
include 'header.php';
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

// $sql = "SELECT * FROM Courses";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}

echo '<div class="container"><h2>Welcome to Our Course Website</h2>
        <p>Here you can find a variety of courses to suit your learning needs.</p></div>';

// Add the sorting dropdown
echo '<div class="sort"><form action="index.php" method="get">
        <label for="order">Sort by:</label>
        <select id="order" name="order" onchange="this.form.submit()">
            <option value="level"' . ($order === 'level' ? ' selected' : '') . '>Level</option>
            <option value="alphabetical"' . ($order === 'alphabetical' ? ' selected' : '') . '>Alphabetical</option>
        </select>
      </form></div>';

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="courses-container">';
    while ($row = $result->fetch_assoc()) {
        if ($row['Hide'] != 0) {
            include 'course_block.php';
        }
        // include 'course_block.php';
    }
    echo '</div>';
} else {
    echo "<p>No courses available.</p>";
}

include 'footer.php';
?>
