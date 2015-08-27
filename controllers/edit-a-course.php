<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
require_once '../controllers/load-template.php';

session_start();
$sql = 'SELECT * FROM `courses` WHERE id = :id';
$id = $_GET['course_id'];
$valuesToBind = array('id' => $id);
$result = ConnectToDB::interogateDB($sql, $valuesToBind);
$titleValue = $result[0]['title'];
$descriptionValue = $result[0]['description'];
//$labelValue = $result[0]['label'];
$sql = 'SELECT id, last_name, user_role FROM `users` WHERE user_role = 2 AND status = 1';
$mentor = ConnectToDB::interogateDB($sql);

$user = new User($_SESSION);
$template = loadTemplate('../templates','create-course.tmpl');
echo $template->render(array('last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'titleValue' => $titleValue, 'descriptionValue' => $descriptionValue, 'mentor' => $mentor));


if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$status = 1;
	$errorMessage = '';
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
	
	$sql = 'SELECT title FROM `courses`';
	$result = ConnectToDB::interogateDB($sql);
	if(strtolower($_POST['title']) == strtolower($result[0][0])) {
		$errorMessage = "A course with this name already exists\n";
		$status = 0;
	}
	
	if($status == 1) {
		$title = $_POST['title'];
		$label = $_POST['label'];
		$presentors = $_POST['mentor'];
		$description = $_POST['textareas'];
		$sql = 'UPDATE `courses` SET title = :title, label = :label, description = :description WHERE id = :id';
		$valuesToBind = array('title' => $title, 'label' => $label, 'textareas' => $textareas, 'id' => $id);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		
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