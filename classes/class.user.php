<?php
	class User{
		function __construct($array) {
			$this->trimDatas($array);
			$this->id = isset($array['id']) ? $array['id'] : NULL;
			$this->first_name = isset($array['first_name']) ? $array['first_name'] : NULL;
			$this->last_name = isset($array['last_name']) ? $array['last_name'] : NULL;
			$this->username = isset($array['username']) ? $array['username'] : NULL;
			$this->email = isset($array['email']) ? $array['email'] : NULL;
			$this->password = isset($array['password']) ? MD5($array['password']) : NULL;
			$this->user_role = isset($array['user_role']) ? $array['user_role'] : NULL;
			$this->profile_image = isset($array['profile_image']) ? $array['profile_image'] : '21232f297a57a5a743894a0e4a801fc3.png';
			$this->session_id = isset($array['session_id']) ? $array['session_id'] : NULL;
			$this->status = isset($array['status']) ? $array['status'] : 1;
			$this->reset_password = isset($array['reset_password']) ? $array['reset_password'] : NULL;
			$this->deletion_link_time = isset($array['deletion_link_time']) ? $array['deletion_link_time'] : NULL;
		}

		private function trimDatas($array){
			foreach ($array as $key => &$value) {
				$array[$key] = trim($value);
			}
			return($array);
		}

		static function verifySessionID() {
			session_start();
			if(!isset($_SESSION['id'])){
				return false;
			}
			$sql = 'SELECT session_id FROM `users` WHERE id = :id';
			$valuesToBind = array('id' => $_SESSION['id']);
			$result = ConnectToDB::interogateDB($sql, $valuesToBind);
			$row = $result[0];
			if($row['session_id'] == session_id()) {
				session_regenerate_id();
				$sql = 'UPDATE `users` SET session_id = :session_id WHERE id = :id';
				$valuesToBind = array('session_id' => session_id(), 'id' => $_SESSION['id']);
				ConnectToDB::interogateDB($sql, $valuesToBind);
				$_SESSION['session_id'] = session_id();
				return true;
			}
			return false;
		}

		static function verifyRequestURL($url) {
			$url = explode('/', $url);
			$url = explode('?', $url[count($url)-1]);
			return $url[0];
		}

		function addProfileImage() {
			$uploadOk = 1;
			$this->profile_image = MD5($_FILES['profile_image']['name']);
			$target_dir = $path . 'images/user-profile-images/';
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
			$errorMessage = '';
			$uploadOk = 1;
			if($check === false) {
				$errorMessage .= "File is not an image.\n";
				$uploadOk = 0;
			}// Check file size
			if ($_FILES['profile_image']['size'] > 2097152) {
				$errorMessage  .= "Sorry, your file is too large.\n";
				$$uploadOk = 0;
			}// Allow certain file formats
			if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
				$errorMessage  .= "Sorry, only JPG, JPEG, PNG and GIF files are allowed.\n";
				$uploadOk = 0;
			}
			if($uploadOk) {
				$sql = 'SELECT id FROM `users` WHERE email = :email';
				$valuesToBind = array('email' => $this->email);
				$result = ConnectToDB::interogateDB($sql, $valuesToBind);
				var_dump($result);
				if(count($result)) {
					$id = $result[0]['id'];
					$completeFileName = $id . '_' . $completeFileName;
					$target_file = $GLOBALS['docRoot'] . $target_dir . $completeFileName;
					$this->profile_image = $completeFileName;
					if(file_exists($target_file)){
						unlink($target_file);
					}
					if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
						$errorMessage .= "Sorry, there was an error uploading your file.\n";
						//$status = 0;
					}
					$sql = 'UPDATE `users` SET profile_image = :profile_image WHERE id = :id';
					$valuesToBind = array('profile_image' => $completeFileName, 'id' => $id);
					ConnectToDB::interogateDB($sql, $valuesToBind);
				}
			}
			return $errorMessage;
		}
	}
?>