<?php

ini_set('log_errors', 'On');
ini_set('error_log', 'php_errors.log');

require_once("conf.php");

$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$db) {
	SendErrorMessage("No MySQL connection");
}

require_once("classes.php");

require_once("processor.php");




$request = new Request;
$response = new Response;


Process();



mysqli_close($db);
exit;