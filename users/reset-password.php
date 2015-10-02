<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../controllers/load-template.php';

try {
	session_start();
	$link = '';

	if($_SERVER['REQUEST_METHOD'] == 'GET') {
	$link = isset($_GET["link"]) ? trim($_GET["link"]) : '';
	$sql = 'SELECT reset_password, deletion_link_time FROM `users` WHERE reset_password = :resetPassword';
	$valuesToBind = array('resetPassword' => $link);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if(!count($result)) {
		$_SESSION['errorMessage'] = 'Requested link not found.';
		header('Location:' . $path . 'login.php');
		exit();
	} else {
		$createDate = strtotime( $result[0]['deletion_link_time'] );
		$expireDate = $createDate + 86400;
		$currentdate = strtotime(date('Y/m/d h:i:s', time()));
		if ($expireDate - $currentdate < 0) {
			$_SESSION['errorMessage'] = "This link expired.\nPlease re-enter your email.";
			header('Location:' . $path . 'users/recover-password.php');
			exit();
		}
	}
}

$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

	$template = loadTemplate('../templates','reset-password.tmpl');
	echo $template->render(array('link' => $link, 'errorMessage' => $errorMessage, 'currentPage' => $currentPage, 'path' => $path));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>