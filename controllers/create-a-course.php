<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.course.php';
require_once '../classes/class.user.php';

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
if(!isset($_POST['textareas'])) {
	$_POST['textareas'] = trim($_POST['textareas']);
	$errorMessage .= "Add a description to the course.\n";
	$status = 0;
}
if($_POST['title'] == '') {
	$errorMessage = "Add a title to the course.\n";
	$status = 0;
}
if($_POST['textareas'] == '') {
	$errorMessage = "Add a description to the course.\n";
	$status = 0;
}
if($status == 1) {
	$sql = 'INSERT INTO `courses` (`id`, `title`, `label`, `description`) VALUES (NULL, :title, :label, :textareas)';
	$valuesToBind = array('title' => $_POST['title'], 'label' => $_POST['label'], 'textareas' => $_POST['textareas']);
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
	header('Location: ../dashboard.php');
	exit();
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ../users/create-course.php');
	exit();
}
?>