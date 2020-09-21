<?php
define('DB_SERVER','192.168.1.11');
define('DB_DATABASE','fooddudestaging_staging');
define('DB_SERVER_USERNAME','fooddudestaging_user');
define('DB_SERVER_PASSWORD','3W.mmR=Q]#{U');
ini_set('display_errors',false);
ini_set('memory_limit', '-1');
ini_set("log_errors", 1);
ini_set("error_log", "logs/php_error.txt");
date_default_timezone_set('America/Chicago');
error_reporting(E_ALL);
$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

if(isset($_POST['login'])){
	include ("php_functions/main.php");
		mainLogin(json_decode($_POST['login'],true));
	die;
}

?>
