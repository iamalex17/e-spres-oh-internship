<?php
	class User{
		function __construct($array) {
			$this->trimDatas($array);
			if(!isset($array['id'])) {
				$this->id = NULL;
			} else {
				$this->id = $array['id'];
			}
			$this->first_name = isset($array['first_name']) ? $array['first_name'] : NULL;
			$this->last_name = isset($array['last_name']) ? $array['last_name'] : NULL;
			$this->username = isset($array['username']) ? $array['username'] : NULL;
			$this->email = isset($array['email']) ? $array['email'] : NULL;
			$this->password = isset($array['password']) ? MD5($array['password']) : NULL;
			$this->user_role = isset($array['user_role']) ? $array['user_role'] : NULL;
			if((!isset($array['profile_image']))||($array['profile_image'] == NULL)) {
				$this->profile_image = '21232f297a57a5a743894a0e4a801fc3.png';
			} else {
				$this->profile_image = $array['profile_image'];
			}
			if(!isset($array['session_id'])) {
				$this->session_id = NULL;
			} else {
				$this->session_id = $array['session_id'];
			}
			if(!isset($array['status'])) {
				$array['status'] = 1;
			} else {
				$this->status = $array['status'];
			}
			if(!isset($array['reset_password'])) {
				$this->reset = NULL;
			} else {
				$this->reset = $array['reset_password'];
			}
		}

		private function trimDatas($array){
			foreach ($array as $key => &$value) {
				$array[$key] = trim($value);
			}
			return($array);
		}

		function setProfileImage(){

		}
	}
?>