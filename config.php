<?php
include 'Twig/Autoloader.php';
Twig_Autoloader::register();

class ConnectDB
{
	function __construct($host, $db, $user, $pass)
	{
		$this->dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass);
	}
}
	try {
		$conn = new ConnectDB('localhost', 'internship', 'root', '');
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

class LoadTemplate
{
	function __construct($folder, $templateFile)
	{
		// define template directory location
		$loader = new Twig_Loader_Filesystem($folder);
		
		// initialize Twig environment
		$twig = new Twig_Environment($loader);
		
		// load template
		$this->template = $twig->loadTemplate($templateFile);
	}
}
?>