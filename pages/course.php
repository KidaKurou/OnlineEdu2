<?php
// Start the session
session_start();

// Include the database connection file
include '../includes/db_connection.php';

// Check if the user is logged in
$loggedIn = isset($_SESSION['user_id']);

// Get the course ID from the URL parameters
$courseId = $_GET['id'];

// Check if user already subscribed. Subscribe button will be disabled if user already subscribed
if ($loggedIn) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM UserCourses WHERE UserID = ? AND CourseID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param('ii', $userId, $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCourse = $result->fetch_assoc();
    $stmt->close();
}

// Prepare and execute the SQL statement
$sql = "SELECT * FROM Courses WHERE CourseID = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param('i', $courseId);
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$course = $result->fetch_assoc();

// Close the statement
$stmt->close();
?>
<html>

<head>
    <title><?php echo $course['Title']; ?></title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?> <!-- Include your header file -->
    <div class="course">
        <img src="../processes/image2.php?table=Courses&id=<?php echo $course['CourseID']; ?>" alt="<?php echo $course['Title']; ?>">
        <div class="course-details">
            <h2><?php echo $course['Title']; ?></h2>
            <p>Level: <?php echo $course['Level']; ?></p>
            <p>Description: <?php echo $course['Description']; ?></p>
            <p>Duration: <?php echo $course['Duration']; ?></p>
            <form id="subscribe-form" method="post">
                <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                <?php if ($loggedIn && !$userCourse) : ?>
                    <input type="submit" value="Subscribe" class="btn" id="subscribe-button">
                <?php else : ?>
                    <input type="submit" value="Subscribe" class="btn disabled" disabled>
                <?php endif; ?>
            </form>
            <?php if (!$loggedIn) echo '<p class="alert">You must be logged in to subscribe.</p>'; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?> <!-- Include your footer file -->
    <script>
        $(document).ready(function() {
            $('#subscribe-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '../processes/subscribe.php',
                    type: 'post',
                    data: $(this).serialize(),
                    success: function() {
                        $('#subscribe-button').prop('disabled', true);
                        // alert('Subscription successful!');
                        showAlert('Subscription successfully!');
                        $('#subscribe-button').attr('disabled');
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
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