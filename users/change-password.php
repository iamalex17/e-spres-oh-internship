<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

$errorMessage = '';
$noExerciseMessage = '';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login');
	exit();
}

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

try {
	$user = new User($_SESSION);
	$template = loadTemplate('../templates','change-password.tmpl');
	echo $template->render(array('first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'errorMessage' => $errorMessage, 'user_role' => $user->user_role, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'noExerciseMessage' => $noExerciseMessage));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>