<?php 
include '../includes/db_connection.php';

$sql = "SELECT * FROM Courses";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->execute();
$courses = $stmt->get_result();

$sql = "SELECT Title FROM Level";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->execute();
$levelsTitle = $stmt->get_result();
?>

<div id="add-courses">
    <div class="admin-header">
        <h2>Add Courses</h2>
    </div>

    <div class="courses-container">
        <?php
        if ($courses->num_rows > 0) {
            while ($row = $courses->fetch_assoc()) {
                if ($row['Hide'] != 0) {
                    include 'course_block.php';
                }
            }
        } else {
            echo "<p>No courses available.</p>";
        }
        ?>

        <div class="course-block add-course-button">
            <button id="add-course-btn">Plus</button>
            <form id="add-course-form" style="display: none;">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title">

                <label for="level">Level:</label>
                <select id="level" name="level">
                    <option value="">Select a level</option>
                    <?php
                    foreach ($levelsTitle as $level) {
                        echo '<option value="' . $level['Title'] . '">' . $level['Title'] . '</option>';
                    }
                    ?>
                </select>

                <label for="description">Description:</label>
                <textarea id="description" name="description"></textarea>

                <label for="duration">Duration:</label>
                <input type="text" id="duration" name="duration">

                <input type="submit" value="Add Course">
            </form>
        </div>
    </div>
</div>