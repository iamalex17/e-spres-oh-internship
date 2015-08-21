<?php
	function loadTemplate($folder, $file){
		include 'Twig/Autoloader.php';
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