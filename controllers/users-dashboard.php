<?php
	$courseMessage = '';

	$sql = 'SELECT * FROM `courses`';
	$allCourses = ConnectToDB::interogateDB($sql);

	$sql = 'SELECT * FROM `courses` WHERE status = 1';
	$courses = ConnectToDB::interogateDB($sql);

	$sql = 'SELECT * FROM `courses` WHERE status = 0';
	$deletedCourses = ConnectToDB::interogateDB($sql);

	$sql = 'SELECT `c`.`title`, `c`.`id`, `c`.`status` FROM `courses` `c` WHERE (SELECT count(*) FROM exercises WHERE course_id = `c`.`id` AND `exercises`.`status` = 1) > 0 AND status = 1';
	$coursesWithExercises = ConnectToDB::interogateDB($sql);

	$noExerciseMessage = '';
	$course = '';

	if(isset($_SESSION['course'])) {
		$course = $_SESSION['course'];
		$course['description'] = $_SESSION['course']['textareas'];
		unset($_SESSION['course']);
	}

	if(isset($_SESSION['title'])) {
		unset($_SESSION['title']);
	}
	
	if (isset($_SESSION['course_id'])) {
		unset($_SESSION['course_id']);
	}

	$label = '';
	if(isset($_GET['show'])) {
		$label = $_GET['show'];
		$sql = 'SELECT DISTINCT `courses`.* FROM `courses` INNER JOIN `presentors` ON `courses`.id = `presentors`.course_id WHERE status = 1 AND `label` LIKE :show';
		$valuesToBind = array('show' => '%'.$label.'%');
		$courses = ConnectToDB::interogateDB($sql, $valuesToBind);
	} else {
		$sql = 'SELECT DISTINCT `courses`.* FROM `courses` INNER JOIN `presentors` ON `courses`.id = `presentors`.course_id WHERE status = 1';
		$courses = ConnectToDB::interogateDB($sql);
	}

	if (count($courses)) {
		foreach ($courses as &$course) {
			$course['label'] = explode(', ', $course['label']);
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
	echo $template->render(array('user_role' => $user->user_role, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'courses' => $courses, 'courseMessage' => $courseMessage, 'label' => $label, 'path' => $path, 'coursesWithExercises' => $coursesWithExercises, 'currentPage' => $currentPage, 'noExerciseMessage' => $noExerciseMessage));
?>