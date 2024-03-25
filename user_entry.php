<?php
session_start(); // Start the session to access logged-in user information

$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<title>Admin Monitoring</title>
<style>
/* Sidebar styles */
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #a8e4a0;
  overflow-x: hidden;
  transition: 0.1s;
  padding-top: 10px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 20px;
  color: #800000;
  display: block;
  transition: 0.1s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 2px;
  font-size: 36px;
  margin-left: 10px;
}

/* Style for logout link */
.sidenav .logout {
  position: absolute;
  bottom: 10px;
  left: 5px;
}

        .scrollable-div {
            overflow-x: auto;
            overflow-y: auto;
            width: 100%; /* Adjust based on your layout needs */
            height: 300px; /* Set a height to enable vertical scrolling */
        }

        .scrollable-table {
            border-collapse: collapse;
            width: auto; /* Set to auto for horizontal scrolling */
            min-width: 500px; /* Ensure the table is wide enough to demonstrate horizontal scrolling */
            background-color: white;
        }

        .scrollable-table, th, td {
            border: 1px solid #ddd;
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
        table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
    margin-left: auto;
    margin-right: auto;
   
    
}
body{
  background-color:#800000;
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
    

        * {
  box-sizing: border-box;
}

#searchInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}


</style>
   
</head>
<body>
  
  <!-- Sidebar -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <!-- <a href="user_table.php">Agent</a>
 <a href="count.php">Agent Entry</a> -->
  <!-- <a href="#">Clients</a>
  <a href="#">Contact</a> -->
  <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Container for sidebar and table -->
<div class="container">
    <!-- Sidebar toggle button -->
    <span style="color:white;font-size:20px;cursor:pointer" onclick="openNav()">&#9776;</span>
    
     <!-- Search bar -->
     <!-- <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names..." style="font-size: 16px; padding: 8px;"> -->
     <!-- <div style="text-align: center;">
        <label for="entry_date">From:</label>
        <input type="date" id="entry_date" name="entry_date">
        <label for="entry_date">To:</label>
        <input type="date" id="entry_date" name="entry_date">
        <button onclick="filterTable()">Apply Filter</button>
    </div> -->

    
    
    <!-- Generate button -->
    <!-- <button onclick="generateTable()">Show</button> -->
<!-- <button onclick="exportToExcel()">Download Excel</button> -->
<h2 style="text-align: center;">CALL - SLIP ENTRIES</h2>








<div class="container">
  <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="font-size: 16px; padding: 8px 10px; margin-right: auto; margin-left: 200px; width: 250px;">
  <!-- <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="font-size: 16px; padding: 4px 8px; margin-right: auto; margin-left: 20px; width: 150px;">
  
 <a href="download.php" onclick="exportToExcel()" style="text-decoration: none;">
    <button style="font-size: 16px; margin: 10px 20px 10px auto; float: right;">Download</button>
</a> -->
  <button onclick="location.href='e-form.php';" style="margin-left: 500px; margin-right: auto;">Add Form</button>

 


  <div class="scrollable-div">
 <table class="scrollable-table" >


        <thead>
            <tr>
           <th>Entry Number</th>
           <th style='background-color: green; border: 1px solid #ddd; padding: 4px; text-align: center;'>Entry Date</th>
    <th style='background-color: green; border: 1px solid #ddd; padding: 4px; text-align: center;'>Full Name</th>
  <th style='background-color: green; border: 1px solid #ddd; padding: 4px; text-align: center;'>Zone</th>
    <th style='background-color: green; border: 1px solid #ddd; padding: 4px; text-align: center;'>Barangay</th>
    <th style='background-color: green; border: 1px solid #ddd; padding: 4px; text-align: center;'>ACTION</th>
    <!-- <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>City</th> 
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Province</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>LCP</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Contact Number</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>NAP</th>
 <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>AGENT</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>LATITUDE</th> 
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>LONGITUDE</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING PLDT</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING PLDT SALES NEW</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING PLDT SALES SWITCH</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING GLOBE</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING GLOBE SALES NEW</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING GLOBE SALES SWITCH</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING CONVERGE</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING CONVERGE SALES NEW</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>EXISTING CONVERGE SALES SWITCH</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'> NO PROVIDERS</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>  PROVIDERS SALES NEW</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>  PROVIDERS SALES SWITCH</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>UNENGAGED</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>  UNENGAGED SALES NEW</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>  UNENGAGED SALES SWITCH</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>OTHER PROVIDER</th>
 <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'> PRICE</th>
 <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>SATISFIED</th>
 <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'> LOCKED-IN</th>
<th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>OTHERS</th>
<th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>ACTION</th>
 <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: center;'>USER</th>"; -->
            </tr>
        </thead>
        <tbody>
        <?php
           
           // Check if user is logged in
           if (isset($_SESSION['userdata']) && $_SESSION['userdata']['user_role'] == "agent") {
               $agent = $_SESSION['userdata']['username'];

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
                    echo "<td>" . htmlspecialchars($row["zone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["barangay"]) . "</td>";
                       echo "<td><a href='edit.php?id=" . $row["id"] . "' class='edit-button'><i class='fas fa-edit edit-icon'></i> Edit</a></td>";
                       // echo "<td><a href='view.php?id=" . $row["id"] . "' class='edit-button'><i class='fas fa-view view-icon'></i> View</a></td>";
                       echo "</tr>";
                   }
               } else {
                   // echo "No entries found for the agent: $agent";
                   // echo "<br><a href='e-form.php'><button>Add Entry</button></a>";
               }

           } else {
               echo "You are not logged in or not authorized to view this page.";
           }

           $conn->close();
           ?>
           </tbody>
       </table>
   </div>
   </div>
        </div>
<!-- JavaScript for sidebar functionality -->


<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementsByClassName("container")[0].style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementsByClassName("container")[0].style.marginLeft = "0";

}

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
</body>
</html>