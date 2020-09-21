<?php
	class RestaurantBase{
		private $db;
		private $primary_key;
		private $primary_params;
		
		function __construct(){
			/*ini_set('display_errors',true);
			//ini_set('memory_limit', '-1');
			ini_set("log_errors", 1);
			ini_set("error_log", "php_error.txt");
			error_reporting(E_ALL);*/
			date_default_timezone_set('America/Chicago');			
			$this->db = new PDO("mysql:host=".'192.168.1.11'.";dbname=".'fooddudestaging_staging', 'fooddudestaging_user', '3W.mmR=Q]#{U');
		}
		public function receive($key,$params){
			$this->primary_key=$key;
			$this->primary_params=$params;
			
			$return = '';
			switch($this->primary_key){
				case 'get_tax_fee':
					$return = $this->getTaxFromConfig();
				break;
				case 'logout':
					$return = $this->logout();
				break;
				case 'resend_order':
					$return = $this->resendOrder();
				break;
				case 'accept_order':
					$return = $this->acceptOrder();
				break;
				case 'accept_multiple_order':
					$return = $this->acceptMultipleOrder();
				break;
				case 'pickup_complete':
					$return = $this->pickupComplete();
				break;
				case 'check_new_order':
					$return = $this->checkNewOrder();
				break;
				case 'current_order':
					$return = $this->currentOrders();
				break;
				case 'future_order':
					$return = $this->futureOrders();
				break;
				case 'past_order':
					$return = $this->pastOrders();
				break;
				case 'report_data':
					$return = $this->reportData();
				break;
				case 'add_charge':
					$return = $this->addCharge();
				break;
				case 'add_note':
					$return = $this->addNote();
				break;
				case 'get_config':
					$return = $this->getConfig();
				break;
				case 'set_config':
					$return = $this->setConfig();
				break;
				case 'signal_flare':
					$return = $this->signalFlare();
				break;
				case 'reverse_signal_flare':
					$return = $this->reverseSignalFlare();
				break;
				case 'java_http':
					$return = $this->javaHttp();
				break;
				case 'menu_category':
					$return = $this->menuCategory();
				break;
				case 'other_restaurants':
					$return = $this->otherRestaurants();
					break;
				case 'update_device_info':
					$return = $this->updatedeviceinfo();
					break;
				case 'product_status_update':
					$return = $this->productStatusUpdate();
				break;
				case 'update_email':
					$return = $this->updateEmail();
				break;
				case 'update_password':
					$return = $this->updatePassword();
				break;
				case 'test':
				case 'get_emails':
					$return = $this->getEmails();
				break;
				case 'set_emails':
					$return = $this->setEmails();
				break;
				case 'new_current_order':
					$return = $this->newCurrentOrders();
					break;
				default:
					$return = $this->primary_params;
					break;
			}
			echo $return;
		}

		private function newCurrentOrders(){
			$categories_id = $this->primary_params['categories_id'];
			//$completed_str = $this->primary_params['completed'];
			$completed = $this->primary_params['completed'];
			
			/*echo "<pre>";
			print_r($this->primary_params);*/

			/*$completed = array();
			if(!empty($completed_str)){
				$completed = explode(",", $completed_str);
				if(!empty($completed)){
					$completed[] = $completed_str;
				}
			}*/
			$today = date('Y-m-d 00:00:00');
			$tonight = date('Y-m-d 23:59:59');
			$id_sql = "
			SELECT oh.orders_id
			FROM orders_status_history AS oh
			INNER JOIN orders AS o ON o.orders_id = oh.orders_id
			WHERE orders_status_id
			IN ( 2 )
			AND orders_status NOT
			IN ( 8, 10, 6, 9, 13 )
			AND date_deliver > '$today'
			AND date_deliver < '$tonight'
			AND categories_id = $categories_id
			LIMIT 0 , 999";	
			//return json_encode([$id_sql]);
			$orders_id_list =  $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
			/*if(count($orders_id_list )===0){
				echo json_encode(array('no_orders'));
				die;	
			}*/

			$today_start = date('Y-m-d 00:00:00');
			$today_end = date('Y-m-d 23:59:59');
			$id_sql = "
			SELECT o.orders_id
			FROM orders AS o
			WHERE orders_status 
			IN (  9 )
			AND date_deliver > '$today_start'
			AND date_deliver < '$today_end'
			AND categories_id = $categories_id
			LIMIT 0 , 999";	
			$future_orders_id_list =  $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);

			$past_start = date('Y-m-d 00:00:00');
			$past_end = date('Y-m-d 23:59:59');

			$past_sql = "SELECT o.orders_id
				FROM orders as o 
				WHERE date_deliver > '$past_start'
				AND date_deliver < '$past_end'
				AND categories_id = $categories_id
				AND orders_status in (10,13,8)
				LIMIT 0 , 999";	
			$past_list =  $this->db->query($past_sql)->fetchAll(PDO::FETCH_COLUMN);

			$active_list = $completed_list = array();
			$orders_id_list= array_values($orders_id_list);
			
			if(!empty($completed)){
				foreach ($orders_id_list as $key => $order_id){
					if(in_array($order_id, $completed)){
						$completed_list[] = $order_id;
					}else{
						$active_list[] = $order_id;
					}
				}
			}else{
				$active_list = $orders_id_list;
			}
			
			$data = array();

			if(!empty($active_list)){
				$active_list = array_values($active_list);
				$data["active"] = $this->getOrder($active_list, $categories_id);
				foreach($data["active"] as $key => $active_){
					$data["active"][$key]["orders_info"]["completed_flag"] = "0";
				}
			}else{
				$data["active"] = "no_orders";
			}
			
			if(!empty($completed_list)){
				$completed_list = array_values($completed_list);
				$data["completed"] = $this->getOrder($completed_list, $categories_id);
				foreach($data["completed"] as $key => $active_){
					$data["completed"][$key]["orders_info"]["completed_flag"] = "1";
				}
			}else{
				$data["completed"] = "no_orders";
			}
			
			if(!empty($future_orders_id_list)){
				$future_orders_id_list= array_values($future_orders_id_list);
				$data["future"] = $this->getOrder($future_orders_id_list, $categories_id);
				foreach($data["future"] as $key => $active_){
					$data["future"][$key]["orders_info"]["completed_flag"] = "2";
				}
			}else{
				$data["future"] = "no_orders";
			}

			if(!empty($past_list)){
				$past_list = array_values($past_list);
				$past_orders = $this->getOrder($past_list, $categories_id);
				
				/*echo "<pre>";
				print_r($past_orders);
				echo "<pre>";
				print_r($data["completed"]);
				exit();*/

				if(!empty($data["completed"]) && $data["completed"] != "no_orders"){
					foreach($past_orders as $key => $p_o){
						$past_orders[$key]["orders_info"]["completed_flag"] = "2";
						$data["completed"][] = $past_orders[$key];
					}

					//$array_merge = array_merge($past_orders,$data["completed"]);
					//unset($data["completed"]);
					//$data["completed"] = $array_merge;
				}else{
					foreach($past_orders as $key => $p_o){
						$past_orders[$key]["orders_info"]["completed_flag"] = "2";
					}
					$data["completed"] = $past_orders;
				}
			}

			return json_encode($data);
		}
		private function setEmails(){
			$categories_id 	= $this->primary_params['categories_id'];
			$admin_id 		= $this->primary_params['admin_id'];
			$email_list 	= $this->primary_params['email_list'];

			$report_email = implode(",", $email_list);

			$this->db->query("Update categories_description SET report_email='".$report_email."' WHERE categories_id='".$categories_id."'");
			return json_encode(array('message'=>'Report email address(s) updated', 'success'=>'1'));
		}

		private function getEmails(){
			$categories_id 	= $this->primary_params['categories_id'];
			$admin_id 		= $this->primary_params['admin_id'];
			$app_version 	= $this->primary_params['app_version'];
			
			//$login_email 	= $this->db->query("SELECT admin_email FROM admin where admin_id = '".$admin_id."' AND categories_id='".$categories_id."'")->fetch(PDO::FETCH_ASSOC);
			$login_email 	= $this->db->query("SELECT admin_email FROM admin where admin_id = '".$admin_id."' ")->fetch(PDO::FETCH_ASSOC);
			$report_emails	= $this->db->query("SELECT report_email from categories_description where categories_id ='".$categories_id."'")->fetch(PDO::FETCH_ASSOC);
			$data = array();
			
			$data['loginemail'] = !empty($login_email['admin_email'])?$login_email['admin_email']:'';

			if(!empty($report_emails['report_email'])){
				$report_emails_list = array();
				$reportemails = explode(",", $report_emails['report_email']);
				foreach ($reportemails as $key => $email) {
					if($key == "0"){
						$data['reportemail'] = trim($email);
					}else{
						$report_emails_list[] = array("id"=>$key, "report_email"=>trim($email), "hide_on_remove"=>"0");
					}
				}
				$data['reportEmailData'] = !empty($report_emails_list)?$report_emails_list:array();
			}else{
				$data['reportEmailData'] = array();
			}
			//$data['reportEmailData'] = array();
			//$data['reportEmailData'] = !empty($report_emails['report_email'])?$report_emails['report_email']:'';

			$app_update_available = $this->db->query("SELECT * FROM app_update_available where current_version = '".$app_version."' ")->fetch(PDO::FETCH_ASSOC); 

			if(!empty($app_update_available)){
				$data["app_update_url"] = $app_update_available["download_url"];
				$data["show_update"] = "1";				
			}else{
				$data["app_update_url"] = "https://deliverhop.app/app_updates/index.php";
				$data["show_update"] = "0";
			}

			/*$app_version++;

			switch ($app_version) {
				case 2:
					$data["show_update"] = "0";
					$data["app_update_url"] = "https://deliverhop.app/app_updates/index.php";
					break;
				case 3:
					$data["show_update"] = "0";
					$data["app_update_url"] = "https://deliverhop.app/app_updates/index.php";
					break;
				case 4:
					$data["show_update"] = "0";
					$data["app_update_url"] = "https://deliverhop.app/app_updates/index.php";
					break;
				default:
					$data["show_update"] = "0";
					$data["app_update_url"] = "https://deliverhop.app/app_updates/index.php";
					break;
			}*/

			return json_encode(array('success'=>'1', 'data'=>$data));
		}

		private function updatePassword(){
			$categories_id 	= $this->primary_params['categories_id'];
			$admin_id 		= $this->primary_params['admin_id'];
			$settings_password = $this->primary_params['settings_password'];

			header("Access-Control-Allow-Origin: *");
			ini_set('display_errors',true);
			define('IS_ADMIN_FLAG', false);
			define('SEND_EMAILS', true);
			$_SESSION['languages_code']='en';
			define('STORE_OWNER', '');
			define('EMAIL_FOOTER_COPYRIGHT', '');
			define('EMAIL_DISCLAIMER', '');
			define('STORE_OWNER_EMAIL_ADDRESS', '');
			define('EMAIL_SPAM_DISCLAIMER', '');
			define('DATE_FORMAT', 'YYYY-mm-dd');
			define('DATE_FORMAT_LONG', 'YYYY-mm-dd');
			define('CHARSET', '');
			define('TEXT_UNSUBSCRIBE', '');

			require_once (realpath(dirname(__FILE__)) . '/../../../includes/configure.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/classes/vendors/password_compat-master/lib/password.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/functions/password_funcs.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/classes/class.base.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/functions/functions_general.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/functions/functions_email.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/classes/class.zcPassword.php');
			require_once (realpath(dirname(__FILE__)) . '/../../../includes/functions/html_output.php');

			$email_from = '';
			$minimun_length=0;
			$store_name = '';

			$configuration_data = $this->db->query("select * from configuration where configuration_key LIKE 'ENTRY_PASSWORD_MIN_LENGTH' OR configuration_key LIKE 'STORE_NAME' OR configuration_key LIKE 'EMAIL_FROM'")->fetchAll(PDO::FETCH_ASSOC);

			foreach ($configuration_data as $key => $data) {
				if($data['configuration_key']=='EMAIL_FROM'){
					$email_from = $data['configuration_value'];
				}
				if($data['configuration_key']=='ENTRY_PASSWORD_MIN_LENGTH'){
					$minimun_length = $data['configuration_value'];
				}
				if($data['configuration_key']=='STORE_NAME'){
					$store_name = $data['configuration_value'];
				}
			}

			define('STORE_NAME', $store_name);
			define('ENTRY_PASSWORD_MIN_LENGTH', $minimun_length);
			define('EMAIL_FROM', $email_from);
			define('EMAIL_DISCLAIMER2', 'This email address was given to us by you or by one of our customers. If you feel that you have received this email in error, please send an email to %s ');
			define('EMAIL_SPAM_DISCLAIMER2','This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.');

			require_once (realpath(dirname(__FILE__)) . '/../../../includes/languages/english/password_forgotten.php');

			$check = $this->db->query("SELECT admin_name, admin_pass, admin_id FROM admin WHERE admin_id = '".$admin_id."'")->fetch(PDO::FETCH_ASSOC);

			if (!empty($check)) {
				$new_password = zen_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
				//$crypted_password = zen_encrypt_password($new_password);
				$crypted_password = password_hash($settings_password, PASSWORD_DEFAULT);
				$this->db->query("UPDATE admin SET admin_pass = '".$crypted_password."' WHERE admin_id = '".$admin_id."'");
				return json_encode(array('message'=>'Password updated', 'success'=>'1'));
			}else{
				return json_encode(array('message'=>'Something went wrong', 'success'=>'0'));
			}
		}

		private function updateEmail(){
			$categories_id 	= $this->primary_params['categories_id'];
			$admin_id 		= $this->primary_params['admin_id'];
			$settings_email = $this->primary_params['settings_email'];

			if(!empty($settings_email) && !empty($categories_id)){

				$restaurant_data = $this->db->query("SELECT * from admin where admin_id != '".$admin_id."' AND admin_email = '".$settings_email."'")->fetch(PDO::FETCH_ASSOC);

					if(empty($restaurant_data)){
					$this->db->query("Update admin SET admin_email='".$settings_email."' WHERE admin_id='".$admin_id."'");
						return json_encode(array('message'=>'Email address updated', 'success'=>'1'));
					}else{
					return json_encode(array('message'=>'Login email address already exists', 'success'=>'0', 'field'=>'settings_email'));
				}
				
			}else{
				return json_encode(array('message'=>'Please enter email address', 'success'=>'0'));
			}
		}

		private function updatedeviceinfo(){
			$cat_id = intval($this->primary_params['categories_id']);
			$admin_id = intval($this->primary_params['admin_id']);
			$device_id = $this->primary_params['device_id'];
			//echo "cat_id: $cat_id , admin_id: $admin_id , device_id: $device_id";
			$app_version = isset($this->primary_params['app_version']) ? $this->primary_params['app_version'] : "2";
			$device = $this->db->query("SELECT * FROM push_info where device_id = '".$device_id."'")->fetch(PDO::FETCH_ASSOC);
			if(!empty($device['device_id'])){
				$this->db->query("DELETE FROM push_info WHERE device_id='".$device_id."'")->fetch(PDO::FETCH_ASSOC);
			}
			$this->db->query("INSERT into push_info (time_created,last_info_time,categories_id,device_id,app_version,real_version) VALUES (NOW(),NOW(),'".$cat_id."','".$device_id."','2','".$app_version."')");
		}

		private function otherRestaurants(){
			$cat_id = intval($this->primary_params['categories_id']);
			$admin_id = intval($this->primary_params['admin_id']);
			
			$multi_city = $this->db->query("SELECT managing_cities FROM admin where admin_id = '".$admin_id."'")->fetch(PDO::FETCH_ASSOC);
			//$multi_city = $this->db->query("SELECT managing_cities FROM admin where categories_id = '".$cat_id."'")->fetch(PDO::FETCH_ASSOC);

			$other_restaurants = $this->db->query("SELECT categories_id profile_id, categories_name profile_anme, address profile_address from categories_description where categories_id IN (".$multi_city['managing_cities'].")")->fetchAll(PDO::FETCH_ASSOC);
			return json_encode(!empty($other_restaurants)?array('tableData'=>$other_restaurants):array('no_restaurants'));
		}

		private function productStatusUpdate(){
			$categories_id = intval($this->primary_params['categories_id']);

			parse_str($this->primary_params['menu_product'], $menu_product_);
			$on_products = $menu_product_['menu_product'];

			parse_str($this->primary_params['h_menu_product'], $h_menu_product_);
			$all_products = $h_menu_product_['h_menu_product'];

			foreach($all_products as $key => $products_id){
				$sql_qry = "update products ";
				if(!in_array($products_id, $on_products)){
					$sql_qry .= " set products_status = 0, ";
				}else{
					$sql_qry .= " set products_status = 1, ";
				}
				$sql_qry .= " products_last_modified = now() where products_id = '" . (int)$products_id . "'";
				$this->db->query($sql_qry);
			}
			$sync =  $this->zuppler_menu_sync($categories_id);
			echo "1";
			exit();
		}
		private function menuCategory(){
			$result = array();
			$cat_id = intval($this->primary_params['categories_id']);
			//$cat_id = "11833";
			
			$cat_ids = $this->db->query("SELECT c.categories_id, c.categories_status, c.categories_status_app, categories_image, parent_id, sort_order, categories_name, categories_description, timezone, is_daylight_saving FROM categories AS c INNER JOIN categories_description AS cd ON cd.categories_id = c.categories_id WHERE c.parent_id = ".$cat_id." ORDER BY categories_name")->fetchAll(PDO::FETCH_ASSOC);
			$cat_ids_ = array();
			foreach($cat_ids as $key => $cat){
				$cat_ids_[] = $cat['categories_id'];
			}
			$cat_ids_str = implode(",", $cat_ids_);
			$cat_one = $this->categoryList($cat_ids_str);
			/*echo "<pre> $cat_ids_str <br>";
			print_r($cat_ids);
			print_r($cat_one);
			exit();*/
			$category=array();
			if(!empty($cat_one)){
				$mykey = 0;
				foreach ($cat_one as $key_one => $value_one) {
					
					/*$subCategory=array();
					$cat_two = $this->categoryList($value_one['categories_id']);
					//print_r($cat_two);
					if(!empty($cat_two)){
						foreach ($cat_two as $key_two => $value_two) {
							$subCategory[$key_two]=[
								'categories_id' => $value_two['categories_id'],
								'status' => ($value_two['categories_status']==0 || $value_two['categories_status_app']==0 ) ? 0 : 1,
								'parent_id' 	=> $value_two['parent_id'],
								//'sort_order' 	=> $value_two['sort_order'],
								'categories_name' 	=> $this->normaliseUrlString($value_two['categories_name']),
								'categories_description' 	=> $this->normaliseUrlString($value_two['categories_description'])						
							];
							$product = $this->products($value_two['categories_id']);
							$itmes = array();
							foreach ($product as $key_product => $value_product) {
								$itmes[$key_product]=[
									'products_id' => $value_product['products_id'],
									'status' => (int)$value_product['products_status'],
									'products_name' => htmlspecialchars($value_product['products_name']),
									'products_price' => $value_product['products_price'],
									//'products_description' => htmlspecialchars($value_product['products_description']),
									//'parent_id' => $value_product['master_categories_id']
								];
								//options = $this->productOptions($value_product['products_id']);
								//$itemOption = array();
								//foreach ($options as $key_option => $value_option) {
								//	$itemOption[$key_option]=[
								//		'product_id' => $value_option['products_id'],
								//		'products_attributes_id' => $value_option['products_attributes_id'],
								//		'options_id' => $value_option['options_id'],
								//		'option_type' => $value_option['products_options_types_name'],
								//		'option_name' => htmlspecialchars($value_option['products_options_name']),
								//		'options_values_id' => $value_option['options_values_id'],
								//		'products_options_values_name' => htmlspecialchars($value_option['products_options_values_name']),
								//		'options_values_price' => $value_option['options_values_price']
								//	];
								
								//}
								//$itmes[$key_product]['options'] = $itemOption;
							}
							$subCategory[$key_two]['items']=$itmes;
						}
					}
					$category[$key_one]['subCategory'] = $subCategory;*/

					$product = $this->products($value_one['categories_id']);
					if(empty($product)){
						continue;
					}
					$itmes = array();
					foreach ($product as $key_product => $value_product) {
						$itmes[$key_product]=[
							'products_id' => $value_product['products_id'],
							'status' => (int)$value_product['products_status'],
							'products_name' => $this->normaliseUrlString($value_product['products_name']),
							'products_price' => $value_product['products_price'],
							'attributes' => array(),
							'products_quantity' => '1'
							//'products_description' => htmlspecialchars($value_product['products_description']),
							//'parent_id' => $value_product['master_categories_id']
						];
					}
					$category[$mykey]['menus_info']=[
						'menus_id' => $value_one['categories_id'],
						'status' => ($value_one['categories_status']==0 || $value_one['categories_status_app']==0 ) ? 0 : 1, //categories_status_app
						'manu_name' 	=> $this->normaliseUrlString($value_one['categories_name']),
						//'parent_id' 	=> $value_one['parent_id'],
						//'categories_description' 	=> $this->normaliseUrlString($value_one['categories_description']),
					];
					$category[$mykey]['products'] = $itmes;
					$mykey++;
				}
			}
			//$category = array_reduce($category, 'array_merge', array());
			/*echo "<pre>";
			print_r(array('menuInfo'=>$category));
			exit();*/
			return json_encode(!empty($category)?array('menuInfo'=>$category):array('no_menus'));
		}

		private function updateOrdersTrueHistory($admin_id,$orders_id,$orders_status_id){
		
			$admin_id=intval($admin_id);
			$orders_id=intval($orders_id);
			$orders_status_id=intval($orders_status_id);
			if($admin_id==0 || $orders_id==0 || $orders_status_id==0){
				return false;
			}
			$this->db->query("INSERT INTO orders_history (admin_id,orders_id,orders_status_id) VALUES ($admin_id,$orders_id,$orders_status_id)");
			return true;
		}
		private function notifyDriver($orders_id,$message){
			$admin_info = $this->db->query("select admin_phone,admin_phone_extension from admin where admin_id = (select orders_admin_id from orders where orders_id = $orders_id) ")->fetch(PDO::FETCH_ASSOC);
			if($admin_info==false){
				return;
			}
			//if(!isset($_SESSION['backup_config'])){
//				return;
//			}
			
			$send_to = $admin_info['admin_phone'].$admin_info['admin_phone_extension'];
			
			
			$admin_info = $this->db->query("select admin_phone,admin_phone_extension from admin where admin_id = (select orders_admin_id from orders where orders_id = $orders_id) ")->fetch(PDO::FETCH_ASSOC);
			if(true){
				$tmp = explode('@',$send_to);
				$sms_to=$tmp[0];
				$sms_message='Info- '.$message;
				include (__DIR__."/../../../aAsd23fadfAd2565Hccxz/includes/ringcentral/vendor/ringcentral/ringcentral-php/demo/sms.php");
			}else{
				mail($send_to,'Info- ',$message,'From: text@deliverhop.app');
			}
			  
		}
		
		private function syncDriverByOrderId($orders_id){
			$orders_id = intval($orders_id);
			if($orders_id < 1){
				return;
			}
			$send =  json_encode(array('key' => 'sync_driver_by_order_id','params'=>array('orders_id'=>$orders_id)));
			$ch = curl_init('https://deliverhop.app:3335/dispatch');
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$send);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			curl_exec($ch);
			return;
		}
		
		private function getTaxFromConfig(){
			if(!isset($this->primary_params['categories_id'])){
				return false;
			}
			$rest_config = $this->db->query("SELECT configuration from restaurant_configuration where categories_id=".$this->primary_params['categories_id'])->fetch(PDO::FETCH_ASSOC);
			$rest_config = json_decode($rest_config['configuration'],true);
			$tax_rate = is_numeric($rest_config['tax_rate']) ? $rest_config['tax_rate'] : 0.08375;
			$delivery_fee = is_numeric($rest_config['delivery_fee']) ? $rest_config['delivery_fee'] : 3.99;
			$active = isset($rest_config['delivery']['active']) ? $rest_config['delivery']['active'] : 0;
			$invoice = isset($rest_config['invoice']) ? $rest_config['invoice'] : 0;
			$payment_types = array('cash'=>$rest_config['delivery']['cash'],'credit'=>$rest_config['delivery']['credit'],'invoice'=>$invoice);
			return json_encode(array('tax_rate'=>$tax_rate,'delivery_fee'=>$delivery_fee,'active'=>$active,'payment'=>$payment_types));
		}
		private function logout(){
			if(!isset($this->primary_params['device_id'])){
				return false;
			}
			$device_id = $this->primary_params['device_id'];
			$this->db->query("update push_info set last_info_json='loggedoff', app_version='2' where device_id='$device_id' ");
			return json_encode(array('success'=>'true'));
			
		}
		private function resendOrder(){
			if(!isset($this->primary_params['orders_id'])){
				return false;
			}
			include (__DIR__."/../../../aAsd23fadfAd2565Hccxz/auto_send.php");
			$auto = new AutoSend;
			$auto->send($this->primary_params['orders_id'],false,false);
			return json_encode(array('success'=>'true'));
		}
		private function javaHttp(){
			if(!isset($this->primary_params['device_id'])){
				return false;
			}
			$device_id = $this->primary_params['device_id'];
			$this->db->query("update push_info set last_java_http=NOW(), app_version='2' where device_id='$device_id' ");
			
			//this is able to send push commands do not change from true
			return json_encode(array('success'=>'true'));
		}
		private function reverseSignalFlare(){
			if(!isset($this->primary_params['device_id'])){
				return false;
			}
			$device_id = $this->primary_params['device_id'];
			$this->db->query("update push_info set last_reverse_push_time=NOW(),reverse_push_json='Online', app_version='2' where device_id='$device_id' ");
			//this is able to send push commands do not change from true
			$ret=true;
			if($device_id=='1e7c60540e37a89b9a8186'){
				//$ret=false;
			}
			return json_encode(array('success'=>$ret,'device_id'=>$device_id,'command'=>'refreshPage'));
			
		}
		private function signalFlare(){
			$categories_id=intval($this->primary_params['categories_id']);
//			if($categories_id<1){
//				echo 'bad cat';
//				return false;
//			}
			if(!isset($this->primary_params['device_id'])){
				return json_encode(array('success'=>'No device id'));
			}
			
	
			$device_id = $this->primary_params['device_id'];
			$this->db->query("update push_info set last_info_time=NOW(),last_info_json='".addslashes(json_encode($this->primary_params['status']))."', app_version='2' where device_id='$device_id' ");
			return json_encode(array('success'=>true,'device_id'=>$device_id,'categories_id'=>$categories_id));
		}
		
		private function setConfig(){
			$categories_id=intval($this->primary_params['categories_id']);
			if($categories_id<1){
				return false;
			}
			$keys= array_keys($this->primary_params['state']);
			$arr=array();
			foreach($keys as $key){
				if(is_array($this->primary_params['state'][$key])){
					$arr[]=$key.'="'.addslashes(implode(',',$this->primary_params['state'][$key])).'"';
				}else{
					$arr[]=$key.'="'.addslashes($this->primary_params['state'][$key]).'"';	
				}
				
			}
			$str="UPDATE categories_description SET ".implode(',',$arr)." WHERE categories_id = $categories_id";

			$ret = $this->db->query($str);
			if(!$ret){
				return false;
			}else{
				return true;
			}
			
		}
		private function getConfig(){
			$this->primary_params=intval($this->primary_params);
			if($this->primary_params<1){
				return false;
			}
			$config_sql = 'SELECT send_method_code,email,fax,report_email,report_fax from categories_description where categories_id = '.$this->primary_params;
			$config = $this->db->query($config_sql)->fetch(PDO::FETCH_ASSOC);	
			foreach($config as $k=> &$c){
				if($k=='send_method_code'){
					continue;
				}
				if(strpos($c,',')!== FALSE){
					$c = explode(',',$c);
				}else{
					if($c==''){
						$c=array();
					}else{
						$c=array($c);
					}
						
				}
			}
			return json_encode($config);
		}
		public function emailCsv($csvData, $body, $to = 'zachfagerness@gmail.com', $subject = 'CSV Sales Report', $from = 'noreply@deliverhop.app') {

			// This will provide plenty adequate entropy
			$multipartSep = '-----'.md5(time()).'-----';
		
			// Arrays are much more readable
			$headers = array(
				"From: $from",
				"Reply-To: $from",
				"Content-Type: multipart/mixed; boundary=\"$multipartSep\""
			);
			
			
			//array to csv
			$csv='';
			$keys = array_keys($csvData[0]);
			foreach($csvData as $c){
				$innercsv=array();
				foreach($keys as $key){
					$innercsv[]=$c[$key];
				}
				$csv.=implode(',',$innercsv)."\n";
			}
			foreach($keys as &$key){
					switch($key){
						case 'orders_id':$key='Orders Id';break;
						case 'date_deliver':$key='Date';break;
						case 'order_total':$key='Total';break;
					}
			}
			$csv=implode(',',$keys)."\n".$csv;
			//
			
			$filename='SalesReport_'. date("m_d_Y");
			$attachment = chunk_split(base64_encode($csv)); 
			// Make the body of the message
			$body = "--$multipartSep\r\n"
				. "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
				. "Content-Transfer-Encoding: 7bit\r\n"
				. "\r\n"
				. "$body\r\n"
				. "--$multipartSep\r\n"
				. "Content-Type: text/csv\r\n"
				. "Content-Transfer-Encoding: base64\r\n"
				. "Content-Disposition: attachment; filename=\"$filename.csv\"\r\n"
				. "\r\n"
				. "$attachment\r\n"
				. "--$multipartSep--";
		
			// Send the email, return the result
			return @mail($to, $subject, $body, implode("\r\n", $headers)); 
		
		}
		private function pickupComplete(){
			$this->db->query(' UPDATE orders set orders_status=13 where orders_id ='.$this->primary_params['orders_id'].' ');
			$this->db->query("INSERT INTO orders_status_history ( orders_id,orders_status_id, date_added, customer_notified, comments, updated_by) VALUES ( ".(int)$this->primary_params['orders_id'].", 13, now(), '0', NULL, 'Restaurant')");
			//$this->sendPush($this->primary_params['orders_id'],array('key'=>'syncOrder','params'=>true));
			$cats_admin_id = $this->db->query("select a.admin_id from admin as a inner join orders as o on o.categories_id = a.categories_id where o.orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
			$this->zupplerOrderUpdateStatusbyAdmin($this->primary_params['orders_id'],13,$cats_admin_id);
			$this->updateOrdersTrueHistory($cats_admin_id,$this->primary_params['orders_id'],13);
			return json_encode(array('success'=>'true'));
		}
		private function acceptMultipleOrder(){
			$orders_ids = $this->primary_params['orders_id'];
			if(!empty($orders_ids) && is_array($orders_ids)){
				foreach($orders_ids as $key => $order_id){
					$this->primary_params['orders_id'] = intval($order_id);
					$this->primary_params['eta'] = intval($this->primary_params['eta']);
					if($this->primary_params['orders_id'] < 1){
						return false;
					}
					$cats_admin_id = $this->db->query("select a.admin_id from admin as a inner join orders as o on o.categories_id = a.categories_id where o.orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
					$is_pickup = $this->db->query("select pickup_order from orders where orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
					
					if($is_pickup==1){
						$ex =' and orders_status in (1,2,5,7) ';
					}else{
						$ex= ' AND orders_admin_id !=0  and orders_status in (2,5,7)  ';
					}
					
					$id_sql = "
					SELECT oh.orders_id
					FROM orders_status_history AS oh
					INNER JOIN orders AS o ON o.orders_id = oh.orders_id
					WHERE orders_status_id
					IN ( 2 )
					AND orders_status_id 
					NOT IN ( 4 )
					and date_deliver > '".date('Y-m-d 00:00:00')."'
					AND categories_id = (select categories_id from orders where orders_id=".$this->primary_params['orders_id'].")
					$ex
					LIMIT 0 , 9999";
					
					$ord = $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
					$ord  = array_unique(array_values($ord));
					$this->db->query(' UPDATE orders set restaurant_eta='.$this->primary_params['eta'].',orders_status=4,last_modified=NOW() where orders_id in ('.implode(',',$ord).') ');
					
					//NEED TO STILL ACCEPT
					foreach($ord as $order){
						$this->updateOrdersTrueHistory($cats_admin_id,$this->primary_params['orders_id'],4);
						$this->db->query("INSERT INTO orders_status_history ( orders_id,orders_status_id, date_added, customer_notified, comments, updated_by) VALUES ( ".(int)$order.", 4, now(), '0', NULL, 'Restaurant')");
					}
					
					$push['msg'] = 'Order #'.$this->primary_params['orders_id'].' has restaurant confirm';
					$push['tag'] = 'update_status';
					$push['value'] = 4;
					$this->sendPushNotificationsDriver($this->primary_params['orders_id'],$push,false);
					//$push_suc = $this->sendPush($this->primary_params['orders_id'],array('key'=>'secondTabletAccept','params'=>true));
					$push_suc = true;
					$this->syncDriverByOrderId($this->primary_params['orders_id']);
				}
			}
			return json_encode(array('success'=>$push_suc,'orders_id' => $orders_ids));
		}
		private function acceptOrder(){
			//do db stuff here
			$this->primary_params['orders_id']=intval($this->primary_params['orders_id']);
			$this->primary_params['eta']=intval($this->primary_params['eta']);
			if($this->primary_params['orders_id']<1){
				return false;
			}
			$cats_admin_id = $this->db->query("select a.admin_id from admin as a inner join orders as o on o.categories_id = a.categories_id where o.orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
			$is_pickup = $this->db->query("select pickup_order from orders where orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
			
			if($is_pickup==1){
				$ex =' and orders_status in (1,2,5,7) ';
			}else{
				$ex= ' AND orders_admin_id !=0  and orders_status in (2,5,7)  ';
			}
			
			$id_sql = "
			SELECT oh.orders_id
			FROM orders_status_history AS oh
			INNER JOIN orders AS o ON o.orders_id = oh.orders_id
			WHERE orders_status_id
			IN ( 2 )
			AND orders_status_id 
			NOT IN ( 4 )
			and date_deliver > '".date('Y-m-d 00:00:00')."'
			AND categories_id = (select categories_id from orders where orders_id=".$this->primary_params['orders_id'].")
			$ex
			LIMIT 0 , 9999";
			
			$ord = $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
			$ord  = array_unique(array_values($ord));
			$this->db->query(' UPDATE orders set restaurant_eta='.$this->primary_params['eta'].',orders_status=4,last_modified=NOW() where orders_id in ('.implode(',',$ord).') ');
			
			//NEED TO STILL ACCEPT
			foreach($ord as $order){
				$this->updateOrdersTrueHistory($cats_admin_id,$this->primary_params['orders_id'],4);
				$this->db->query("INSERT INTO orders_status_history ( orders_id,orders_status_id, date_added, customer_notified, comments, updated_by) VALUES ( ".(int)$order.", 4, now(), '0', NULL, 'Restaurant')");
			}
			
			//$push_suc = $this->sendPush($this->primary_params['orders_id'],array('key'=>'playSound','params'=>false));
			$push['msg'] = 'Order #'.$this->primary_params['orders_id'].' has restaurant confirm';
			$push['tag'] = 'update_status';
			$push['value'] = 4;
			$this->sendPushNotificationsDriver($this->primary_params['orders_id'],$push,false);
			//$push_suc = $this->sendPush($this->primary_params['orders_id'],array('key'=>'secondTabletAccept','params'=>true));
			$push_suc = true;
			
			$this->syncDriverByOrderId($this->primary_params['orders_id']);
			
			
			return json_encode(array('success'=>$push_suc,'orders_id'=>$this->primary_params['orders_id']));
		}
		public function checkNewOrder(){
			//echo 'test';
			
			$this->primary_params=intval($this->primary_params);
			$is_pickup = $this->db->query("select pickup_order from orders where orders_id = ".$this->primary_params)->fetch(PDO::FETCH_COLUMN);
			
			if($is_pickup==1){
				$ex =' and orders_status in (1,2,5) ';
			}else{
				$ex= ' AND orders_admin_id !=0  and orders_status in (2,5)  ';
			}
			//do db stufff here
			$id_sql = "
			SELECT oh.orders_id
			FROM orders_status_history AS oh
			INNER JOIN orders AS o ON o.orders_id = oh.orders_id
			WHERE orders_status_id
			IN ( 2 )
			AND orders_status_id 
			NOT IN ( 4 )
			and date_deliver > '".date('Y-m-d 00:00:00')."'
			AND categories_id = (select categories_id from orders where orders_id=".$this->primary_params.")
			$ex
			LIMIT 0 , 9999";
			
			$ord = $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
			
			$ord  = array_values(array_unique(array_values($ord)));
			//print_r($ord);
			$ord[]=$this->primary_params;
			$ord = array_unique($ord);
			//die;
			return json_encode(array('success'=>true,'orders_id'=>$ord));
		}
		
		private function addNote(){
			$orders_id = intval($this->primary_params['orders_id']);
			$note = addslashes($this->primary_params['note']);
			if($orders_id<1){
				return false;	
			}
			$insert_sql = "
			INSERT INTO notes( order_id, note_type, note, timestamp, made_by )
			VALUES ( $orders_id, '1', '$note', NOW() , (
			SELECT a.admin_id
			FROM admin AS a
			INNER JOIN orders AS o ON o.categories_id = a.categories_id
			WHERE orders_id=$orders_id
			LIMIT 1
			) ) ";
			$this->db->query($insert_sql);
			$push['msg'] = 'Order #'.$orders_id.' has a new note';
			$push['tag'] = 'add_note';
			$push['value'] = $this->primary_params['note'];
			$this->sendPushNotificationsDriver($orders_id,$push);
			$this->notifyDriver($orders_id,'Order #'.$orders_id.' has a new note: '.$this->primary_params['note']);
			return true;
		}
		private function adjust($orders_id,$adjust){
							//ini_set('display_errors',true);
							$orders_id=intval($orders_id);
							$adjust=floatval($adjust);
							if($orders_id==0 || $adjust ==0){
								return false;
							}
							$total_check = $this->db->query("SELECT orders_total FROM adjust_totals WHERE orders_id = $orders_id")->fetch(PDO::FETCH_ASSOC);	
							if($total_check==false){
								$this->db->query("INSERT INTO adjust_totals (orders_id,orders_total) VALUES ($orders_id,0)");
							}
							$this->db->query("UPDATE adjust_totals SET orders_total = orders_total + $adjust WHERE orders_id = $orders_id");
		}
		private function addCharge(){
				
			$totals = $this->db->query("select * from orders_total where orders_id=".$this->primary_params['orders_id'])->fetchAll(PDO::FETCH_ASSOC);
			foreach($totals as $t){
				$new_total[$t['class']]=$t;
			}
			$tax_sql = 'select products_tax from orders_products  where orders_id='.$this->primary_params['orders_id'].' and products_tax > 0 limit 0,1';
			$rate=$this->db->query($tax_sql)->fetch();
			$rate=$rate['products_tax']/100;
  
			$method=$this->db->query("select payment_method from orders where orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
			//subtract tax & subtotal from total
			// calc subtotal and then tax(subtotal+delivery fee)
			// add tax & subtotal to total
			//update orders_total tax,subtotal,total,  orders orders_total, orders_tax
			$total = $new_total['ot_total']['value'];
			$original_total  = $total ;
			$tax = $new_total['ot_tax']['value'];
			$subtotal = $new_total['ot_subtotal']['value'];
			$delivery = $new_total['ot_shipping']['value'];
			$ot_loworderfee =0;
			if(isset($new_total['ot_loworderfee'])){
				$ot_loworderfee = floatval($new_total['ot_loworderfee']['value']);
			}
			
			$total=$total-$subtotal-$tax;
			
			
			if($this->primary_params['type']=='plus'){
				$type="+";
				$subtotal=$subtotal+floatval($this->primary_params['adjustment']);
			}else if($this->primary_params['type']=='minus'){
				$type="-";
				$subtotal=$subtotal-floatval($this->primary_params['adjustment']);
			}
			
			$tax=($subtotal+$delivery+$ot_loworderfee)*$rate;
			$total=$total+$tax+$subtotal;
			
			$spin=array('ot_total'=>$total,'ot_tax'=>$tax,'ot_subtotal'=>$subtotal);
			foreach($new_total as $key=>$value){
				switch($key){
					case 'ot_total':
					case 'ot_tax':
					case 'ot_subtotal':
					$update_total='update orders_total set text="'.money_format('$%i',$spin[$key]).'", value='.$spin[$key].' where orders_total_id='.$value['orders_total_id'];
					$this->db->query($update_total);
  
					break;
				}
			}
			$orders_table = "update orders set order_total=".$total.",order_tax=".$tax.",orders_price_changed=1 where orders_id =".$this->primary_params['orders_id'];
			$this->db->query($orders_table);
			$note_insert="INSERT INTO notes (order_id,note,timestamp,made_by,note_type) values (:order_id,:note,NOW(),(
			SELECT a.admin_id
			FROM admin AS a
			INNER JOIN orders AS o ON o.categories_id = a.categories_id
			WHERE orders_id=:order_id
			LIMIT 1
			),:note_type)";
			$note = $this->db->prepare($note_insert);
			$note->bindValue(':order_id',$this->primary_params['orders_id'], PDO::PARAM_INT);
			$note->bindValue(':note',$method.' adjustment '.$type.' $'.round(floatval($this->primary_params['adjustment']),2).' '.$this->primary_params['note'], PDO::PARAM_STR);
			$note->bindValue(':note_type',1, PDO::PARAM_INT);
			//$note->bindValue(':made_by',999, PDO::PARAM_INT);
			$note->execute();
			$this->adjust($this->primary_params['orders_id'],floatval($total)-floatval($original_total));
			
			$push['msg'] = 'Order #'.$this->primary_params['orders_id'].' has had its price adjusted '.$type.'$'.round(floatval($this->primary_params['adjustment']),2);
			$push['tag'] = 'price_change';
			$push['value'] = round(floatval($this->primary_params['adjustment']),2);
			$this->sendPushNotificationsDriver($this->primary_params['orders_id'],$push);

			$this->notifyDriver($this->primary_params['orders_id'],'Order #'.$this->primary_params['orders_id'].' has had its price adjusted '.$type.'$'.round(floatval($this->primary_params['adjustment']),2));
			$this->zuppler_order_update_total($this->primary_params['orders_id']);
			return true;
		}
		
		public function zuppler_order_update_total($order_id=0){
			$query = $this->db->query(
				'SELECT `zuppler_order_uid`, `payment_module_code`, `shipping_method` FROM orders ' .
				'WHERE `orders_id`=\'' . (int)$order_id . '\' '
			)->fetch(PDO::FETCH_ASSOC);
					
			if(!empty($query)) {	
				if (
					$query['zuppler_order_uid'] != '' 
						&& 
					in_array($query['payment_module_code'], array('invoice', 'cod', 'braintree_api'))
						&& 
					$query['shipping_method'] == 'Delivery'
				) {
		            
		            $queryTotal = $this->db->query(
        				'SELECT `class`, `value` FROM orders_total ' .
        				'WHERE `orders_id`=\'' . (int)$order_id . '\' '
        			)->fetchAll(PDO::FETCH_ASSOC);
        			
        			$order_total= 0; 
        			$gratuty = 0;
        			$orderTotal=0;
        			$arrayLength = count($queryTotal);
        			$i = 0;
        			while ($i < $arrayLength){
        				if ($queryTotal[$i]['class']=='ot_total') {
        					$orderTotal = $queryTotal[$i]['value'];
        				}
        				if ($queryTotal[$i]['class'] == 'ot_tip') {
        					$gratuty = $queryTotal[$i]['value'];
        				}
        
        				//$this->writeRequestResponseLog($queryTotal[$i]);
                        $i++;
        			}
        			
        			$order_total=$orderTotal-$gratuty;
		
					$url = 'http://posaas.zuppler.com/webhooks/adjustments';
					$post = array
					(
						  'orderInfo'  => array( 'uuid' => $query['zuppler_order_uid'] ),
						  'payments'   => array(
							array(
								"tip" => $gratuty,
								"amount" =>$order_total
							)
						  )
					);
		
					$headers = array
					(
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
					
					file_put_contents('zupplerapplog.txt', json_encode(array($result, $post, $orderTotal, $gratuty)));
		
					if ( curl_errno( $ch ) ) {
					  $zupplerError = curl_error( $ch ); 
					  eo_log('Zuppler order update error: '.$zupplerError);
					} else {
						$me = $_SESSION['admin_id'];
						$sql = "INSERT INTO notes (order_id,note_type,note,made_by,admin_id,timestamp) values('".(int)$order_id."','5','Zuppler Response:".$result."','".$me."','".$me."',now())";
						$this->db->query($sql);
						file_put_contents('zupplerApplog3.txt', json_encode(array($result, $post, $orderTotal, $gratuty)));
					}
					curl_close( $ch );	
				}
			}
		}

		public function writeAppRequestResponseLog($data)    {        
       
			$apiLog = fopen("admin-log-ykp.txt", "a+");    
			
			$text = "\n\n\n**************************************************************************************************\n";
			$text .= '"Date":'.date('Y-m-d H:i:s')."\n";            
			$text .= json_encode($data);     
				   
			//$text .= $data;        
			fwrite($apiLog, $text);   
			  
			fclose($apiLog);    
		}
		
		private function reportData(){
		
			
		$start = $this->primary_params[0];
		$end = $this->primary_params[1];
		$categories_id = $this->primary_params[2];
		$pord = $this->primary_params[3];
		if($pord=='pickup'){
			$pord=1;
		}else{
			$pord=0;
		}
		if($start==0 || $end==0){
			$start = date('Y-m-d 00:00:00');
			$end = date('Y-m-d 23:59:59');
		}else{
			$start = date($start.' 00:00:00');
			$end = date($end.' 23:59:59');
		}
		$reportTable = $this->db->query("SELECT o.orders_id,date_deliver,value as order_total  from orders as o inner join orders_total as ot on ot.orders_id = o.orders_id WHERE date_deliver  > '$start' AND date_deliver < '$end' and categories_id = $categories_id and pickup_order=$pord and orders_status in (10,13) and class='ot_subtotal' ")->fetchAll(PDO::FETCH_ASSOC);
		
		$beverageTable = $this->db->query("SELECT sum(products_price * products_quantity) as bev,o.orders_id from orders as o inner join orders_products as op on op.orders_id=o.orders_id WHERE date_deliver  > '$start' AND date_deliver < '$end' and categories_id = $categories_id and pickup_order=$pord and orders_status in (10,13) and op.products_model in ('BEVERAGE') group by o.orders_id")->fetchAll(PDO::FETCH_ASSOC);
		
		$miscTable = $this->db->query("SELECT sum(final_price * products_quantity) as bev,o.orders_id from orders as o inner join orders_products as op on op.orders_id=o.orders_id WHERE date_deliver  > '$start' AND date_deliver < '$end' and categories_id = $categories_id and pickup_order=$pord and orders_status in (10,13) and op.products_model = 'FOODDUDEMISC' group by o.orders_id")->fetchAll(PDO::FETCH_ASSOC);
		
		
		
		$new_misc=array();
		foreach($miscTable as $mi){
			$new_misc[$mi['orders_id']] = floatval($mi['bev']);
		}
		
		$new_bev=array();
		foreach($beverageTable as $bt){
			$new_bev[$bt['orders_id']]=floatval($bt['bev']);
		}
		$tot=0;
		foreach($reportTable as &$rt){
			
			if(array_key_exists($rt['orders_id'],$new_bev)){
				$bev=floatval($new_bev[$rt['orders_id']]);
			}else{
				$bev= 0;	
			}
			
			if(array_key_exists($rt['orders_id'],$new_misc)){
				$misc=floatval($new_misc[$rt['orders_id']]);
			}else{
				$misc= 0;	
			}
			$rt['date_deliver']=date('m/d/y g:ia',strtotime($rt['date_deliver']));
			$rt['order_total']=money_format('%i',floatval($rt['order_total'])-$bev-$misc);
			$tot+=$rt['order_total'];
		}
		array_unshift($reportTable,array('orders_id'=>'','date_deliver'=>'Grand Total: ','order_total'=>money_format('%i',$tot)));
//		$date_search = strtotime($start)<1430456400 ? 'date_purchased' : 'date_deliver';
//		$where= " WHERE $date_search  > '$start' AND $date_search < '$end' ";
//		$chart_sql = "
//		SELECT orders_id,$date_search as date_deliver
//		FROM orders
//		$where
//		AND categories_id in($categories_id)
//		order by $date_search
//		LIMIT 0 , 999999";
		

		$epochLength = strtotime($end)-strtotime($start);
		$new_chart_data=array();
		$labels=array();
		$vals=array();
		
		$test='';
		//print_r($chart_data);
		if($epochLength <= 86400){
			$test='day';
		//day 
			  $chart_sql = "SELECT day( date_deliver ) AS
			  day , hour( date_deliver ) AS hour , count( * ) AS cou
			  FROM orders
			  WHERE date_deliver > '$start'
			  AND date_deliver < '$end'
			  AND categories_id in($categories_id)
			  AND pickup_order=$pord
			  AND orders_status in (10,13)
			  GROUP BY day( date_deliver ) , hour( date_deliver ) ";
			  $chart_data =  $this->db->query($chart_sql)->fetchAll(PDO::FETCH_ASSOC);
			  if(count($chart_data)>0){
				for($i=$chart_data[0]['hour']-1;$i<24;$i++){
					$val=0;
					foreach($chart_data as $c){
						if($i==$c['hour']){
							$val=$c['cou'];
						}
					}
					$labels[]=date('g:ia',strtotime($this->primary_params[0].' '.$i.':00:00'));
					$vals[]=intval($val);
				}
			  }
		}else if($epochLength <= 604800){
			$test='week';
		//week
		$startday=date('j',strtotime($start));
		$endday=date('j',strtotime($end));
		
			  $chart_sql = "SELECT day( date_deliver ) AS
			  day , count( * ) AS cou
			  FROM orders
			  WHERE date_deliver > '$start'
			  AND date_deliver < '$end'
			  AND categories_id in($categories_id)
			  AND pickup_order=$pord
			  AND orders_status in (10,13)
			  GROUP BY day( date_deliver ) ";
			  $chart_data =  $this->db->query($chart_sql)->fetchAll(PDO::FETCH_ASSOC);
			  $z=0;
			  for($i=$startday;$i<=$endday;$i++){
				 
				  $val=0;
				  foreach($chart_data as $c){
					 
					  if($i==$c['day']){
						  $val=$c['cou'];
					  }
				  }
				  $labels[]=date('m/d',strtotime($this->primary_params[0].' 00:00:00' )+(86400*$z));
				  $vals[]=intval($val);
				  $z++;
			  }
			
		}else if($epochLength <= 2678420){
			$test='month';
		//month//
		$startday=date('j',strtotime($start));
		$endday=date('j',strtotime($end));
			//$num_days = $epochLength/86400;
			$chart_sql = "SELECT day( date_deliver ) AS
			day , count( * ) AS cou
			FROM orders
			WHERE date_deliver > '$start'
			AND date_deliver < '$end'
			AND categories_id in($categories_id)
			AND pickup_order=$pord
			AND orders_status in (10,13)
			GROUP BY day( date_deliver ) ";
			$chart_data =  $this->db->query($chart_sql)->fetchAll(PDO::FETCH_ASSOC);
			
			$z=0;
			for($i=$startday;$i<$endday;$i++){
				$val=0;
				foreach($chart_data as $c){
					//echo $i.'='.$c['day'].'--';
					if($i==$c['day']){
						$val=$c['cou'];
					}
				}
				//$labels[]=date('m/d',strtotime($this->primary_params[0].' 00:00:00' )+(86400*$z));
				//$vals[]=intval($val);
				$z++;
			}

		}else if($epochLength <= 31622400 ){
			$test='lolwtf';

		}
		$new_chart_data=array('labels'=>$labels,'values'=>$vals);
		//print_r(json_encode($new_chart_data ));
		return json_encode(array('test'=>$test,'tableData'=>$reportTable,'chartData'=>$new_chart_data ));
		//[0]=>array(string,string),[1]=>array(3,5);
		}
		private function pastOrders(){
			$cat_id=intval($this->primary_params['categories_id']);
			$search_id=intval($this->primary_params['search_id']);
			
			if($search_id==0){
				$start = date($this->primary_params['start'].' 00:00:00');
				$end = date($this->primary_params['end'].' 23:59:59');
				$id_sql = "
				SELECT o.orders_id
				FROM orders as o 
				WHERE date_deliver > '$start'
				AND date_deliver < '$end'
				AND categories_id = $cat_id
				AND orders_status in (10,13,8)
				LIMIT 0 , 99999";	
				$orders_id_list =  $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
			}else{
				$orders_id_list =  $this->db->query("select orders_id from orders where orders_id = $search_id and  categories_id = $cat_id")->fetch();
			}
			
			if($orders_id_list==false || count($orders_id_list)===0){
				echo json_encode(array('no_orders'));
				die;	
			}
			$orders_id_list= array_values($orders_id_list);
			
			return json_encode($this->getOrder($orders_id_list,$cat_id));
		}
		
		
		private function currentOrders(){
			$today = date('Y-m-d 00:00:00');
			$tonight = date('Y-m-d 23:59:59');
			$id_sql = "
			SELECT oh.orders_id
			FROM orders_status_history AS oh
			INNER JOIN orders AS o ON o.orders_id = oh.orders_id
			WHERE orders_status_id
			IN ( 2 )
			AND orders_status NOT
			IN ( 8, 10, 6, 9, 13 )
			AND date_deliver > '$today'
			AND date_deliver < '$tonight'
			AND categories_id = $this->primary_params
			LIMIT 0 , 9999";	
			//return json_encode([$id_sql]);
			$orders_id_list =  $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
			if(count($orders_id_list )===0){
				echo json_encode(array('no_orders'));
				die;	
			}
			$orders_id_list= array_values($orders_id_list);
			
			return json_encode($this->getOrder($orders_id_list,$this->primary_params));
		}
		
		
		
		private function futureOrders(){
			$today = date('Y-m-d 00:00:00');
			$id_sql = "
			SELECT o.orders_id
			FROM orders AS o
			WHERE orders_status 
			IN (  9 )
			AND date_deliver > '$today'
			AND categories_id = $this->primary_params
			LIMIT 0 , 999";	
			$orders_id_list =  $this->db->query($id_sql)->fetchAll(PDO::FETCH_COLUMN);
			if(count($orders_id_list )===0){
				echo json_encode(array('no_orders'));
				die;	
			}
			$orders_id_list= array_values($orders_id_list);
			
			return json_encode($this->getOrder($orders_id_list,$this->primary_params));
		}
		

		private function sendPush($orders_id,$push){
			$push_sql="SELECT device_id FROM push_info AS p inner join orders AS o ON o.categories_id = p.categories_id WHERE o.orders_id = $orders_id"; // AND last_info_json!='loggedoff'
			$push_info= $this->db->query($push_sql)->fetchAll(PDO::FETCH_COLUMN);
			if(!$push_info){
				return false;
			}
			$push_info=array_values($push_info);
			
			// $apiKey = 'bb3cc6dfc39536504a013208810eb2c2b774cc39657c2b114805ae827e1e29db';
			$apiKey = '579fe3f9ac99145d7bf6a548878bdc97e8fa798b8684aaaf52b97333821c2e77';
			$url = 'https://api.pushy.me/push?api_key=' . $apiKey;
			$post = array
			(
				'registration_ids'  => $push_info,
				// 'data'              => array('json_link'=>json_encode($push)),
				'data'              => array(
					// 'json_link'=>json_encode($push),
			        "title" => "Food Dudes", // Notification title
			        "message" => "Hello, Please check order status.", // Notification body text
			        "url" => "https://deliverhop.app" // Opens when clicked
			      ),
			    'time_to_live' => 1800
			);
			$headers = array
			(
				'Content-Type: application/json'
			);
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
			$result = curl_exec( $ch );
			if ( curl_errno( $ch ) )
			{
				//echo curl_error( $ch );
				return false;	
			}
			curl_close( $ch );
			//print_r($result);	
			return true;
			
		}
		function sendPushNotificationsDriver($orders_id, $push=array('msg'=>'','tag'=>"new_order","value"=>""), $popupType = true){	 		

	 		$info_sql = 'select c.categories_id,c.base_city,o.date_deliver,o.date_purchased,c.categories_name,c.address,c.phone, o.orders_admin_id from categories_description as c inner join orders as o on o.categories_id= c.categories_id where o.orders_id="'.$orders_id.'"';			
			$info = $this->db->query($info_sql)->fetch(PDO::FETCH_ASSOC);
			$reestaurantInfo = array(
			'categories_name'=>$info['categories_name'],
			'base_city'=>$info['base_city'],
			'date_purchased'=>$info['date_purchased'],
			'date_deliver'=>$info['date_deliver'],
			'categories_id'=>$info['categories_id'],
			'address'=>$info['address'],
			'phone'=>$info['phone']);

			

			$push_sql = "SELECT device_id, admin_display_name FROM admin WHERE admin_id = '".$info['orders_admin_id']."'";			
			$push_info_sql= $this->db->query($push_sql)->fetchAll(PDO::FETCH_ASSOC);
			$push_info=array();
			$adminDisplayName = '';

			foreach ($push_info_sql as $key => $value) {
				$push_info[]=$value['device_id'];
				$adminDisplayName = $value['admin_display_name'];				
			}			
			if(empty($push_info)){
				return true;
			}
			$push_info[]='1423eb4d3acb3d81999e11';
			
			// $apiKey = 'bb3cc6dfc39536504a013208810eb2c2b774cc39657c2b114805ae827e1e29db';
			$apiKey = '579fe3f9ac99145d7bf6a548878bdc97e8fa798b8684aaaf52b97333821c2e77';
			$url = 'https://api.pushy.me/push?api_key=' . $apiKey;
			if($push['tag']=='new_order'){
				$msg = "Hello $adminDisplayName, You have receive a new order";
				$soundName = "coinMultiple.mp3";
			}else{
				$msg = $push['msg'];
				$soundName = "coin.mp3";
			}

			if($popupType){ //non slient notification
				$post = array
				(
					'registration_ids'  => $push_info,
					'data'              => array(
						// 'json_link'=>json_encode($push),
				        "title" => "Food Dudes",
				        "order_id" => $orders_id,
				        "restaurant_info" => $reestaurantInfo, 
				        "tag" => $push['tag'],
				        "value" => (string)$push['value'],
				        "message" => $msg,
				        "url" => "https://deliverhop.app" // Opens when clicked
				      ),
				      "notification"=> array(
				        "body"=> $msg,
				        "badge"=> 1,
				        "sound"=> $soundName
				      ),
				      'time_to_live' => 1800
				);
			}else{ // slient notification
				$post = array
				(
					'registration_ids'  => $push_info,
					'data'              => array(				
				        "title" => "Food Dudes",
				        "order_id" => (string)$orders_id,
				        "restaurant_info" => $reestaurantInfo,
				        "tag" => $push['tag'],
				        "value" => (string)$push['value'],
				        "message" => $push['msg'],
				        "url" => "https://deliverhop.app" // Opens when clicked
				      ),
				      "notification"=> array(
				        "body"=> "",		        
				        "sound"=> ""		        
				      ),
				      "content_available"=> true,
				      'time_to_live' => 1800
				);
			}
			

			$headers = array
			(
				'Content-Type: application/json'
			);
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );
			$result = curl_exec( $ch );
			//print_r($result); exit;
			if ( curl_errno( $ch ) )
			{
				return false;
				
			}
			curl_close( $ch );
			return true;
		}
		private function zupplerOrderUpdateStatusbyAdmin($order_id=0,$order_status=0,$res_admin_id){
      
	      $order_s = 'SELECT zuppler_order_uid, payment_module_code, shipping_method FROM orders WHERE orders_id =' . (int)$order_id;
	      $order_data =  $this->db->query($order_s)->fetch(PDO::FETCH_ASSOC);     
	      
	      if(!empty($order_data['zuppler_order_uid'])){

	        $url = 'http://posaas.zuppler.com/webhooks/update_status';
	          $post = array
	          (
	              'zuppler_order_uid'  => $order_data['zuppler_order_uid'],
	              'order_status'  => (int)$order_status
	          );

	          $headers = array
	          (
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

	          if ( curl_errno( $ch ) )
	          {
	            // echo 
	            $zupplerError = curl_error( $ch ); 
	            eo_log('Zuppler order update error: '.$zupplerError);
	            // exit;
	          }else{
	            $me = $res_admin_id;
	            $sql = "INSERT INTO notes (order_id,note_type,note,made_by,admin_id,timestamp) values('".(int)$order_id."','4','Zuppler Response:".$result."','".$me."','".$me."',now())";          
	          $this->db->query($sql);
	          //file_put_contents('zupplerlog3.txt', json_encode(array($result, $post)));
	          }
	          curl_close( $ch );          
	      }
	    }
		public function getOrder($orders_id_list,$categories_id){
		  $orders_id_string = implode(',',$orders_id_list);
		  $orders_sql = 'SELECT duration_to_deliver,payment_method,payment_module_code,orders_status,cash_order, categories_id, customers_id, customers_lat, customers_lng, customers_name, customers_telephone, date_deliver, date_purchased, delivery_city, delivery_company, delivery_country, delivery_name, delivery_postcode, delivery_state, delivery_street_address, delivery_suburb, distance_to_deliver, duration_to_deliver, last_modified, orders_id, orders_status, order_total, payment_module_code, updated_from_dispatched, updated_from_future
		  ,pickup_order FROM orders as o where o.orders_id in ('.$orders_id_string.') order by date_deliver desc';
		  
		  //b
		  $orders_products_sql='SELECT op.onetime_charges,op.orders_products_id,op.orders_id,op.products_name, op.products_price, op.products_quantity from orders_products as op inner join orders as o on o.orders_id = op.orders_id where o.orders_id in ('.$orders_id_string.') and op.products_model !="BEVERAGE"';
		  
		  //c
		  $orders_total_sql='select orders_id,value from orders_total where class="ot_subtotal" and orders_id in ('.$orders_id_string.')';
		  
		  //d
		  $orders_products_attributes_sql='select orders_products_id,orders_id,options_values_price,price_prefix,products_options, products_options_values from orders_products_attributes where orders_id in ('.$orders_id_string.')';
		  
		  //e
		  $note_array=array();
		  //$this->get_note_array($new_difference);
		  $orders_notes = array();//$this->note_array;
		  $orders_notes_sql = $this->db->query('select * from notes where note_type in (1,4) and order_id in ('.$orders_id_string.')')->fetchAll(PDO::FETCH_ASSOC);
		  //f
		  $orders_restaurant_adjustment_sql='select orders_id,value from orders_total where class="ot_restaurant_adjustment" and orders_id in ('.$orders_id_string.')';
		  
		  
		 $orders_total_n = $this->db->query('select value,orders_id from orders_total where class="ot_subtotal" and orders_id in ('.$orders_id_string.')')->fetchAll(PDO::FETCH_ASSOC);
		  $new_sub=array();
		  foreach($orders_total_n as $ot){
			  $new_sub[$ot['orders_id']]=$ot['value'];
			  
		  }

		 // if(in_array(148283,$orders_id_list)){
			  //print_r( );
			 // die;
		  //}
		  
		  $final_react = array();
		  
		  foreach($orders_notes_sql as $on){
			  $orders_notes[$on['order_id']][]=$on['note'];
		  }
		  //BOF sql looping to array
		  
				  try{
				  $d = $this->db->query($orders_products_attributes_sql);
				  $orders_products_attributes=array();
				  foreach ($d as $dx){
						  $orders_products_attributes[$dx['orders_products_id']][]=array(
							  'products_options'=>utf8_encode($dx['products_options']), 
							  'price_prefix'=>$dx['price_prefix'], 
							  'options_values_price'=>round($dx['options_values_price'],2), 
							  'products_options_values'=>utf8_encode($dx['products_options_values']));
			  
				  }
			  }catch(Exception $e){
				  print_r($e->getMessage().' Error at sql d in restaurant_table');
			  }
			  
			  try{
				  $b = $this->db->query($orders_products_sql);
				  $orders_products=array();
				  foreach ($b as $bx){
			  
						  $orders_products[$bx['orders_id']][]=
						  array('products_name'=>utf8_encode($bx['products_name']),
								'orders_products_id'=>$bx['orders_products_id'],
								'products_quantity'=>$bx['products_quantity'],
								'onetime_charges'=>$bx['onetime_charges'],
								'products_price'=>round($bx['products_price'],2),
							'attributes'=>array_key_exists($bx['orders_products_id'],$orders_products_attributes)? $orders_products_attributes[$bx['orders_products_id']] : array()  );
			  
				  }
			  }catch(Exception $e){
				  print_r($e->getMessage().' Error at sql b in restaurant_table');
			  }
			  
			  $history = $this->db->query('select orders_id from orders_status_history where orders_id in ('.$orders_id_string.') and orders_status_id=4')->fetchAll(PDO::FETCH_COLUMN);
			  //echo 'select orders_status_id from orders_status_history where orders_id in ('.$orders_id_string.') and orders_status_id=4';
			  $new_history = array();
		  
			  foreach($orders_id_list as $his){
				  
				  if(!in_array($his,$history)){
					  $new_history[$his]=true;
				  }else{
					  $new_history[$his]=false;	
				  }
			  }
				  $orders_status =array_values(json_decode('[{"orders_status_name": "New"}, {"orders_status_name": "Restaurant Placed"}, {"orders_status_name": "Driver Dispatched"}, {"orders_status_name": "Restaurant Confirmed"}, {"orders_status_name": "Driver Accepted"}, {"orders_status_name": "Canceled"}, {"orders_status_name": "Arrived"}, {"orders_status_name": "Picked Up"}, {"orders_status_name": "Future"}, {"orders_status_name": "Delivered"}, {"orders_status_name": "Company Refund"}, {"orders_status_name": "Restaurant Refund"}, {"orders_status_name": "Completed"}, {"orders_status_name": "Pending"}]',true));//$this->orders_status_name;
		  
		  foreach($orders_status as &$os){
			  $os  = $os['orders_status_name'];
		  }
		  array_unshift($orders_status,0);
		  
		  $beverage_sql = $this->db->query('
		  SELECT sum( products_price * products_quantity ) as bev,orders_id
		  FROM orders_products
		  WHERE orders_id in ('.$orders_id_string.')
		  AND products_model = "BEVERAGE"
		  group by orders_id
		  ')->fetchAll(PDO::FETCH_ASSOC);
		  $beverage=array();
		  
		  foreach( $beverage_sql as $bb){
			  $beverage[$bb['orders_id']]=$bb['bev'];
		  }
		  
		  $time_driver_accept = $this->db->query('
			  select date_added,orders_id from orders_status_history
			  where orders_status_id = 4 and orders_id in ('.$orders_id_string.')
		  ')->fetchAll(PDO::FETCH_ASSOC);
		  $accept_time = array();
		  foreach($time_driver_accept as $td){
			  $accept_time[$td['orders_id']]=$td['date_added'];
		  }
			  try{
				  $a = $this->db->query($orders_sql);
				  $order=array();
				  
				  $timezone_sql = $this->db->query("select timezone from categories_description where categories_id = (select parent_id from categories where categories_id = ".$categories_id.")")->fetch(PDO::FETCH_ASSOC);
				  foreach ($a as $ax){
					    $tz_mod = 0;//
						switch($timezone_sql['timezone']){
							case 'central':
								$tz_mod = 0;
							break;
							case 'mountain':
								$tz_mod = -3600;
							break;
							case 'eastern':
								$tz_mod = 3600;
							break;
							case 'western':
								$tz_mod = (-3600 * 2);
							break;
						}
						$tz_mod=0;
					  	if($ax['orders_status']==9 || $ax['updated_from_future']==1){
							//$tz_mod=0;
							$display_date = date('m/d g:ia',strtotime($ax['date_deliver'])-1200+$tz_mod).' Future Order';
						}else{
							//$tz_mod=0;
							if(array_key_exists($ax['orders_id'],$accept_time)){
								$display_date = date('m/d g:ia',strtotime($accept_time[$ax['orders_id']])+$tz_mod);
								$display_date.=' ASAP';
							}else{
								$display_date = date('m/d',strtotime($ax['date_deliver']));
								$display_date.=' ASAP';
							}

						}
						  
						  
						  $bev_sub = array_key_exists($ax['orders_id'],$beverage)? floatval($beverage[$ax['orders_id']]):0;
						  $order[]=array('orders_info'=>
										  array('orders_id'=>$ax['orders_id'],
												'order_total'=>money_format('$%i',$new_sub[$ax['orders_id']]-$bev_sub),
												'orders_status'=>$orders_status[$ax['orders_status']],
												'orders_status_'=>$ax['orders_status'],
												'duration_to_deliver'=>$ax['duration_to_deliver'],
												'payment_module_code'=>$ax['payment_module_code'],
												'date_deliver'=>$display_date,
												'pickup_order'=>$ax['pickup_order'],
												'customers_name'=>htmlspecialchars($ax['customers_name']),
												'customers_telephone'=>$ax['customers_telephone'],
												'payment_method'=>$ax['payment_method'],
												),
										  'products'=>$orders_products[$ax['orders_id']],
										  'extras'=>array(
										  'needs_accept'=>$new_history[$ax['orders_id']],
										  'notes'=>array_key_exists($ax['orders_id'],$orders_notes)? implode(', ',array_unique($orders_notes[$ax['orders_id']])):''
										  ));
				  
				  }	
			  }catch(Exception $e){
				  print_r($e->getMessage().' Error at sql a in restaurant_table');
			  }
		  
		  return $order;	
					
		}
		
		public function categoryList($parent_id){
			$cat_nm_not_in = " AND cd.categories_name NOT IN ('Restaurant Misc', 'Food Dudes Misc')";
			//$cat_nm_not_in = " ";
			$catagory = $this->db->query("SELECT c.categories_id, c.categories_status, c.categories_status_app, categories_image, parent_id, sort_order, categories_name, categories_description, timezone, is_daylight_saving
				FROM categories AS c
				INNER JOIN categories_description AS cd ON cd.categories_id = c.categories_id
				WHERE c.parent_id IN (".$parent_id.") $cat_nm_not_in ORDER BY categories_name")->fetchAll(PDO::FETCH_ASSOC);
			return $catagory;
		}
		
		public function products($category = 0){
			$products_model_not_in = " AND p.products_model NOT IN ('BEVERAGE', 'FOODDUDEMISC', 'RESTAURANTMISC')";
			//$products_model_not_in = "";
			$products = $this->db->query("SELECT * from products_to_categories pc 
			INNER JOIN products_description AS pd ON pd.products_id = pc.products_id
			INNER JOIN products AS p ON p.products_id = pc.products_id
			WHERE pc.categories_id = ".$category ." $products_model_not_in ORDER BY products_name")->fetchAll(PDO::FETCH_ASSOC);

			return $products;
		}

		public function productOptions($product_id = 0){
			$options = $this->db->query("SELECT * FROM `products_attributes` pa INNER JOIN products_options as po on po.products_options_id = pa.options_id INNER JOIN products_options_types as pot on pot.products_options_types_id = po.products_options_type INNER JOIN products_options_values as pov on pov.products_options_values_id = pa.options_values_id WHERE pa.`products_id` = ".$product_id."
				and pa.options_values_id != 0")->fetchAll(PDO::FETCH_ASSOC);

			return $options;
		}

		public function normaliseUrlString($str){
			$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή', '', '');
			$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η', '-', '\'');
			return str_replace($a, $b, utf8_encode($str));
		}
		
		private function zuppler_menu_sync($categories_id){
			$ch = curl_init();
				
			$fields 					= array();
			$fields["update_type"] 		= "menu";
			$fields["restaurant_id"] 	= $categories_id;

			$url = "http://posaas.zuppler.com/webhooks/sync"; //Live

			$headers = array(
				"authorization: Basic ".base64_encode("9ZzTdUmesPcL6:K#9kwswgX&zENWgr0$7CLhW27"), //Live
				'Content-Type: application/json'
			);

			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$return = curl_exec($ch);
			$return = json_decode($return);
			//$return = json_encode($return);
			curl_close($return);

			return true;
		}
	}
?>