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
			var_dump($row);
			var_dump(session_id());
			exit();
			return false;
		}

		static function verifyRequestURL($url) {
			$url = explode('/', $url);
			$url = explode('?', $url[count($url)-1]);
			return $url[0];
		}
	}
?>