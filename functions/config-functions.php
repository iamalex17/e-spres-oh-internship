<?php
	function connectDB($host, $db, $user, $pass){
		return (new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass));
	}
?>