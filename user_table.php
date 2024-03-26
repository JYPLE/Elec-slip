<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALL - SLIP ENTRIES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            margin-top: 20px;
        }

        .scrollable-div {
    overflow-x: auto;
    overflow-y: auto;
    width: 100%;
    height: 350px;
    display: flex;
    justify-content: center;
    align-items: center;
}
        .scrollable-table {
            border-collapse: collapse;
            width: auto; /* Set to auto for horizontal scrolling */
            min-width: 600px; /* Ensure the table is wide enough to demonstrate horizontal scrolling */
            background-color: white;
        }

        .scrollable-table, th, td {
            border: 1px solid #ddd;
        }

        th, h2 {
            padding: 8px;
            text-align: center;
            color: white;
            color:white;
        }

        td {
            padding: 8px;
            text-align: center;
            color: white;
            color:black;
        }
        thead th {
            position: sticky;
            top: 0;
            background-color: green;
            z-index: 1;
        }

        thead th:nth-child(-n+2) {
            position: sticky;
            left: 0;
            background-color: ;
            z-index: 1;
        }
      
        .edit-button {
            padding: 5px 10px;
            border: none;
            background-color: green;
            color: #fff;
            cursor: pointer;
            text-decoration: none; /* Remove default underline */
            display: inline-block; /* Make it inline-block to adjust width */
        }

        .edit-button:hover {
            background-color: red;
        }

        .edit-icon {
            margin-right: 5px;
        }
        .back-button:hover {
            background-color: #bbb;
        }
        body{
            background-color: #800000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User</h2>
   <!-- Your search input and buttons can be added here if needed -->
   <a href="entry.php" class="back-button" onclick="history.back()" style="color: white; float: right; margin-right: 200px;">
    <i class="fas fa-arrow-alt-circle-left"></i>back
</a>
<!-- Add button -->
<button class="add-button" onclick="window.location.href='register.php'" style="float: left; margin-left: 110px;">Add New Entry</button>

    <div class="scrollable-div">
        <table class="scrollable-table" data-fixed-columns="true" data-fixed-number="2">
            <thead>
                <tr>
                   <th>Full Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                    session_start();
                    $conn = new mysqli("localhost", "root", "", "eslip");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM user";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["full_name"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["user_role"] . "</td>";
                            // Adding Font Awesome icon alongside the Edit text
                            echo "<td><a href='edit_entry.php?id=" . $row["user_id"] . "' class='edit-button'><i class='fas fa-edit edit-icon'></i> Edit</a></td>";
                            // echo "<td><a href='user_entry.php' class='custom-button'>Button Text</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No entries found.</td></tr>";
                    }

                    $conn->close();
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
