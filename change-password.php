<?php
require_once 'config.php';
require_once 'functions/load-template.php';
require_once 'class.connect-to-db.php';
require_once 'class.user.php';

if(!User::verifySessionID()) {
	header('Location: login.php');
	exit();
}

$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

try {
	$user = new User($_SESSION);
	$template = loadTemplate('templates','change-password.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>