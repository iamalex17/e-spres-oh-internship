<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

$errorMessage = '';
$userToAdd = '';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

if(isset($_SESSION['userToAdd'])) {
	$userToAdd = $_SESSION['userToAdd'];
	unset($_SESSION['userToAdd']);
}

$sql = 'SELECT * FROM `google_users` WHERE status = 0 AND user_role = 0';
$pendingUsers = ConnectToDB::interogateDB($sql);
$requests = count($pendingUsers);

try {
	$user = new User($_SESSION);
	$template = loadTemplate('../templates', 'create-intern.tmpl');
	echo $template->render(array('id' => $user->id, 'first_name' => $user->first_name, 'user_role' => $user->user_role, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage, 'userToAdd' => $userToAdd, 'path' => $path, 'currentPage' => $currentPage, 'requests' => $requests));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}