<?php
require 'config.php';
require 'functions/load_template.php';
try {
	$link = '';
	$errorMessage = '';
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$link = $_GET["link"];
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if($_POST['newPassword'] == $_POST['retypeNewPassword']) {
			$newPassword = $_POST['retypeNewPassword'];
			$resetPassword = $_POST['link'];
			$sth = $dbh->prepare('UPDATE `users` SET password = MD5(:retypeNewPassword), reset_password = NULL, deletion_link_time = NULL WHERE reset_password = :resetPassword');
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
	echo $template->render(array('link' => $link, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>