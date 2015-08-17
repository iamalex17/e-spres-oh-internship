<?php
require_once 'config.php';
require_once 'functions/load_template.php';
require_once 'functions/login_functions.php';

try {
	$username = '';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['email'])){
			$link = generateRandomString($_POST['email']);
		}else{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$sth = $dbh->prepare('SELECT * FROM `users` WHERE username = :username AND password = MD5(:password)');
			$sth->bindValue(':username', $username);
			$sth->bindValue(':password', $password);
			$sth->execute();
			$result = $sth->fetchAll();
			if(count($result)==1){
				header('Location: dashboard.php');
				exit();
			}	
		}
	}
	$template = loadTemplate('templates','login.tmpl');
	echo $template->render(array('username'=>$username));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>