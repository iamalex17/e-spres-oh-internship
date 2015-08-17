<?php 
	function generateRandomString($email) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 64; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		if(!link_exists($randomString)){
			generateRandomString();
		}else{
			insert_link($randomString, $email);
		}
	}

	function link_exists($string){
		$sth = $dbh->prepare('SELECT reset_password FROM `users` WHERE reset_password = :string');
		$sth->bindValue(':string', $string);
		$sth->execute();
		$result = $sth->fetchAll();
		if(count($result)){
			return true;
		}else{
			return false;
		}
	}

	function insert_link($string, $email){
		$sth = $dbh->prepare('UPDATE `users` SET reset_password = :string WHERE email = :email');
		$sth->bindValue(':string', $string);
		$sth->bindValue(':email', $email);
		$sth->execute();
	}

	function send_link($string, $email){
		require 'Sendgrid/Autoloader.php';
		$sendgrid_username = "internship-espresoh";
		$sendgrid_password = "internship-project1";
		$url = get_current_url();
		$string = $url . '/resetPassword.php?link=' . $string;
		$emailContent = "To recover your sign in creditentials acces the following link: <a href=\"" . $string . "\">" . $string. "</a>";
		echo $emailContent;
		$to = $email;
		$from = 'andrei.g.csiki@gmail.com';
		$sendgrid = new SendGrid($sendgrid_username, $sendgrid_password, array("turn_off_ssl_verification" => true));
		$email = new SendGrid\Email();
		$email->addTo($to)->
		setFrom($from)->
//		setFrom('noreply-e-spres-oh@google.com')->
		setSubject('[Recover password] e-spres-oh')->
		setText($emailContent)->
		setHtml($emailContent)->
		addHeader('X-Sent-Using', 'SendGrid-API')->
		addHeader('X-Transport', 'web');
		$response = $sendgrid->send($email);
		var_dump($response);
	}

	function get_current_url($strip = true) {
		// filter function
		static $filter;
		if ($filter == null) {
			$filter = function($input) use($strip) {
				$input = str_ireplace(array(
					"\0", '%00', "\x0a", '%0a', "\x1a", '%1a'), '', urldecode($input));
				if ($strip) {
					$input = strip_tags($input);
				}
				// or whatever encoding you use instead of utf-8
				$input = htmlentities($input, ENT_QUOTES, 'utf-8'); 
				return trim($input);
			};
		}
		return 'http'. (($_SERVER['SERVER_PORT'] == '443') ? 's' : '').'://'. $_SERVER['SERVER_NAME'] . '/e-spres-oh-internship';
	}

?>