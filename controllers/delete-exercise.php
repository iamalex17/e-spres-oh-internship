<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!User::verifySessionID()) {
		header('Location: ' . $GLOBALS['path'] . 'login.php');
		exit();
	}
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if(($request != 'dashboard.php') || ($_SESSION['user_role'] != 2)) {
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	}
	$deleteExercise = $_POST['delete_exercise'];
	$sql = 'UPDATE `exercises` SET status = 0 WHERE id = :id';
	$valuesToBind = array('id' => $deleteExercise);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$sql = 'UPDATE `submitted_exercises` SET status = 0 WHERE exercise_id = :exerciseID)';
	$valuesToBind = array('exerciseID' => $deleteExercise);
	ConnectToDB::interogateDB($sql, $valuesToBind);
?>