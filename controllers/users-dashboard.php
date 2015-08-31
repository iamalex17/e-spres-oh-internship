<?php
	$courseMessage = '';

	$sql = 'SELECT * FROM `courses`';
	$allCourses = ConnectToDB::interogateDB($sql);

	$sql = 'SELECT * FROM `courses` WHERE status = 1';
	$courses = ConnectToDB::interogateDB($sql);

	$sql = 'SELECT * FROM `courses` WHERE status = 0';
	$deletedCourses = ConnectToDB::interogateDB($sql);

	$course = '';

	if(isset($_SESSION['course'])) {
		$course = $_SESSION['course'];
		$course['description'] = $_SESSION['course']['textareas'];
		unset($_SESSION['course']);
	}

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

	if (count($courses)) {
		foreach ($courses as &$course) {
			$sql = 'SELECT CONCAT_WS(" ", `users`.`last_name`, `users`.`first_name`) AS mentor_name
					FROM `users`
					INNER JOIN `presentors` ON `presentors`.`presentor_id` = `users`.`id`
					INNER JOIN `courses` ON `courses`.`id` = `presentors`.`course_id`
					WHERE `courses`.`id` = :courseID';
			$valuesToBind = array('courseID' => $course['id']);
			$mentors = ConnectToDB::interogateDB($sql, $valuesToBind);
			foreach ($mentors as $key => &$mentor) {
				unset($mentor[0]);
				unset($mentor[1]);
				$mentor = implode(' ', $mentor);
			}
			$mentors = implode(', ', $mentors);
			$course['mentors'] = $mentors;
			html_entity_decode($course['description']);
		}
	}

	if(count($deletedCourses != 0)) {
		if(count($allCourses) == count($deletedCourses)) {
			$courses = NULL;
			$courseMessage = 'No courses to display yet.';
		}
	}
	echo $template->render(array('user_role' => $user->user_role, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'courses' => $courses, 'courseMessage' => $courseMessage, 'label' => $label));
?>