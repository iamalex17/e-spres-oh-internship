<?php
require 'config.php';
require 'functions/load-template.php';

$template = loadTemplate('templates', 'create-course.tmpl');
echo $template->render(array());
?>