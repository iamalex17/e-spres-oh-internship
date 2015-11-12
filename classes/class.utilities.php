<?php
require_once '../config.php';

class Utilities {
	public function redirectWithFilter() {
		$currentFilter = $_SESSION['label'];
		if(isset($currentFilter)) {
			header('Location: ' . $GLOBALS['path'] . 'dashboard?show=' . $currentFilter);
			exit();
		} else {
			header('Location: ' . $GLOBALS['path'] . 'dashboard');
			exit();
		}
	}
}
?>