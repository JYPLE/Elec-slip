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
      
#main {
            transition: margin-left .5s;
            padding: 16px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        form {
    width: 40%;
    margin: 0 auto;
}
.form-control-sm {
        height: calc(1.5em + .5rem + 2px);
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
    }

label, input[type="text"], input[type="date"], select, input[type="number"], input[type="submit"] {
    display: block;
    margin: 10px 0;
    width: 100%; /* Full width */
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Additional styles */
select, input[type="text"], input[type="date"], input[type="number"] {
    padding: 5px;
    margin-bottom: 2px;
    box-sizing: border-box;
}

table {
    width: 50%;
    border-collapse: collapse;
    margin-bottom: 40px;
    margin-left: auto;
    margin-right: auto;
}


th, td {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
}

.table-container {
            max-height: 400px; /* Adjust the max height as needed */
            overflow-y: auto;
        }
        .fixed-header-table thead {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <a href="count.php" class="back-button" onclick="history.back()" style="float: right; margin-right: 110px;">Back</a>
    <!-- <form method="post">
        <label for="date_from">From:</label>
        <input type="date" id="date_from" name="date_from" value="<?php echo $date_from; ?>">
        <label for="date_to">To:</label>
        <input type="date" id="date_to" name="date_to" value="<?php echo $date_to; ?>">
        <input type="submit" name="filter_button" value="Filter">
    </form> -->

    <?php
  
    $conn = new mysqli("localhost", "root", "", "eslip");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables for date range
    $date_from = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-d');
    $date_to = isset($_POST['date_to']) ? $_POST['date_to'] : date('Y-m-d');

    // Retrieve the barangay information from the URL
    $barangay = isset($_GET['barangay']) ? urldecode($_GET['barangay']) : '';

    $conn = new mysqli("localhost", "root", "", "eslip");
    
   
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
