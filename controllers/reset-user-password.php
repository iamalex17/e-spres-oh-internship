<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

	$link = '';
	$errorMessage = '';
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'reset-password.php') {
			header('Location: ' . $GLOBALS['path'] . 'login.php');
			exit();
		}
		session_start();
		if(isset($_POST['newPassword'])) {
			$newPassword = trim($_POST['newPassword']);
			if(!strlen($newPassword)<8) {
				if(isset($_POST['retypeNewPassword'])) {
					$retypeNewPassword = trim($_POST['retypeNewPassword']);
					if($newPassword == $retypeNewPassword) {
						$resetLink = trim($_POST['link']);
						$sql = 'UPDATE `users` SET password = MD5(:retypeNewPassword), reset_password = NULL, deletion_link_time = NULL WHERE reset_password = :resetPassword';
						$valuesToBind = array('retypeNewPassword' => $newPassword, 'resetPassword' => $resetLink);
						$result = ConnectToDB::interogateDB($sql, $valuesToBind);
						$successMessage = 'Your password has been successfully modified.';
						$_SESSION['successMessage'] = $successMessage;
						header('Location: ' . $GLOBALS['path'] . 'login.php');
						exit();
					} else {
						$errorMessage = "Passwords do not match. Check again!\n";
					}
				} else {
					$errorMessage = "Passwords do not match. Check again!\n";
				}
			} else {
				$errorMessage = "Password must have at least 8 characters.\n";
			}
		} else {
			$errorMessage = "Please insert password.\n";
		}

		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ' . $GLOBALS['path'] . 'users/reset-password.php');
		exit();
	}
?>