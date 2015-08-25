<?php

require_once '../config.php';
require_once '../class.connect-to-db.php';
require_once '../class.user.php';
	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'edit-profile.php') {
		header('Location: ../dashboard.php');
		exit();
	}
	$status = 1;
	$errorMessage = '';
	if((!isset($_POST['first_name'])) || (trim($_POST['first_name']) == '')) {
		$errorMessage = "Please insert first name.\n";
		$status = 0;
	}
	if((!isset($_POST['last_name'])) || (trim($_POST['last_name']) == '')) {
		$errorMessage .= "Please insert last name.\n";
		$status = 0;
	}
	if($status) {
		$user = new User($_SESSION);
		$user->first_name = trim($_POST['first_name']);
		$user->last_name = trim($_POST['last_name']);
		$sql = 'UPDATE `users` SET first_name = :first_name, last_name = :last_name WHERE id = :id';
		$valuesToBind = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'id' => $user->id);
		ConnectToDB::interogateDB($sql, $valuesToBind);
		$successMessage = 'Your data has been successfully modified.';
		$_SESSION = (array)$user;
		$_SESSION['successMessage'] = $successMessage;
		header('Location: ../dashboard.php');
	} else {
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ../edit-profile.php');
		exit();
	}
}

?>