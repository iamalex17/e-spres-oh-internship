<?php
require_once '../config.php';


if($_SERVER['REQUEST_METHOD'] == 'GET') {
	if($_GET['action'] == 'logout') {
		logout();
	}
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request != 'login.php'){
		header('Location: ' . $GLOBALS['path'] . 'login');
	}
	if($_GET['action'] == 'login') {
		login();
	} else if ($_GET['action'] == 'logout') {
		logout();
	}
}

function login() {
	if(isset($_POST['username'])) {
		session_start();
		$errorMessage = '';
		$_SESSION['username'] = $_POST['username'];
		if(isset($_POST['password'])) {
			$user = new User($_POST);
			$sql = 'SELECT * FROM `users` WHERE username = :username AND password = :password';
			$valuesToBind = array('username' => $user->username, 'password' => $user->password);
			$result = ConnectToDB::interogateDB($sql, $valuesToBind);
			if(count($result)==1) {
				$user = new User($result[0]);
				session_regenerate_id();
				$user->session_id = session_id();
				$sql = 'UPDATE `users` SET session_id = :session_id WHERE username = :username';
				$valuesToBind = array('session_id' => session_id(), 'username' => $user->username);
				ConnectToDB::interogateDB($sql, $valuesToBind);
				$_SESSION = (array)$user;
				header('Location: ' . $GLOBALS['path'] . 'dashboard');
				exit();
			} else {
				$errorMessage .= 'Username or password incorrect. Please, try again.';
				$_SESSION['errorMessage'] = $errorMessage;
				header('Location: ' . $GLOBALS['path'] . 'login');
			}
		} else {
			$errorMessage .= 'Please insert password.';
		}
	} else {
		$errorMessage .= 'Please insert username.';
	}
}

function logout() {
	session_start();
	if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];
	$sql = 'UPDATE `users` SET session_id = NULL WHERE id = :id';
	$valuesToBind = array('id' => $id);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	}
	session_unset();
	session_destroy();
	header('Location: ' . $GLOBALS['path'] . 'login');
	exit();
}
?>