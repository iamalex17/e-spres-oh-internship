<?php
require_once 'config.php';
require_once 'functions/load-template.php';
if(!verifySessionID($dbh)) {
	header('Location: login.php');
	exit();
}
$userID = $_SESSION['id'];
$lastName = $_SESSION['last_name'];
$userRole = $_SESSION['user_privilege'];
$profileImage = $_SESSION['profile_image'];
$template = loadTemplate('templates','change-password.tmpl');
echo $template->render(array('userID' => $userID, 'last_name' => $lastName, 'user_role' => $userRole, 'profile_image' => $profileImage));
?>