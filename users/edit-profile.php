<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if(!User::verifySessionID()) {
	header('Location: ' . $GLOBALS['path'] . 'login.php');
	exit();
}

$errorMessage = '';

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

$sql = 'SELECT `c`.`title`, `c`.`id` FROM `courses` `c` WHERE (SELECT count(*) FROM exercises WHERE course_id = `c`.`id`) > 0';
$coursesWithExercises = ConnectToDB::interogateDB($sql);

try {
	$user = new User($_SESSION);
	$template = loadTemplate('../templates','edit-profile.tmpl');
	echo $template->render(array('last_name' => $user->last_name, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'user_role' => $user->user_role, 'errorMessage' => $errorMessage, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises));
} catch (Exception $e) {
	die('ERROR: ' . $e->getMessage());
}
?>