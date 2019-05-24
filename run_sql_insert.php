<?php

require("phpMQTT.php");

$servername = "localhost";
$username = "root";
$password = "12345";
$dbauction = "db_tea_auction";

$server = "broker.hivemq.com";     // change if necessary io.adafruit.com
$port = 1883;                   // set your password
$client_id = "bid-notification-bkm02"; // make sure this is unique for connecting to sever - you could use uniqid()

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
	
	$mqtt = new phpMQTT($server, $port, $client_id);
	if ($mqtt->connect(true, NULL, $username, $password)) {
		$mqtt->publish("mqtt/new/bid_server", "query");
		$mqtt->close();
	} else {
		echo "Time out!\n";
	}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>