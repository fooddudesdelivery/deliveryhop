<?php
header("Access-Control-Allow-Origin: *");
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

if(isset($_GET['restaurant_status'])){
	include ("php_functions/main.php");
		restaurantStatusChange(json_decode($_GET['category_id'],true));
	die;
}

if(isset($_POST['restaurant_status'])){
	include ("php_functions/main.php");
		restaurantStatus(json_decode($_POST['restaurant_status'],true));
	die;
}
if(isset($_POST['check_restaurant_status'])){
	include ("php_functions/main.php");
		checkRestaurantStatus(json_decode($_POST['check_restaurant_status'],true));
	die;
}

if(isset($_POST['zip_info'])){
	include ("php_functions/main.php");
		getZipInfo(intval(preg_replace('/[^0-9]/s', '', $_POST['zip_info'])));
	die;
}

if(isset($_POST['get_credit_key'])){

	include ("php_functions/creditProcess.php");
	$card = new CreditCard;
	echo $card->getClientId();
}

if(isset($_GET['action']) && $_GET['action']=='fast_order'){
	include ("php_functions/creditProcess.php");
	$card = new CreditCard;

	if(!isset($_GET['categories_id'])){
		$card->creditError('Error no restaurant id');
	}
	$info_sql = "SELECT categories_name, cd.categories_id, configuration,email
		  FROM restaurant_configuration AS pi
		  INNER JOIN categories_description AS cd ON cd.categories_id = pi.categories_id
		  where cd.categories_id = '".$_GET['categories_id']."'
		  LIMIT 0 , 1";
		  //echo $info_sql;
		$info_query = $db->query($info_sql)->fetch(PDO::FETCH_ASSOC);
		$info_query['configuration']=json_decode($info_query['configuration'],true);
		
	$card->initData(array_merge($_GET,$info_query));
	
	$_GET['name'] = addslashes($_GET['name']);
    $_GET['company'] = addslashes($_GET['company']);
    $_GET['address'] = addslashes($_GET['address']);
    $_GET['apt'] = addslashes($_GET['apt']);
    $_GET['city'] = addslashes($_GET['city']);
    
	$dupl_check = $db->query("select orders_id from orders where customers_name = '".$_GET['name']."' and
	customers_city = '".$_GET['city']."' and customers_street_address = '".$_GET['company'].' '.$_GET['address'].' '.$_GET['apt']."' 
	and orders_status!=6 and date_deliver > '".date('Y-m-d H:i:s',strtotime('-5 minutes now'))."'")->fetch(PDO::FETCH_COLUMN);
	
	if($dupl_check!==false){
		echo json_encode(array('success'=>false,'error'=>'Attempted duplicate order'));
		die;
	}
	
	if(isset($_GET['payment_method_nonce'])){
		//$token = $card->authorizeTransaction();
		//if($token!==false){
			$order_gen = $card->fastOrderGenerate(true);	
			$total= $card->getTotal();
			$charge_amt = $total+$card->getUpcharge();
			$card->processTransaction($charge_amt,$total);
		//}
		
	}else{

		$card->fastOrderGenerate();	
	}

	die;
}


?>
