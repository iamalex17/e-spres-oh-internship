<?php
	require_once '../config.php';

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		if($_GET['action'] == 'logout') {
					logout();
		}
	}

	function login() {

	}

	function logout() {
		session_start();
		$id = $_SESSION['id'];
		$sql = 'UPDATE `users` SET session_id = NULL WHERE id = :id';
		$valuesToBind = array('id' => $id);
		ConnectToDB::interogateDB($sql, $valuesToBind);
		session_unset();
		session_destroy();
		header('Location: ../login.php');
	}
?>