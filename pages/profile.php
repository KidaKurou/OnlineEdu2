<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include '../includes/db_connection.php';

// Get the user's information
$sql = "SELECT * FROM Users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Get the user's courses
$sql = "SELECT c.CourseID, c.Title, uc.Status, c.Level FROM UserCourses uc JOIN Courses c ON uc.CourseID = c.CourseID WHERE uc.UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$courses = $stmt->get_result();

// Update user level based on completed courses
$levels = ['Beginner', 'Junior', 'Middle', 'Senior'];
$maxLevel = 'Beginner';
while ($course = $courses->fetch_assoc()) {
    if ($course['Status'] == 'Completed' && array_search($course['Level'], $levels) > array_search($maxLevel, $levels)) {
        $maxLevel = $course['Level'];
    }
}
if ($maxLevel != $user['Level']) {
    $sql = "UPDATE Users SET Level = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $maxLevel, $_SESSION['user_id']);
    $stmt->execute();
    $user['Level'] = $maxLevel;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?> <!-- Include your header file -->
    <div class="profile">
        <h2>Profile</h2>
        <p>Name: <?php echo $user['FirstName']; ?></p>
        <p>Surname: <?php echo $user['LastName']; ?></p>
        <p>Email: <?php echo $user['Email']; ?></p>
        <p>Level: <?php echo $user['Level']; ?></p>
        <h3>Courses</h3>
        <?php foreach ($courses as $course) : ?>
            <div class="course-profile">
                <h4><?php echo $course['Title']; ?></h4>
                <p>Status: <?php echo $course['Status']; ?></p>
                <?php if ($course['Status'] == 'In Progress') : ?>
                    <!-- <div class="btn-group">
                        <form action="../processes/unsubscribe.php" method="post">
                            <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                            <input class="btn" type="submit" value="Unsubscribe">
                        </form>
                        <form action="../processes/finish.php" method="post">
                            <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                            <input class="btn" type="submit" value="Finish">
                        </form>
                    </div> -->
                    <div class="btn-group">
                        <button class="btn unsubscribe-btn" data-course-id="<?php echo $course['CourseID']; ?>">Unsubscribe</button>
                        <button class="btn finish-btn" data-course-id="<?php echo $course['CourseID']; ?>">Finish</button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <form action="../processes/logout.php" method="post">
            <input class="logout" type="submit" value="Logout">
        </form>
    </div>
    <?php include 'footer.php'; ?> <!-- Include your footer file -->
    <script>
        $(document).ready(function() {
            // Handle the Unsubscribe button click
            $('.unsubscribe-btn').click(function(e) {
                e.preventDefault();
                var courseId = $(this).data('course-id');
                var courseBlock = $(this).closest('.course-profile');
                $.ajax({
                    url: '../processes/unsubscribe.php',
                    type: 'post',
                    data: {
                        course_id: courseId
                    },
                    success: function(response) {
                        // alert('Unsubscribed successfully!');
                        showAlert('Unsubscribed successfully!');
                        courseBlock.remove();
                    },
                    error: function() {
                        alert('An error occurred.');
                    }
                });
            });

            // Handle the Finish button click
            $('.finish-btn').click(function(e) {
                e.preventDefault();
                var courseId = $(this).data('course-id');
                var courseBlock = $(this).closest('.course-profile');
                $.ajax({
                    url: '../processes/finish.php',
                    type: 'post',
                    data: {
                        course_id: courseId
                    },
                    success: function(response) {
                        // alert('Course finished successfully!');
                        showAlert('Course finished successfully!');
                        courseBlock.find('.btn-group').remove(); // Remove the buttons
                        courseBlock.find('p:contains("Status:")').text('Status: Completed'); // Update the status
                    },
                    error: function() {
                        alert('An error occurred.');
                    }
                });
            });

            function showAlert(message) {
                var alertBox = $('<div></div>').addClass('alert-message').text(message);
                $('body').append(alertBox);
                alertBox.fadeIn();
                setTimeout(function() {
                    alertBox.fadeOut();
                }, 5000);
            }
        });
    </script>

</body>

</html>