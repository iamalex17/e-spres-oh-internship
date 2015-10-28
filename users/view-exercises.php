<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

session_start();

$solutionsMessage = '';
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

$sql = 'SELECT `c`.`title`, `c`.`id`, `c`.`status` FROM `courses` `c` WHERE (SELECT count(*) FROM exercises WHERE course_id = `c`.`id` AND `exercises`.`status` = 1) > 0 AND `c`.status = 1';
$coursesWithExercises = ConnectToDB::interogateDB($sql);

if(isset($_GET['course_id'])) {
	$courseID = $_GET['course_id'];
	$_SESSION['course_id'] = $courseID;
	$sql = 'SELECT * FROM `exercises` `e` WHERE `e`.course_id = :courseID';
	$valuesToBind = array('courseID' => $courseID);
	$exercises = ConnectToDB::interogateDB($sql, $valuesToBind);
	foreach ($exercises as &$exercise) {
		$solutionsMessage = '';
		$exercise['description'] = html_entity_decode($exercise['description']);
		$sql = 'SELECT * FROM `courses` WHERE id = :courseID';
		$valuesToBind = array('courseID' => $exercise['course_id']);
		$course = ConnectToDB::interogateDB($sql, $valuesToBind);
		$course = $course[0];
		$exercise['course'] = $course;
		$sql = 'SELECT * FROM `submitted_exercises` `s` WHERE exercise_id = :exerciseID';
		$valuesToBind = array('exerciseID' => $exercise['id']);
		$solutions = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(count($solutions)) {
			foreach ($solutions as &$solution) {
				$solution['description'] = html_entity_decode($solution['description']);
				$sql = 'SELECT CONCAT_WS(" ", first_name, last_name) FROM `users` WHERE id = :userID';
				$valuesToBind = array('userID' => $solution['user_id']);
				$userName = ConnectToDB::interogateDB($sql, $valuesToBind);
				$solution['userName'] = $userName[0][0];
			}
		} else {
			$solutionsMessage = "No solution at the moment.";
		}
		$exercise['solutions'] = $solutions;
		$exercise['solutionsMessage'] = $solutionsMessage;
	}
	$template = loadTemplate('../templates','submitted-exercises.tmpl');
	if(isset($_SESSION['google_id'])) {
		$sql = 'SELECT * FROM `users` WHERE google_id = :google_id';
		$valuesToBind = array('google_id' => $_SESSION['google_id']);
		$userGoogle = ConnectToDB::interogateDB($sql, $valuesToBind);
		$firstName = $userGoogle[0]['first_name'];
		$profileImage = $userGoogle[0]['profile_image'];
		$role = $userGoogle[0]['user_role'];
		$googleId = $userGoogle[0]['google_id'];
		if(isset($_SESSION['successMessage'])) {
			$successMessage = $_SESSION['successMessage'];
		}
		if(isset($_SESSION['errorMessage'])) {
			$errorMessage = $_SESSION['errorMessage'];
		}
		echo $template->render(array('course' => $course, 'solutionsMessage' => $solutionsMessage, 'exercises' => $exercises, 'path' => $path, 'first_name' => $firstName, 'profile_image' => $profileImage, 'user_role' => $role, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage));
	} else {
		$user = new User($_SESSION);
		if(isset($_SESSION['successMessage'])) {
			$successMessage = $_SESSION['successMessage'];
		}
		if(isset($_SESSION['errorMessage'])) {
			$errorMessage = $_SESSION['errorMessage'];
		}
		echo $template->render(array('course' => $course, 'solutionsMessage' => $solutionsMessage, 'exercises' => $exercises, 'path' => $path, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage));
	}
} else {
	header('Location: ../dashboard.php');
}
?>