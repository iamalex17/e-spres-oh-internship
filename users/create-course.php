<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ../login.php');
	exit();
}
$step = 0;
$course = '';
$successMessage = '';
$courseMentors = array();
if(isset($_SESSION['course'])) {
	$course = $_SESSION['course'];
	$course['description'] = $_SESSION['course']['textareas'];
	unset($_SESSION['course']);
	if(isset($course['label'])) {
		$course['label'] = implode(', ', $course['label']);
	}
	if(isset($course['mentor'])) {
		foreach ($course['mentor'] as $key => $courseMentor) {
			$a = array('id' => $courseMentor);
			array_push($courseMentors, $a);
		}
	}
}

$errorMessage = '';
$successMessage = '';
if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}
if(isset($_SESSION['successMessage'])) {
	$successMessage = $_SESSION['successMessage'];
	unset($_SESSION['successMessage']);
}

if(isset($_GET['step'])) {
	$step = $_GET['step'] == 2 ? 2 : 0;
}

try {
	$page = '';
	if((($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['course_id'])) || isset($_SESSION['course_id'])) {
		$page = 'edit';
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'dashboard.php' && $request != 'create-course.php') {
			header('Location: ../dashboard.php');
			exit();
		}
		$id = isset($_GET['course_id']) ? $_GET['course_id'] : $_SESSION['course_id'];
		unset($_SESSION['course_id']);
		$sql = 'SELECT * FROM `courses` WHERE id = :id';
		$valuesToBind = array('id' => $id);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(isset($result[0])) {
			$course = $result[0];
			$sql = 'SELECT users.id
					FROM `users`
					INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
					INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
					WHERE `courses`.`id` = :courseID';
			$valuesToBind = array('courseID' => $course['id']);
			$courseMentors = ConnectToDB::interogateDB($sql, $valuesToBind);
		}
	}

	$user = new User($_SESSION);
	$sql = 'SELECT * FROM `users` WHERE user_role = 2 AND status = 1';
	$mentor = ConnectToDB::interogateDB($sql);
	$template = loadTemplate('../templates','create-course.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'mentor' => $mentor, 'course' => $course, 'courseMentors' => $courseMentors, 'page' => $page, 'errorMessage' => $errorMessage, 'successMessage' => $successMessage, 'step' => $step));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>