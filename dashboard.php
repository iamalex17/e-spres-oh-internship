<?php
require 'config.php';
require 'functions/load_template.php';
session_start();
session_regenerate_id();
$template = loadTemplate('templates','dashboard.tmpl');
	echo $template->render(array());
?>