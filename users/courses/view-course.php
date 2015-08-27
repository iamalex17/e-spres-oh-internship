<?php

if($_SERVER['REQUEST_METHOD'] != 'GET') {
		header('Location: ../dashboard.php');
		exit();
	} else {
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'dashboard.php') {
			header('Location:../dashboard.php');
			exit();
		} else {
			require_once '../controllers/course-details.php';
		}
	}


?>