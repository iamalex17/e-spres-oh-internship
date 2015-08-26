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

if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

$internMessage = '';
$mentorMessage = '';

$sql = 'SELECT * FROM `users` WHERE session_id = :session_id';
$valuesToBind = array('session_id' => $_SESSION['session_id']);

$user = new User($_SESSION);

$sql = 'SELECT * FROM `users` WHERE user_role = 2';
$mentor = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `users` WHERE user_role = 2 AND status = 0';
$result = ConnectToDB::interogateDB($sql);

if(count($result) != 0) {
	if(count($result) == count($mentor)) {
		$mentor = NULL;
		$mentorMessage .= 'No mentor to display yet.';
	}
}

$sql = 'SELECT * FROM `users` WHERE user_role = 3';
$intern = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `users` WHERE user_role = 3 AND status = 0';
$result = ConnectToDB::interogateDB($sql);

if(count($result) != 0) {
	if(count($result) == count($intern)) {
		$intern = NULL;
		$internMessage .= 'No intern to display yet.';
	}
}

$template = loadTemplate('templates','dashboard.tmpl');
echo $template->render(array('user_role' => $user->user_role, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage));

?>