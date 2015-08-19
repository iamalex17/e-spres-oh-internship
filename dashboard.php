<?php
require 'config.php';
require 'functions/load_template.php';

session_start();
session_regenerate_id();

$userID = $_SESSION['id'];
$sth = $dbh->prepare('SELECT last_name, user_privilege FROM `users` WHERE id = :userID');
$sth->bindValue(':userID', $userID);
$sth->execute();
$result = $sth->fetchAll();
if(count($result) == 1) {
	$message = '';
	$user = $result[0];
	$lastName = $user[0];
	$user_role = $user[1];
	$sth = $dbh->prepare('SELECT id, first_name, last_name, email FROM `users` WHERE user_privilege = 2');
	$sth->execute();
	$mentor = $sth->fetchAll();
	if(!count($mentor)) {
		$message .= 'No mentor to display yet.';
	}
	$sth = $dbh->prepare('SELECT id, first_name, last_name, email FROM `users` WHERE user_privilege = 3');
	$sth->execute();
	$intern = $sth->fetchAll();
	if(!count($intern)) {
		$message .= 'No intern to display yet.';
	}
	$template = loadTemplate('templates','dashboard.tmpl');
	echo $template->render(array('user_role'=>$user_role, 'last_name' => $lastName, 'mentor' => $mentor, 'intern' => $intern, 'message' => $message));
}
//else errorMessage?
?>