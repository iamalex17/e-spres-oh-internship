<?php
	require_once '../config.php';
	require_once '../classes/class.user.php';
	require_once '../classes/class.connect-to-db.php';

session_start();

	$errorMessage = '';
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
		if($request != 'recover-password.php') {
			exit();
		}
		if(isset($_POST['email'])) {
			$email = trim($_POST['email']);
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$sql = 'SELECT * FROM `users` WHERE email = :email';
				$valuesToBind = array('email' => $email);
				$result = ConnectToDB::interogateDB($sql, $valuesToBind);
				if(count($result)) {
					$link = generateRandomString($email);
					$successMessage = 'An e-mail with recover details was sent to ' .$email ;
					$_SESSION['successMessage'] = $successMessage;
					header('Location: ' . $GLOBALS['path'] . 'login.php');
					exit();
				} else {
					$successMessage = 'An e-mail with recover details was sent to ' .$email ;
					$_SESSION['successMessage'] = $successMessage;
					header('Location: ' . $GLOBALS['path'] . 'login.php');
					exit();
				}
			} else {
				$errorMessage = 'E-mail address is not valid.';
				$_SESSION['errorMessage'] = $errorMessage;
				header('Location: ' . $GLOBALS['path'] . 'users/recover-password.php');
				exit();
			}
		} else {
			$errorMessage = 'E-mail address is not valid.';
			$_SESSION['errorMessage'] = $errorMessage;
			header('Location: ' . $GLOBALS['path'] . 'users/recover-password.php');
			exit();
		}
	}

function generateRandomString($email) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < 64; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	if(link_exists($randomString)){
		generateRandomString($email);
	}else{
		insert_link($randomString, $email);
	}
}

function link_exists($string){
	$sql = 'SELECT reset_password FROM `users` WHERE reset_password = :string';
	$valuesToBind = array('string' => $string);
	$result = ConnectToDB::interogateDB($sql, $valuesToBind);
	if(count($result)){
		return true;
	}else{
		return false;
	}
}

function insert_link($string, $email){
	$sql = 'UPDATE `users` SET reset_password = :string, deletion_link_time = NOW() WHERE email = :email';
	$valuesToBind = array('string' => $string, 'email' => $email);
	ConnectToDB::interogateDB($sql, $valuesToBind);
	send_link($string, $email);
}

function send_link($string, $email){
	require '../vendors/Sendgrid/Autoloader.php';
	$sendgrid_username = "internship-espresoh";
	$sendgrid_password = "internship-project1";
	$url = get_current_url();
	$string = $url . '/users/reset-password.php?link=' . $string;
	$emailContent = "To recover your sign in creditentials acces the following link: <a href=\"" . $string . "\">" . $string. "</a>";
	$to = $email;
	$from = 'andrei.g.csiki@gmail.com';
	$sendgrid = new SendGrid($sendgrid_username, $sendgrid_password, array("turn_off_ssl_verification" => true));
	$email = new SendGrid\Email();
	$email->addTo($to)->
	setFrom($from)->
//		setFrom('noreply-e-spres-oh@google.com')->
	setSubject('[Recover password] e-spres-oh')->
	setText($emailContent)->
	setHtml($emailContent)->
	addHeader('X-Sent-Using', 'SendGrid-API')->
	addHeader('X-Transport', 'web');
	$response = $sendgrid->send($email);
}

function get_current_url($strip = true) {
	// filter function
	static $filter;
	if ($filter == null) {
		$filter = function($input) use($strip) {
			$input = str_ireplace(array(
				"\0", '%00', "\x0a", '%0a', "\x1a", '%1a'), '', urldecode($input));
			if ($strip) {
				$input = strip_tags($input);
			}
			// or whatever encoding you use instead of utf-8
			$input = htmlentities($input, ENT_QUOTES, 'utf-8'); 
			return trim($input);
		};
	}
	return 'http'. (($_SERVER['SERVER_PORT'] == '443') ? 's' : '').'://'. $_SERVER['SERVER_NAME'] . '/e-spres-oh-internship';
}

?>