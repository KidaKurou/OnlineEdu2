<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="admin-panel">
        <div class="admin-menu">
            <div class="admin-header">
                <h2>Admin Panel</h2>
            </div>
            <ul>
                <li><a href="#" id="add-course-link" class="actual">Add Courses</a></li>
                <li><a href="#" id="edit-course-link">Edit Courses</a></li>
                <li><a href="#" id="delete-course-link">Delete Courses</a></li>
                <li><a href="#" id="user-info-link">User Info</a></li>
            </ul>
        </div>

        <div class="admin-container">
            <div class="admin-header"></div>
            <div class="courses-container"></div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="../js/admin.js"></script>
</body>

</html>