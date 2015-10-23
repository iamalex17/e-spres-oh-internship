<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

session_start();

$errorMessage = '';
$noExerciseMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

$sql = 'SELECT `c`.`title`, `c`.`id`, `c`.`status` FROM `courses` `c` WHERE (SELECT count(*) FROM exercises WHERE course_id = `c`.`id` AND `exercises`.`status` = 1) > 0 AND `c`.status = 1';
$coursesWithExercises = ConnectToDB::interogateDB($sql);

if(count($coursesWithExercises) == 0) {
	$coursesWithExercises = NULL;
	$noExerciseMessage = 'No exercises to display';
}

if(isset($_SESSION['google_id'])) {
	$sql = 'SELECT * FROM `users` WHERE google_id = :google_id';
	$valuesToBind = array('google_id' => $_SESSION['google_id']);
	$userGoogle = ConnectToDB::interogateDB($sql, $valuesToBind);
	$lastName = $userGoogle[0]['last_name'];
	$firstName = $userGoogle[0]['first_name'];
	$profileImage = $userGoogle[0]['profile_image'];
	$role = $userGoogle[0]['user_role'];
	$googleId = $userGoogle[0]['google_id'];
}

if(isset($_SESSION['google_id'])) {
	$template = loadTemplate('../templates','edit-profile.tmpl');
	echo $template->render(array('google_id' => $googleId, 'last_name' => $lastName, 'first_name' => $firstName, 'profile_image' => $profileImage, 'user_role' => $role, 'errorMessage' => $errorMessage, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'noExerciseMessage' => $noExerciseMessage));
} else {
	$user = new User($_SESSION);
	$template = loadTemplate('../templates','edit-profile.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'errorMessage' => $errorMessage, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'noExerciseMessage' => $noExerciseMessage));
}
?>