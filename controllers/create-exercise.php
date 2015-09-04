<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
require_once '../classes/class.exercise.php';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'create-course.php') {
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	}
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
			if($_POST['exercise_id'][$key]) {
				$sql = 'UPDATE `exercises` SET description = :description WHERE exercise_id = :exerciseID';
				$valuesToBind = array('description' => $description, 'exerciseID' => $_POST['exercise'][$key]);
				ConnectToDB::interogateDB($sql, $valuesToBind);
			} else {
				$sql = 'INSERT INTO `exercises` (course_id, description) VALUES (:courseID, :description)';
				$valuesToBind = array('courseID' => $courseID, 'description' => $description);
				ConnectToDB::interogateDB($sql, $valuesToBind);
			}
			$successMessage = 'Exercises added successfully.';
			$_SESSION['successMessage'] = $successMessage;
			header('Location:' . $path . 'dashboard.php');
		}
	}
	exit();
	if(!$ok) {
		$errorMessage = "Please add exercise description.\n";
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ../users/create-course.php');
	}
}

?>