<?php
require_once '../config.php';

class Utilities {
	public function redirectWithFilter() {
		$currentFilter = '';
		if(isset($_SESSION['label'])) {
			$currentFilter = $_SESSION['label'];
			header('Location: ' . $GLOBALS['path'] . 'dashboard?show=' . $currentFilter);
			exit();
		} else {
			header('Location: ' . $GLOBALS['path'] . 'dashboard');
			exit();
		}
	}
}
?>