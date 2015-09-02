<?php
	class Exercise{
		function __construct($array) {
			$this->course_id = isset($array['course_id']) ? $array['course_id'] : 0;
			$this->description = $array['description'];
		}
	}
?>