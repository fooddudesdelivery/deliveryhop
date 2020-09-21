<?php
	class RestaurantBase{
		private $db;
		private $primary_key;
		private $primary_params;
		
		function __construct(){
			ini_set('display_errors',true);
			//ini_set('memory_limit', '-1');
			ini_set("log_errors", 1);
			ini_set("error_log", "php_error.txt");
			date_default_timezone_set('America/Chicago');
			error_reporting(E_ALL);
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
				case 'test':
				default:
					$return = $this->primary_params;
				break;
			}
			echo $return;
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
			$this->db->query("update push_info set last_info_json='loggedoff' where device_id='$device_id' ");
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
			$this->db->query("update push_info set last_java_http=NOW() where device_id='$device_id' ");
			
			//this is able to send push commands do not change from true
			return json_encode(array('success'=>'true'));
		}
		private function reverseSignalFlare(){
			if(!isset($this->primary_params['device_id'])){
				return false;
			}
			$device_id = $this->primary_params['device_id'];
			$this->db->query("update push_info set last_reverse_push_time=NOW(),reverse_push_json='Online' where device_id='$device_id' ");
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
			$this->db->query("update push_info set last_info_time=NOW(),last_info_json='".addslashes(json_encode($this->primary_params['status']))."' where device_id='$device_id' ");
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
			$this->sendPush($this->primary_params['orders_id'],array('key'=>'syncOrder','params'=>true));
			$cats_admin_id = $this->db->query("select a.admin_id from admin as a inner join orders as o on o.categories_id = a.categories_id where o.orders_id = ".$this->primary_params['orders_id'])->fetch(PDO::FETCH_COLUMN);
			$this->updateOrdersTrueHistory($cats_admin_id,$this->primary_params['orders_id'],13);
			return json_encode(array('success'=>'true'));
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
			$push_suc = $this->sendPush($this->primary_params['orders_id'],array('key'=>'secondTabletAccept','params'=>true));
			
			$this->syncDriverByOrderId($this->primary_params['orders_id']);
			
			
			return json_encode(array('success'=>$push_suc,'orders_id'=>$this->primary_params['orders_id']));
		}
		public function checkNewOrder(){
			//echo 'test';
			
			$this->primary_params=intval($this->primary_params);
			$is_pickup = $this->db->query("select pickup_order from orders where orders_id = ".$this->primary_params)->fetch(PDO::FETCH_COLUMN);
			
			if($is_pickup==1){
				$ex =' and orders_status in (1,2,5,7) ';
			}else{
				$ex= ' AND orders_admin_id !=0  and orders_status in (2,5,7)  ';
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
			$note->bindValue(':note',$method.' adjustment '.$type.round(floatval($this->primary_params['adjustment']),2).' '.$this->primary_params['note'], PDO::PARAM_STR);
			$note->bindValue(':note_type',1, PDO::PARAM_INT);
			//$note->bindValue(':made_by',999, PDO::PARAM_INT);
			$note->execute();
			$this->adjust($this->primary_params['orders_id'],floatval($total)-floatval($original_total));
			$this->notifyDriver($this->primary_params['orders_id'],'Order #'.$this->primary_params['orders_id'].' has had its price adjusted '.$type.'$'.round(floatval($this->primary_params['adjustment']),2));
			return true;
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
			$push_sql="SELECT device_id FROM push_info AS p inner join orders AS o ON o.categories_id = p.categories_id WHERE o.orders_id = $orders_id AND last_info_json!='loggedoff'";
			$push_info= $this->db->query($push_sql)->fetchAll(PDO::FETCH_COLUMN);
			if(!$push_info){
				return false;
			}
			$push_info=array_values($push_info);
			
			$apiKey = 'c41a0766e45072a2897720ddbb13fe877e28847f7f958621ce4f46df35d80b0a';
			$url = 'https://api.pushy.me/push?api_key=' . $apiKey;
			$post = array
			(
				'registration_ids'  => $push_info,
				'data'              => array('json_link'=>json_encode($push)),
				'time_to_live' => 180
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
		
		public function getOrder($orders_id_list,$categories_id){
		  $orders_id_string = implode(',',$orders_id_list);
		  $orders_sql = 'SELECT duration_to_deliver,payment_method,orders_status,cash_order, categories_id, customers_id, customers_lat, customers_lng, customers_name, customers_telephone, date_deliver, date_purchased, delivery_city, delivery_company, delivery_country, delivery_name, delivery_postcode, delivery_state, delivery_street_address, delivery_suburb, distance_to_deliver, duration_to_deliver, last_modified, orders_id, orders_status, order_total, payment_module_code, updated_from_dispatched, updated_from_future
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
												'duration_to_deliver'=>$ax['duration_to_deliver'],
												'payment_module_code'=>$ax['payment_module_code'],
												'date_deliver'=>$display_date,
												'pickup_order'=>$ax['pickup_order'],

												'customers_name'=>htmlspecialchars($ax['customers_name']),

												'customers_telephone'=>$ax['customers_telephone'],
												'payment_method'=>$ax['payment_method']
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
		
	}
?>