<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.course.php';
require_once '../classes/class.user.php';

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard');
}

if((isset($_POST['exerciseContent'])) && !empty($_POST['exerciseContent'])) {
	$description = htmlentities($_POST['exerciseContent']);
	$sql = 'INSERT INTO `submitted_exercises` (`exercise_id`, `user_id`, `description`, `status`) VALUES (:exerciseID, :userID, :description, 1)';
	$valuesToBind = array('exerciseID' => $_POST['exercise_id'], 'userID' => $_SESSION['id'], 'description' => $description);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = 'Solution added succesfully.';
	$_SESSION['successMessage'] = $successMessage;
} else {
	$errorMessage = "Please insert your solution.\n";
	$_SESSION['errorMessage'] = $errorMessage;
}

header('Location: ' . $GLOBALS['path'] . 'users/view-course?course_id=' . $_POST['course_id']);
?>