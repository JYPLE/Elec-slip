<?php
// Database connection parameters
require_once 'db_connection.php';

// Establish database connection
$conn = connect_db();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'problem' field is set and not empty
    if (isset($_POST["problem"]) && !empty($_POST["problem"])) {
        // Retrieve the value of the 'problem' field
        $problem = $_POST["problem"];
        
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO field (problem) VALUES (?)");
        $stmt->bind_param("s", $problem);
        
        // Execute SQL statement
        if ($stmt->execute()) {
            header('Location: fiel_table.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        // If 'problem' field is empty or not set, display an error message
        echo "Problem field is required.";
    }
}

// Close connection
$conn->close();
?>
