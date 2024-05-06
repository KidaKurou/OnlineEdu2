<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="centered-form">
        <h2>Login</h2>
        <form action="../processes/login_process.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
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
