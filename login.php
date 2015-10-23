<?php
require_once 'config.php';
require_once 'controllers/load-template.php';
require_once 'classes/class.connect-to-db.php';
require_once 'vendors/Google/autoload.php';

ini_set("allow_url_fopen", true);
session_start();
//session_unset();

$errorMessage = '';
$successMessage = '';

$client_id = '349074393075-ht8af6613q4bfmc185i3pngl08davutl.apps.googleusercontent.com';
$client_secret = 'NPkhzmka3ZEfTYcJtkCgvOts';
$redirect_uri = 'http://localhost/e-spres-oh-internship/login.php';

$db_username = "root";
$db_password = "root";
$host_name = "localhost";
$db_name = "internship";

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

if(isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
//	$tokens_decoded = json_decode($access_token);
//	$refreshToken = $tokens_decoded->refresh_token;
//	var_dump($refreshR)
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	exit();
}

//if($client->isAccessTokenExpired()) {
//	echo 'Access Token Expired'; // Debug
//	$client->refreshToken($_SESSION['access_token']);
//}

if(isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	$client->setAccessToken($_SESSION['access_token']);
} else {
	$authUrl = $client->createAuthUrl();
}

if(isset($authUrl)) {
	$login = $authUrl;
} else {
	$userGoogle = $service->userinfo->get();
	$_SESSION['google_id'] = $userGoogle->id;
	$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
	if($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	$result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM users WHERE google_id=$userGoogle->id AND status = 1");
	$user_count = $result->fetch_object()->usercount;
	$result = $mysqli->query("SELECT COUNT(google_id) as notapproved FROM users WHERE google_id=$userGoogle->id AND status = 0");
	$not_approved = $result->fetch_object()->notapproved;
	if($user_count) {
//		redirect
		header('Location: ' . $GLOBALS['path'] . 'dashboard.php');
		exit();
	} elseif($not_approved) {
		session_destroy();
		session_unset();
		session_start();
		$GLOBALS['errorMessage'] .= "Your account was not approved yet!";
		$_SESSION['errorMessage'] = $GLOBALS['errorMessage'];
		header('Location: ' . $GLOBALS['path'] . 'login.php');
		exit();
	} else {
		$sql = 'SELECT email FROM `users` WHERE email = :email';
		$valuesToBind = array('email' => $userGoogle->email);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(count($result)) {
			session_destroy();
			session_unset();
			session_start();
			$GLOBALS['errorMessage'] = "You already have an account with this email. Contact the admin for details, thank you!\n";
			$_SESSION['errorMessage'] = $GLOBALS['errorMessage'];
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			exit();
		} else {
			$image = MD5($userGoogle->givenName) . '.jpg';
			$sql = 'INSERT INTO `users` (`google_id`, `first_name`, `last_name`, `email`, `user_role`, `profile_image`, `google_picture_link`, `status`, `google_link`) VALUES (:google_id, :first_name, :last_name, :email, 4, :profile_image, :google_picture_link, 0, :google_link)';
			$valuesToBind = array('google_id' => $userGoogle->id, 'first_name' => $userGoogle->givenName, 'last_name' => $userGoogle->familyName, 'email' => $userGoogle->email, 'profile_image' => $image, 'google_picture_link' => $userGoogle->picture, 'google_link' => $userGoogle->link);
			$result = ConnectToDB::interogateDB($sql, $valuesToBind);
			$content = file_get_contents($userGoogle->picture);
			$fp = fopen("images/user-profile-images/" . MD5($userGoogle->givenName) . ".jpg", "w");
			fwrite($fp, $content);
			fclose($fp);
			session_destroy();
			session_unset();
			session_start();
			$GLOBALS['successMessage'] = "Thank you. Your account will be soon aproved by the admin!";
			$_SESSION['successMessage'] = $GLOBALS['successMessage'];
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			exit();
		}
	}
}

if(isset($_SESSION['errorMessage'])) {
	$errorMessage = $_SESSION['errorMessage'];
	unset($_SESSION['errorMessage']);
}

if(isset($_SESSION['successMessage'])) {
	$successMessage = $_SESSION['successMessage'];
	unset($_SESSION['successMessage']);
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

try {
	$template = loadTemplate('templates','login.tmpl');
	echo $template->render(array('username' => $username, 'errorMessage' => $errorMessage, 'successMessage' => $successMessage, 'login' => $login));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>