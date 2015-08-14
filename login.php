<?php
	require 'config.php';

// include and register Twig auto-loader
include 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
	// define template directory location
	$loader = new Twig_Loader_Filesystem('templates');
	
	// initialize Twig environment
	$twig = new Twig_Environment($loader);
	
	// load template
	$template = $twig->loadTemplate('login.tmpl');
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}

try {
	$username = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
	echo $template->render(array('username'=>$username));
	
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>