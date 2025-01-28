<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "eslip"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo " ";

// Get the date range and grouping type from the form submission
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : 'From';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : 'To';
$city = isset($_GET['city']) ? $_GET['city'] : '';
$barangay = isset($_GET['barangay']) ? $_GET['barangay'] : '';

// Query distinct cities and barangays
$citiesQuery = "SELECT DISTINCT city FROM slip_entry";
$citiesResult = $conn->query($citiesQuery);

$barangaysQuery = "SELECT city, barangay FROM slip_entry";
$barangaysResult = $conn->query($barangaysQuery);

$barangaysData = [];
while ($row = $barangaysResult->fetch_assoc()) {
    $barangaysData[$row['city']][] = $row['barangay'];
}

// Query the data
$query = "
SELECT 
    city,
    barangay,
    SUM(pldt_existing = 'yes') AS pldt_existing,
    SUM(globe_existing = 'yes') AS globe_existing,
    SUM(converge_existing = 'yes') AS converge_existing,
    SUM(no_providers_existing = 'yes') AS no_providers_existing
FROM slip_entry
WHERE entry_date BETWEEN '$fromDate' AND '$toDate'
";

if ($city) {
    $query .= " AND city = '$city'";
}

if ($barangay) {
    $query .= " AND barangay = '$barangay'";
}

$query .= " GROUP BY city, barangay";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Summary</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #a8e4a0;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 20px;
            color: #800000;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: black;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .sidenav .logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            gap: 10px;
        }

        .form-container button {
            padding: 5px 10px;
            background-color: hsl(128, 68.30%, 49.40%);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        /* Layout for the table and chart side by side */
        .container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .chart-container,
        .provider-count-table {
            width: 48%; /* Each will take up 48% of the width */
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="entry.php">Home</a>
        <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <span style="color: black; font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

    <a href="entry.php" class="back-button" onclick="history.back()" style="color: white; float: left; margin-left: 150px;"></a>

    <div class="form-container">
        <form method="GET" action="">
            <label for="fromDate">From:</label>
            <input type="date" id="fromDate" name="fromDate" value="<?php echo $fromDate; ?>">
            <label for="toDate">To:</label>
            <input type="date" id="toDate" name="toDate" value="<?php echo $toDate; ?>">
            <label for="city">MUNICIPALITY:</label>
            <select id="city" name="city" onchange="updateBarangays()">
                <option value="">All Municipality</option>
                <?php while ($row = $citiesResult->fetch_assoc()): ?>
                    <option value="<?php echo $row['city']; ?>" <?php if ($row['city'] == $city) echo 'selected'; ?>>
                        <?php echo $row['city']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="barangay">Barangay:</label>
            <select id="barangay" name="barangay">
                <option value="">Select Barangay</option>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>

    <div class="container">
        <!-- Chart Container -->
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>

        <!-- Table Container -->
        <div class="provider-count-table">
            <h3>Provider Count by City and Barangay</h3>
            <table>
                <thead>
                    <tr>
                        <th style="background-color: #f4f4f4;">Barangay</th>
                        <th style="background-color: rgba(206, 17, 17, 0.8); color: white;">PLDT Existing</th>
                        <th style="background-color: hsla(239, 91.80%, 28.80%, 0.77); color: white;">Globe Existing</th>
                        <th style="background-color: rgba(223, 129, 8, 0.95); color: white;">Converge Existing</th>
                        <th style="background-color: rgba(15, 2, 2, 0.98); color: white;">No Providers Existing</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo $row['barangay']; ?></td>
                            <td><?php echo $row['pldt_existing']; ?></td>
                            <td><?php echo $row['globe_existing']; ?></td>
                            <td><?php echo $row['converge_existing']; ?></td>
                            <td><?php echo $row['no_providers_existing']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var barangaysData = <?php echo json_encode($barangaysData); ?>;
        var selectedCity = "<?php echo $city; ?>";
        var selectedBarangay = "<?php echo $barangay; ?>";

        function updateBarangays() {
            var citySelect = document.getElementById('city');
            var barangaySelect = document.getElementById('barangay');
            var selectedCity = citySelect.value;

            barangaySelect.innerHTML = '<option value="">All Barangay</option>';

            if (selectedCity && barangaysData[selectedCity]) {
            var uniqueBarangays = [...new Set(barangaysData[selectedCity])];
            uniqueBarangays.forEach(function(barangay) {
                var option = document.createElement('option');
                option.value = barangay;
                option.text = barangay;
                if (barangay === selectedBarangay) {
                option.selected = true;
                }
                barangaySelect.appendChild(option);
            });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateBarangays();
        });

        var data = <?php echo json_encode($data); ?>;
        var labels = data.map(function(row) { return row.city + ' - ' + row.barangay; });
        var pldt_existing = data.map(function(row) { return row.pldt_existing; });
        var globe_existing = data.map(function(row) { return row.globe_existing; });
        var converge_existing = data.map(function(row) { return row.converge_existing; });
        var no_providers_existing = data.map(function(row) { return row.no_providers_existing; });

        var ctx = document.getElementById('myChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'PLDT Existing',
                        data: pldt_existing,
                        backgroundColor: 'rgba(206, 17, 17, 0.8)',
                    },
                    {
                        label: 'Globe Existing',
                        data: globe_existing,
                        backgroundColor: 'hsla(239, 91.80%, 28.80%, 0.77)',
                    },
                    {
                        label: 'Converge Existing',
                        data: converge_existing,
                        backgroundColor: 'rgba(223, 129, 8, 0.95)',
                    },
                    {
                        label: 'No Providers Existing',
                        data: no_providers_existing,
                        backgroundColor: 'rgba(15, 2, 2, 0.98)',
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Providers Summary (Count)',
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        function openNav() {
            document.getElementById("mySidenav").style.width = "150px";
            document.getElementById("main").style.marginLeft = "150px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>
</body>
</html>
