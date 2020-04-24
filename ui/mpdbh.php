<?php

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "loginsystemtut";

$conn = mysqli_connect($severname, $dbUsername, $dbPassword, $dbName);

if(!$conn)
{
	die("connection failed: ".mysqli_connect_error());
}

?>