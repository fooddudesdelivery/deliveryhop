<?php 
include ("includes/location_process/loc.php");
include_once dirname(__FILE__) . '/includes/configure.php';

ini_set('display_errors',false);
ini_set('memory_limit', '-1');
ini_set("log_errors", 1);
ini_set("error_log", "logs/php_error.txt");
date_default_timezone_set(SITE_TIMEZONE);
error_reporting(E_ALL);

define('SERVER_NAME',DB_SERVER);
define('DATABASE_NAME',DB_DATABASE);
define('DATABASE_USER',DB_SERVER_USERNAME);
define('DATABASE_PASS',DB_SERVER_PASSWORD);

try{
	$db = new PDO("mysql:host=".SERVER_NAME.";dbname=".DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	print_r($e->getMessage()); exit;
	///$this->addError("Connection failed: " . $e->getMessage());
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