<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}
$step = 0;
$course = '';
$exercises = '';
$successMessage = '';
$exerciseStatus = '';
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

$sql = 'SELECT `c`.`title`, `c`.`id`, `c`.`status` FROM `courses` `c` WHERE (SELECT count(*) FROM exercises WHERE course_id = `c`.`id` AND `exercises`.`status` = 1) > 0 AND status = 1';
$coursesWithExercises = ConnectToDB::interogateDB($sql);

if(count($coursesWithExercises) == 0) {
		$coursesWithExercises = NULL;
		$noExerciseMessage = 'No exercises to display';
}

try {
	$page = '';
	if((($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['course_id'])) || isset($_SESSION['course_id'])) {
		$page = 'edit';
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'dashboard.php' && $request != 'create-course.php') {
			header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
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
		$exerciseStatus = '';
		$sql = 'SELECT * FROM `exercises` WHERE course_id = :id';
		$valuesToBind = array('id' => $course['id']);
		$exercises = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(count($exercises)) {
			foreach($exercises as &$exercise) {
				$exercise['description'] = html_entity_decode($exercise['description']);
			}
			$exerciseStatus = 1;
		} else {
			$exerciseStatus = 0;
		}
	}

	$user = new User($_SESSION);
	$sql = 'SELECT * FROM `users` WHERE user_role = 2 AND status = 1';
	$mentor = ConnectToDB::interogateDB($sql);
	$template = loadTemplate('../templates','create-course.tmpl');
	echo $template->render(array('noExerciseMessage' => $noExerciseMessage, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'mentor' => $mentor, 'course' => $course, 'courseMentors' => $courseMentors, 'page' => $page, 'errorMessage' => $errorMessage, 'successMessage' => $successMessage, 'step' => $step, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'exercises' => $exercises, 'exerciseStatus' => $exerciseStatus, 'currentPage' => $currentPage));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>