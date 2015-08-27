<?php
	$coureseMessage = '';
	$sql = 'SELECT * FROM `courses`';
	$courses = ConnectToDB::interogateDB($sql);
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
	echo $template->render(array('user_role' => $user->user_role, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'courses' => $courses));
?>