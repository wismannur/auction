<?php

$servername = "localhost";
$username = "root";
$password = "12345";
$dbauction = "db_tea_auction";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbauction);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/* Get data from Client side using $_POST array */
$sql  = $_POST['sql'];

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>