<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';
require_once '../vendors/Sendgrid/Autoloader.php';

session_start();

$errorMessage = '';
$successMessage = '';
$status = 1;

if($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ' . $GLOBALS['path'] . 'dashboard');
}

if($status == 1) {
	$sql = 'UPDATE `users` SET status = 1, user_role = 2 WHERE google_id = :google_id';
	$valuesToBind = array('google_id' => $_POST['accept_button']);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	$sql = 'SELECT email FROM `users` WHERE google_id = :google_id';
	$valuesToBind = array('google_id' => $_POST['accept_button']);
	$email = ConnectToDB::interogateDB($sql, $valuesToBind);
	$sendgrid_username = "internship-espresoh";
	$sendgrid_password = "internship-project1";
	$emailContent = "<h3>Hello there (:</h3> <p>Welcome! Looks like your account have been aproved by the admin. Excited? Well I hope so, you can enjoy all the mythy powers you have been granted as a mentor. Use them wisely! (:</p> <p>You can access the application now at http://esohintern.bucatzel.ro/login.</p> <h4>Enjoy and have a nice day!</h4>";
	$to = $email[0]['email'];
	$from = 'lex.greenapple@gmail.com';
	$sendgrid = new SendGrid($sendgrid_username, $sendgrid_password, array("turn_off_ssl_verification" => true));
	$email = new SendGrid\Email();
	$email->addTo($to)->
	setFrom($from)->
	setSubject('Your account has been activated')->
	setText($emailContent)->
	setHtml($emailContent)->
	addHeader('X-Sent-Using', 'SendGrid-API')->
	addHeader('X-Transport', 'web');
	$response = $sendgrid->send($email);
	$successMessage = "Role assigned!";
	$_SESSION['successMessage'] = $successMessage;
	header('Location: ' . $GLOBALS['path'] . 'admin/pending-requests');
	exit();
} else {
	$_SESSION['errorMessage'] = $errorMessage;
	header('Location: ' . $GLOBALS['path'] . 'admin/pending-requests');
	exit();
}
?>