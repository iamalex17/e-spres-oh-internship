<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'edit-profile.php') {
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	}
	$errorMessage = '';
	$status = 1;
	if((!isset($_POST['first_name'])) || (trim($_POST['first_name']) == '')) {
		$errorMessage = "Please insert first name.\n";
		$status = 0;
	}

	if((!isset($_POST['last_name'])) || (trim($_POST['last_name']) == '')) {
		$status = 0;
	}

	if($status) {
		if(isset($_SESSION['google_id'])) {
			$lastName = trim($_POST['last_name']);
			$firstName = trim($_POST['first_name']);
			$sql = 'UPDATE `users` SET first_name = :first_name, last_name = :last_name WHERE google_id = :google_id';
			$valuesToBind = array('last_name' => $lastName, 'first_name' => $firstName, 'google_id' => $_SESSION['google_id']);
			ConnectToDB::interogateDB($sql, $valuesToBind);
			$successMessage = 'Your data has been successfully modified.';
			$_SESSION['successMessage'] = $successMessage;
			header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
			exit();
		} else {
			$user = new User($_SESSION);
			$user->last_name = trim($_POST['last_name']);
			$user->first_name = trim($_POST['first_name']);
			$sql = 'UPDATE `users` SET first_name = :first_name, last_name = :last_name WHERE id = :id';
			$valuesToBind = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'id' => $user->id);
			ConnectToDB::interogateDB($sql, $valuesToBind);
			$successMessage = 'Your data has been successfully modified.';
			if($_FILES['profile_image']['name'] != '') {
				$errorMessage .= $user->addProfileImage();
			}
			$_SESSION = (array)$user;
			$_SESSION['successMessage'] = $successMessage;
			header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
			exit();
		}
	} else {
		$errorMessage = "Please insert first name and/or last name.\n";
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ' . $GLOBALS['path'] . 'users/edit-profile.php');
		exit();
	}
}
?>