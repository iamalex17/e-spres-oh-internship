<?php
require 'config.php';
require 'functions/load_template.php';
try {
	$link = '';
	$errorMessage = '';
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$link = trim($_GET["link"]);
	}
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$request = verifyRequestURL($_SERVER['REQUEST_URI']);
		if($request != 'resetPassword.php'){
			exit();
		}
		if(isset($_POST['newPassword'])){
			$newPassword = trim($_POST['newPassword']);
			if(isset($_POST['retypeNewPassword'])){
				$retypeNewPassword = trim($_POST['retypeNewPassword']);
				if($newPassword == $retypeNewPassword) {
					$resetLink = trim($_POST['link']);
					$sth = $dbh->prepare('UPDATE `users` SET password = MD5(:retypeNewPassword), reset_password = NULL, deletion_link_time = NULL WHERE reset_password = :resetPassword');
					$sth->bindValue(':retypeNewPassword', $newPassword);
					$sth->bindValue(':resetPassword', $resetLink);
					$sth->execute();
					$result = $sth->fetchAll();
					header('Location: login.php');
					exit();
				} else {
					$errorMessage .= 'Passwords do not match. Check again!</br>';
				}
			}
		} else{
			$errorMessage .= 'Password must be at least 8 characters long.</br>';
		}
	}
	$template = loadTemplate('templates','resetPassword.tmpl');
	echo $template->render(array('link' => $link, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>