<?php
require_once '../config.php';
require_once '../classes/class.user.php';
require_once '../classes/class.connect-to-db.php';

$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
$errorMessage = '';
$status = 1;
$_SESSION['userToAdd'] = $_POST;
$user = new User($_POST);

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
}

if(!User::verifySessionID()) {
	header('Location: login.php');
	exit();
}

if($request == 'create-intern.php') {
	$role = 3;
} else if($request == 'create-mentor.php') {
	$role = 2;
} else {
	header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
}

if(!isset($_POST['first_name'])) {
	$_POST['first_name'] = trim($_POST['first_name']);
	$errorMessage .= "First name field should not be empty.\n";
	$status = 0;
}

if(!isset($_POST['last_name'])) {
	$_POST['last_name'] = trim($_POST['last_name']);
	$errorMessage .= "Last name filed should not be empty.\n";
	$status = 0;
}

if(!isset($_POST['username'])) {
	$_POST['username'] = trim($_POST['username']);
	$errorMessage .= "Username field should not be empty.\n";
	$status = 0;
}

if(!isset($_POST['email'])) {
	$_POST['email'] = trim($_POST['email']);
	$errorMessage .= "Email field should not be empty.\n";
	$status = 0;
}

if((!isset($_POST['password'])) || (strlen($_POST['password']))<8) {
	$_POST['password'] = trim($_POST['password']);
	$errorMessage .= "Password must have at least 8 characters.\n";
	$status = 0;
}

if(!isset($_POST['retypePassword'])) {
	$_POST['retypePassword'] = trim($_POST['retypePassword']);
	$errorMessage .= "Retype password field should not be empty.\n";
	$status = 0;
}


if($status == 0) {
	$_SESSION['errorMessage'] = $errorMessage;
	$role == 2 ? header('Location: ../admin/create-mentor.php') : header('Location: ../admin/create-intern.php');
	exit();
}


if($user->first_name == '') {
	$errorMessage .= "First Name field not completed properly.\n";
	$status = 0;
}

if($user->last_name == '') {
	$errorMessage .= "Last Name field not completed properly.\n";
	$status = 0;
}

if($user->username == '') {
	$errorMessage .= "Username filed not completed properly.\n";
	$status = 0;
} else {
	$sql = 'SELECT username FROM `users` WHERE username = :username';
	$valuesToBind = array('username' => $user->username);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if(count($result)) {
		$errorMessage .= "Username already exists.\n";
		$status = 0;
	}
}

if(strlen($user->password)< 8) {
	$errorMessage .= "Password must have at least 8 characters.\n";
	$status = 0;
}

if($user->password != MD5($_POST['retypePassword'])) {
	$errorMessage .= "Passwords do not match. Check again!\n";
	$status = 0;
}

if(filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
	$sql = 'SELECT email FROM `users` WHERE email = :email';
	$valuesToBind = array('email' => $user->email);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if(count($result)){
		$errorMessage .= "Email already exists.\n";
		$status = 0;
	}
	$sql = 'SELECT google_email FROM `google_users` WHERE google_email = :google_email';
	$valuesToBind = array('google_email' => $user->email);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if(count($result)){
		$errorMessage .= "Email already exists.\n";
		$status = 0;
	}
} else {
	$errorMessage .= "Email is not valid.\n";
	$status = 0;
}

if($status == 1) {
	$sql = 'INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_role`, `profile_image`, `status`, `reset_password`, `deletion_link_time`) VALUES (NULL, :first_name, :last_name, :username, :email, :password, :role, "21232f297a57a5a743894a0e4a801fc3.png", 1, NULL, NULL)';
	$valuesToBind = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'username' => $user->username, 'email' => $user->email, 'password' => $user->password, 'role' => $role);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$_SESSION['successMessage'] =  $role == 2 ? 'Mentor added succesfully.' : 'Intern added succesfully';
	if($_FILES['profile_image']['name'] != '') {
		array_push($_SESSION['userToAdd'], $_FILES['profile_image']['name']);
		$errorMessage .= $user->addProfileImage();
		$_SESSION['errorMessage'] = $errorMessage;
	} else {
		$errorMessage .= "Profile image was not added.";
	}
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	$role == 2 ? header('Location:../admin/create-mentor.php') : header('Location:../admin/create-intern.php');
	exit();
}
header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
?>