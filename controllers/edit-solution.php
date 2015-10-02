<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.course.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
}

if((isset($_POST['exerciseContent'])) && !empty($_POST['exerciseContent'])) {
	$description = htmlentities($_POST['exerciseContent']);
	$sql = 'UPDATE `submitted_exercises` SET `description` = :description WHERE id = :solutionID';
	$valuesToBind = array('solutionID' => $_POST['solution_id'], 'description' => $description);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = 'Solution updated succesfully.';
	$_SESSION['successMessage'] = $successMessage;
} else {
	$errorMessage = "Please insert your solution.\n";
	$_SESSION['errorMessage'] = $errorMessage;
}

header('Location: ' . $GLOBALS['path'] . 'users/view-course.php?course_id=' . $_POST['course_id']);
?>