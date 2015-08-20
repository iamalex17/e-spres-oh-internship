<?php
require_once 'config.php';
require_once 'functions/load_template.php';
$template = loadTemplate('templates','changePasswordMentor.tmpl');
echo $template->render(array());
?>