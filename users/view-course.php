<?php

session_start();
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../controllers/load-template.php';

if($_SERVER['REQUEST_METHOD'] != 'GET') {
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	} else {
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'dashboard.php') {
			header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
			exit();
		} else {
			require_once '../controllers/course-details.php';
		}
	}


?>