<?php
	$courseMessage = '';
	$sql = 'SELECT * FROM `courses` WHERE status = 1';
	$courses = ConnectToDB::interogateDB($sql);

	$sql = 'SELECT * FROM `courses` WHERE status = 0';
	$deletedCourses = ConnectToDB::interogateDB($sql);

	$label = '';
	if(isset($_GET['show'])) {
		$label = $_GET['show'];
		$sql = 'SELECT * FROM `courses` WHERE status = 1 AND label = :show';
		$valuesToBind = array('show' => $label);
		$courses = ConnectToDB::interogateDB($sql, $valuesToBind);
	} else {
		$sql = 'SELECT * FROM `courses` WHERE status = 1';
		$courses = ConnectToDB::interogateDB($sql);
	}

	/*echo '<pre>';
	var_dump($courses);*/
	if (count($courses)) {
		foreach ($courses as &$course) {
			$sql = 'SELECT CONCAT_WS(" ", `users`.`last_name`, `users`.`first_name`) AS mentor_name
					FROM `users`
					INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
					INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
					WHERE `courses`.`id` = :courseID';
			$valuesToBind = array('courseID' => $course['id']);
			$mentors = ConnectToDB::interogateDB($sql, $valuesToBind);
			$course['mentors'] = $mentors;
			html_entity_decode($course['description']);
		}
	}

	if(count($deletedCourses != 0)) {
		if(count($courses) == count($deletedCourses)) {
			$courses = NULL;
			$courseMessage = 'No courses to display yet.';
		}
	}
	echo $template->render(array('user_role' => $user->user_role, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'courses' => $courses, 'courseMessage' => $courseMessage));
?>