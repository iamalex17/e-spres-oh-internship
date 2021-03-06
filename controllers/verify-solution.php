<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard');
}

if(isset($_POST['solution-feedback'])) {
	if(isset($_POST['feedback'])) {
		$sql = 'UPDATE `submitted_exercises` SET `feedback` = :feedback WHERE id = :id';
		$valuesToBind = array('feedback' => $_POST['feedback'], 'id' => $_POST['solution_id']);
		ConnectToDB::interogateDB($sql, $valuesToBind);
	}
	$mentorID = $_SESSION['id'];
	$sql = 'UPDATE `submitted_exercises` SET mentor_id = :mentor_id, status = :status WHERE id = :id';
	$valuesToBind = array('status' => $_POST['solution-feedback'], 'id' => $_POST['solution_id'], 'mentor_id' => $mentorID);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = "Feedback has been sent successfully!";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $path . 'users/view-exercises?course_id=' . $_SESSION['course_id']);
	exit();
} else {
	$errorMessage = "Please, choose if the solution is correct or not.\n";
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ' . $path . 'users/view-exercises?course_id=' . $_SESSION['course_id']);
	exit();
}
?>