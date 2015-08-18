<?php
require 'config.php';
require 'functions/load_template.php';
session_start();
session_regenerate_id();
$template = loadTemplate('templates','dashboard.tmpl');
	$user_role = 1;
	echo $template->render(array('user_role'=>$user_role));
?>