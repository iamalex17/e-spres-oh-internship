<?php
$exercisesMessage = '';
$successMessage = '';
$errorMessage = '';
$solutionStatus = '';
$feedback = '';
$course_id = $_GET['course_id'];
$currentFilter = '';
$feedbackMentor = '';

if(isset($_SESSION['label'])) {
	$currentFilter = $_SESSION['label'];
}

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

$sql = 'SELECT * FROM `courses` WHERE id = :id';
$valuesToBind = array('id'=>$course_id);
$result = ConnectToDB::interogateDB($sql, $valuesToBind);
$course = $result[0];
$course['label'] = explode(', ', $course['label']);

$sql = 'SELECT * FROM `exercises` WHERE course_id = :courseID AND status = 1';
$valuesToBind = array('courseID' => $course['id']);
$exercises = ConnectToDB::interogateDB($sql, $valuesToBind);

if(count($exercises)) {
	foreach($exercises as &$exercise) {
		$exercise['description'] = html_entity_decode($exercise['description']);
		$sql = 'SELECT * FROM `submitted_exercises` WHERE exercise_id = :exerciseID AND user_id = :userID';
		$valuesToBind = array('exerciseID' => $exercise['id'], 'userID' => $_SESSION['id']);
		$solution = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(count($solution)) {
			$solution[0]['description'] = html_entity_decode($solution[0]['description']);
			$exercise['solution'] = $solution[0];
			$mentorID = $exercise['solution']['mentor_id'];
			$sql = 'SELECT first_name, last_name FROM `users` WHERE id = :id';
			$valuesToBind = array('id' => $mentorID);
			$result = ConnectToDB::interogateDB($sql, $valuesToBind);
			if(count($result)) {
				$feedbackMentor = $result[0];
			}
		} else {
			$solution = '';
		}
	}
	$course['exercises'] = $exercises;
} else {
	$exercisesMessage = 'No exercise at the moment.';
}

$sql = 'SELECT `users`.first_name, `users`.last_name
		FROM `users`
		INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
		INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
		WHERE `courses`.`id` = :courseID';
$valuesToBind = array('courseID' => $course['id']);
$courseMentors = ConnectToDB::interogateDB($sql, $valuesToBind);

foreach($courseMentors as $key => &$mentor) {
			unset($mentor[0]);
			unset($mentor[1]);
			$mentor = implode(' ', $mentor);
		}
$courseMentors = implode(', ', $courseMentors);

$template = loadTemplate('../templates','details-course.tmpl');

if(isset($_SESSION['google_id'])) {
	$sql = 'SELECT * FROM `users` WHERE google_id = :google_id';
	$valuesToBind = array('google_id' => $_SESSION['google_id']);
	$userGoogle = ConnectToDB::interogateDB($sql, $valuesToBind);
	$firstName = $userGoogle[0]['first_name'];
	$profileImage = $userGoogle[0]['profile_image'];
	$role = $userGoogle[0]['user_role'];
	$googleId = $userGoogle[0]['google_id'];
	echo $template->render(array('google_id' => $googleId, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'exercisesMessage'=> $exercisesMessage, 'user_role' => $role, 'first_name' => $firstName, 'profile_image' => $profileImage, 'course' => $course, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises,  'currentPage' => $currentPage, 'courseMentors' => $courseMentors, 'currentFilter' => $currentFilter, 'feedbackMentor' => $feedbackMentor));
} else {
	echo $template->render(array('successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'exercisesMessage'=> $exercisesMessage, 'user_role' => $_SESSION['user_role'], 'first_name' => $_SESSION['first_name'], 'profile_image' => $_SESSION['profile_image'], 'course' => $course, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises,  'currentPage' => $currentPage, 'courseMentors' => $courseMentors, 'currentFilter' => $currentFilter, 'feedbackMentor' => $feedbackMentor));
}
?>