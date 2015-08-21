<?php
require 'config.php';
require 'functions/load-template.php';

if(!verifySessionID()) {
	header('Location: login.php');
	exit();
}

$deleteMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$request = verifyRequestURL($_SERVER['REQUEST_URI']);
	if($request != 'dashboard.php') {
		exit();
	}
	$deleteUser = $_POST['delete_button'];


	$sth = $dbh->prepare('UPDATE `users` SET status = 0 WHERE id = :deletedUserID');
	$sth->bindValue(':deletedUserID', $deleteUser);
	$sth->execute();
	$deleteMessage = 'User succesfully deleted!';
}

$internMessage = '';
$mentorMessage = '';

$sql = 'SELECT * FROM `users` WHERE session_id = :session_id';
$valuesToBind = array('session_id' => $_SESSION['session_id']);

$user = new User($_SESSION);

$sql = 'SELECT * FROM `users` WHERE user_role = 2';
$mentor = ConnectToDB::interogateDB($sql);

$sql = 'SELECT count(*) FROM `users` WHERE user_privilege = 2 AND status = 0';
$result = ConnectToDB::interogateDB($sql);

if($result[0] == count($mentor)) {
	$mentor = NULL;
	$mentorMessage .= 'No mentor to display yet.';
}


$sql = 'SELECT * FROM `users` WHERE user_role = 2';
$intern = ConnectToDB::interogateDB($sql);

$sql = 'SELECT count(*) FROM `users` WHERE user_privilege = 3 AND status = 0';
$result = ConnectToDB::interogateDB($sql);

if($result[0] == count($intern)) {
	$intern = NULL;
	$internMessage .= 'No intern to display yet.';
}

$template = loadTemplate('templates','dashboard.tmpl');
echo $template->render(array('user_role' => $user->user_role, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'deleteMessage' => $deleteMessage));

?>