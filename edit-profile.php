<?php
require_once 'config.php';
require_once 'functions/load-template.php';
require_once 'class.connect-to-db.php';
require_once 'class.user.php';

if(!User::verifySessionID()) {
	header('Location: login.php');
	exit();
}

$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';

try {
	$user = new User($_SESSION);
	$template = loadTemplate('templates','edit-profile.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'profile_image' => $user->profile_image));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>