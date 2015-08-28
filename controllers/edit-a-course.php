<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: login.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$status = 1;
	$errorMessage = '';
	$id = $_POST['course_id'];
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
	
	$sql = 'SELECT count(*) FROM `courses` WHERE title = :title AND id != :id';
	$valuesToBind = array('title' => $_POST['title'], 'id' => $id);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if($result[0][0]) {
		$status = 0;
	}

	if($status == 1) {
		$title = $_POST['title'];
		$label = $_POST['label'];
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
			$valuesToBind = array('course_id' => $id, 'presentor_id' => $presentor);
			ConnectToDB::interogateDB($sql, $valuesToBind);
		}

		$successMessage = "Course updated!\n";
		$_SESSION['successMessage'] = $successMessage;
		header('Location: ../dashboard.php');
		exit();
	} else {
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ../users/create-course.php');
		exit();
	}
}
?>