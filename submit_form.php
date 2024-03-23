<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agent = $_POST['agent'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "eslip";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the combination of first name and last name already exists
    $stmt_check = $conn->prepare("SELECT * FROM slip_entry WHERE name = ?");
    $stmt_check->bind_param("s", $_POST["name"]);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        // Name already exists, handle accordingly
        echo "Error: Name already exists.";
        exit();
    }

    // Prepare and bind SQL statement for insertion
    $stmt_insert = $conn->prepare("INSERT INTO slip_entry (agent, entry_number, entry_date, name, zone, barangay, city, province, lcp, contact_number, nap, longitude, latitude, pldt_existing, pldt_sales_new, pldt_sales_switch, globe_existing, globe_sales_new, globe_sales_switch, converge_existing, converge_sales_new, converge_sales_switch, others_existing, others_sales_new, others_sales_switch, no_providers_existing, no_providers_sales_new, no_providers_sales_switch, unengaged_existing, unengaged_sales_new, unengaged_sales_switch, other_prov, price, satisfied, locked_in, others_not_signing_up) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt_insert->bind_param("ssssssssssssssssssssssssssssssssssss",
                    $_POST["agent"],    
                      $_POST["entry_number"],
                      $_POST["entry_date"],
                      $_POST["name"],
                      $_POST["zone"],
                      $_POST["barangay"],
                      $_POST["city"],
                      $_POST["province"],
                      $_POST["lcp"],
                      $_POST["contact_number"],
                      $_POST["nap"],
                      $_POST["longitude"],
                      $_POST["latitude"],
                      $_POST["pldt_existing"],
                      $_POST["pldt_sales_new"],
                      $_POST["pldt_sales_switch"],
                      $_POST["globe_existing"],
                      $_POST["globe_sales_new"],
                      $_POST["globe_sales_switch"],
                      $_POST["converge_existing"],
                      $_POST["converge_sales_new"],
                      $_POST["converge_sales_switch"],
                      $_POST["others_existing"],
                      $_POST["others_sales_new"],
                      $_POST["others_sales_switch"],
                      $_POST["no_providers_existing"],
                      $_POST["no_providers_sales_new"],
                      $_POST["no_providers_sales_switch"],
                      $_POST["unengaged_existing"],
                      $_POST["unengaged_sales_new"],
                      $_POST["unengaged_sales_switch"],
                      $_POST["other_prov"],
                      $_POST["price"],
                      $_POST["satisfied"],
                      $_POST["locked_in"],
                      $_POST["others_not_signing_up"]);

    if ($stmt_insert->execute()) {
        header('Location: user_entry.php');
        exit();
    } else {
        echo "Error: " . $stmt_insert->error;
    }

    $stmt_check->close();
    $stmt_insert->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
