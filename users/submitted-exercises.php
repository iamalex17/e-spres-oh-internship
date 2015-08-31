<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';


	$template = loadTemplate('../templates','submitted-exercises.tmpl');
	echo $template->render(array());
?>