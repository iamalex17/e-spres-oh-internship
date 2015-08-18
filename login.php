<?php
require_once 'config.php';
require_once 'functions/load_template.php';
session_start();
session_regenerate_id();
$errorMessage = '';
$username = '';
try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$request = verifyRequestURL($_SERVER['REQUEST_URI']);
		if($request != 'login.php'){
			exit();
		}
		if(isset($_POST['username'])){
			$username = $_POST['username'];
			if(isset($_POST['password'])){
				$password = $_POST['password'];
				$sth = $dbh->prepare('SELECT * FROM `users` WHERE username = :username AND password = MD5(:password)');
				$sth->bindValue(':username', $username);
				$sth->bindValue(':password', $password);
				$sth->execute();
				$result = $sth->fetchAll();
				if(count($result)==1){
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