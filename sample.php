<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>CALL - SLIP ENTRIES</title>
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
<a href="entry.php" class="back-button" onclick="history.back()" style="float: right; margin-right: 110px;">Back</a>
<form method="post">
    <label for="date_from">From:</label>
    <input type="date" id="date_from" name="date_from" value="<?php echo $date_from; ?>">
    <label for="date_to">To:</label>
    <input type="date" id="date_to" name="date_to" value="<?php echo $date_to; ?>">
    <label for="city">City:</label>
    <select id="city" name="city">
        <option value="">Select City</option>
        <?php foreach ($cities as $city) { ?>
            <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
        <?php } ?>
    </select>
   

<?php
// Establish connection to the database
$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch list of cities
$sql_cities = "SELECT DISTINCT city FROM slip_entry";
$result_cities = $conn->query($sql_cities);

$cities = array();
if ($result_cities && $result_cities->num_rows > 0) {
    while ($row = $result_cities->fetch_assoc()) {
        $cities[] = $row['city'];
    }
}

// Initialize variables for date range
$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-d');
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : date('Y-m-d');
$selected_city = isset($_POST['city']) ? $_POST['city'] : '';

// Filter entries based on the date range and selected city
$sql = "SELECT 
            barangay, 
            COUNT(*) AS entry_count,
            SUM(CASE WHEN pldt_existing = 'Yes' THEN 1 ELSE 0 END) AS pldt_yes_count,
            SUM(CASE WHEN pldt_existing = 'No' THEN 1 ELSE 0 END) AS pldt_no_count,
            SUM(CASE WHEN globe_existing = 'Yes' THEN 1 ELSE 0 END) AS globe_yes_count,
            SUM(CASE WHEN globe_existing = 'No' THEN 1 ELSE 0 END) AS globe_no_count,
            SUM(CASE WHEN converge_existing = 'Yes' THEN 1 ELSE 0 END) AS converge_yes_count,
            SUM(CASE WHEN converge_existing = 'No' THEN 1 ELSE 0 END) AS converge_no_count
        FROM slip_entry 
        WHERE entry_date BETWEEN '$date_from' AND '$date_to'";
if (!empty($selected_city)) {
    $sql .= " AND city = '$selected_city'";
}
$sql .= " GROUP BY barangay";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr>
    <th>Barangay</th>
    <th>Entry Count</th>
    <th>PLDT Existing Yes</th>
    <th>PLDT Existing No</th>
    <th>Globe Existing Yes</th>
    <th>Globe Existing No</th>
    <th>Converge Existing Yes</th>
    <th>Converge Existing No</th>
    <th>Number of Barangays</th>
    </tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["barangay"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["entry_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["pldt_yes_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["pldt_no_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["globe_yes_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["globe_no_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["converge_yes_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["converge_no_count"]) . "</td>";
        echo "<td id='num_barangays'></td>"; // Placeholder for number of barangays
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "No entries found";
}

$conn->close();
?>
<script>
    document.getElementById('city').addEventListener('change', function() {
        var city = this.value;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var barangays = JSON.parse(xhr.responseText);
                    var numBarangays = barangays.length;
                    document.getElementById('num_barangays').textContent = numBarangays;
                }
            }
        };
        xhr.open('GET', 'get_barangays.php?city=' + city, true);
        xhr.send();
    });
</script>
</body>
</html>










<!-- count table -->
<?php
 

// Establish connection to the database
$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for date range
$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-d');
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : date('Y-m-d');

// Filter entries based on the date range
$sql = "SELECT 
            barangay, 
            COUNT(*) AS entry_count,
            SUM(CASE WHEN pldt_existing = 'Yes' THEN 1 ELSE 0 END) AS pldt_yes_count,
            SUM(CASE WHEN pldt_existing = 'No' THEN 0 ELSE 0 END) AS pldt_no_count,
            SUM(CASE WHEN globe_existing = 'Yes' THEN 1 ELSE 0 END) AS globe_yes_count,
            SUM(CASE WHEN globe_existing = 'No' THEN 0 ELSE 0 END) AS globe_no_count,
            SUM(CASE WHEN converge_existing = 'Yes' THEN 1 ELSE 0 END) AS converge_yes_count,
            SUM(CASE WHEN converge_existing = 'No' THEN 0 ELSE 0 END) AS converge_no_count
        FROM slip_entry 
        WHERE entry_date BETWEEN '$date_from' AND '$date_to'
        GROUP BY barangay";
$result = $conn->query($sql);
// Fetch the entry details based on the provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM slip_entry WHERE id = $id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "<table class='scrollable-table'>";
    echo "<thead><tr>
    <th>Barangay</th>
    <th>Entry Count</th>
    <th>PLDT Existing Yes</th>
    <th>PLDT Existing No</th>
    <th>Globe Existing Yes</th>
    <th>Globe Existing No</th>
    <th>Converge Existing Yes</th>
    <th>Converge Existing No</th>
    </tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["barangay"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["entry_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["pldt_yes_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["pldt_no_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["globe_yes_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["globe_no_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["converge_yes_count"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["converge_no_count"]) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

} else {
    echo "No entries found";

}
$conn->close();
?>



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
    <title>CALL - SLIP ENTRIES</title>
    <style>
      .sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: green;
  overflow-x: hidden;
  transition: 0.1s;
  padding-top: 20px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.1s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 4px;
  font-size: 36px;
  margin-left: 10px;
}

/* Style for logout link */
.sidenav .logout {
  position: absolute;
  bottom: 20px;
  left: 20px;
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
            min-width: 1000px; /* Ensure the table is wide enough to demonstrate horizontal scrolling */
        }

        .scrollable-table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 1px;
            text-align: center;
           
            

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
  background-color:red;
}
        /* .search-container {
    display: flex;
    justify-content: center; /* Center horizontally */
   /* align-items: center;  Center vertically 
    margin-bottom: 100px;

*/
/* #searchInput {
    font-size: 16px;
    padding: 4px 8px;
    width: 1850px; 
 
}
 */
    </style>
</head>
<body>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- <a href="user_table.php">Agent</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a> -->
    <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Container for sidebar and table -->
<div class="container">
    <!-- Sidebar toggle button -->
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

    <!-- Rest of your content -->
    

    <h2 style="text-align: center;">CALL - SLIP ENTRIES</h2>
    <div class="container">
  <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="font-size: 16px; padding: 4px 8px; margin-right: auto; margin-left: 280px; width: 200px;">
  <!-- <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="font-size: 16px; padding: 4px 8px; margin-right: auto; margin-left: 20px; width: 150px;"> -->
  
  <button onclick="location.href='e-form.php';" style="margin-left: 563px; margin-right: auto;">Add Form</button>
</div>
    <div class="scrollable-div">
  
        <table class="scrollable-table">
            <thead>
            <tr>
                <th>Entry Number</th>
                <th>Full Name</th>
                <th>Entry Date</th>
                <th>Zone</th>
                <th>Barangay</th>
                <th>Action</th>
                <!-- <th>View</th> -->
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
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td><a href='view.php?id=" . $row["id"] . "'>" . $row["name"] . "</a></td>";
                         echo "<td>" . $row["entry_date"] . "</td>";
                        echo "<td>" . $row["zone"] . "</td>";
                        echo "<td>" . $row["barangay"] . "</td>";
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

<!-- JavaScript code for sidebar functionality -->
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    


        function searchTable() {
            var input, filter, table, tr, td, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.querySelector(".scrollable-table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
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
