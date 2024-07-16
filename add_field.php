<?php

require_once 'db_connection.php';


$conn = connect_db();


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (isset($_POST["problem"]) && !empty($_POST["problem"])) {
       
        $problem = $_POST["problem"];
        
        
        $stmt = $conn->prepare("INSERT INTO field (problem) VALUES (?)");
        $stmt->bind_param("s", $problem);
        
      
        if ($stmt->execute()) {
            header('Location: fiel_table.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        
       
        $stmt->close();
    } else {
       
        echo "Problem field is required.";
    }
}


$conn->close();
?>
