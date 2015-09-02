<?php
	require_once 'classes/class.connect-to-db.php';
	require_once 'classes/class.user.php';
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

	$server = 'http://' . $_SERVER['SERVER_NAME'] . '/';
	$additionalFolder = 'e-spres-oh-internship/';

	$path = $server . $additionalFolder;
?>