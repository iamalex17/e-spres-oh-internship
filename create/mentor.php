<?php
require 'config.php';
require 'functions/load_template.php';
try {
	$errorMessage = '';
	$status = 1;
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['firstName']) && isset($_POST['lastName']) &&isset($_POST['username']) && isset($_POST['emailAdress']) && isset($_POST['password']) && isset($_POST['retypePassword'])) {
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$username = $_POST['username'];
			$emailAdress = $_POST['emailAdress'];
			$password = $_POST['password'];
			if(trim($firstName)  = '') {
				$errorMessage .= 'First Name field not completed properly';
				$status = 0;
			}
			if(trim($lastName) = '') {
				$errorMessage .= 'Last Name field not completed properly';
				$status = 0;
			}
			if(trim($password) < 8) {
				$errorMessage = 'Password must have at least 8 characters length';
				$status = 0;
			}
			if(trim(($username)) = '') {
				$errorMessage .= 'Username filed not completed properly';
				$status = 0;
			}
			if(!($_POST['password'] == $_POST['retypePassword'])) {
				$errorMessage .= 'Passwords do not match. Check again!<br>';
				$status = 0;
				}
			if(!filter_var($emailAdress, FILTER_VALIDATE_EMAIL)) {
				$errorMessage. = 'Email is not valid<br>';
				$status = 0;
			}
			if($status = 1) {
				$sth = $dbh->prepare('INSERT INTO `internship`.`users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_privilege`, `status`, `reset_password`, `deletion_link_time`) VALUES (NULL, :firstName, :lastName, :emailAdress, :username, :password, 2, 1, NULL, NULL);');
				$sth->bindValue(':firstName', $firstName);
				$sth->bindValue(':lastName', $lastName);
				$sth->bindValue(':username', $username);
				$sth->bindValue(':emailAdress', $emailAdress);
				$sth->bindValue(':password', $password);
				$sth->execute();
				$result = $sth->fetchAll();
			}
		}
	}
	$template = loadTemplate('templates', 'createMentor.tmpl');
	echo $template->render(array('errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>