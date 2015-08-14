<?php

require 'config.php';
require 'functions/load_template.php';
$template = loadTemplate('templates','dashboard.tmpl');
	echo $template->render(array());
?>