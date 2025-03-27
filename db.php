<?php
// db.php
$servername = "localhost";      // or your server's IP
$dbUsername = "root";          // your DB username
$dbPassword = "";              // your DB password
$dbName = "password_generator"; // your DB name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
