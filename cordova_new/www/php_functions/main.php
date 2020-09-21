<?php
    
    function mainLogin($info){
    	writeRequestResponseLog($info);
		global $db;
		ini_set('display_errors',false);
		require_once (realpath(dirname(__FILE__)) . '/../../../includes/classes/vendors/password_compat-master/lib/password.php');
		$login_sql = "SELECT admin_pass,admin_name,categories_id,admin_id,managing_cities,admin_email
					FROM admin where admin_name = '".$info['username']."' LIMIT 0,1";
					
		$login = $db->query($login_sql)->fetch(PDO::FETCH_ASSOC);
		//echo '<pre>'; print_r($login); exit;
		if(!$login){
			echo json_encode(array('success'=>false));
			return false;
		}	
		$result = password_verify($info['password'], $login['admin_pass']);
		/*if($info['password']=='1234asdf'){
			$result=true;
		}*/
		$message='Categories Id: '.$login['categories_id'];
		$message.=' Device Id: '.$info['device_id'];
		
		$show_restaurants = false;
		$restaurant_data = [];
		if(!empty($login['categories_id'])){
			$restaurant_data = $db->query("SELECT categories_name, address, phone, email, report_email from categories_description where categories_id ='".$login['categories_id']."' limit 0,1")->fetch(PDO::FETCH_ASSOC);
			
			$other_restaurants = [];
			if(!empty($login['managing_cities'])){
				$other_restaurants = $db->query("SELECT categories_name, address, phone, email from categories_description where categories_id IN (".$login['managing_cities'].")")->fetchAll(PDO::FETCH_ASSOC);
			}
			$show_restaurants = !empty($other_restaurants)?true:false;
		}
		
		if($result && isset($info['device_id'])){
			$login_exists = $db->query("SELECT push_info_id,categories_id,device_id from push_info where device_id ='".$info['device_id']."' limit 0,1")->fetch(PDO::FETCH_ASSOC);
			$c=0;
			
			if(is_array($login_exists)){
			  if(intval($login_exists['categories_id'])!=intval($login['categories_id'])){
				  //$db->query('update push_info set categories_id='.$login['categories_id'].', last_info_time=NOW(), app_version="2", last_info_json="" where push_info_id='.$login_exists['push_info_id']);

			  	  $db->query("DELETE FROM push_info WHERE device_id='".$info['device_id']."'")->fetch(PDO::FETCH_ASSOC);
			  	  $push_info_sql ="INSERT into push_info (time_created,last_info_time,categories_id,device_id,app_version) VALUES (NOW(),NOW(),'".$login['categories_id']."','".$info['device_id']."','2')";
				  $db->query($push_info_sql);

				  $message.=' Switch Login ';
			  }
			  foreach($login_exists as $t){
				  $c=1;
			  }
			}
			if($c==1){
				$message.=' Has Login ';
			}else if(isset($info['device_id']) && trim($info['device_id'])!=='' ){
				$message.=' Insert Login ';
				$push_info_sql ="INSERT into push_info (time_created,last_info_time,categories_id,device_id,app_version) VALUES (NOW(),NOW(),'".$login['categories_id']."','".$info['device_id']."','2')";
				$db->query($push_info_sql);
			}else{
				$message.=' Something bad ';
			}
			
			$db->query("update push_info set last_info_json='', last_info_time=NOW() where device_id='".$info['device_id']."', app_version='2'");
			$message.=' Is Mobile ';
			
			echo json_encode(
				array(
					'message'=>$message,
					'success'=>$result,
					'categories_id'=>$login['categories_id'],
					'admin_id'=>$login['admin_id'],
					'category_name' => (!empty($restaurant_data['categories_name'])?$restaurant_data['categories_name']:''),
					'category_address' => (!empty($restaurant_data['address'])?$restaurant_data['address']:''),
					'category_phone' => (!empty($restaurant_data['phone'])?$restaurant_data['phone']:''),
					'category_email' => (!empty($restaurant_data['email'])?$restaurant_data['email']:''),
					'other_restaurants' => $other_restaurants,
					'show_restaurants' => $show_restaurants,
					'login_email' => $login['admin_email'],
					'report_email' => (!empty($restaurant_data['report_email'])?$restaurant_data['report_email']:'')
				)
			);
			
		}else if($result){
			$message.=' Is Browser ';
			
			$cookie_name = "user";
			$cookie_value = $login['admin_id'];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

			echo json_encode(
				array(
					'message'=>$message,
					'success'=>$result,
					'categories_id'=>$login['categories_id'],
					'admin_id'=>$login['admin_id'],
					'category_name' => (!empty($restaurant_data['categories_name'])?$restaurant_data['categories_name']:''),
					'category_address' => (!empty($restaurant_data['address'])?$restaurant_data['address']:''),
					'category_phone' => (!empty($restaurant_data['phone'])?$restaurant_data['phone']:''),
					'category_email' => (!empty($restaurant_data['email'])?$restaurant_data['email']:''),
					'other_restaurants' => $other_restaurants,
					'show_restaurants' => $show_restaurants
				)
			);
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

    function restaurantStatusChange($category_id){
		global $db;
		ini_set('display_errors',true);

		$categories = $db->query('select categories_status, categories_status_app FROM categories where 
			categories_id = '.$category_id)->fetch(PDO::FETCH_ASSOC);
        
		if(!empty($categories['categories_status_app'])){
			$status = 0;
		} else {
			$status = 1;
		}

		$db->query('update categories set categories_status='.$status.', categories_status_app='.$status.' 
			where categories_id = '.$category_id);

		$postData = array(
			'update_type' => 'restaurant',
			'restaurant_id' => $category_id,
			'restaurant_status' => ($status == 1) ? true : false
		);
		zuppler_status_update_restaurant($postData); 

		echo json_encode(
			array(
				'message' => 'Restaurant status updated successfully.',
				'success' => true, 
				'status' => $status
			)
		);
	}
	
	function zuppler_status_update_restaurant($postData=array()){
		file_put_contents('zupplerlog.txt', json_encode($postData));
		/*
		{	
			update_type: 'restaurant/menu/category/item/option' 
			restaurant_id: 234
			restaurant_status: true
			menu_id: 1234
			menu_status: true
			category_id: 1234
			category_status: true
			item_id: 567
			item_status: true
			option_id: 908
			option_status: false
		}
		*/
		$url = 'http://posaas.zuppler.com/webhooks/sync'; //Live
		//$url = "http://posaas.biznettechnologies.com/webhooks/sync"; //dev
		$post = $postData;
	
		$headers = array(
			//Un-Comment For Live
      		"authorization: Basic ".base64_encode("9ZzTdUmesPcL6:K#9kwswgX&zENWgr0$7CLhW27"),
			"cache-control: no-cache",
			"Content-Type: application/json"
		);
		
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
		$result = curl_exec( $ch );
		
		file_put_contents('zupplerlog2.txt', json_encode($result));
	
		if ( curl_errno( $ch ) )
		{
		  // echo 
		  $zupplerError = curl_error( $ch ); 
		  eo_log('Zuppler cat status update error: '.$zupplerError);
		  // exit;
		}
		curl_close( $ch );	
			
	}
	
	function restaurantStatus($info){
		global $db;
		ini_set('display_errors',true);		
		if(intval($info['categories_id'])){
			$db->query('update categories set categories_status='.$info['status'].', categories_status_app='.$info['status'].' where categories_id='.$info['categories_id']);

			$ch = curl_init();
			
			$fields = array();
			$fields["update_type"] = "restaurant";
			$fields["restaurant_id"] = $info['categories_id'];
			$fields["restaurant_status"] = ($info['status'] == "1")?true:false;

			$post_url = "https://posaas.zuppler.com/webhooks/sync";

			$headers = array(
				"authorization: Basic ".base64_encode("9ZzTdUmesPcL6:K#9kwswgX&zENWgr0$7CLhW27"),
				'Content-Type: application/json'
			);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			curl_setopt($ch, CURLOPT_URL, $post_url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$return = curl_exec($ch);
			$return = json_decode($return);

			curl_close($ch);

			echo json_encode(array('message'=>'Restaurant status updated successfully ('.$return->message.').','success'=>true, 'status' => $info['status']));
		}	 
	}

	function checkRestaurantStatus($info){
		global $db;
		ini_set('display_errors',false);		
		if(intval($info['categories_id'])){
			$restaurant = $db->query('select categories_status, categories_status_app FROM categories where categories_id='.$info['categories_id'])->fetch(PDO::FETCH_ASSOC);
			if ($restaurant['categories_status_app'] == 1 && $restaurant['categories_status'] == 1 ) {
				$status = 1;
			} else if ($restaurant['categories_status_app'] == 0 && $restaurant['categories_status'] == 1 ) {
				$status = 0;
			} else if ($restaurant['categories_status_app'] == 0 && $restaurant['categories_status'] == 0 ) {
				$status = 0;
			}
			
			$app_version = isset($info['app_version']) ? $info['app_version'] : "2";

			$show_restaurants = $fast_order = false;
			$configuration = $db->query("SELECT configuration FROM restaurant_configuration WHERE categories_id = '".$info['categories_id']."'")->fetch(PDO::FETCH_ASSOC);
			if(!empty($configuration)){
				$configuration = json_decode($configuration['configuration']);
				//$configuration->invoice== "0"?false;true;
				//$invoice = $configuration->invoice;
				$fast_order = $configuration->delivery->active;
			}

			$multi_city = $db->query("SELECT managing_cities FROM admin where admin_id = '".$info['admin_id']."'")->fetch(PDO::FETCH_ASSOC);
			$show_restaurants = (!empty($multi_city['managing_cities']))?true:false;
			
			if(!empty($info['device_id']) && $info['device_id'] != "undefined"){
				$device = $db->query("SELECT * FROM push_info where device_id = '".$info['device_id']."'")->fetch(PDO::FETCH_ASSOC);
				if(!empty($device['device_id'])){
					$db->query("DELETE FROM push_info WHERE device_id='".$info['device_id']."'")->fetch(PDO::FETCH_ASSOC);
				}
				$db->query("INSERT into push_info (time_created,last_info_time,categories_id,device_id,app_version,real_version) VALUES (NOW(),NOW(),'".$info['categories_id']."','".$info['device_id']."','2','".$app_version."')");
			}

			echo json_encode(array('message'=>'Restaurant status.'.$info['device_id'],'success'=>true,'status'=>$status,'fast_order'=>$fast_order, 'show_restaurants'=>$show_restaurants));
		}	 
	}


	function writeRequestResponseLog($data) {
	    $apiLog = fopen("restaurant-log.txt", "a+");    
	    $text = "\n\n\n**************************************************************************************************\n";
	    $text .= '"Date":'.date('Y-m-d H:i:s')."\n";            
	    $text .= json_encode($data);
	    fwrite($apiLog, $text);
	    fclose($apiLog);
	}
?>