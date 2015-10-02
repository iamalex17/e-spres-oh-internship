<?php
class ConnectToDB{
	function __construct($host, $db, $user, $pass) {
		$this->dbh = (new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass));
	}

	static function interogateDB($sql, $valuesToBind = NULL) {
		global $dbConnector;
		$sth = $dbConnector->dbh->prepare($sql);
		if($valuesToBind != NULL) {
			foreach($valuesToBind as $key => $value) {
				$sth->bindValue(':'.$key, $value);
			}
		}
		$sth->execute();
		return $sth->fetchAll();
	}
}
?>