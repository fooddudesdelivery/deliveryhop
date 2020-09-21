<?php
ini_set('display_errors',true);
if(isset($_POST['username']) && isset($_POST['password'])){
	require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');
	require ('includes/configure.php');

	$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
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
