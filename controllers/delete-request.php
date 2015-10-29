<?php
require_once '../config.php';
require_once '../classes/class.user.php';

$successMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($_SESSION['user_role'] != 1) {
		header('Location: ' . $GLOBALS['path'] . 'dashboard');
		exit();
	}

	$deleteUser = $_POST['delete_button'];

	$sql = 'DELETE FROM `users` WHERE google_id = :google_id';
	$valuesToBind = array('google_id' => $deleteUser);
	ConnectToDB::interogateDB($sql, $valuesToBind);

	$successMessage = 'Request succesfully deleted!';
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $GLOBALS['path'] . 'admin/pending-requests');
	exit();
}
?>