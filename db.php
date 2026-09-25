<?php
// db.php — shared database connection
// Default XAMPP settings: user "root", no password.
// If your MySQL has a password, set it below.

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "Hotel_management";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}