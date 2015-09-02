<?php

	$exercisesMessage = '';
	$course_id = $_GET['course_id'];

	$sql = 'SELECT * FROM `courses` WHERE id = :id';
	$valuesToBind = array('id'=>$course_id);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$course = $result[0];
	$sql = 'SELECT * FROM `exercises` WHERE course_id = :courseID';
	$valuesToBind = array('courseID' => $course['id']);
	$exercises = ConnectToDB::interogateDB($sql, $valuesToBind);
	if(count($exercises)) {
		foreach ($exercises as &$exercise) {
			$exercise['description'] = html_entity_decode($exercise['description']);
		}
		$course['exercises'] = $exercises;
	} else {
		$exercisesMessage = 'No exercise at the moment.';
	}
	$template = loadTemplate('../templates','details-course.tmpl');
	echo $template->render(array('exercisesMessage'=> $exercisesMessage, 'user_role' => $_SESSION['user_role'], 'last_name' => $_SESSION['last_name'], 'profile_image' => $_SESSION['profile_image'], 'course' => $course, 'path' => $path));
?>