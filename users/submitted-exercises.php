<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}

$user = new User($_SESSION);

$template = loadTemplate('../templates','submitted-exercises.tmpl');
echo $template->render(array('path' => $path, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role));
?>