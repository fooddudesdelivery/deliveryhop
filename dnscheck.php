<?php
ini_set('display_errors',true);
error_reporting(E_ALL);

include_once dirname(__FILE__) . '/db_config.php';

if(defined('_DB_SERVER')){
	$db = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);
}else{
	mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/dnscheck.php");
	$db = new PDO("mysql:host=192.168.1.11;dbname=fooddudestaging_staging","fooddudestaging_user",'3W.mmR=Q]#{U');
}
$return = $db->query("select is_alive from DNS_FAILOVER")->fetch(PDO::FETCH_ASSOC);
//echo 'down';
echo $return['is_alive'];
?>