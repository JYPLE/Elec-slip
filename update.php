<?php
// Initialize the database connection
$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $entry_id = $_GET['id']; // Retrieve the ID from the URL
    $name = $_POST['name']; // Assuming 'name' is the field to update

    // Update the entry in the database
    $sql = "UPDATE slip_entry SET name = '$name' WHERE id = $entry_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
