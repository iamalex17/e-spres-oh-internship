<?php
if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

$internMessage = '';
$mentorMessage = '';
$sql = 'SELECT * FROM `users` WHERE user_role = 2';
$mentor = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `users` WHERE user_role = 2 AND status = 0';
$result = ConnectToDB::interogateDB($sql);

if(count($result) != 0) {
	if(count($result) == count($mentor)) {
		$mentor = NULL;
		$mentorMessage .= 'No mentor to display yet.';
	}
}

$sql = 'SELECT * FROM `users` WHERE user_role = 3';
$intern = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `users` WHERE user_role = 3 AND status = 0';
$result = ConnectToDB::interogateDB($sql);

if(count($result) != 0) {
	if(count($result) == count($intern)) {
		$intern = NULL;
		$internMessage .= 'No intern to display yet.';
	}
}

echo $template->render(array('user_role' => $user->user_role, 'last_name' => $user->last_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage));
?>