<?php
require_once 'config.php';
require_once 'functions/load_template.php';
try {
	session_start();
	$userID = $_SESSION['id'];
	$sth = $dbh->prepare('UPDATE `users` SET session_id = NULL WHERE id = :userID');
	$sth->bindValue(':userID', $userID);
	$sth->execute();
	session_unset();
	session_destroy();
	header('Location: login.php');
	exit();
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>