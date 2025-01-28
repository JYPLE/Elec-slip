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
  background-color: #111;
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
            height: 500px; /* Set a height to enable vertical scrolling */
        }

        .scrollable-table {
            border-collapse: collapse;
            width: auto; /* Set to auto for horizontal scrolling */
            min-width: 500px; /* Ensure the table is wide enough to demonstrate horizontal scrolling */
        }

        .scrollable-table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 1px;
            text-align: left;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            z-index: 1;
        }

        thead th:nth-child(-n+2) {
            position: sticky;
            left: 0;
            background-color: #f2f2f2;
            z-index: 1;
        }
        table {
    width: 50%;
    border-collapse: collapse;
    margin-bottom: 40px;
    margin-left: auto;
    margin-right: auto;
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
  <a href="entry.php" class="logout"><i class="fas fa-sign-out-alt"></i> Back</a>
</div>

<!-- Container for sidebar and table -->
<div class="container">
    <!-- Sidebar toggle button -->
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
    
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
  <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search..." style="font-size: 16px; padding: 4px 8px; margin-right: auto; margin-left: 20px; width: 150px;">
  
  <button onclick="exportToExcel()" style="font-size: 16px; margin: 10px 20px 10px auto; float: right;">Download CSV</button>
</div>







<div class="scrollable-div">
 <table class="scrollable-table" id="entriesTable">

        <thead>
            <tr>
           <th>Entry Number</th>
           <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Entry Date</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Full Name</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Zone</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Barangay</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>City</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Province</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>LCP</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>Contact Number</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>NAP</th>
   <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>AGENT</th>
    <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>LATITUDE</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>LONGITUDE</th>
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>IMAGE</th>
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
  <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>NOT SIGNING IN</th>
<th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>OTHERS</th>
<!-- <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 4px; text-align: center;'>ACTION</th> -->
<!-- <th style='background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px; text-align: center;'>USER</th>"; -->
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "eslip");

            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM slip_entry";
            if(isset($_POST['entry_date']) && isset($_POST['entry_date'])) {
                $entry_date = $_POST['entry_date'];
                $entry_date = $_POST['entry_date'];
                // Add date filter to SQL query
                $sql .= " WHERE DATE(entry_date) BETWEEN '$entry_date' AND '$entry_date'";
            }
            
            $sql .= " ORDER BY id DESC";
            
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $entries = array();
                while($row = $result->fetch_assoc()) {
                    // Only add entries within the date range to the array
                    $entry_date = date('Y-m-d', strtotime($row['entry_date']));
                    if ($entry_date >= $entry_date && $entry_date <= $entry_date) {
                        $entries[] = $row;
                    }
                }
              }
            
        
            // Handle file upload
            $nap_target_file = '';
            if (isset($_FILES['nap']) && $_FILES['nap']['error'] == UPLOAD_ERR_OK) {
              $nap_target_dir = "uploads/";
              $nap_target_file = $nap_target_dir . basename($_FILES["nap"]["name"]);
              move_uploaded_file($_FILES["nap"]["tmp_name"], $nap_target_file);
            }

            // Display image in the table

            // Select query
            $sql = "SELECT * FROM slip_entry ORDER BY id DESC";

    //  $sql = "SELECT * FROM user.user_id, slip_entry.user
    //         FROM user
    //         Inner Join slip_entry on user.user_id=name.user_id";
