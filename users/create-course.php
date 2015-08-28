<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ../login.php');
	exit();
}

$course = '';

if(isset($_SESSION['course'])) {
	$course = $_SESSION['course'];
	$course['description'] = $_SESSION['course']['textareas'];
	unset($_SESSION['course']);
}

$errorMessage = '';
if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

try {
	$courseMentors = '';
	$page = '';
	if(($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['course_id'])) {
		$page = 'edit';
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'dashboard.php') {
			header('Location: ../dashboard.php');
			exit();
		}
		$sql = 'SELECT * FROM `courses` WHERE id = :id';
		$id = $_GET['course_id'];
		$valuesToBind = array('id' => $id);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		$course = $result[0];
		$sql = 'SELECT id, last_name, user_role FROM `users` WHERE user_role = 2 AND status = 1';
		$mentor = ConnectToDB::interogateDB($sql);

		$sql = 'SELECT users.id
				FROM `users`
				INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
				INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
				WHERE `courses`.`id` = :courseID';
		$valuesToBind = array('courseID' => $course['id']);
		$courseMentors = ConnectToDB::interogateDB($sql, $valuesToBind);
	}

	$user = new User($_SESSION);
	$sql = 'SELECT id, last_name, user_role FROM `users` WHERE user_role = 2 AND status = 1';
	$mentor = ConnectToDB::interogateDB($sql);
	$template = loadTemplate('../templates','create-course.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'mentor' => $mentor, 'course' => $course, 'courseMentors' => $courseMentors, 'page' => $page, 'errorMessage' => $errorMessage));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>