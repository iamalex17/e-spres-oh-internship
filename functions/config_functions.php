<?php
	function connectDB($host, $db, $user, $pass){
		return (new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass));
	}

	function verifyRequestURL($url){
		$url = explode('/', $url);
		return $url[count($url)-1];
	}

	function verifySessionID($dbh){
		session_start();
		if(!isset($_SESSION['id'])){
			return false;
		}
		$sth = $dbh->prepare('SELECT session_id FROM `users` WHERE id = :userID');
		$sth->bindValue(':userID', $_SESSION['id']);
		$sth->execute();
		$result=$sth->fetch();
		if($result[0]==session_id()){
			session_regenerate_id();
			$sth = $dbh->prepare('UPDATE `users` SET session_id = :sessionID WHERE id = :userID');
			$sth->bindValue(':sessionID', session_id());
			$sth->bindValue(':userID', $_SESSION['id']);
			$sth->execute();
			return true;
		}
		return false;
	}
?>