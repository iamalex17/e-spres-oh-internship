<?php

require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'edit-profile.php') {
		header('Location: ../dashboard.php');
		exit();
	}
	$status = 3;
	$errorMessage = '';
	if((!isset($_POST['first_name'])) || (trim($_POST['first_name']) == '')) {
		$errorMessage = "Please insert first name.\n";
		$status -= 1;
	}
	if((!isset($_POST['last_name'])) || (trim($_POST['last_name']) == '')) {
		$status -= 2;
	}
	if($status) {
		$user = new User($_SESSION);
	} else {
		$errorMessage = "Please insert first name and/or last name.\n";
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ../users/edit-profile.php');
		exit();
	}
	switch ($status) {
		case 1:
			$user->last_name = trim($_POST['last_name']);
			$sql = 'UPDATE `users` SET last_name = :last_name WHERE id = :id';
			$valuesToBind = array('last_name' => $user->last_name, 'id' => $user->id);
			break;
		case 2:
			$user->first_name = trim($_POST['first_name']);
			$sql = 'UPDATE `users` SET first_name = :first_name WHERE id = :id';
			$valuesToBind = array('first_name' => $user->first_name, 'id' => $user->id);
			break;
		case 3:
			$user->last_name = trim($_POST['last_name']);
			$user->first_name = trim($_POST['first_name']);
			$sql = 'UPDATE `users` SET first_name = :first_name, last_name = :last_name WHERE id = :id';
			$valuesToBind = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'id' => $user->id);
			break;
		default:
			break;
	}
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = 'Your data has been successfully modified.';
	$_SESSION = (array)$user;
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ../dashboard.php');
	exit();
}
?>