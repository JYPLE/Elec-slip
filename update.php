<?php

$conn = new mysqli("localhost", "root", "", "eslip");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $entry_id = $_GET['id']; // Retrieve the ID from the URL
    $name = $_POST['name']; // Assuming 'name' is the field to update

   
    $sql = "UPDATE slip_entry SET name = '$name' WHERE id = $entry_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


$conn->close();
?>
