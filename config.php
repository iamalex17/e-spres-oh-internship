<?php
	require_once 'classes/class.connect-to-db.php';
	require_once 'classes/class.user.php';

	if(($_SERVER['SERVER_NAME'] == '127.0.0.1') || $_SERVER['SERVER_NAME'] == 'localhost') {
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
		$currentPage = $_SERVER['REQUEST_URI'];

	} else if ($_SERVER['SERVER_NAME'] == 'esohintern.bucatzel.ro') {
		$host = 'localhost';
		$db = 'esohintern';
		$user = 'esohintern';
		$pass = 'eI--sjdf1';
		try {
			$dbConnector = new ConnectToDB($host, $db, $user, $pass);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		$server = 'http://' . $_SERVER['SERVER_NAME'] . '/';
		$additionalFolder = '';
		$path = $server . $additionalFolder;
		$currentPage = $_SERVER['REQUEST_URI'];
	}
?>