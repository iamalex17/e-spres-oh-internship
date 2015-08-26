<?php
require_once '../config.php';
require_once '../functions/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

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
	$sql = 'SELECT id, last_name FROM `users` WHERE user_role = 2 AND status = 1';
	$mentor = ConnectToDB::interogateDB($sql);
	$template = loadTemplate('templates','create-course.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage, 'mentor' => $mentor));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>