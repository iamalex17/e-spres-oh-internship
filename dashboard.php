<?php
require 'config.php';
require 'functions/load_template.php';

if(!verifySessionID($dbh)){
	header('Location: login.php');
	exit();
}
$deleteMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$request = verifyRequestURL($_SERVER['REQUEST_URI']);
	if($request != 'dashboard.php'){
		exit();
	}
	$deleteUser = $_POST['delete_button'];
	$sth = $dbh->prepare('UPDATE `users` SET status = 0 WHERE id = :deletedUserID');
	$sth->bindValue(':deletedUserID', $deleteUser);
	$sth->execute();
	$deleteMessage = 'User succesfully deleted!';
}
	$userID = $_SESSION['id'];
	$sth = $dbh->prepare('SELECT last_name, user_privilege, profile_image FROM `users` WHERE id = :userID');
	$sth->bindValue(':userID', $userID);
	$sth->execute();
	$result = $sth->fetchAll();
	if(count($result) == 1) {
		$internMessage = '';
		$mentorMessage = '';
		$user = $result[0];
		$lastName = $user[0];
		$userRole = $user[1];
		$profileImage = $user[2];
		$sth = $dbh->prepare('SELECT id, first_name, last_name, email FROM `users` WHERE user_privilege = 2');
		$sth->execute();
		$mentor = $sth->fetchAll();
		if(!count($mentor)) {
			$mentorMessage .= 'No mentor to display yet.';
		}
		$sth = $dbh->prepare('SELECT id, first_name, last_name, email FROM `users` WHERE user_privilege = 3');
		$sth->execute();
		$intern = $sth->fetchAll();
		if(!count($intern)) {
			$internMessage .= 'No intern to display yet.';
		}
		$template = loadTemplate('templates','dashboard.tmpl');
		echo $template->render(array('user_role'=>$userRole, 'last_name' => $lastName, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'deleteMessage' => $deleteMessage, 'profile_image' => $profileImage));
	}
//else errorMessage?
?>