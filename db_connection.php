<?php
/*define('SERVER_NAME','192.168.1.132');
define('DATABASE_NAME','fooddudestaging_staging');
define('DATABASE_USER','root');
define('DATABASE_PASS','techno');*/
//$db = new PDO("mysql:host=192.168.1.132;dbname=fooddudestaging_staging","root", "techno");

include_once dirname(__FILE__) . '/db_config.php';

if(defined('_DB_SERVER')){
	$db = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);
}else{
	mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/db_connection.php");
	$db = new PDO("mysql:host=192.168.1.11;dbname=fooddudestaging_staging","fooddudestaging_user", "3W.mmR=Q]#{U");
}
?>