<?php
session_start();

require_once 'db_connection.php'; // Include database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connect_db(); // Connect to the database

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and bind SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Store user data in session
            $_SESSION['userdata'] = $row;
            // Redirect based on user role
            if ($row["user_role"] == "admin") {
                header('Location: entry.php');
                exit(); // Stop further execution
            } elseif ($row["user_role"] == "agent") {
                header('Location: user_entry.php');
                exit(); // Stop further execution
            }
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "User not found";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Display login form or error message
?>