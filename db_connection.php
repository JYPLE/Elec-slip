<?php
function connect_db() {
    // Database connection
    $host = "localhost"; // Change this to your host
    $username = "root"; // Change this to your username
    $password = ""; // Change this to your password
    $database = "eslip"; // Change this to your database name

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
