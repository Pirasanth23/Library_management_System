<?php
$servername = "localhost";
$username   = "root";   // change if you set a password
$password   = "";
$database   = "library_db"; // use the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // test line
?>
