<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // Replace with your DB username
$password = "";      // Replace with your DB password
$dbname = "suara_nesia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
