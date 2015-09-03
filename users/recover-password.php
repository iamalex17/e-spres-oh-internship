<?php
	require_once '../config.php';
	require_once '../controllers/load-template.php';

session_start();
$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

$template = loadTemplate('../templates','recover-password.tmpl');
echo $template->render(array('errorMessage' => $errorMessage, 'path' => $path, 'currentPage' => $currentPage));
?>