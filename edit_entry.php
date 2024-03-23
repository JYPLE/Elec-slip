<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #800000;
        }
        form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: green;
        }
        h2 {
            text-align: center;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: green;
        }
    </style>
</head>
<body>
<?php
// Start the session and include your database connection file
session_start();
$conn = new mysqli("localhost", "root", "", "eslip");

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch the user data based on the ID
    $sql = "SELECT * FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!-- Display the user data in a form -->
        <form action="update_entry.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            Full Name: <input type="text" name="full_name" value="<?php echo $row['full_name']; ?>"><br>
            Username: <input type="text" name="username" value="<?php echo $row['username']; ?>"><br>
            Role: <select name="user_role">
                <option value="admin" <?php echo ($row['user_role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="agent" <?php echo ($row['user_role'] == 'agent') ? 'selected' : ''; ?>>Agent</option>
                <!-- Add other roles as needed -->
            </select><br>
            <input type="submit" value="Update">
        </form>
        <?php
    } else {
        echo "User not found.";
    }
    $stmt->close();
} else {
    echo "No user ID provided.";
}
$conn->close();
?>
</body>
</html>
