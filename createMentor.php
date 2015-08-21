<?php
require 'config.php';
require 'functions/load_template.php';
$errorMessage = '';
$successMessage = '';
if(!verifySessionID()){
	header('Location: login.php');
	exit();
}
try {
	$status = 1;
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['username']) && isset($_POST['emailAdress']) && isset($_POST['password']) && isset($_POST['retypePassword'])) {
			$firstName = trim($_POST['firstName']);
			$lastName = trim($_POST['lastName']);
			$username = trim($_POST['username']);
			$email = trim($_POST['emailAdress']);
			$password = trim($_POST['password']);
			$retypePassword = trim($_POST['retypePassword']);
			if($firstName == '') {
				$errorMessage .= 'First Name field not completed properly'.PHP_EOL;
				$status = 0;
			}
			if($lastName == '') {
				$errorMessage .= 'Last Name field not completed properly'.PHP_EOL;
				$status = 0;
			}
			if(strlen($password) < 8) {
				$errorMessage = 'Password must have at least 8 characters length';
				$status = 0;
			}
			if($username == '') {
				$errorMessage .= 'Username filed not completed properly'.PHP_EOL;
				$status = 0;
			}
			if($password != $retypePassword) {
				$errorMessage .= 'Passwords do not match. Check again!'.PHP_EOL;
				$status = 0;
				}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errorMessage .= 'Email is not valid'.PHP_EOL;
				$status = 0;
			}else{
				$sth = $dbh->prepare('SELECT email FROM `users` WHERE email = :email');
				$sth->bindValue(':email', $email);
				$sth->execute();
				if(count($sth->fetchAll())){
					$errorMessage .= 'Email already exists.'.PHP_EOL;
					$status = 0;
				}
			}
			$target_dir = "images/user_profile_images/";
			$file = $_FILES['fileToUpload'];
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
			$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$errorMessage .= 'File is not an image.';
				$uploadOk = 0;
			}// Check file size
			if ($_FILES['fileToUpload']['size'] > 2097152) {
				$errorMessage .= 'Sorry, your file is too large.';
				$uploadOk = 0;
			}// Allow certain file formats
			if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
				$errorMessage .= 'Sorry, only JPG, JPEG, PNG and GIF files are allowed.';
				$uploadOk = 0;
			}// Check if $uploadOk is set to 0 by an error
			if($status == 1) {
				$sth = $dbh->prepare('INSERT INTO `internship`.`users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `user_privilege`, `profile_image`, `status`, `reset_password`, `deletion_link_time`) VALUES (NULL, :firstName, :lastName, :username, :email, MD5(:password), 2, NULL, 1, NULL, NULL)');
				$sth->bindValue(':firstName', $firstName);
				$sth->bindValue(':lastName', $lastName);
				$sth->bindValue(':username', $username);
				$sth->bindValue(':email', $email);
				$sth->bindValue(':password', $password);
				$sth->execute();
				$result = $sth->fetchAll();
				$successMessage = 'Mentor added succesfully.';
				$sth = $dbh->prepare('SELECT id FROM `users` WHERE username = :username');
				$sth->bindValue(':username', $username);
				$sth->execute();
				$result = $sth->fetch;
				$id = $result[0];
				$target_file = $id . '_' . $target_file;
				$completeFileName = $id . '_' . $completeFileName;
				if(file_exists($target_file)){
					unlink($target_file);
				}
				if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$errorMessage .= "Sorry, there was an error uploading your file.";
					$status = 0;
				}
				$sth = $dbh->prepare('UPDATE `users` SET profile_image = :profile_image WHERE id = :userid');
				$sth->bindValue(':profile_image', $completeFileName);
				$sth->bindValue('userid', $id);
				$sth->execute();
			}
		}
	}
	$template = loadTemplate('templates', 'createMentor.tmpl');
	echo $template->render(array('errorMessage' => $errorMessage, 'successMessage' => $successMessage));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}