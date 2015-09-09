<?php
require_once '../config.php';
require_once '../classes/class.user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if(($request != 'dashboard.php') || ($_SESSION['user_role'] != 1)) {
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	}
	$deleteUser = $_POST['delete_button'];

	$sql = 'DELETE FROM presentors WHERE presentor_id = :deletedUserID';
	$valuesToBind = array('deletedUserID' => $deleteUser);
	ConnectToDB::interogateDB($sql, $valuesToBind);

	$sql = 'DELETE FROM submitted_exercises WHERE user_id = :deletedUserID';
	$valuesToBind = array('deletedUserID' => $deleteUser);
	ConnectToDB::interogateDB($sql, $valuesToBind);

	$sql = 'DELETE FROM `users` WHERE id = :deletedUserID';
	$valuesToBind = array('deletedUserID' => $deleteUser);
	ConnectToDB::interogateDB($sql, $valuesToBind);

	$successMessage = 'User succesfully deleted!';
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
	exit();
}

?>