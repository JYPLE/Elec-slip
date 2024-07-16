<?php

$conn = new mysqli("localhost", "root", "", "eslip");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = $_GET['id'];


$sql = "SELECT * FROM slip_entry WHERE id = $id";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
   
    $entry = $result->fetch_assoc();
   
    
    echo json_encode($entry);
} else {
   
    echo json_encode(array('error' => 'Entry not found'));
}


$conn->close();
?>
