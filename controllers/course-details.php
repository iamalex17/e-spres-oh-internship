<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
require_once '../controllers/load-template.php';

	if($_SERVER['REQUEST_METHOD'] != 'GET') {
		header('Location: ../dashboard.php');
		exit();
	} else {
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'dashboard.php') {
			header('Location:../dashboard.php');
			exit();
		}
	}

	$course_id = $_GET['course_id'];

	$sql = 'SELECT * FROM `courses` WHERE id = :id';
	$valuesToBind = array('id'=>$course_id);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$course = $result[0];
	session_start();
	$template = loadTemplate('../templates','details-course.tmpl');
	echo $template->render(array('user_role' => $_SESSION['user_role'], 'last_name' => $_SESSION['last_name'], 'profile_image' => $_SESSION['profile_image'], 'course' => $course));
?>