<?php
	function connectDB($host, $db, $user, $pass){
		return (new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass));
	}

	function verifyRequestURL($url){
		$url = explode('/', $url);
		return $url[count($url)-1];
	}

	function verifySessionID(){
		session_start();
		if(!isset($_SESSION['id'])){
			return false;
		}
		$sql = 'SELECT session_id FROM `users` WHERE id = :userID';
		$valuesToBind = array('userID' => $_SESSION['id']);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		$row = $result[0];
		if($row['session_id'] == session_id()) {
			session_regenerate_id();
			$sql = 'UPDATE `users` SET session_id = :session_id WHERE id = :id';
			$valuesToBind = array('session_id' => session_id(), 'id' => $_SESSION['id']);
			ConnectToDB::interogateDB($sql, $valuesToBind);
			return true;
		}
		return false;
	}
?>