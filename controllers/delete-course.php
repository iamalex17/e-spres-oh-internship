<?php
require_once '../config.php';
require_once '../classes/class.user.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!User::verifySessionID()) {
		header('Location: ' . $GLOBALS['path'] . 'login.php');
		exit();
	}
	$deleteCourse = $_POST['delete_course'];
	$sql = 'UPDATE `courses` SET status = 0 WHERE id = :deletedCourseID';
	$valuesToBind = array('deletedCourseID' => $deleteCourse);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$sql = 'UPDATE `exercises` SET status = 0 WHERE course_id = :courseID';
	$valuesToBind = array('courseID' => $deleteCourse);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$sql = 'UPDATE `submitted_exercises` SET status = 0 WHERE exercise_id = (SELECT id FROM `exercises` WHERE course_id = :courseID)';
	$valuesToBind = array('courseID' => $deleteCourse);
	ConnectToDB::interogateDB($sql, $valuesToBind);

	$successMessage = 'Course succesfully deleted!';
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
	exit();
}
?>