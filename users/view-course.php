<?php

session_start();
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../controllers/load-template.php';

if(!isset($_SESSION['session_id']) && !isset($_SESSION['access_token'])) {
	header('Location: ' . $GLOBALS['path'] . 'login');
	exit();
}

if($_SERVER['REQUEST_METHOD'] != 'GET') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard');
	exit();
} else {
	require_once '../controllers/course-details.php';
}
?>