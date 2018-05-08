<?php
	// Database configuration
	$dbHost     = "localhost";
	$dbUsername = "root";
	$dbPassword = "";
	$dbName     = "geo";
	$dbPort  	= "3306";
	
	//Create connection and select DB
	$link = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

	if ($link->connect_error) {
		$GET['error'] = 1;
		die("Unable to connect database: " . $link->connect_error);
	}
?>