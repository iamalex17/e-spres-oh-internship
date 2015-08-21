<?php
require_once 'config.php';
require_once 'functions/load-template.php';
$errorMessage = '';
$username = '';
try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$request = verifyRequestURL($_SERVER['REQUEST_URI']);
		if($request != 'login.php'){
			exit();
		}
		if(isset($_POST['username'])){
			if(isset($_POST['password'])){
				$user = new User($_POST);
				$sql = 'SELECT * FROM `users` WHERE username = :username AND password = :password';
				$valuesToBind = array('username' => $user->username, 'password' => $user->password);
				$result = ConnectToDB::interogateDB($sql, $valuesToBind);
				if(count($result)==1){
					$user = new User($result[0]);
					session_start();
					session_regenerate_id();
					$user->session_id = session_id();
					$sql = 'UPDATE `users` SET session_id = :session_id WHERE username = :username';
					$valuesToBind = array('session_id' => session_id(), 'username' => $user->username);
					ConnectToDB::interogateDB($sql, $valuesToBind);
					$_SESSION = (array)$user;
					header('Location: dashboard.php');
					exit();
				} else {
					$errorMessage .= 'Username or password incorrect. Please, try again.';
				}
			} else {
				$errorMessage .= 'Please insert password.';
			}
		} else {
			$errorMessage .= 'Please insert username.';
		}
	}
	$template = loadTemplate('templates','login.tmpl');
	echo $template->render(array('username' => $username, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>