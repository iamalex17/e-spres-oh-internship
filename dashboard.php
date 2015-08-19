<?php
require 'config.php';
require 'functions/load_template.php';
session_start();
session_regenerate_id();
$userID = $_SESSION['id'];
$sth = $dbh->prepare('SELECT last_name, user_privilege FROM `users` WHERE id = :userID');
$sth->bindValue(':userID', $userID);
$sth->execute();
$result = $sth->fetchAll();
$user_role = $result[0][1];
$lastName = $result[0][0];
$template = loadTemplate('templates','dashboard.tmpl');
echo $template->render(array('user_role'=>$user_role, 'last_name' => $lastName));

?>