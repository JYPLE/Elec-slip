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

    // Check if the image field is set and not empty
    if (empty($_FILES["image"]["name"])) {
        echo "Error: Image cannot be null.";
        exit();
    }

    // Handle the image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "Error: There was an error uploading the image.";
        exit();
    }

    // Check if the nap field is set and not empty
    if (empty($_FILES["nap"]["name"])) {
        echo "Error: NAP image cannot be null.";
        exit();
    }

    // Handle the nap image upload
    $nap_target_file = $target_dir . basename($_FILES["nap"]["name"]);
    if (!move_uploaded_file($_FILES["nap"]["tmp_name"], $nap_target_file)) {
        echo "Error: There was an error uploading the NAP image.";
        exit();
    }

    // Prepare and bind SQL statement for insertion
    $stmt_insert = $conn->prepare("INSERT INTO slip_entry (agent, entry_number, entry_date, name, zone, barangay, city, province, lcp, contact_number, image, nap, longitude, latitude, pldt_existing, pldt_lock_date, pldt_sales_new, pldt_sales_switch, globe_existing, globe_lock_date, globe_sales_new, globe_sales_switch, converge_existing, lock_date, converge_sales_new, converge_sales_switch, no_providers_existing, no_providers_sales_new, no_providers_sales_switch, unengaged_existing, unengaged_sales_new, unengaged_sales_switch, other_prov, other_lock_date, other_sales_new, other_sales_switch, field_probs, others_not_signing_up) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters with null or empty string if not set
    $agent = $_POST["agent"] ?? '';
    $entry_number = $_POST["entry_number"] ?? '';
    $entry_date = $_POST["entry_date"] ?? '';
    $name = $_POST["name"] ?? '';
    $zone = $_POST["zone"] ?? '';
    $barangay = $_POST["barangay"] ?? '';
    $city = $_POST["city"] ?? '';
    $province = $_POST["province"] ?? '';
    $lcp = $_POST["lcp"] ?? '';
    $contact_number = $_POST["contact_number"] ?? '';
    $longitude = $_POST["longitude"] ?? '';
    $latitude = $_POST["latitude"] ?? '';
    $pldt_existing = $_POST["pldt_existing"] ?? '';
    $pldt_lock_date = $_POST["pldt_lock_date"] ?? '';
    $pldt_sales_new = $_POST["pldt_sales_new"] ?? '';
    $pldt_sales_switch = $_POST["pldt_sales_switch"] ?? '';
    $globe_existing = $_POST["globe_existing"] ?? '';
    $globe_lock_date = $_POST["globe_lock_date"] ?? '';
    $globe_sales_new = $_POST["globe_sales_new"] ?? '';
    $globe_sales_switch = $_POST["globe_sales_switch"] ?? '';
    $converge_existing = $_POST["converge_existing"] ?? '';
    $lock_date = $_POST["lock_date"] ?? '';
    $converge_sales_new = $_POST["converge_sales_new"] ?? '';
    $converge_sales_switch = $_POST["converge_sales_switch"] ?? '';
    $no_providers_existing = $_POST["no_providers_existing"] ?? '';
    $no_providers_sales_new = $_POST["no_providers_sales_new"] ?? '';
    $no_providers_sales_switch = $_POST["no_providers_sales_switch"] ?? '';
    $unengaged_existing = $_POST["unengaged_existing"] ?? '';
    $unengaged_sales_new = $_POST["unengaged_sales_new"] ?? '';
    $unengaged_sales_switch = $_POST["unengaged_sales_switch"] ?? '';
    $other_prov = $_POST["other_prov"] ?? '';
    $other_lock_date = $_POST["other_lock_date"] ?? '';
    $other_sales_new = $_POST["other_sales_new"] ?? '';
    $other_sales_switch = $_POST["other_sales_switch"] ?? '';
    $field_probs = $_POST["field_probs"] ?? '';
    $others_not_signing_up = $_POST["others_not_signing_up"] ?? '';

    $stmt_insert->bind_param("ssssssssssssssssssssssssssssssssssssss",
                      $agent,
                      $entry_number,
                      $entry_date,
                      $name,
                      $zone,
                      $barangay,
                      $city,
                      $province,
                      $lcp,
                      $contact_number,
                      $target_file, // Save the image path in the database
                      $nap_target_file, // Save the nap image path in the database
                      $longitude,
                      $latitude,
                      $pldt_existing,
                      $pldt_lock_date,
                      $pldt_sales_new,
                      $pldt_sales_switch,
                      $globe_existing,
                      $globe_lock_date,
                      $globe_sales_new,
                      $globe_sales_switch,
                      $converge_existing,
                      $lock_date,
                      $converge_sales_new,
                      $converge_sales_switch,
                      $no_providers_existing,
                      $no_providers_sales_new,
                      $no_providers_sales_switch,
                      $unengaged_existing,
                      $unengaged_sales_new,
                      $unengaged_sales_switch,
                      $other_prov,
                      $other_lock_date,
                      $other_sales_new,
                      $other_sales_switch,
                      $field_probs,
                      $others_not_signing_up);

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
