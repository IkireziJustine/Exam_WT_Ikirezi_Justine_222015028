<?php
$servername = "localhost";
$username = "Justine";
$password = "222015028";
$database = "inventory_management_system_for_retail";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "Connected successfully";
}
?>