<?php
$internMessage = '';
$mentorMessage = '';

if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

$sql = 'SELECT * FROM `users` WHERE user_role = 2 AND status = 1';
$mentor = ConnectToDB::interogateDB($sql);
$sql = 'SELECT * FROM google_users WHERE google_email NOT IN (SELECT email FROM users) AND user_role = 2';
$googleMentor = ConnectToDB::interogateDB($sql);

if(count($mentor) == 0) {
	$mentor = NULL;
	$mentorMessage .= 'No mentor to display yet.';
}

$sql = 'SELECT * FROM `users` WHERE user_role = 3 AND status = 1';
$intern = ConnectToDB::interogateDB($sql);

if(count($intern) == 0) {
	$intern = NULL;
	$internMessage .= 'No intern to display yet.';
}


$sql = 'SELECT * FROM `google_users` WHERE status = 0 AND user_role = 0';
$pendingUsers = ConnectToDB::interogateDB($sql);
$requests = count($pendingUsers);

echo $template->render(array('user_role' => $user->user_role, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor,'googleMentor' => $googleMentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'path' => $path, 'currentPage' => $currentPage, 'requests' => $requests));
?>