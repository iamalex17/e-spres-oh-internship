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
			$email = trim($_POST['emailAdress']);
			$password = trim($_POST['password']);
			$retypePassword = trim($_POST['retypePassword']);
			if($firstName == '') {
				$errorMessage .= 'First Name field not completed properly'.PHP_EOL;
				$status = 0;
			}
			if($lastName == '') {
				$errorMessage .= 'Last Name field not completed properly'.PHP_EOL;
				$status = 0;
			}
			if(strlen($password) < 8) {
				$errorMessage = 'Password must have at least 8 characters length'.PHP_EOL;
				$status = 0;
			}
			if($username == '') {
				$errorMessage .= 'Username filed not completed properly'.PHP_EOL;
				$status = 0;
			}
			if($password != $retypePassword) {
				$errorMessage .= 'Passwords do not match. Check again!'.PHP_EOL;
				$status = 0;
				}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errorMessage .= 'Email is not valid'.PHP_EOL;
				$status = 0;
			}else{
				$sth = $dbh->prepare('SELECT email FROM `users` WHERE email = :email');
				$sth->bindValue(':email', $email);
				$sth->execute();
				if(count($sth->fetchAll())){
					$errorMessage .= 'Email already exists.'.PHP_EOL;
					$status = 0;
				}
			}
			if($status == 1) {
				$sth = $dbh->prepare('INSERT INTO `internship`.`users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_privilege`, `status`, `reset_password`, `deletion_link_time`) VALUES (NULL, :firstName, :lastName, :username, :email, MD5(:password), 3, 1, NULL, NULL);');
				$sth->bindValue(':firstName', $firstName);
				$sth->bindValue(':lastName', $lastName);
				$sth->bindValue(':username', $username);
				$sth->bindValue(':email', $email);
				$sth->bindValue(':password', $password);
				$sth->execute();
				$result = $sth->fetchAll();
				$successMessage = 'Intern added succesfully.';
			}
		}
	}
	$template = loadTemplate('templates', 'createIntern.tmpl');
	echo $template->render(array('errorMessage' => $errorMessage, 'successMessage' => $successMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>