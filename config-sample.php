<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'classes/class.connect-to-db.php';
require_once 'classes/class.user.php';

if(($_SERVER['SERVER_NAME'] == '127.0.0.1') || $_SERVER['SERVER_NAME'] == 'localhost') {
	$host = '';
	$db = '';
	$user = '';
	$pass = '';
	try {
		$dbConnector = new ConnectToDB($host, $db, $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	$additionalFolder = 'e-spres-oh-internship/';
	$docRoot = '';
} else if ($_SERVER['SERVER_NAME'] == 'esohintern.bucatzel.ro') {
	$host = '';
	$db = '';
	$user = '';
	$pass = '';
	try {
		$dbConnector = new ConnectToDB($host, $db, $user, $pass);
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	$additionalFolder = '';
	$docRoot = '/home/esohintern/public_html/';
}

$server = 'http://' . $_SERVER['SERVER_NAME'] . '/';
$path = $server . $additionalFolder;

$currentPage = explode('/', $_SERVER["SCRIPT_FILENAME"]);
$currentPage = $currentPage[count($currentPage)-1];

if(isset($_SERVER["QUERY_STRING"]) && !empty($_SERVER["QUERY_STRING"])) {
	$currentPage .= '?' . $_SERVER["QUERY_STRING"];
}
?>