<?php
$servername = "localhost";
$username = ""; // Your MySQL username
$password = ""; // Your MySQL password
$database = "eslip"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

