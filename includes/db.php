<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sportsbuddy";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Optional: set character encoding to UTF-8
mysqli_set_charset($conn, "utf8");
?>
