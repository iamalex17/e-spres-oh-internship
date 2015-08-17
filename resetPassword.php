<?php
require 'config.php';
require 'functions/load_template.php';
$errorMessage = '';
try {
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if($_POST['newPassword'] == $_POST['retypeNewPassword']) {
			$newPassword = $_POST['retypeNewPassword'];
			$resetPassword = 'abc';
			$sth = $dbh->prepare('UPDATE `users` SET password = :retypeNewPassword WHERE reset_password = :resetPassword');
			$sth->bindValue(':retypeNewPassword', $newPassword);
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