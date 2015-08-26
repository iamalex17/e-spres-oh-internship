<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ../login.php');
	exit();
}

$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

$userToAdd = '';

if(isset($_SESSION['userToAdd'])) {
	$userToAdd = $_SESSION['userToAdd'];
	unset($_SESSION['userToAdd']);
}

try {
	$user = new User($_SESSION);
	$template = loadTemplate('../templates', 'create-intern.tmpl');
	echo $template->render(array('id' => $user->id, 'last_name' => $user->last_name, 'user_role' => $user->user_role, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage, 'userToAdd' => $userToAdd));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}