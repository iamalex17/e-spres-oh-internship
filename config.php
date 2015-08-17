<?php
	require 'functions/config_functions.php';
	$host = 'localhost';
	$db = 'internship';
	$user = 'root';
	$pass = '';
	try {
		$dbh = connectDB($host, $db, $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

?>