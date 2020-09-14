<?php

ini_set('display_errors',true);



if(isset($_POST['username']) && isset($_POST['password'])){

	

	require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');
	
	include_once dirname(__FILE__) . '/db_config.php';
	
	if(defined('_DB_SERVER')){
		$db = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);
	}else{
		mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/password_verify.php");
		$db = new PDO("mysql:host=192.168.1.11;dbname=fooddudestaging_staging","fooddudestaging_user", "3W.mmR=Q]#{U");
	}

	$login_sql = "SELECT admin_pass,admin_name,admin_id FROM admin where admin_name = :admin_name LIMIT 0,1";		

	$prep_login = $db->prepare($login_sql);

	$prep_login->bindValue(':admin_name', $_POST['username'], PDO::PARAM_STR);

	$prep_login->execute();

	$login = $prep_login->fetch(PDO::FETCH_ASSOC);

	

	$result = password_verify($_POST['password'], $login['admin_pass']);

	

	

	

	$login['admin_id'] = intval($login['admin_id']);





	

	

	if($result){

		$out = array('success'=>true,'admin_id'=>$login['admin_id']);

	}else{

		$out = array('success'=>false);

	}

	echo json_encode($out);





}

die;