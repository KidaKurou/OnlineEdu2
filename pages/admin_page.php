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
                <li><a href="#" id="deleted-course-link">Delete Courses</a></li>
                <li><a href="#" id="users-feedback-link">Users Feedback</a></li>
                <!-- <li><a href="#" id="users-info-link">Users Info</a></li> -->
            </ul>
        </div>

        <div class="admin-container">
            <div class="admin-header admin-header-panel"></div>
            <div class="courses-container"></div>
            <h2>Previouse Course Info</h2>
            <div class="previous-courses-info" style="width: 80%; display: flex; justify-content: space-between;">
                <div class="previous-data">
                    <h3>Previous Data</h3>
                </div>
                <div class="new-data">
                    <h3>New Data</h3>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="../js/admin_add_course.js"></script>
    <script src="../js/admin_edit_course.js"></script>
    <script src="../js/admin_deleted_course.js"></script>
    <script src="../js/admin_user_feedback.js"></script>
</body>

</html>