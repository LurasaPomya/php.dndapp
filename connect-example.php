<?php
$servername = "";		//Server hostname
$dbusername = "";			//MySQL username
$dbpassword = "";	//Password for the above user
$dbname = "";			//DnDApp database name
try {	//Attempts connect, shows error if it doesn't work
	$conn = new PDO("mysql:host=$servername;dbname=$dbname",$dbusername, $dbpassword);	// Create connection
} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();	//Outputs error if it fails to connect
}

//Sets value for MySQL fields to get rid of funny characters.
$stmt = $conn->prepare("SET NAMES 'utf8'");
$stmt->execute();

?>
