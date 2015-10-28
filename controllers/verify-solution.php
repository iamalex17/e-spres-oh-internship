<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
}

if(isset($_POST['solution-feedback'])) {
	if(isset($_POST['feedback'])) {
		$sql = 'UPDATE `submitted_exercises` SET `feedback` = :feedback WHERE id = :id';
		$valuesToBind = array('feedback' => $_POST['feedback'], 'id' => $_POST['solution_id']);
		ConnectToDB::interogateDB($sql, $valuesToBind);
	}
	$sql = 'UPDATE `submitted_exercises` SET status = :status WHERE id = :id';
	$valuesToBind = array('status' => $_POST['solution-feedback'], 'id' => $_POST['solution_id']);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = "Feedback has been sent successfully!";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $GLOBALS['path'] . 'users/view-exercises.php?course_id=' . $_SESSION['course_id']);
	exit();
} else {
	$errorMessage = "Please, choose if the solution is correct or not.\n";
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ' . $GLOBALS['path'] . 'users/view-exercises.php?course_id=' . $_SESSION['course_id']);
	exit();
}
?>