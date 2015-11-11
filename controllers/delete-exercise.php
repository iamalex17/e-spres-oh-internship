<?php
require_once '../config.php';
require_once '../controllers/load-template.php';
require_once '../classes/class.connect-to-db.php';
require_once '../classes/class.user.php';

session_start();

$successMessage = '';

$request = explode('=', $_SERVER['HTTP_REFERER']);
$request = end($request);
$deleteExercise = $_POST['delete_course'];

$sql = 'UPDATE `exercises` SET status = 0 WHERE id = :id';
$valuesToBind = array('id' => $deleteExercise);
ConnectToDB::interogateDB($sql, $valuesToBind);

$sql = 'UPDATE `submitted_exercises` SET status = 0 WHERE exercise_id = :exerciseID)';
$valuesToBind = array('exerciseID' => $deleteExercise);
ConnectToDB::interogateDB($sql, $valuesToBind);

$successMessage = 'Exercise was succesfully deleted.';
$_SESSION['successMessage'] = $successMessage;
header('Location: ' . $GLOBALS['path'] . 'users/create-course?course_id=' . $request);
?>