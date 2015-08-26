<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.course.php';
require_once '../classesclass.user.php';

if(!User::verifySessionID()) {
	header('Location: ../login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ../dashboard.php');
}

$errorMessage = '';
$successMessage = '';
$status = 1;

if(!isset($_POST['title'])) {
	$_POST['title'] = trim($_POST['title']);
	$errorMessage .= "Add a title to the course.\n";
	$status = 0;
}
if(empty($_POST['label'])) {
	$errorMessage .= "Select a label: backend or frontend.\n";
	$status = 0;
}
if(empty($_POST['mentor'])) {
	$errorMessage .= "Choose at least one mentor.\n";
	$status = 0;
}
/*$test = array();
if(!empty($_POST['mentor'])) {
	foreach((array)$_POST['mentor'] as $check) {
		array_push($test, $check);
		print_r($test) . '<br>';
	}
}*/
/*if(!isset($_POST['content'])) {
	$_POST['content'] = trim($_POST['content']);
	$errorMessage .= "Add a description to the course.\n";
	$status = 0;
}*/
if($_POST['title'] == '') {
	$errorMessage = "Add a title to the course.\n";
	$status = 0;
}
if($_POST['content'] == '') {
	$errorMessage = "Add a description to the course.\n";
	$status = 0;
}
if($status == 1) {
	$sql = 'INSERT INTO `internship`.`courses` (`id`, `title`, `label`, `description`) VALUES (NULL, :title, :label, :content)';
	$valuesToBind = array('title' => $_POST['title'], 'label' => $_POST['label'], 'content' => $_POST['content']);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$successMessage = "Course created!\n";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ../dashboard.php');
	exit();
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ../users/create-course.php');
	exit();
}
?>