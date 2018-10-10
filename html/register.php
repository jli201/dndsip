<?php

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

$host = "localhost";
$dbusername = "mhypnaro";
$dbpassword = "Pial-9-tiop";
$dbname = "test_database";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()){
	echo("Error in connecting!");
} else {
	if(!empty($username) && !empty($password)) {
		$newUser = "INSERT INTO Users values ('$username', '$password')";
		if  ($conn->query($newUser)){
			echo("A new user has been insterted");
		} else {
			echo("Error: " . $sql . "<br>" . $conn->error);
		}
	} else {
		if(empty($username)){
			echo("Please fill out a username.<br>");
		}
		if(empty($password)){
			echo("Please fill out a password.");
		}
	}
}
$conn->close();
?>
