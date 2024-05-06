<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>OnlineEdu</title>
    <link rel="stylesheet" type="text/css" href="../styles/styles.css">
</head>

<body>
    <header>
        <div class="header-content">
            <div id="branding">
                <h1><a href="index.php" id="logo">OnlineEdu</a></h1>
            </div>
            <nav>
                <ul>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['admin']) : ?>
                        <li>
                            <a href="admin_page.php">Admin Panel</a>
                        </li>
                    <?php endif; ?>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li>
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <a href="profile.php">Profile</a>
                        <?php else : ?>
                            <a href="login.php">Login</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>