<?php
require_once '../config.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	$errorMessage = '';
	$status = 1;
	if((!isset($_POST['first_name'])) || (trim($_POST['first_name']) == '')) {
		$errorMessage = "Please insert first name.\n";
		$status = 0;
	}

	if((!isset($_POST['last_name'])) || (trim($_POST['last_name']) == '')) {
		$status = 0;
	}

	if($status) {
		if(isset($_SESSION['google_id'])) {
			$lastName = trim($_POST['last_name']);
			$firstName = trim($_POST['first_name']);
			$sql = 'UPDATE `users` SET first_name = :first_name, last_name = :last_name WHERE google_id = :google_id';
			$valuesToBind = array('last_name' => $lastName, 'first_name' => $firstName, 'google_id' => $_SESSION['google_id']);
			ConnectToDB::interogateDB($sql, $valuesToBind);
			if($_FILES['profile_image']['name'] != '') {
				$sql = 'SELECT profile_image FROM `users` WHERE google_id = :google_id';
				$valuesToBind = array('google_id' => $_SESSION['google_id']);
				$result = ConnectToDB::interogateDB($sql, $valuesToBind);
				$imagePath = "../images/user-profile-images/".$result[0]['profile_image'];
				unlink($imagePath);
				$fileName = $_FILES["profile_image"]["name"];
				$fileTmp = $_FILES["profile_image"]["tmp_name"];
				$ext = pathinfo($fileName,PATHINFO_EXTENSION);
				$fileEncrypted = MD5($fileName) . '.' . $ext;
				if(!file_exists("../images/user-profile-images/".$fileName)) {
				move_uploaded_file($fileTmp=$_FILES["profile_image"]["tmp_name"],"../images/user-profile-images/".$fileEncrypted);
				} else {
					$fileName = basename($fileName,$ext);
					$newFileName = MD5($fileName.time()).".".$ext;
					move_uploaded_file($fileTmp=$_FILES["profile_image"]["tmp_name"],"../images/user-profile-images/".$newFileName);
				}
				$sql = 'UPDATE `users` SET profile_image = :profile_image WHERE google_id = :google_id';
				$valuesToBind = array('profile_image' => $fileEncrypted, 'google_id' => $_SESSION['google_id']);
				ConnectToDB::interogateDB($sql, $valuesToBind);
			}
			$successMessage = 'Your data has been successfully modified.';
			$_SESSION['successMessage'] = $successMessage;
			header('Location: ' . $GLOBALS['path'] . 'dashboard');
			exit();
		} else {
			$user = new User($_SESSION);
			$user->last_name = trim($_POST['last_name']);
			$user->first_name = trim($_POST['first_name']);
			$sql = 'UPDATE `users` SET first_name = :first_name, last_name = :last_name WHERE id = :id';
			$valuesToBind = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'id' => $user->id);
			ConnectToDB::interogateDB($sql, $valuesToBind);
			$successMessage = 'Your data has been successfully modified.';
			if($_FILES['profile_image']['name'] != '') {
				$errorMessage .= $user->addProfileImage();
			}
			$_SESSION = (array)$user;
			$_SESSION['successMessage'] = $successMessage;
			header('Location: ' . $GLOBALS['path'] . 'dashboard');
			exit();
		}
	} else {
		$errorMessage = "Please insert first name and/or last name.\n";
		$_SESSION['errorMessage'] = $errorMessage;
		header('Location: ' . $GLOBALS['path'] . 'users/edit-profile');
		exit();
	}
}
?>