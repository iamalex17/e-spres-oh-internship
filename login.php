<?php
require 'config.php';
require 'functions/load_template.php';
try {
	$username = '';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sth = $dbh->prepare('SELECT * FROM `users` WHERE username = :username AND password = MD5(:password)');
		$sth->bindValue(':username', $username);
		$sth->bindValue(':password', $password);
		$sth->execute();
		$result = $sth->fetchAll();
		if(count($result)==1){
		//Sendgrid test
/*			require 'Sendgrid/Autoloader.php';
			$sendgrid_username = "internship-espresoh";
			$sendgrid_password = "internship-project1";
			$to = "andrei.g.csiki@gmail.com";
			$sendgrid = new SendGrid($sendgrid_username, $sendgrid_password, array("turn_off_ssl_verification" => true));
			$email = new SendGrid\Email();
			$email->addTo($to)->
			setFrom($to)->
			setSubject('[sendgrid-php-example] Owl named %yourname%')->
			setText('Owl are you doing?')->
			setHtml('<strong>%how% are you doing?</strong>')->
			addSubstitution("%yourname%", array("Mr. Owl"))->
			addSubstitution("%how%", array("Owl"))->
			addHeader('X-Sent-Using', 'SendGrid-API')->
			addHeader('X-Transport', 'web');
			$response = $sendgrid->send($email);
			var_dump($response);
			*/
			header('Location: dashboard.php');
			exit();
		}
	}
	$template = loadTemplate('templates','login.tmpl');
	echo $template->render(array('username'=>$username));
} catch (Exception $e) {
	die ('ERROR: ' . $e->getMessage());
}


?>