<?php
session_start(); // Start the session to access logged-in user information

// Check if user is logged in
if (!isset($_SESSION['userdata'])) {
    echo "You are not logged in.";
    exit; // Stop further execution
}

// Check if the ID parameter is provided in the URL
if (!isset($_GET['id'])) {
    echo "Entry ID is missing.";
    exit; // Stop further execution
}

// Database connection
$conn = new mysqli("localhost", "root", "", "eslip");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the entry details based on the provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM slip_entry WHERE id = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Display the entry details
    $row = $result->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entry Details</title>
        <style>
            .entry-details {
                width: 50%;
                margin: 0 auto;
            }

            .entry-details table {
                border-collapse: collapse;
                width: 100%;
            }

            .entry-details th, .entry-details td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            .entry-details th {
                background-color: #f2f2f2;
            }

            .entry-details input[type="text"],
            .entry-details input[type="date"] {
                width: calc(100% - 16px);
                padding: 4px;
                border: none;
                background-color: #f9f9f9;
                pointer-events: none;
            }
        </style>
    </head>
    <body>
      <!-- <center>  <h1>DETAILS OF: <?php echo $row["name"]; ?></h1></center> -->
        <div class="entry-details">
            <table>
                <tr><th>Field</th><th>Info</th></tr>
                <tr><td>Entry Number:</td><td><?php echo $row["id"]; ?></td></tr>
                <tr><td>Entry Date:</td><td><input type="date" value="<?php echo $row["entry_date"]; ?>" disabled></td></tr>
                <tr><td>Name:</td><td><input type="text" value="<?php echo $row["name"]; ?>" disabled></td></tr>
                <tr><td>Zone:</td><td><input type="text" value="<?php echo $row["zone"]; ?>" disabled></td></tr>
                <tr><td>Barangay:</td><td><input type="text" value="<?php echo $row["barangay"]; ?>" disabled></td></tr>
                <tr><td>City:</td><td><input type="text" value="<?php echo $row["city"]; ?>" disabled></td></tr>
                <tr><td>Province:</td><td><input type="text" value="<?php echo $row["province"]; ?>" disabled></td></tr>

                <tr><td>Lcp:</td><td><input type="text" value="<?php echo $row["lcp"]; ?>" disabled></td></tr>
                <tr><td>Contact Number:</td><td><input type="number" value="<?php echo $row["contact_number"]; ?>" disabled></td></tr>
                <tr><td>Nap:</td><td><input type="text" value="<?php echo $row["nap"]; ?>" disabled></td></tr>
                <tr><td>Longitude:</td><td><input type="number" value="<?php echo $row["longitude"]; ?>" disabled></td></tr>
                <tr><td>Latitude:</td><td><input type="number" value="<?php echo $row["latitude"]; ?>" disabled></td></tr>
                <tr><td>Pldt Existing:</td><td><input type="text" value="<?php echo $row["pldt_existing"]; ?>" disabled></td></tr>

                <tr><td>Pldt Sales_new:</td><td><input type="text" value="<?php echo $row["pldt_sales_new"]; ?>" disabled></td></tr>
                <tr><td>Pldt Sales Switch:</td><td><input type="text" value="<?php echo $row["pldt_sales_switch"]; ?>" disabled></td></tr>
                <tr><td>EXISTING GLOBE:</td><td><input type="text" value="<?php echo $row["globe_existing"]; ?>" disabled></td></tr>
                <tr><td>EXISTING GLOBE SALES NEW:</td><td><input type="text" value="<?php echo $row["globe_sales_new"]; ?>" disabled></td></tr>
                <tr><td>EXISTING GLOBE SALES SWITCH:</td><td><input type="number" value="<?php echo $row["globe_sales_switch"]; ?>" disabled></td></tr>

                <tr><td>EXISTING CONVERGE:</td><td><input type="text" value="<?php echo $row["converge_existing"]; ?>" disabled></td></tr>
                <tr><td>EXISTING CONVERGE SALES NEW:</td><td><input type="text" value="<?php echo $row["converge_sales_new"]; ?>" disabled></td></tr>
                <tr><td>EXISTING CONVERGE SALES SWITCH:</td><td><input type="text" value="<?php echo $row["converge_sales_switch"]; ?>" disabled></td></tr>

                <tr><td>OTHER EXISTING:</td><td><input type="text" value="<?php echo $row["others_existing"]; ?>" disabled></td></tr>
                <tr><td>OTHER SALES NEW:</td><td><input type="text" value="<?php echo $row["others_sales_new"]; ?>" disabled></td></tr>
                <tr><td>OTHER SALES SWITCH:</td><td><input type="text" value="<?php echo $row["others_sales_switch"]; ?>" disabled></td></tr>

                <tr><td>NO PROVIDERS:</td><td><input type="text" value="<?php echo $row["no_providers_existing"]; ?>" disabled></td></tr>
                <tr><td>PROVIDERS SALES NEW:</td><td><input type="text" value="<?php echo $row["no_providers_sales_new"]; ?>" disabled></td></tr>
                <tr><td>PROVIDERS SALES SWITCH:</td><td><input type="text" value="<?php echo $row["no_providers_sales_switch"]; ?>" disabled></td></tr>

                <tr><td>UNENGAGED:</td><td><input type="text" value="<?php echo $row["unengaged_existing"]; ?>" disabled></td></tr>
                <tr><td>UNENGAGED SALES NEW:</td><td><input type="text" value="<?php echo $row["unengaged_sales_new"]; ?>" disabled></td></tr>
                <tr><td>UNENGAGED SALES SWITCH:</td><td><input type="text" value="<?php echo $row["unengaged_sales_switch"]; ?>" disabled></td></tr>

                <tr><td>OTHER PROVIDER:</td><td><input type="text" value="<?php echo $row["other_prov"]; ?>" disabled></td></tr>
                <tr><td>PRICE:</td><td><input type="number" value="<?php echo $row["price"]; ?>" disabled></td></tr>
                <tr><td>SATISFIED:</td><td><input type="text" value="<?php echo $row["satisfied"]; ?>" disabled></td></tr>
                <tr><td>LOCKED-IN:</td><td><input type="text" value="<?php echo $row["locked_in"]; ?>" disabled></td></tr>
                <tr><td>OTHERS:</td><td><input type="text" value="<?php echo $row["others_not_signing_up"]; ?>" disabled></td></tr>
                <!-- Add other fields here with similar pattern -->
            </table>
        </div>
    </body>
    </html>
<?php
} else {
    echo "Entry not found.";
}

$conn->close();
?>
