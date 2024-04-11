
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="android" content="width=device-width, initial-scale=1.0">
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
        padding-top: 100px;
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
        height: 95%;
        width: 200px;
        position: fixed;
        z-index: 1031;
        top: 102px; /* Height of top navbar */
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
        color: white;
    }

    /* Add padding to the main content area to prevent content from being hidden under the fixed side navbar */
    .main-content {
        margin-left: 250px; /* Width of the side navbar */
        padding: 10px;
    }
    .scrollable-div {
            overflow-x: auto;
            overflow-y: auto;
            width: 80%; /* Adjust based on your layout needs */
            height: 500px; /* Set a height to enable vertical scrolling */
            margin-left: auto;
           
        }

        .scrollable-table {
            border-collapse: collapse;
           width: auto; /*Set to auto for horizontal scrolling */
            min-width: 100px;  /* Ensure the table is wide enough to demonstrate horizontal scrolling */
            background-color: white;
        }

        .scrollable-table, th, td {
            border: 2px solid black;
        }

         td {
            padding: 1px;
            text-align: center;
            color: black;
        }
        th, h2{
          padding: 1px;
            text-align: center;
            color: white;
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
            background-color: green;
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
    

      

/* Style for logout link */
.sidenav .logout {
  position: absolute;
  bottom: 60px;
  left: 5px;
}

</style>
</head>
<body>
<?php
session_start(); // Start the session to access logged-in user information

$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
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
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="margin-right: 150px;">
            <!-- <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button> -->
        </form>
    </div>
</nav>

<!-- Side Navbar -->
<div class="sidenav">
 
                <a class="nav-link" href="e-form.php">ADD FORM <i class="fas fa-plus"></i></a>
           
<!-- <a href="count.php" class="agentEntry"><i class="fas fa-chart-bar"></i>Agent Entry</a>
 <a href="download.php" class="agentEntry"><i class="fas fa-file-excel"></i>Export Excel</a> -->

 <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
<div class="scrollable-div">
 <table class="scrollable-table" >


        <thead>
            <tr>
           <th>Entry Number</th>
           <th >Entry Date</th>
    <th >Full Name</th>
    <th>Contact Number</th>
  <th >Zone</th>
    <th>Barangay</th>
    <th>ACTION</th>

            </tr>
        </thead>
        <tbody>
        <?php
// Check if user is logged in
if (isset($_SESSION['userdata']) && $_SESSION['userdata']['user_role'] == "agent") {
    $agent = $_SESSION['userdata']['username'];

    // Check if a new entry has been made (you need to replace 'YOUR_POST_FIELD_NAMES' with the actual names of your form fields)
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['YOUR_POST_FIELD_NAMES'])) {
        // Insert new entry into the database (assuming you have code here to insert the entry)

        // Fetch entries for the logged-in agent
        $sql = "SELECT * FROM slip_entry WHERE agent = '$agent' ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            

            // Display table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["entry_date"]) . "</td>";
                echo "<td><a href='view.php?id=" . $row['id'] . "'>" . htmlspecialchars($row["name"]) . "</a></td>";
                echo "<td>" . htmlspecialchars($row["contact"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["zone"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["barangay"]) . "</td>";
                echo "<td><a href='edit.php?id=" . $row["id"] . "' class='edit-button'><i class='fas fa-edit edit-icon'></i> Edit</a></td>";
                echo "</tr>";
            }

            // Close the table
            echo "</table>";
        } else {
            // echo "No entries found for the agent: $agent";
            // echo "<br><a href='e-form.php'><button>Add Entry</button></a>";
        }

        // Calculate the date and time one hour ago
        $truncate_datetime = date('Y-m-d H:i:s', strtotime('-1 hour'));

        // Truncate entries older than one hour
        $truncate_sql = "DELETE FROM slip_entry WHERE agent = '$agent' AND entry_date < '$truncate_datetime'";
        if ($conn->query($truncate_sql) !== TRUE) {
            echo "Error truncating entries: " . $conn->error;
        }
    } else {
        // Fetch entries for the logged-in agent
        $sql = "SELECT * FROM slip_entry WHERE agent = '$agent' ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Display table header
            // echo "<table>";
            // echo "<tr><th>ID</th><th>Entry Date</th><th>Name</th><th>Zone</th><th>Barangay</th><th>Action</th></tr>";

            // Display table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["entry_date"]) . "</td>";
                echo "<td><a href='view.php?id=" . $row['id'] . "'>" . htmlspecialchars($row["name"]) . "</a></td>";
                echo "<td>" . htmlspecialchars($row["contact_number"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["zone"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["barangay"]) . "</td>";
                echo "<td><a href='edit.php?id=" . $row["id"] . "' class='edit-button'><i class='fas fa-edit edit-icon'></i> Edit</a></td>";
                echo "</tr>";
            }

            // Close the table
            echo "</table>";
        } else {
            // echo "No entries found for the agent: $agent";
            // echo "<br><a href='e-form.php'><button>Add Entry</button></a>";
        }
    }
} else {
    echo "You are not logged in or not authorized to view this page.";
}

$conn->close();
?>
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

           </tbody>
       </table>
   </div>
   </div>
        </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
