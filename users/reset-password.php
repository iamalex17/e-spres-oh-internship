<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
try {

$link = '';

if($_SERVER['REQUEST_METHOD'] == 'GET') {
	$link = isset($_GET["link"]) ? trim($_GET["link"]) : '';
}

session_start();

$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

	$template = loadTemplate('../templates','reset-password.tmpl');
	echo $template->render(array('link' => $link, 'errorMessage' => $errorMessage, 'currentPage' => $currentPage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>