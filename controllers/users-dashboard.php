<?php
$courseMessage = '';
$noExerciseMessage = '';
$course = '';
$label = '';

$sql = 'SELECT * FROM `courses`';
$allCourses = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `courses` WHERE status = 1';
$courses = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `courses` WHERE status = 0';
$deletedCourses = ConnectToDB::interogateDB($sql);

$sql = 'SELECT `c`.`title`, `c`.`id`, `c`.`status` FROM `courses` `c` WHERE (SELECT count(*) FROM exercises WHERE course_id = `c`.`id` AND `exercises`.`status` = 1) > 0 AND `c`.status = 1';
$coursesWithExercises = ConnectToDB::interogateDB($sql);

if(isset($_SESSION['course'])) {
	$course = $_SESSION['course'];
	$course['description'] = $_SESSION['course']['textareas'];
	unset($_SESSION['course']);
}

if(isset($_SESSION['title'])) {
	unset($_SESSION['title']);
}

if(isset($_SESSION['course_id'])) {
	unset($_SESSION['course_id']);
}

if(isset($_SESSION['label'])) {
	unset($_SESSION['label']);
}

if(isset($_GET['show'])) {
	$label = $_GET['show'];
	$_SESSION['label'] = $label;
	$sql = 'SELECT DISTINCT `courses`.* FROM `courses` LEFT JOIN `presentors` ON `courses`.id = `presentors`.course_id WHERE status = 1 AND `label` LIKE :show ORDER BY `id` DESC';
	$valuesToBind = array('show' => '%'.$label.'%');
	$courses = ConnectToDB::interogateDB($sql, $valuesToBind);
} else {
	$sql = 'SELECT DISTINCT `courses`.* FROM `courses` LEFT JOIN `presentors` ON `courses`.id = `presentors`.course_id WHERE status = 1 ORDER BY `id` DESC';
	$courses = ConnectToDB::interogateDB($sql);
}

if(count($courses)) {
	foreach($courses as &$course) {
		$course['label'] = explode(', ', $course['label']);
		$courseID = $course['id'];
		$sql = 'SELECT CONCAT_WS(" ", `users`.`last_name`, `users`.`first_name`) AS mentor_name
				FROM `users`
				INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
				INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
				WHERE `courses`.`id` = :courseID';
		$valuesToBind = array('courseID' => $course['id']);
		$mentors = ConnectToDB::interogateDB($sql, $valuesToBind);
		foreach($mentors as $key => &$mentor) {
			unset($mentor[0]);
			unset($mentor[1]);
			$mentor = implode(' ', $mentor);
		}
		$sql = 'SELECT count(*) FROM `exercises` WHERE status = 1 AND course_id = :course_id';
		$valuesToBind = array('course_id' => $courseID);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		$exercises = $result[0][0];
		$mentors = implode(', ', $mentors);
		$course['mentors'] = $mentors;
		$course['numberOfExercises'] = $exercises;
		html_entity_decode($course['description']);
	}
	if(count($deletedCourses != 0)) {
		if(count($allCourses) == count($deletedCourses)) {
			$courses = NULL;
			$courseMessage = 'No courses to display yet.';
		}
	}

	if(count($coursesWithExercises) == 0) {
			$coursesWithExercises = NULL;
			$noExerciseMessage = 'No exercises to display';
	}

} else {
	$courses = NULL;
	$courseMessage = 'No courses to display yet.';
}


if($user == NULL) {
	echo $template->render(array('google_id' => $googleId, 'user_role' => $role, 'first_name' => $firstName, 'profile_image' => $profileImage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'courses' => $courses, 'courseMessage' => $courseMessage, 'label' => $label, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'noExerciseMessage' => $noExerciseMessage));
} else {
	echo $template->render(array('user_role' => $user->user_role, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'courses' => $courses, 'courseMessage' => $courseMessage, 'label' => $label, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'noExerciseMessage' => $noExerciseMessage));
}
?>