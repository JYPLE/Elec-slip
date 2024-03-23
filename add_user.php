<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
<?php
require_once 'db_connection.php';

// Establish database connection
$conn = connect_db();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both full name, username, password, and user role are provided
    if (isset($_POST["full_name"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["user_role"])) {
        // Retrieve and sanitize inputs
        $full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $user_role = mysqli_real_escape_string($conn, $_POST["user_role"]);

        // Check if the username already exists
        $existing_username = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
        // Check if the full name already exists
        $existing_full_name = mysqli_query($conn, "SELECT * FROM user WHERE full_name='$full_name'");

        if (mysqli_num_rows($existing_username) > 0) {
            echo "Username already exists. Please choose a different username.";
        } elseif (mysqli_num_rows($existing_full_name) > 0) {
            echo "Full name already exists. Please choose a different full name.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO user (full_name, username, password, user_role) VALUES (?, ?, ?, ?)");

            // Check if the statement is prepared successfully
            if ($stmt) {
                $stmt->bind_param("ssss", $full_name, $username, $hashed_password, $user_role);

                // Execute SQL statement
                if ($stmt->execute()) {
                    // Retrieve the user_id of the registered agent
                    $user_id = $stmt->insert_id;
                    header('Location: user_table.php');
                    // Close statement
                    $stmt->close();
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    } else {
        // If full name, username, password, or user role is not provided
        echo "Full name, username, password, and user role are required.";
    }
    // Close connection
    $conn->close();
}
?>
