<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "OnlineCSchool";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
