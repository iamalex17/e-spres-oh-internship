<?php
require_once 'config.php';
require_once 'functions/load_template.php';
try {
	session_start();
	session_regenerate_id();
	session_unset();
	session_destroy();
	header('Location: login.php');
	exit();
	} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>