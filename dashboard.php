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
if(count($result) == 1){
	$user = $result[0];
	$lastName = $user[0];
	$user_role = $user[1];
	$template = loadTemplate('templates','dashboard.tmpl');
	echo $template->render(array('user_role'=>$user_role, 'last_name' => $lastName));
}
//else errorMessage?
?>