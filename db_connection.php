<?php
function connect_db() {
    
    $host = "localhost"; 
    $username = "root"; 
    $password = "Jaypee11."; 
    $database = "u656032189_eslip"; 
    
    $conn = new mysqli($host, $username, $password, $database);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
