<?php
require_once 'config.php';
require_once 'controllers/load-template.php';

session_start();

$errorMessage = '';
$successMessage = '';
$role = '';

if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

if(isset($_SESSION['successMessage'])) {
	$successMessage = $_SESSION['successMessage'];
	unset($_SESSION['successMessage']);
}

if(isset($_SESSION['course'])) {
	unset($_SESSION['course']);
}

if(isset($_SESSION['access_token'])) {
	$sql = 'SELECT * FROM `google_users` WHERE google_id = :google_id';
	$valuesToBind = array('google_id' => $_SESSION['google_id']);
	$userGoogle = ConnectToDB::interogateDB($sql, $valuesToBind);
	$firstName = $userGoogle[0]['google_first_name'];
	$lastName = $userGoogle[0]['google_last_name'];
	$profileImage = $userGoogle[0]['image'];
	$role = $userGoogle[0]['user_role'];
	$googleId = $userGoogle[0]['google_id'];
	$user = NULL;
} else {
	$sql = 'SELECT * FROM `users` WHERE session_id = :session_id';
	$valuesToBind = array('session_id' => $_SESSION['session_id']);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$user = new User($_SESSION);
	$userGoogle = NULL;
}

$template = loadTemplate('templates','dashboard.tmpl');

if($user == NULL) {
	if(($role == 2) || ($role == 3)) {
		require_once 'controllers/users-dashboard.php';
	}
} else {
	if($user->user_role == 1) {
		require_once 'controllers/admin-dashboard.php';
	} elseif (($user->user_role == 2) || ($user->user_role  == 3)) {
		require_once 'controllers/users-dashboard.php';
	}
}
?>