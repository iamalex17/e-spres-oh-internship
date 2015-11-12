<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
require_once '../classes/class.exercise.php';
require_once '../classes/class.utilities.php';

session_start();

if(!isset($_SESSION['session_id']) && !isset($_SESSION['access_token'])) {
	header('Location: ' . $GLOBALS['path'] . 'login');
	exit();
}

if(isset($_POST['exerciseContent'])) {
	$ok = 0;
	$courseID = $_POST['course_id'];
	$exercises = array();
	$sql = 'SELECT id FROM `courses` WHERE id = :courseId';
	$valuesToBind = array('courseId' => $courseID);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	foreach($_POST['exerciseContent'] as $key => $exercise) {
		if(!empty($exercise)) {
			$description = htmlentities($exercise);
			$ok = 1;
			if(isset($_POST['exercise_id'][$key])) {
				$sql = 'UPDATE `exercises` SET description = :description WHERE id = :exerciseID';
				$valuesToBind = array('description' => $description, 'exerciseID' => $_POST['exercise_id'][$key]);
				ConnectToDB::interogateDB($sql, $valuesToBind);
			} else {
				$sql = 'INSERT INTO `exercises` (course_id, description, status) VALUES (:courseID, :description, 1)';
				$valuesToBind = array('description' => $description, 'courseID' => $courseID);
				ConnectToDB::interogateDB($sql, $valuesToBind);
			}
			$successMessage = 'Exercises added successfully.';
			$_SESSION['successMessage'] = $successMessage;
		}
	}
	$_SESSION['course_id'] = $courseID;
	if(!$ok) {
		$errorMessage = "Please add exercise description.\n";
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location:' . $path . 'users/create-course?course_id=' . $courseID);
		exit();
	}
	if(isset($_POST['exit'])) {
		$utility = new Utilities;
		$utility->redirectWithFilter();
	} else {
		header('Location:' . $path . 'users/create-course?course_id=' . $courseID);
		exit();
	}
}
?>