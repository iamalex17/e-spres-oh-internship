<?php
require 'config.php';
require 'functions/load_template.php';
session_start();
session_regenerate_id();
$errorMessage = '';
$successMessage = '';
try {
	$status = 1;
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['username']) && isset($_POST['emailAdress']) && isset($_POST['password']) && isset($_POST['retypePassword'])) {
			$firstName = trim($_POST['firstName']);
			$lastName = trim($_POST['lastName']);
			$username = trim($_POST['username']);
			$emailAdress = trim($_POST['emailAdress']);
			$password = trim($_POST['password']);
			$retypePassword = trim($_POST['retypePassword']);
			if($firstName == '') {
				$errorMessage .= 'First Name field not completed properly';
				$status = 0;
			}
			if($lastName == '') {
				$errorMessage .= 'Last Name field not completed properly';
				$status = 0;
			}
			if($password < 8) {
				$errorMessage = 'Password must have at least 8 characters length';
				$status = 0;
			}
			if($username == '') {
				$errorMessage .= 'Username filed not completed properly';
				$status = 0;
			}
			if($password != $retypePassword) {
				$errorMessage .= 'Passwords do not match. Check again!<br>';
				$status = 0;
				}
			if(!filter_var($emailAdress, FILTER_VALIDATE_EMAIL)) {
				$errorMessage .= 'Email is not valid<br>';
				$status = 0;
			}
			if($status == 1) {
				$sth = $dbh->prepare('INSERT INTO `internship`.`users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_privilege`, `status`, `reset_password`, `deletion_link_time`) VALUES (NULL, :firstName, :lastName, :emailAdress, :username, MD5(:password), 2, 1, NULL, NULL);');
				$sth->bindValue(':firstName', $firstName);
				$sth->bindValue(':lastName', $lastName);
				$sth->bindValue(':username', $username);
				$sth->bindValue(':emailAdress', $emailAdress);
				$sth->bindValue(':password', $password);
				$sth->execute();
				$result = $sth->fetchAll();
				$successMessage = 'Mentor added succesfully.</br>';
			}
		}
	}
	$template = loadTemplate('templates', 'createMentor.tmpl');
	echo $template->render(array('errorMessage' => $errorMessage, 'successMessage' => $successMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>