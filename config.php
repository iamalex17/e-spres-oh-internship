<?php
	require 'class.connect-to-db.php';
	require_once 'class.user.php';
//	$interogate = 'ConnectToDB::interogateDB';
	$host = 'localhost';
	$db = 'internship';
	$user = 'root';
	$pass = '';
	try {
		$dbConnector = new ConnectToDB($host, $db, $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

?>