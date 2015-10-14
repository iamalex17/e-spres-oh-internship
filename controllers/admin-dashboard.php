<?php
$internMessage = '';
$mentorMessage = '';

if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

$sql = 'SELECT * FROM `users` WHERE user_role = 2';
$mentor = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `users` WHERE user_role = 2';
$result = ConnectToDB::interogateDB($sql);

if(count($result) == 0) {
	if(count($result) == count($mentor)) {
		$mentor = NULL;
		$mentorMessage .= 'No mentor to display yet.';
	}
}

$sql = 'SELECT * FROM `users` WHERE user_role = 3';
$intern = ConnectToDB::interogateDB($sql);

$sql = 'SELECT * FROM `users` WHERE user_role = 3';
$result = ConnectToDB::interogateDB($sql);

if(count($result) == 0) {
	if(count($result) == count($intern)) {
		$intern = NULL;
		$internMessage .= 'No intern to display yet.';
	}
}

$sql = 'SELECT * FROM `google_users` WHERE status = 0 AND user_role IS NULL';
$pendingUsers = ConnectToDB::interogateDB($sql);
$requests = count($pendingUsers);

echo $template->render(array('user_role' => $user->user_role, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'path' => $path, 'currentPage' => $currentPage, 'requests' => $requests));
?>