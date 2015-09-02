<?php
require_once '../config.php';
require_once '../classes/class.user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if(($request != 'dashboard.php') || ($_SESSION['user_role'] != 2)) {
		header('Location: ' . $path . 'dashboard.php');
		exit();
	}
	$deleteCourse = $_POST['delete_course'];
	$sql = 'UPDATE `courses` SET status = 0 WHERE id = :deletedCourseID';
	$valuesToBind = array('deletedCourseID' => $deleteCourse);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = 'Course succesfully deleted!';
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $path . 'dashboard.php');
	exit();
}

?>