// Fetch entries for the logged-in agent
// $sql = "SELECT * FROM slip_entry WHERE agent = '$agent' ORDER BY entry_date";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $entry_number = $result->num_rows;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    // Ensure your table data matches these fields
                    echo "<td>" . $entry_number-- . "</td>";
                    echo "<td>" . htmlspecialchars($row["entry_date"]) . "</td>";
                    echo "<td><a href='view.php?id=" . $row['id'] . "'>" . htmlspecialchars($row["name"]) . "</a></td>";
                    echo "<td>" . htmlspecialchars($row["zone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["barangay"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["city"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["province"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["lcp"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["contact_number"]) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row["nap"]) . "' alt='NAP Image' style='width:100px;height:auto;'></td>";
                    echo "<td>" . htmlspecialchars($row["agent"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["latitude"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["longitude"]) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row["image"]) . "' alt='Image' style='width:100px;height:auto;'></td>";
                    echo "<td>" . htmlspecialchars($row["pldt_existing"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["pldt_sales_new"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["pldt_sales_switch"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["globe_existing"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["globe_sales_new"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["globe_sales_switch"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["converge_existing"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["converge_sales_new"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["converge_sales_switch"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["no_providers_existing"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["no_providers_sales_new"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["no_providers_sales_switch"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["unengaged_existing"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["unengaged_sales_new"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["unengaged_sales_switch"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["other_prov"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["field_probs"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["others_not_signing_up"]) . "</td>";
                    // echo "<td><button onclick='viewEntry(" . $row['id'] . ")'>View</button></td>";
                    // echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                    // Add more data cells as needed
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No entries found</td></tr>";
            }
          // Close connection
$conn->close();
?>
</div>

<!-- JavaScript for sidebar functionality -->
<script>

    function filterTable() {
            var entry_date = document.getElementById("entry_date").value;
            var entry_date = document.getElementById("entry_date").value;
            fetch('fetch_slip_entries.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                      entry_date: entry_date,
                      entry_date: entry_date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    generateTable(data.entries);
                })
                .catch(error => console.error('Error:', error));
        }

        function generateTable(entries) {
            const table = document.getElementById('entriesTable');
            table.innerHTML = ''; // Clear current table contents

            // Create table headers
            const headers = ["Entry Number", "Entry Date", "Name", "Zone", "Barangay", "City", "Province", "LCP", "Contact Number", "NAP", "AGENT", "LATITUDE", "LONGITUDE", "EXISTING PLDT", "EXISTING PLDT SALES NEW", "EXISTING PLDT SALES SWITCH", "EXISTING GLOBE", "EXISTING GLOBE SALES NEW", "EXISTING GLOBE SALES SWITCH", "EXISTING CONVERGE", "EXISTING CONVERGE SALES NEW", "EXISTING CONVERGE SALES SWITCH", "NO PROVIDERS", "PROVIDERS SALES NEW", "PROVIDERS SALES SWITCH", "UNENGAGED", "UNENGAGED SALES NEW", "UNENGAGED SALES SWITCH", "OTHER PROVIDER", "PRICE", "SATISFIED", "LOCKED-IN", "OTHERS"];

            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');
            headers.forEach(headerText => {
                const th = document.createElement('th');
                th.textContent = headerText;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Create table body
            const tbody = document.createElement('tbody');
            entries.forEach(entry => {
                const row = document.createElement('tr');
                Object.values(entry).forEach(value => {
                    const cell = document.createElement('td');
                    cell.textContent = value;
                    row.appendChild(cell);
                });
                tbody.appendChild(row);
            });
            table.appendChild(tbody);
        }

        function exportToCSV() {
            const table = document.getElementById('entriesTable');
            const rows = Array.from(table.querySelectorAll('tr'));

            // Create comma-separated values string
            const data = rows.map(row => Array.from(row.querySelectorAll('th, td')).map(cell => cell.textContent).join(',')).join('\n');

            // Create Blob object
            const blob = new Blob([data], { type: 'text/csv' });

            // Create download link and trigger click
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'slip_entries.csv';
            link.click();
        }


// nav
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementsByClassName("container")[0].style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementsByClassName("container")[0].style.marginLeft = "0";

}
function searchTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementsByTagName("table")[0];
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    var tdName = tr[i].getElementsByTagName("td")[2]; // Name column
    var tdId = tr[i].getElementsByTagName("td")[0]; // ID (Entry Number) column
    var tdBarangay = tr[i].getElementsByTagName("td")[3]; // Barangay column
    var tdCity = tr[i].getElementsByTagName("td")[4]; // City column
    var tdAgent = tr[i].getElementsByTagName("td")[5]; // Agent column
    var tdEntryDate = tr[i].getElementsByTagName("td")[6]; // Entry Date column
    if (tdName || tdId || tdBarangay || tdCity || tdAgent || tdEntryDate) {
      var txtValueName = tdName.textContent || tdName.innerText;
      var txtValueId = tdId.textContent || tdId.innerText;
      var txtValueBarangay = tdBarangay.textContent || tdBarangay.innerText;
      var txtValueCity = tdCity.textContent || tdCity.innerText;
      var txtValueAgent = tdAgent.textContent || tdAgent.innerText;
      var txtValueEntryDate = tdEntryDate.textContent || tdEntryDate.innerText;
      if (txtValueName.toUpperCase().indexOf(filter) > -1 || 
          txtValueId.toUpperCase().indexOf(filter) > -1 ||
          txtValueBarangay.toUpperCase().indexOf(filter) > -1 ||
          txtValueCity.toUpperCase().indexOf(filter) > -1 ||
          txtValueAgent.toUpperCase().indexOf(filter) > -1 ||
          txtValueEntryDate.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function generateTable() {
  fetch('fetch_slip_entries.php')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (!data.error && data.entries) {
        const tbody = document.querySelector('#entriesTable tbody');
        tbody.innerHTML = ''; // Clear current table rows
        data.entries.forEach(entry => {
          let row = tbody.insertRow();
          let cell1 = row.insertCell(0);
          let cell2 = row.insertCell(1);
          let cell3 = row.insertCell(2);
          let cell4 = row.insertCell(3);
          let cell5 = row.insertCell(4);
          let cell6 = row.insertCell(5);
          let cell7 = row.insertCell(6);
          let cell8 = row.insertCell(7);
          let cell9 = row.insertCell(8);
          let cell10 = row.insertCell(9);
          let cell11 = row.insertCell(10);
          let cell12 = row.insertCell(11);
          let cell13 = row.insertCell(12);
          let cell14 = row.insertCell(13);
          let cell15 = row.insertCell(14);
          let cell16 = row.insertCell(15);
          let cell17 = row.insertCell(16);
          let cell18 = row.insertCell(17);
          cell1.textContent = entry.id;
          cell2.textContent = entry.name;
          cell3.textContent = entry.zone;
          cell4.textContent = entry.barangay;
          cell5.textContent = entry.city;
          cell6.textContent = entry.province;
          cell7.textContent = entry.lcp;
          cell8.textContent = entry.entry_date;
            cell9.innerHTML = entry.nap ? `<img src="uploads/${entry.nap}" alt="NAP Image" style="width:100px;height:auto;">` : '';
            cell10.innerHTML = entry.nap ? `<img src="uploads/${entry.nap}" alt="NAP Image" style="width:100px;height:auto;">` : ''; 
          cell11.textContent = entry.longitude;
          cell12.textContent = entry.latitude;
            cell12.innerHTML = entry.image ? `<a href="uploads/${entry.image}" target="_blank">View Image</a>` : '';
          cell13.textContent = entry.pldt_existing;
          cell14.textContent = entry.pldt_sales_new;
          cell15.textContent = entry.pldt_sales_switch;
          cell16.textContent = entry.globe_existing;
          cell17.textContent = entry.globe_sales_new;
          cell18.textContent = entry.globe_sales_switch;
        });
      } else {
        throw new Error(data.message || "An error occurred");
      }
    })
    .catch(error => {
      console.error('Error fetching entries:', error);
      alert("Error fetching data. Please try again.");
    });
}

function exportToExcel() {
  const table = document.getElementById('entriesTable');
  const rows = Array.from(table.querySelectorAll('tr'));

  // Create tab-separated values string
  const data = rows.map(row => Array.from(row.querySelectorAll('th, td')).map(cell => {
    if (cell.querySelector('img')) {
      return `=HYPERLINK("${cell.querySelector('img').src}", "click here to show image")`; // Use image URL with hyperlink
    }
    return cell.textContent;
  }).join('\t')).join('\n');

  // Create Blob object
  const blob = new Blob([data], { type: 'text/plain' });
  
  // Create download link and trigger click
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = 'slip_entries.xls';
  link.click();
}




<?php
$conn = new mysqli("localhost", "root", "", "eslip");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM slip_entry ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Output column headers
    // echo "ID\tName\tZone\tBarangay\tCity\tProvince\tLCP\tDATE\n";
    
    // // Output data rows
    
} else {
    echo "No entries found";
}

$conn->close();
?>

// function generateTable() {
//   fetch('fetch_slip_entries.php')
//     .then(response => {
//       if (!response.ok) {
//         throw new Error('Network response was not ok');
//       }
//       return response.json();
//     })
//     .then(data => {
//       if (!data.error && data.entries) {
//         const tbody = document.querySelector('#entriesTable tbody');
//         tbody.innerHTML = ''; // Clear current table rows
//         data.entries.forEach(entry => {
//           let row = tbody.insertRow();
//           let cell1 = row.insertCell(0);
//           let cell2 = row.insertCell(1);
//           let cell3 = row.insertCell(2);
//           let cell4 = row.insertCell(3);
//           let cell5 = row.insertCell(4);
//           let cell6 = row.insertCell(5);
//           let cell7 = row.insertCell(6);
//           cell1.innerHTML = entry.id;
//           cell2.innerHTML = entry.name;
//           cell3.innerHTML = entry.zone;
//           cell4.innerHTML = entry.barangay;
//           cell5.innerHTML = entry.city;
//           cell6.innerHTML = entry.province;
//           cell7.innerHTML = entry.lcp;
//         });
//       } else {
//         throw new Error(data.message || "An error occurred");
//       }
//     })
//     .catch(error => {
//       console.error('Error fetching entries:', error);
//       alert("Error fetching data. Please try again.");
//     });
// }
</script>
<script>
    function viewEntry(id) {
        // Redirect to a page or open a modal to display entry details
        // You can use the id parameter to fetch the specific entry details
        // Example:
        window.location.href = "view.php?id=" + id;
    }
</script>

</body>
</html>