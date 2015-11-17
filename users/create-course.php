<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

session_start();

$step = 0;
$course = '';
$exercises = '';
$successMessage = '';
$exerciseStatus = '';
$courseMentors = array();
$noExerciseMessage = '';
$errorMessage = '';
$successMessage = '';
$numberOfExercises = '';
$currentFilter = '';

if(!isset($_SESSION['session_id']) && !isset($_SESSION['access_token'])) {
	header('Location: ' . $GLOBALS['path'] . 'login');
	exit();
}

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

if(isset($_GET['course_id'])) {
	$sql = 'SELECT count(*) FROM exercises WHERE course_id = :course_id AND status = 1';
	$valuesToBind = array('course_id' => $_GET['course_id']);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$numberOfExercises = $result[0][0];
}

if(count($coursesWithExercises) == 0) {
		$coursesWithExercises = NULL;
		$noExerciseMessage = 'No exercises to display';
}

try {
	$page = '';
	if((($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['course_id'])) || isset($_SESSION['course_id'])) {
		$page = 'edit';
		$currentFilter = $_SESSION['label'];
		$id = isset($_GET['course_id']) ? $_GET['course_id'] : $_SESSION['course_id'];
		unset($_SESSION['course_id']);
		$sql = 'SELECT * FROM `courses` WHERE id = :id';
		$valuesToBind = array('id' => $id);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(isset($result[0])) {
			$course = $result[0];
			$sql = 'SELECT `users`.id
					FROM `users`
					INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
					INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
					WHERE `courses`.`id` = :courseID';
			$valuesToBind = array('courseID' => $course['id']);
			$courseMentors = ConnectToDB::interogateDB($sql, $valuesToBind);
		}
		$exerciseStatus = '';
		$sql = 'SELECT * FROM `exercises` WHERE course_id = :id AND status = 1';
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

	$template = loadTemplate('../templates','create-course.tmpl');

	if(isset($_SESSION['google_id'])) {
		$sql = 'SELECT id,first_name,last_name,email
				FROM users
				WHERE status = 1 AND user_role = 2';
		$mentor = ConnectToDB::interogateDB($sql);
		$sql = 'SELECT * FROM `users` WHERE google_id = :google_id';
		$valuesToBind = array('google_id' => $_SESSION['google_id']);
		$userGoogle = ConnectToDB::interogateDB($sql, $valuesToBind);
		$firstName = $userGoogle[0]['first_name'];
		$profileImage = $userGoogle[0]['profile_image'];
		$role = $userGoogle[0]['user_role'];
		$googleId = $userGoogle[0]['google_id'];
		echo $template->render(array('mentor' => $mentor, 'google_id' => $googleId, 'noExerciseMessage' => $noExerciseMessage, 'first_name' => $firstName, 'profile_image' => $profileImage, 'user_role' => $role, 'course' => $course, 'courseMentors' => $courseMentors, 'page' => $page, 'errorMessage' => $errorMessage, 'successMessage' => $successMessage, 'step' => $step, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'exercises' => $exercises, 'exerciseStatus' => $exerciseStatus, 'currentPage' => $currentPage, 'numberOfExercises' => $numberOfExercises, 'currentFilter' => $currentFilter));
	} else {
		$user = new User($_SESSION);
		$sql = 'SELECT id,first_name,last_name,email
				FROM users
				WHERE status = 1 AND user_role = 2';
		$mentor = ConnectToDB::interogateDB($sql);
		echo $template->render(array('noExerciseMessage' => $noExerciseMessage, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'mentor' => $mentor, 'course' => $course, 'courseMentors' => $courseMentors, 'page' => $page, 'errorMessage' => $errorMessage, 'successMessage' => $successMessage, 'step' => $step, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'exercises' => $exercises, 'exerciseStatus' => $exerciseStatus, 'currentPage' => $currentPage, 'numberOfExercises' => $numberOfExercises, 'currentFilter' => $currentFilter));
	}
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>