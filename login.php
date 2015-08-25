<?php
require_once 'config.php';
require_once 'functions/load-template.php';
require_once 'class.connect-to-db.php';
session_start();
$errorMessage = '';
if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	session_unset();
	session_destroy();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$request = User::verifyRequestURL($_SERVER['REQUEST_URI']);
		if($request != 'login.php'){
			exit();
		}
	}
	$template = loadTemplate('templates','login.tmpl');
	echo $template->render(array('username' => $username, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>