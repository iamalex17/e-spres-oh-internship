<?php
require 'config.php';
require 'functions/load_template.php';
$errorMessage = '';
try {
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if($_POST['password'] == $_POST['newPassword']) {
			$newPassword = $_POST['newPassword'];
			$resetPassword = 'abc';
			$sth = $dbh->prepare('UPDATE `users` SET password = :newPassword WHERE reset_password = :resetPassword');
			$sth->bindValue(':newPassword', $newPassword);
			$sth->bindValue(':resetPassword', $resetPassword);
			$sth->execute();
			$result = $sth->fetchAll();
			header('Location: login.php');
			exit();
		} else {
			$errorMessage = 'Passwords do not match. Check again!';
			}
	}
	$template = loadTemplate('templates','resetPassword.tmpl');
	echo $template->render(array('errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>