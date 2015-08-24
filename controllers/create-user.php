<?php
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		header('Location: ../dashboard.php');
	}

	require_once '../config.php';
	require_once '../class.user.php';
	require_once '../class.connect-to-db.php';
	
	if(!User::verifySessionID()) {
		header('Location: login.php');
		exit();
	}

	$request = User::verifyRequestURL($_SERVER['HTTP_REFERER']);
	if($request == 'create-intern.php') {
		$role = 3;
	} else if($request == 'create-mentor.php') {
		$role = 2;
	} else {
		header('Location: ../dashboard.php');
	}
	$errorMessage = '';
	$status = 1;

	if(!isset($_POST['first_name'])) {
		$_POST['first_name'] = trim($_POST['first_name']);
		$errorMessage .= "First name field should not be empty.\n";
		$status = 0;
	}
	if(!isset($_POST['last_name'])) {
		$_POST['last_name'] = trim($_POST['last_name']);
		$errorMessage .= "Last name filed should not be empty.\n";
		$status = 0;
	}
	if(!isset($_POST['username'])) {
		$_POST['username'] = trim($_POST['username']);
		$errorMessage .= "Username field should not be empty.\n";
		$status = 0;
	}
	if(!isset($_POST['email'])) {
		$_POST['email'] = trim($_POST['email']);
		$errorMessage .= "Email field should not be empty.\n";
		$status = 0;
	}
	if(!isset($_POST['password'])) {
		$_POST['password'] = trim($_POST['password']);
		$errorMessage .= "Password field should not be empty.\n";
		$status = 0;
	}
	if(!isset($_POST['retypePassword'])) {
		$_POST['retypePassword'] = trim($_POST['retypePassword']);
		$errorMessage .= "Retype password field should not be empty.\n";
		$status = 0;
	}

	if($status == 0) {
		$_SESSION['errorMessage'] = $errorMessage;
		$role == 2 ? header('Location: ../create-mentor.php') : header('Location: ../create-intern.php');
		exit();
	}

	$user = new User($_POST);
	if($user->first_name == '') {
		$errorMessage .= "First Name field not completed properly.\n";
		$status = 0;
	}
	if($user->last_name == '') {
		$errorMessage .= "Last Name field not completed properly.\n";
		$status = 0;
	}
	if($user->username == '') {
		$errorMessage .= "Username filed not completed properly.\n";
		$status = 0;
	}
	if(strlen($user->password)< 8) {
		$errorMessage = "Password must have at least 8 characters.\n";
		$status = 0;
	}
	if($user->password != MD5($_POST['retypePassword'])) {
		$errorMessage .= "Passwords do not match. Check again!\n";
		$status = 0;
	}
	if(filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
		$sql = 'SELECT email FROM `users` WHERE email = :email';
		$valuesToBind = array('email' => $user->email);
		$result = ConnectToDB::interogateDB($sql, $valuesToBind);
		if(count($result)){
			$errorMessage .= "Email already exists.\n";
			$status = 0;
		}
	} else {
		$errorMessage .= "Email is not valid.\n";
		$status = 0;
	}

	$uploadOk = 1;

	if($user->profile_image != '21232f297a57a5a743894a0e4a801fc3.png') {
		$target_dir = 'images/user-profile-images';
		$file = $_FILES['profile_image'];
		$fileName = explode('.', $file['name']);
		$fileExtension = $fileName[count($fileName)-1];
		unset($fileName[count($fileName)-1]);
		$fileName = implode('', $fileName);
		$fileName = MD5($fileName);
		$completeFileName = $fileName . '.' . $fileExtension;
		$target_file = $target_dir . $completeFileName;
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES['profile_image']['tmp_name']);
		if($check === false) {
			$errorMessage .= "File is not an image.\n";
			$uploadOk = 0;
		}// Check file size
		if ($_FILES['profile_image']['size'] > 2097152) {
			$errorMessage .= "Sorry, your file is too large.\n";
			$uploadOk = 0;
		}// Allow certain file formats
		if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
			$errorMessage .= "Sorry, only JPG, JPEG, PNG and GIF files are allowed.\n";
			$uploadOk = 0;
		}
	} else {
		$uploadOk = 0;
	}
	if($status == 1) {
		$sql = 'INSERT INTO `internship`.`users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_role`, `profile_image`, `status`, `reset_password`, `deletion_link_time`) VALUES (NULL, :first_name, :last_name, :username, :email, MD5(:password), :role, "21232f297a57a5a743894a0e4a801fc3.png", 1, NULL, NULL)';
		$valuesToBind = array('first_name' => $user->first_name, 'last_name' => $user->last_name, 'username' => $user->username, 'email' => $user->email, 'password' => $user->password, 'role' => $role);
		ConnectToDB::interogateDB($sql, $valuesToBind);
		$_SESSION['successMessage'] = 'Mentor added succesfully.';
		if($uploadOk) {
			$sql = 'SELECT id FROM `users` WHERE username = :username';
			$valuesToBind = array('username' => $user->username);
			$result = ConnectToDB::interogateDB($sql, $valuesToBind);
			if(count($result)) {
				$id = $result[0]['id'];
				$target_file = $id . '_' . $target_file;
				$completeFileName = $id . '_' . $completeFileName;
				if(file_exists($target_file)){
					unlink($target_file);
				}
				if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
					$errorMessage .= "Sorry, there was an error uploading your file.\n";
					//$status = 0;
				}
				$sql = 'UPDATE `users` SET profile_image = :profile_image WHERE id = :userid';
				$valuesToBind = array('profile_image' => $completeFileName);
				ConnectToDB::interogateDB($sql, $valuesToBind);
			}
		} else {
			$_SESSION['errorMessage'] = $errorMessage;
		}
	} else {
		$_SESSION['errorMessage'] = $errorMessage;
		$role == 2 ? header('Location:../create-mentor.php') : header('Location:../create-intern.php');
		exit();
	}
	header('Location: ../dashboard.php');
?>