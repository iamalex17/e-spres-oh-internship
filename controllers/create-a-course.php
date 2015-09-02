<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.course.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $path . 'login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $path . 'dashboard.php');
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

if(!isset($_POST['textareas'])) {
	$_POST['textareas'] = trim($_POST['textareas']);
	$errorMessage .= "Add a description to the course.\n";
	$status = 0;
}

if($_POST['title'] == '') {
	$errorMessage .= "Add a title to the course.\n";
	$status = 0;
}

if($_POST['textareas'] == '') {
	$errorMessage .= "Add a description to the course.\n";
	$status = 0;
}

$sql = 'SELECT title FROM `courses`';
$result = ConnectToDB::interogateDB($sql);
if(count($result)) {
	if(strtolower($_POST['title']) == strtolower($result[0][0])) {
		$errorMessage .= "A course with this name already exists\n";
		$status = 0;
	}
}

if($status == 0) {
	$titleToAdd = $_POST['title'];
	$descriptionToAdd = $_POST['textareas'];
}

if(!empty($_POST['label'])) {
	$label = implode(', ', $_POST['label']);
}

$_SESSION['course'] = $_POST;
if($status == 1) {
	$sql = 'INSERT INTO `courses` (`id`, `title`, `label`, `description`, `status`) VALUES (NULL, :title, :label, :textareas, 1)';
	$valuesToBind = array('title' => $_POST['title'], 'label' => $label, 'textareas' => $_POST['textareas']);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$sql = 'SELECT id FROM `courses` WHERE title = :title';
	$valuesToBind = array('title' => $_POST['title']);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$courseId = $result[0][0];
	foreach($_POST['mentor'] as $id) {
		$sql = 'INSERT INTO `presentors` (course_id, presentor_id) VALUES (:course_id, :presentor_id)';
		$valuesToBind = array('course_id' => $courseId, 'presentor_id' => $id);
		ConnectToDB::interogateDB($sql, $valuesToBind);
	}
	$successMessage = "Course created!\n";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $path . 'users/create-course.php?step=2');
	exit();
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ' . $path . 'users/create-course.php');
	exit();
}
?>