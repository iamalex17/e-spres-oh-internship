<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

$errorMessage = '';
$noRequests = '';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}

if(isset($_SESSION['noRequests'])) {
	$errorMessage = $_SESSION['noRequests'];
	unset($_SESSION['noRequests']);
}

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

$sql = 'SELECT * FROM `google_users` WHERE status = 0 AND user_role IS NULL';
$pendingUsers = ConnectToDB::interogateDB($sql);

if(count($pendingUsers) == 0) {
	$noRequests = "No users at the moment.\n";
}

try {
	$user = new User($_SESSION);
	$template = loadTemplate('../templates', 'pending-requests.tmpl');
	echo $template->render(array('id' => $user->id, 'first_name' => $user->first_name, 'user_role' => $user->user_role, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage, 'path' => $path, 'currentPage' => $currentPage, 'pendingUsers' => $pendingUsers, 'noRequests' => $noRequests));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>