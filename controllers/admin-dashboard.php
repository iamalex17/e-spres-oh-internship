<?php
$internMessage = '';
$mentorMessage = '';

if(isset($_SESSION['userToAdd'])) {
	unset($_SESSION['userToAdd']);
}

$sql = 'SELECT id,first_name,last_name,email
        FROM users
        WHERE email NOT IN(SELECT google_email FROM google_users) AND status = 1 AND user_role = 2
        UNION
        SELECT google_id AS id,google_first_name as first_name,google_last_name AS last_name,google_email AS email
        FROM google_users
        WHERE status = 1 AND user_role = 2';

$mentor = ConnectToDB::interogateDB($sql);

if(count($mentor) == 0) {
	$mentor = NULL;
	$mentorMessage .= 'No mentor to display yet.';
}

$sql = 'SELECT id,first_name,last_name,email
        FROM users
        WHERE email NOT IN(SELECT google_email FROM google_users) AND status = 1 AND user_role = 3
        UNION
        SELECT google_id AS id,google_first_name as first_name,google_last_name AS last_name,google_email AS email
        FROM google_users
        WHERE status = 1 AND user_role = 3';

$intern = ConnectToDB::interogateDB($sql);

if(count($intern) == 0) {
	$intern = NULL;
	$internMessage .= 'No intern to display yet.';
}


$sql = 'SELECT * FROM `google_users` WHERE status = 0 AND user_role = 0';
$pendingUsers = ConnectToDB::interogateDB($sql);
$requests = count($pendingUsers);

echo $template->render(array('user_role' => $user->user_role, 'first_name' => $user->first_name, 'profile_image' => $user->profile_image, 'mentor' => $mentor, 'intern' => $intern, 'mentorMessage' => $mentorMessage, 'internMessage' => $internMessage, 'successMessage' => $successMessage, 'errorMessage' => $errorMessage, 'path' => $path, 'currentPage' => $currentPage, 'requests' => $requests));
?>