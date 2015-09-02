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
	$exercises = array();
	$courseID = 1;
	foreach ($_POST['exerciseContent'] as $key => $exercise) {
		if(!empty($exercise)) {
			$description = htmlentities($exercise);
			$ok = 1;
			$sql = 'INSERT INTO `exercises` (course_id, description) VALUES (:courseID, :description)';
			$valuesToBind = array('courseID' => $courseID, 'description' => $description);
			ConnectToDB::interogateDB($sql, $valuesToBind);
			$successMessage = 'Exercises added successfully.';
			$_SESSION['successMessage'] = $successMessage;
			header('Location: ../users/create-course.php');
		}
	}
	if(!$ok) {
		$errorMessage = "Please add exercise description.\n";
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ../users/create-course.php');
	}
}

?>