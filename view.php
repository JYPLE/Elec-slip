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
    echo "<h1>Entry Details</h1>";
    echo "<div class='entry-details'>";
    echo "<table>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    echo "<tr><td>Entry Number:</td><td>" . $row["id"] . "</td></tr>";
    echo "<tr><td>Entry Date:</td><td>" . $row["entry_date"] . "</td></tr>";
    echo "<tr><td>Name:</td><td>" . $row["name"] . "</td></tr>";
    echo "<tr><td>Zone:</td><td>" . $row["zone"] . "</td></tr>";
    echo "<tr><td>Barangay:</td><td>" . $row["barangay"] . "</td></tr>";
    echo "<tr><td>City:</td><td>" . $row["city"] . "</td></tr>";
    echo "<tr><td>Province:</td><td>" . $row["province"] . "</td></tr>";
    echo "<tr><td>Lcp:</td><td>" . $row["lcp"] . "</td></tr>";
    echo "<tr><td>Contact Number:</td><td>" . $row["contact_number"] . "</td></tr>";
    echo "<tr><td>Nap:</td><td>" . $row["nap"] . "</td></tr>";
    echo "<tr><td>Longitude:</td><td>" . $row["longitude"] . "</td></tr>";
    echo "<tr><td>Latitude:</td><td>" . $row["latitude"] . "</td></tr>";
    echo "<tr><td>Price:</td><td>" . $row["price"] . "</td></tr>";

    echo "<tr><td>EXISTING PLDT:</td><td>" . $row["pldt_existing"] . "</td></tr>";
    echo "<tr><td>EXISTING PLDT SALES NEW:</td><td>" . $row["pldt_sales_new"] . "</td></tr>";
    echo "<tr><td>EXISTING PLDT SALES SWITCH:</td><td>" . $row["pldt_sales_switch"] . "</td></tr>";
    echo "<tr><td>EXISTING GLOBE:</td><td>" . $row["globe_existing"] . "</td></tr>";
    echo "<tr><td>EXISTING GLOBE SALES NEW:</td><td>" . $row["globe_sales_new"] . "</td></tr>";
    echo "<tr><td>EXISTING GLOBE SALES SWITCH:</td><td>" . $row["globe_sales_switch"] . "</td></tr>";
    echo "<tr><td>EXISTING CONVERGE:</td><td>" . $row["converge_existing"] . "</td></tr>";
    echo "<tr><td>EXISTING CONVERGE SALES NEW:</td><td>" . $row["converge_sales_new"] . "</td></tr>";
    echo "<tr><td>EXISTING CONVERGE SALES SWITCH:</td><td>" . $row["converge_sales_switch"] . "</td></tr>";
     echo "<tr><td>NO PROVIDERS:</td><td>" . $row["no_providers_existing"] . "</td></tr>";
    echo "<tr><td>PROVIDERS SALES NEW:</td><td>" . $row["no_providers_sales_new"] . "</td></tr>";
    echo "<tr><td>PROVIDERS SALES SWITCH:</td><td>" . $row["no_providers_sales_switch"] . "</td></tr>";
    echo "<tr><td>UNENGAGED:</td><td>" . $row["unengaged_existing"] . "</td></tr>";
    echo "<tr><td>UNENGAGED SALES NEW:</td><td>" . $row["unengaged_sales_new"] . "</td></tr>";
    echo "<tr><td>UNENGAGED SALES SWITCH:</td><td>" . $row["unengaged_sales_switch"] . "</td></tr>";
    echo "<tr><td>OTHER PROVIDER:</td><td>" . $row["other_prov"] . "</td></tr>";
    echo "<tr><td>Satisfied:</td><td>" . $row["satisfied"] . "</td></tr>";
    echo "<tr><td>Locked_in:</td><td>" . $row["locked_in"] . "</td></tr>";
    echo "<tr><td>Others_not_signing_up:</td><td>" . $row["others_not_signing_up"] . "</td></tr>";
    echo "</table>";
    echo "</div>";
} else {
    echo "Entry not found.";
}

$conn->close();
?>

<style>
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
</style>
