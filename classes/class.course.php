<?php
class Course {
	function __construct($array) {
		$this->trimDatas($array);
		$this->id = isset($array['id']) ? $array['id'] : NULL;
		$this->title = isset($array['title']) ? $array['title'] : NULL;
		$this->label = isset($array['label']) ? $array['id'] : NULL;
		$this->description = isset($array['id']) ? $array['id'] : NULL;
	}

	private function trimDatas($array) {
		foreach($array as $key => &$value) {
			$array[$key] = trim($value);
		}
		return($array);
	}
}
?>