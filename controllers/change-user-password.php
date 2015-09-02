<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $path . 'login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $path . 'dashboard.php');
}

$errorMessage = '';
$successMessage = '';
$status = 1;
$newPassword = $_POST['newPassword'];
$retypePassword = $_POST['retypePassword'];
$password = $_POST['oldPassword'];

if(!isset($password)) {
	$_POST['oldPassword'] = trim($_POST['oldPassword']);
	$errorMessage .= "Please enter your password.\n";
	$status = 0;
}
if(!isset($newPassword)) {
	$_POST['newPassword'] = trim($_POST['newPassword']);
	$errorMessage .= "Please enter your new password.\n";
	$status = 0;
}
if(!isset($retypePassword)) {
	$_POST['retypePassword'] = trim($_POST['retypePassword']);
	$errorMessage .= "Please reenter your new password.\n";
	$status = 0;
}

$sql = 'SELECT password FROM `users` WHERE id = :id';
$valuesToBind = array('id' => $_SESSION['id']);
$result = ConnectToDB::interogateDB($sql, $valuesToBind);

if(MD5($password) != $result[0]['password']) {
	$errorMessage = "Current password not entered properly.\n";
	$status = 0;
}
if($password == '') {
	$errorMessage .= "Password field not completed properly.\n";
	$status = 0;
}
if($retypePassword == '') {
	$errorMessage .= "Password field not completed properly.\n";
	$status = 0;
}
if($newPassword != $retypePassword) {
	$errorMessage = "Passwords do no match. Check again!\n";
	$status = 0;
}
if(strlen($newPassword) < 8 && strlen($retypePassword < 8)) {
	$errorMessage = "New password must be at least 8 characters length.\n";
	$status = 0;
}

if($status == 1) {
	$sql = 'UPDATE `users` SET password = :newPassword WHERE id = :id';
	$valuesToBind = array('newPassword' => MD5($_POST['newPassword']), 'id' => $_SESSION['id']);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = "Password changed succesfully!\n";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $path . 'dashboard.php');
	exit();
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ' . $path . 'users/change-password.php');
	exit();
}
?>