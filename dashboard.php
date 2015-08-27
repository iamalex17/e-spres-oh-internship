<?php
require_once 'config.php';
require_once 'controllers/load-template.php';

if(!User::verifySessionID()) {
	header('Location: login.php');
	exit();
}

$errorMessage = '';
$successMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

if(isset($_SESSION['successMessage'])) {
	$successMessage = $_SESSION['successMessage'];
	unset($_SESSION['successMessage']);
}

$sql = 'SELECT * FROM `users` WHERE session_id = :session_id';
$valuesToBind = array('session_id' => $_SESSION['session_id']);
ConnectToDB::interogateDB($sql, $valuesToBind);

$user = new User($_SESSION);

$template = loadTemplate('templates','dashboard.tmpl');

if($user->user_role == 1) {
	require_once 'controllers/admin-dashboard.php';
} else if (($user->user_role == 2) || ($user->user_role  == 3)) {
	require_once 'controllers/users-dashboard.php';
}

?>