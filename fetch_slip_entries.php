<?php
$conn = new mysqli("localhost", "root", "", "eslip");

$response = array();
if ($conn->connect_error) {
    $response["error"] = true;
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    $sql = "SELECT * FROM slip_entry ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $entries = array();
        while($row = $result->fetch_assoc()) {
            $entries[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "zone" => $row["zone"],
                "barangay" => $row["barangay"],
                "city" => $row["city"],
                "province" => $row["province"],
                "lcp" => $row["lcp"],
                "entry_date" => $row["entry_date"],
                "contact_number" => $row["contact_number"],
                "nap" => $row["nap"],
                "longitude" => $row["longitude"],
                "latitude" => $row["latitude"],
                "pldt_existing" => $row["pldt_existing"],
                "pldt_sales_new" => $row["latitude"],
                "latitude" => $row["pldt_sales_new"],
                "pldt_sales_switch" => $row["pldt_sales_switch"],
                "globe_existing" => $row["globe_existing"],
                "globe_sales_new" => $row["globe_sales_new"],
              
                // Ensure all necessary fields are included
            );
        }
        $response["error"] = false;
        $response["entries"] = $entries;
    } else {
        $response["error"] = true;
        $response["message"] = "No entries found";
    }
}
echo json_encode($response);
$conn->close();
?>
