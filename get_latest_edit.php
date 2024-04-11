<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get entry ID from the AJAX request
$id = $_GET['id'];

// Query to fetch details of the latest edited entry with the given ID
$sql = "SELECT * FROM slip_entry WHERE id = $id";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch the latest edited entry details
    $entry = $result->fetch_assoc();
    // Return JSON response
    
    echo json_encode($entry);
} else {
    // No entry found with the given ID
    echo json_encode(array('error' => 'Entry not found'));
}

// Close connection
$conn->close();
?>
