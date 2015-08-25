<?php
require_once '../config.php';
require_once '../class.user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if(($request != 'dashboard.php') || ($_SESSION['user_role'] != 1)) {
		header('Location: ../dashboard.php');
		exit();
	}
	$deleteUser = $_POST['delete_button'];
	$sql = 'UPDATE `users` SET status = 0 WHERE id = :deletedUserID';
	$valuesToBind = array('deletedUserID' => $deleteUser);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = 'User succesfully deleted!';
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ../dashboard.php');
	exit();
}

?>