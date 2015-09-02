<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $path . 'login.php');
	exit();
}

$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'dashboard.php') {
		header('Location: ' . $path . 'dashboard.php');
		exit();
	}
	require_once '../controllers/edit-a-course.php';
} else {
	header('Location: ' . $path . 'dashboard.php');
	exit();
}
?>