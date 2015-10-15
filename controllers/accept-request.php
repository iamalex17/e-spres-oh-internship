<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.course.php';
require_once '../classes/class.user.php';

session_start();

$errorMessage = '';
$successMessage = '';
$status = 1;

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
}

if(empty($_POST['role'])) {
	$errorMessage = "Select a role.\n";
	$status = 0;
}

if($status == 1) {
	if($_POST['role'] == 'mentor') {
		$sql = 'UPDATE `google_users` SET status = 1, user_role = 2 WHERE google_id = :google_id';
		$valuesToBind = array('google_id' => $_POST['accept_button']);
		ConnectToDB::interogateDB($sql, $valuesToBind);
	} elseif($_POST['role'] == 'intern') {
		$sql = 'UPDATE `google_users` SET status = 1, user_role = 3 WHERE google_id = :google_id';
		$valuesToBind = array('google_id' => $_POST['accept_button']);
		ConnectToDB::interogateDB($sql, $valuesToBind);
	}
	$successMessage = "Role assigned!";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $GLOBALS['path'] . 'admin/pending-requests.php');
	exit();
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ' . $GLOBALS['path'] . 'admin/pending-requests.php');
	exit();
}
?>