<?php
function loadTemplate($folder, $file){
	$p = (explode('/', $folder));
	$path = $p[0] == '..' ? '../vendors/Twig/Autoloader.php' : 'vendors/Twig/Autoloader.php';
	require_once $path;
	Twig_Autoloader::register();
	// define template directory location
	$loader = new Twig_Loader_Filesystem($folder);
	// initialize Twig environment
	$twig = new Twig_Environment($loader);
	// load template
	$template = $twig->loadTemplate($file);
	return $template;
}
?>