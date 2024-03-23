<?php
session_start();
$conn = new mysqli("localhost", "root", "", "eslip");

// Check for POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user input from the form
    $userId = $_POST['user_id'];
    $fullName = $_POST['full_name'];
    $username = $_POST['username'];
    $userRole = $_POST['user_role'];

    // Prepare an SQL statement to update user data
    $sql = "UPDATE user SET full_name = ?, username = ?, user_role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fullName, $username, $userRole, $userId);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            // User updated successfully, redirect to user_table.php
            header('Location: user_table.php');
            exit(); // Ensure script stops execution after redirect
        } else {
            // No rows were affected, display a message
            echo "No rows were affected. User ID might be incorrect.";
        }
    } else {
        // Error occurred while executing SQL statement
        echo "Error updating user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
