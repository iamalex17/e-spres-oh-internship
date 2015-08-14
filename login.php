<?php

// include and register Twig auto-loader
include 'Twig/Autoloader.php';
Twig_Autoloader::register();

try {
	// define template directory location
	$loader = new Twig_Loader_Filesystem('templates');
	
	// initialize Twig environment
	$twig = new Twig_Environment($loader);
	
	// load template
	$template = $twig->loadTemplate('login.tmpl');

	// set template variables
	// render template
	echo $template->render(array ());
	
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}
?>