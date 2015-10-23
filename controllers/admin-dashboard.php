<?php
$internMessage = '';
$mentorMessage = '';

if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

$sql = 'SELECT id,first_name,last_name,email
        FROM users
        WHERE status = 1 AND user_role = 2';

$mentor = ConnectToDB::interogateDB($sql);

if(count($mentor) == 0) {
	$mentor = NULL;
	$mentorMessage .= 'No mentor to display yet.';
}

$sql = 'SELECT id,first_name,last_name,email
        FROM users
        WHERE status = 1 AND user_role = 3';

$intern = ConnectToDB::interogateDB($sql);

if(count($intern) == 0) {
	$intern = NULL;
	$internMessage .= 'No intern to display yet.';
}


$sql = 'SELECT * FROM `users` WHERE status = 0 AND user_role = 4';
$pendingUsers = ConnectToDB::interogateDB($sql);
$requests = count($pendingUsers);

echo $template->render(array('user_role' => $user->user_role, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'path' => $path, 'currentPage' => $currentPage, 'requests' => $requests));
?>