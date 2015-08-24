<?php
require 'config.php';
require 'functions/load-template.php';
require_once 'class.connect-to-db.php';
require_once 'class.user.php';

if(!User::verifySessionID()) {
	header('Location: login.php');
	exit();
}

$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';

try {
	$user = new User($_SESSION);
	$template = loadTemplate('templates', 'create-mentor.tmpl');
	echo $template->render(array('id' => $user->id, 'last_name' => $user->last_name, 'user_role' => $user->user_role, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
