<?php


	$course_id = $_GET['course_id'];

	$sql = 'SELECT * FROM `courses` WHERE id = :id';
	$valuesToBind = array('id'=>$course_id);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	$course = $result[0];
	$template = loadTemplate('../templates','details-course.tmpl');
	echo $template->render(array('user_role' => $_SESSION['user_role'], 'last_name' => $_SESSION['last_name'], 'profile_image' => $_SESSION['profile_image'], 'course' => $course));
?>