<?php
	require('includes/restaurant_login/dispatch_class.php');
	
	include_once dirname(__FILE__) . '/../../db_config.php';

	class Sync extends Dispatch{
		function __construct($categories_id,$admin_id,$dispatch,$admin_display_name) 
		{
			$this->return_matrix=array();
			// KEYS -->
			//remove_restaurant_panel
			//add_restaurant_panel
			//success
			//add_orders_object
			//error
			//price change return
			//error_message
			//success_message
			
			//orders_status
//$this->return_matrix['success_message']
			$this->admin_display_name=$admin_display_name;
			$this->sync_orders_status=array();
			$this->orders_sql='';
			$this->past_order_sql='';
			$this->orders_object=array();
			$this->function_trace=array();
			$this->orders_id=array();
			$this->db = NULL;
			$this->past_sync=false;
			$this->debug=false;
			$this->categories_id=$categories_id;
			$this->admin_id=$admin_id;
			$this->note_array=array();
			$this->orders_status_name=array();
			$this->restaurant_table='';
			$this->load_sql_statments();
			$this->dispatch=$dispatch;
			$this->load_database();
			$this->past_orders_id = array();
			$this->android_ring=false;
			$this->load_orders_status_name();
			
			$this->set_dispatch_info($dispatch);
			$this->sync();

			
			

		}

		function get_orders_object(){
			echo json_encode($this->orders_object);
		}
		function load_database(){
			$this->function_trace[]=__METHOD__;
			
			if(defined('_DB_SERVER')){
				$host=_DB_SERVER;
				$dbname=_DB_DATABASE;
				$username=_DB_SERVER_USERNAME;
				$password=_DB_SERVER_PASSWORD;
			}else{
				$host='192.168.1.11';
				$dbname='fooddudestaging_staging';
				$username='fooddudestaging_user';
				$password='3W.mmR=Q]#{U';
			}
			try {
    			$this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
			}catch (PDOException $e) {
   				echo 'Connection failed: ' . $e->getMessage();
			}
		}
		function get_orders_status_name(){
			return $this->orders_status_name;
		}
		function kill_db(){
			$this->function_trace[]=__METHOD__;
			$this->db = NULL;
		}
		function toggle_debug($boolean){
			$this->function_trace[]=__METHOD__;
			$this->debug=$boolean;
		}
		function s_print($print){
			$this->function_trace[]=__METHOD__;
			print_r($print);
		}
		function error($msg=''){
			$this->function_trace[]=__METHOD__;
			$this->success['success']=0;
			$this->return_matrix['error_message'][]=$msg;
		}
		function success($e){
			$this->function_trace[]=__METHOD__;
			$this->success['success']=1;
			$this->return_matrix['success_message'][]=$e;
		}
		function get_id_list($order_id){
			$this->function_trace[]=__METHOD__;
			return implode(',',$order_id);
		}
		function receive($incoming) 
		{
		
			$this->function_trace[]=__METHOD__;
			$this->load_database();
			$this->return_matrix=array();
			//$this->success('SESSION-->>>'.json_encode($_SESSION).' INCSYNC-->>>'.json_encode($incoming));
			if(isset($_POST['android_sync'])){
				$this->transfer['action']='sync';
			}else{
				$this->transfer=json_decode($incoming,true);
			}
				switch($this->transfer['action']){
					case 'sync':
						$this->sync();
						break;
					case 'change_page':
						$this->change_page();
						break;
					case 'change_orders_status':
						$this->change_orders_status();
						break;
					case 'change_restaurant_adjustment':
						$this->change_restaurant_adjustment();
						break;
					case 'reprint':
						$this->sync_reprint();
						break;
					case 'invoice':
						$this->invoice();
						break;
					case 'sync_test':
						$this->sync_test();
						break;
					case 'toggle_debug':
						$this->toggle_debug($this->transfer['toggle']);
						break;
					default:
						$this->error('Invalid sync action');
						break;
				}
				$this->check_status_array_for_accepted();	
				$this->send();
		}
		function sync_test(){
			$this->function_trace[]=__METHOD__;
			$this->return_matrix['sync_test']=1;
		}
		
		
		function send(){
			$this->function_trace[]=__METHOD__;
			
			if($this->debug){
				$this->return_matrix['trace']=$this->function_trace;
			}
			if($this->transfer['action']=='change_page'){
				$this->return_matrix['dont_sound']=1;
			}
			if(count($this->return_matrix)==0){
				$this->return_matrix['this']=NULL;
			}else{
				$action = array_keys($this->return_matrix);
				$this->return_matrix['action']=$action;
			}
			$this->success('TRACER-->>'.json_encode($this->function_trace));
			
				if(true){
					//$this->return_matrix['remove_restaurant_panel']=array(77);
					//$this->return_matrix['add_restaurant_panel']='<div id="77-main-panel" class="btn btn-default">x</div>';
					
					
					//$this->return_matrix['action'][]='remove_restaurant_panel';
					//$this->return_matrix['action'][]='add_restaurant_panel';
					//$this->return_matrix['action']=array('add_restaurant_panel','remove_restaurant_panel');
				}

				if(isset($_POST['android_sync'])){
					
					print_r( json_encode(array('sync'=>$this->return_matrix)));
				}else{
					print_r( json_encode($this->return_matrix));
				}
				//echo json_encode(array('sync'=>array('this'=>$this->android_ring)));
				

			$this->kill_db();
			$this->return_matrix=array();
			$this->function_trace=array();
			$this->orders_object=array();
			$this->restaurant_table=array();
			$this->transfer=array();
		}
		
		function new_page(){
			$this->function_trace[]=__METHOD__;
				foreach ($this->db->query($this->past_sql) as $orders_sync) {
					$new_difference[]=$orders_sync['orders_id'];
				}	
				$this->past_orders_id=$new_difference;
				require('includes/restaurant_login/restaurant_table.php');
				$this->return_matrix['add_orders_object']=$this->orders_object;
				$this->return_matrix['add_restaurant_panel']=$this->restaurant_table;
		}
		function check_status_array_for_accepted (){
		if(count($this->orders_id)==0){
			$this->return_matrix['stop_sound']=true;
			return;
		}
			$orders_history  = $this->db->query('select h.orders_id,h.orders_status_id from orders_status_history  as h inner join orders as o on o.orders_id=h.orders_id where o.orders_status in(4,5,7,8) and categories_id = "'.$this->categories_id.'" and  h.orders_id in('.implode(',',$this->orders_id).')');
			

			$tmp_array=array();
			$tmp_array_all=array();
			foreach($orders_history as $o){
				$tmp_array_all[]=$o['orders_id'];
				if($o['orders_status_id']==4){
					$tmp_array[]=$o['orders_id'];
				}
			}
			
			if(count(array_diff($tmp_array_all,$tmp_array))){
				$this->return_matrix['order_needs_accepting']=true;
				$this->return_matrix['play_sound']=true;

			}else{

				$this->return_matrix['stop_sound']=true;
			}
		}
		function sync(){
			$this->function_trace[]=__METHOD__;
			$orders_status_difference=array();
			$delivered_difference=array();
 			$sync_orders_status=array();
			$new_difference=array();
			$sync_id=array();
			

//$this->orders_sql='select orders_id from orders where   categories_id=44 and orders_status =10  and date_deliver >= "2015-07-07 00:00:00" and date_deliver <= "2015-07-09 23:59:00" limit 0,9999 ';
			try{
				foreach ($this->db->query($this->orders_sql) as $orders_sync) {

					$sync_id[]=$orders_sync['orders_id'];
				    $sync_orders_status[$orders_sync['orders_id']]=$orders_sync['orders_status'];
				}	
			}catch(Exception $e){
				$this->error($e->getMessage().' Error at sync');
			}
			
			$orders_status_difference=array_diff_assoc($sync_orders_status,$this->sync_orders_status);
//			print_r($this->sync_orders_status);
//			print_r($sync_orders_status);
//			print_r($orders_status_difference);
			if(count($orders_status_difference)){
				foreach($orders_status_difference as $orders_id=>$orders_status){
					$this->return_matrix['sync_orders_status'][]=array('orders_id'=>$orders_id,'orders_status'=>$orders_status);
				}
				$this->sync_orders_status=$sync_orders_status;
			}
			// new or delivered order block
				
			$delivered_difference = array_diff($this->orders_id,$sync_id);
			$new_difference = array_diff($sync_id,$this->orders_id);
			$this->success('NEW_ORDERS-->>'.json_encode($new_difference));
			$this->success('OLD_ORDERS-->>'.json_encode($delivered_difference));
			if(!isset($_POST['android_sync'])){
				$this->orders_id=$sync_id;		
			}
			
			if(count($delivered_difference)>0){
				$this->return_matrix['remove_restaurant_panel']=$delivered_difference;
				
			}
			
			

			if(count($new_difference)>0){
				try{
					require('includes/restaurant_login/restaurant_table.php');
				}catch(Exception $e){
					$this->error($e->getMessage().' Error including restaurant_table');
				}
				$this->return_matrix['add_orders_object']=$this->orders_object;
				$this->success('NEW_OBJECT_ADDED-->>'.json_encode($this->orders_object));
				$this->return_matrix['add_restaurant_panel']=$this->restaurant_table;
				
				$this->success('NEW_PANEL_ADDED-->>TRUE');
			$this->success(json_encode($this->restaurant_table));

			
			}
			//status block
		}
		function display_restaurant_table(){
			$this->function_trace[]=__METHOD__;
			if(isset($this->return_matrix['add_restaurant_panel'])){
				return $this->return_matrix['add_restaurant_panel'];
			}else{
				return '';	
			}
			

		}
		function check_status($orders_id,$status){
			$this->function_trace[]=__METHOD__;
				$check = $this->process_sql_values('select orders_status_id from orders_status_history where orders_id ="'.$orders_id.'"','orders_status_id');
				
				if(in_array($status,$check)){
					return true;
				}else{
					return false;
				}
		}
		
		function process_sql_values($sql,$col){
			$this->function_trace[]=__METHOD__;
			$sql = $this->db->query($sql);
			$array=array();
			foreach($sql as $s){
				$array[]=$s[$col];
			}
			return $array;
		}
		
		function change_page(){
				
			$this->function_trace[]=__METHOD__;
			//needs work
			
			switch($this->transfer['page']){
				case 'current':
				
					if($this->past_sync){
						$this->orders_id=$this->past_orders_id;
					}
					if(!count($this->orders_id)){
						$this->orders_id=array();
					}
					$this->past_sync=false;
					$this->sync();
					
					break;
				case 'past':
					$this->past_sync=true;
					if(!isset($this->transfer['start_date']) && !isset($this->transfer['end_date'])){
						//categories_id="'.$this->categories_id.'" and
						$this->past_sql='select orders_id from orders where  categories_id in ('.$this->categories_id.') and orders_status in (6,8,9,10)  and date_deliver >= "'.date('Y-m-d 00:00:00',strtotime('today')).'" limit 0,9999';	
					}else{
						$start_date = date('Y-m-d 00:00:00',strtotime($this->transfer['start_date']));
						$end_date = date('Y-m-d 23:59:59',strtotime($this->transfer['end_date']));
						//categories_id="'.$this->categories_id.'" and
						$this->past_sql='select orders_id from orders where categories_id in ('.$this->categories_id.') and orders_status in (6,8,9,10)  and date_deliver >= "'.$start_date .'" and date_deliver <= "'.$end_date.'" limit 0,9999 ';
					}
					$this->new_page();
					break;	
			}
			//print_r($this->orders_sql);
		}
		
		
		function get_note_array($new_difference){
			$this->function_trace[]=__METHOD__;
			global $db;
			$note_sql=$this->db->query('select order_id,timestamp,note,note_type from notes where order_id in ('.$this->get_id_list($new_difference).') and note_type in (1,4)');
			$note_array=array();
			foreach($note_sql as $note){
				switch($note['note_type']){
					case 0:$note_type='Driver';
						break;
					case 1:$note_type='Restaurant';
						break;
					case 2:$note_type='Admin';
						break;
					case 3:$note_type='Note about a driver';
						break;
					case 4:$note_type='Customer';
						break;
					default:$note_type='NA';
						break;
				}
				//$zen_com = zen_get_orders_comments($note_sql->fields['order_id']);
				//if($zen_com !=''){
//					$note_array[$note_sql->fields['order_id']][]=array('timestamp'=>0,'note'=>$zen_com,'note_type'=>1);
//				}
				$note['note'] = $note['note'].trim();
				
				if($note['note']!=''){
					$this->note_array[$note['order_id']][]=array('timestamp'=>$note['timestamp'],'note'=>$note['note'],'note_type'=>$note_type);
				}
				
			}
			
			
		}
		function load_orders_status_name(){
			$this->function_trace[]=__METHOD__;
			$orders_status_sql='select orders_status_id, orders_status_name from orders_status';
			$g = $this->db->query($orders_status_sql);
			$orders_status=array();
			foreach ($g as $gx){
				if($gx['orders_status_name']=='Restaurant Confirmed'){
					$gx['orders_status_name']='Confirmed';
				}
				if($gx['orders_status_name']=='Restaurant Placed'){
					$gx['orders_status_name']='Placed';
				}
					$this->orders_status_name[$gx['orders_status_id']]=$gx['orders_status_name'];
			}
		}
		
		function change_orders_status(){
			global $gcpm;
			$this->function_trace[]=__METHOD__;
			try{
				$this->db->query('insert into orders_status_history (orders_status_id,date_added,orders_id,updated_by) values (4,now(),"'.$this->transfer['orders_id'].'","'.$this->admin_display_name.'")');
				$this->db->query('update orders set orders_status='.$this->transfer['orders_status'].',last_modified=now() where orders_id="'.$this->transfer['orders_id'].'" and orders_status in(1,2,3,4,5,7)');
				$this->success('Order Accepted');
				
			}catch(Exception $e){
				$this->error($e->getMessage().' Error changing status to confirm');
			}
			if(isset($_SESSION['device_id'])){
				$gcpm->setDevices(array($_SESSION['device_id']));
				$gcpm->send("stop_sound", array('title' => 'fooddudestagingsdelivery'));
			}
			
		}
		
		function sync_reprint(){
			$this->function_trace[]=__METHOD__;
			//$this->set_dispatch_info($this->transfer['dispatch']);
			$this->set_orders_id($this->transfer['orders_id']);
			$this->reprint();
		}
		
		function invoice(){
			
			$this->function_trace[]=__METHOD__;
			$this->get_invoice();
			$this->return_matrix['invoice']=$this->invoice;
		
		}
		
		function change_restaurant_adjustment(){
			$this->function_trace[]=__METHOD__;
//function r_price_change($orders_id,$adjustment,$orders_comments){
			$orders_comments = addslashes($this->transfer['orders_comment'].' '.money_format('$%i',$this->transfer['adjustment']));
			try{
				$check_db = $this->db->query('select value,class from orders_total where orders_id="'.$this->transfer['orders_id'].'" and class in ("ot_subtotal","ot_total","ot_restaurant_adjustment","ot_shipping","ot_loworderfee","ot_tax")');
			}catch(Exeception $e){
				$this->error($e->getMessage().' Error changing restaurant adjustment to get orders total and class');
			}
			$subtotal=0;
			$total=0;
			$shipping=0;
			$lowfee=0;
			$origtax=0;
			foreach($check_db as $check){
				switch($check['class']){
					case 'ot_subtotal':
						$subtotal = floatval($check['value']);
						break;
					case 'ot_total':
						$total = floatval($check['value']);
						break;
					case 'ot_restaurant_adjustment':
						$adj = floatval($check['value']);
						break;
					case 'ot_shipping':
						$shipping = floatval($check['value']);
						break;
					case 'ot_loworderfee':
						$lowfee = floatval($check['value']);
						break;
					case 'ot_tax':
						$origtax = floatval($check['value']);
						break;
						
						
				}
			}
			
			if(!isset($adj)){
				$subtotal+=$this->transfer['adjustment'];
				$total+=$this->transfer['adjustment'];
				//try{
					$this->db->query('INSERT INTO orders_total (title,class,sort_order,orders_id,value,text)
						VALUES ("Restaurant Adjustment:","ot_restaurant_adjustment","333","'.$this->transfer['orders_id'].'","'
						.$this->transfer['adjustment'].'","'.money_format('$%i',$this->transfer['adjustment']).'")');				
				//}catch(Exeception $e){
					//$this->error($e->getMessage().' Error inserting restaurant adjustment total');
				//}
			}else{
				$subtotal=$subtotal-$adj;
				$total=$total-$adj;
				
				$subtotal+=$this->transfer['adjustment'];
				$total+=$this->transfer['adjustment'];
				//try{
					$this->db->query('UPDATE orders_total set text="'.money_format('$%i',$this->transfer['adjustment']).'",value="'.$this->transfer['adjustment'].'" where orders_id="'.$this->transfer['orders_id'].'" and class="ot_restaurant_adjustment"');
				//}catch(Exeception $e){
					//$this->error($e->getMessage().' Error updating restaurant adjustment total');
				//}
			}
			$tax_sql = 'select products_tax from orders_products  where orders_id='.$this->transfer['orders_id'].' and products_tax > 0 limit 0,1';
			$rate=$this->db->query($tax_sql)->fetch();
			$rate=$rate['products_tax']/100;
			if(floatval($rate)==0){
			$rate=.08375;	
			}
			$tax= ($subtotal+$shipping+$lowfee)*$rate;
			
			$total=($total-$origtax)+$tax;
			//try{
			$this->db->query('UPDATE orders_total set text="'.money_format('$%i',$tax).'",value='.$tax.' where orders_id="'.$this->transfer['orders_id'].'" and class="ot_tax"');
			
				$this->db->query('UPDATE orders_total set text="'.money_format('$%i',$subtotal).'",value='.$subtotal.' where orders_id="'.$this->transfer['orders_id'].'" and class="ot_subtotal"');
			//}catch(Exception $e){
				//$this->error($e->getMessage().' Error updating orders subtotal');
			//}
			
			//try{
				$this->db->query('UPDATE orders_total set text="'.money_format('$%i',$total).'",value='.$total.' where orders_id="'.$this->transfer['orders_id'].'" and class="ot_total"');
				
				$this->db->query('update orders set order_total="'.$total.'" where orders_id="'.$this->transfer['orders_id'].'"');
			//}catch(Exception $e){
				//$this->error($e->getMessage().' Error updating orders total');
			//}
			
		//	try{
				$this->db->query('INSERT into notes (note,note_type,order_id,made_by) values ("'.$orders_comments.'","1","'.$this->transfer['orders_id'].'","'.$this->admin_id.'")');
			//}catch(Exception $e){
			//	$this->error($e->getMessage().' Error inserting notes');
			//}
				$this->return_matrix['price_change_return']=1;
		}
			

		
		
		







		function load_sql_statments(){
			//$this->orders_sql='select orders_id,orders_status from orders where orders_status in (2,4,5,7) and date_deliver >"2015-07-10 00:00:00"';
					//$sync_sql='select orders_id,orders_status from orders where orders_status  in (1) and orders_id="94575" 
					//categories_id="'.$this->categories_id.'" and
					$this->orders_sql='select orders_id,orders_status from orders where categories_id in ('.$this->categories_id.') and orders_status  in (2,4,5,7)';
		//and date_deliver >"'.date('Y-m-d 00:00:00').'"';

		}

	}

?>