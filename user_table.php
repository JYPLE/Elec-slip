<?php
                    session_start();
                    $conn = new mysqli("localhost", "root", "", "eslip");
                    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fixed Side Nav and Top Navbar with Search</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    /* Adjusting padding to make space for fixed top navbar */
    body {
        padding-top: 70px;
        background-color: #800000;
    }

    /* Fixed top navbar */
    .navbar-fixed-top {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1030;
    }

    /* Fixed side navbar */
    .sidenav {
        height: 100%;
        width: 200px;
        position: fixed;
        z-index: 1031;
        top: 56px; /* Height of top navbar */
        left: 0;
        background-color: green;
        padding-top: 20px;
    }

    /* Style for links in the side navbar */
    .sidenav a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 18px;
        color: white;
        display: block;
    }

    /* Style for active link in the side navbar */
    .sidenav a.active {
        background-color: #007bff;
        color: #fff;
    }

    /* Add padding to the main content area to prevent content from being hidden under the fixed side navbar */
    .main-content {
        margin-left: 250px; /* Width of the side navbar */
        padding: 20px;
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

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
    <a class="navbar-brand" href="#">CALL SLIP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="#">ADD FORM <i class="fas fa-plus"></i></a>
            </li> -->
         
        </ul>
        <!-- Search Form -->
        <form class="form-inline my-2 my-lg-0">
            <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." >
            <!-- <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button> -->
        </form>
    </div>
</nav>

<!-- Side Navbar -->
<div class="sidenav">
<a href="entry.php" class="agent"><i class="fas fa-arrow-alt-circle-left"></i>Back</a>
 <a href="register.php" class="agentEntry"><i class="fas fa-user-alt"></i>Add User</a>
 <!-- <a href="download.php" class="agentEntry"><i class="fas fa-file-excel"></i>Export Excel</a> -->

 <!-- <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a> -->
</div>
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

    <script>
  function searchTable() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.querySelector(".scrollable-table");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Start from index 1 to skip header row
        var found = false;
        td = tr[i].getElementsByTagName("td");

        for (var j = 0; j < td.length; j++) {
            var cell = td[j];
            if (cell) {
                var cellText = cell.textContent || cell.innerText;
                if (cellText.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
