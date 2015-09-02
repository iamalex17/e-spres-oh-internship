<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
require_once '../classes/class.exercise.php';

if(!User::verifySessionID()) {
	header('Location: ' . $path . 'login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'create-course.php') {
		header('Location: ' . $path . 'dashboard.php');
		exit();
	}
}
echo "<pre>";
var_dump($_POST);
exit();	
?>