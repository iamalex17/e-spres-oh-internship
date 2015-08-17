<?php
	require_once 'config.php';
	require_once 'functions/load_template.php';
	require_once 'functions/recover_functions.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['email'])){
			$link = generateRandomString($_POST['email']);
		}
	}
	$template = loadTemplate('templates','recoverPassword.tmpl');
	echo $template->render(array());
?>