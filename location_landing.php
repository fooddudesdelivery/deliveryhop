<?php 
ini_set('display_errors',false);
ini_set('memory_limit', '-1');
ini_set("log_errors", 1);
ini_set("error_log", "logs/php_error.txt");
date_default_timezone_set('America/Chicago');
error_reporting(E_ALL);

include ("includes/location_process/loc.php");

include_once dirname(__FILE__) . '/db_config.php';

if(defined('_DB_SERVER')){
	define('SERVER_NAME',_DB_SERVER);
	define('DATABASE_NAME',_DB_DATABASE);
	define('DATABASE_USER',_DB_SERVER_USERNAME);
	define('DATABASE_PASS',_DB_SERVER_PASSWORD);
}else{
	mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/location_landing.php");
	define('SERVER_NAME','192.168.1.11');
	define('DATABASE_NAME','fooddudestaging_staging');
	define('DATABASE_USER','fooddudestaging_user');
	define('DATABASE_PASS','3W.mmR=Q]#{U');
}

		try{
			$db = new PDO("mysql:host=".SERVER_NAME.";dbname=".DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			//$this->addError("Connection failed: " . $e->getMessage());
		}
$Location = new Location_new;


if(isset($_POST['mapquestError'])){
	$mpe=json_decode($_POST['mapquestError'],true);
	$Location->getLatLngRoutes($mpe);
	die;
}


if(isset($_POST['update_routes'])){
	$vv=json_decode($_POST['update_routes'],true);
	$Location->updateRoutes($vv);
	die;
}

if(isset($_GET['x'])||isset($_POST['address_info_new'])){
  
    $_POST['address_info']=$_POST['address_info_new'];//'{"street":"Highway 55 Service Road","city":"Plymouth","state":"Minnesota","zipcode":55441,"lat":45.00219269999999,"lng":-93.44328289999999,"google_place_id":"ChIJkxZZKhVKs1IRgWz6lTX8yPY"}';

	$Location->runLocation();
	
	die;
}

if(isset($_POST['address_info'])){
	ini_set('display_errors',true);
	include ("includes/location_process/Location.php");
	$n = new Location;
	$n->runLocation();
	
	die;
}
?>