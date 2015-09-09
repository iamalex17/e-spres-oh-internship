<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$status = 1;
	$errorMessage = '';
	if(isset($_POST['course_id'])) {
		$id = $_POST['course_id'];
	} else if (isset($_SESSION['course_id'])) {
		$id = $_SESSION['course_id'];
		unset($_SESSION['course_id']);
	}
	if(isset($_POST['title'])) {
		$title = trim($_POST['title']);
	} else if(isset($_SESSION['title'])) {
		$title = $_SESSION['title'];
		unset($_SESSION['title']);
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

	if($title == '') {
		$errorMessage = "Add a title to the course.\n";
		$status = 0;
	}

	if($_POST['textareas'] == '') {
		$errorMessage = "Add a description to the course.\n";
		$status = 0;
	}
	$sql = 'SELECT count(*) FROM `courses` WHERE id != :id AND title = :title';
	$valuesToBind = array('title' => $title, 'id' => $id);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if($result[0][0]) {
		$status = 0;
	}
	if($status == 1) {
		$label = implode(', ', $_POST['label']);
		$presentors = $_POST['mentor'];
		$description = $_POST['textareas'];
		$sql = 'UPDATE `courses` SET title = :title, label = :label, description = :description WHERE id = :id';
		$valuesToBind = array('title' => $title, 'label' => $label, 'description' => $description, 'id' => $id);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		$sql = 'DELETE FROM `presentors` WHERE course_id = :id';
		$valuesToBind = array('id' => $id);
		ConnectToDB::interogateDB($sql, $valuesToBind);

		foreach ($presentors as $presentor) {
			$sql = 'INSERT INTO `presentors` (course_id, presentor_id) VALUES (:course_id, :presentor_id)';
			$valuesToBind = array('course_id' => $id, 'presentor_id' => $presentor[0]);
			ConnectToDB::interogateDB($sql, $valuesToBind);
		}

		$successMessage = "Course updated!\n";
		$_SESSION['successMessage'] = $successMessage;
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	} else {
		$_SESSION['errorMessage'] = $errorMessage;
		$_SESSION['course_id'] = $id;
		$_SESSION['title'] = $title;
		header('Location: ' . $GLOBALS['path'] . 'users/create-course.php');
		exit();
	}
}
?>