<?php
	require 'config.php';
	require 'functions/load-template.php';
	require 'functions/recover-functions.php';
	$errorMessage = '';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$request = verifyRequestURL($_SERVER['REQUEST_URI']);
		if($request != 'recover-password.php'){
			exit();
		}
		if(isset($_POST['email'])){
			$email = trim($_POST['email']);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				$link = generateRandomString($dbh, $email);
			}
			else{
				$errorMessage = 'E-mail address is not valid.</br>';
			}
		}
	}
	$template = loadTemplate('templates','recover-password.tmpl');
	echo $template->render(array('errorMessage' => $errorMessage));
?>