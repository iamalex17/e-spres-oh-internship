<?php
require_once 'config.php';
require_once 'controllers/load-template.php';
require_once 'classes/class.connect-to-db.php';
session_start();

$errorMessage = '';
$successMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

if(isset($_SESSION['successMessage'])) {
	$successMessage = $_SESSION['successMessage'];
	unset($_SESSION['successMessage']);
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

try {
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'login.php'){
			exit();
		}
	}
	$template = loadTemplate('templates','login.tmpl');
	echo $template->render(array('username' => $username, 'errorMessage' => $errorMessage, 'successMessage' => $successMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>