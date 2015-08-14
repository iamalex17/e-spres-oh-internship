<?php

	$host = 'localhost';
	$port = '3306';
	$user = 'root';
	$pass = '';
	$db = 'internship';
	try {
		$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
?>