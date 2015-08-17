<?php
	require 'config.php';
	require 'functions/load_template.php';
	require 'functions/recover_functions.php';

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['email'])){
			$link = generateRandomString($dbh, $_POST['email']);
		}
	}
	$template = loadTemplate('templates','recoverPassword.tmpl');
	echo $template->render(array());
?>