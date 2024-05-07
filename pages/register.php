<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="centered-form">
        <h2>Register</h2>
        <form action="../processes/register_process.php" method="post">
            <label for="fname">First Name:</label><br>
            <input type="text" id="fname" name="fname" required><br>
            <label for="lname">Last Name:</label><br>
            <input type="text" id="lname" name="lname" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
        <?php
        // Display error message if set
        if (isset($_SESSION['error'])) {
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);  // Clear the error message
        }
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
