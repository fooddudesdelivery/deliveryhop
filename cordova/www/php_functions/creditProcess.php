<?php
require(__DIR__.'/../../../order_online/vendor/autoload.php');
if(true){
define('BRAINTREE_ENVIROMENT','production');
define('BRAINTREE_MERCHANT_ID','vt7n4fr3h9xwkn55');
define('BRAINTREE_PUBLIC_KEY','frpvgg3g7xyjzzwk');
define('BRAINTREE_PRIVATE_KEY','aed2ba70051f1055050d30076f965142');
}else{
//
define('BRAINTREE_ENVIROMENT','sandbox');
define('BRAINTREE_MERCHANT_ID','vztk698qjg5q4xzp');
define('BRAINTREE_PUBLIC_KEY','hjmqb53r3q8nrh37');
define('BRAINTREE_PRIVATE_KEY','711108442f94ca4cc8416c94d1f52829');
}
		Braintree_Configuration::environment(BRAINTREE_ENVIROMENT);
		Braintree_Configuration::merchantId(BRAINTREE_MERCHANT_ID);
		Braintree_Configuration::publicKey(BRAINTREE_PUBLIC_KEY);
		Braintree_Configuration::privateKey(BRAINTREE_PRIVATE_KEY);
class CreditCard{
		private $paymentToken='';
		private $braintreeinfo=array();
		private $info=array();
		//idk if i need these

	public function getClientId(){
		return Braintree_ClientToken::generate();
	}
	public function initData($info){
		$info['total']=$info['tax']+$info['subtotal']+$info['delivery']+$info['tip'];
		$this->info = $info;

		 
		if($this->info['total']<=50){
			$this->info['upcharge']=10;
		}else{
			$this->info['upcharge'] = $this->info['total'] *.2;
		}
		
	}
	public function getUpcharge(){
		return $this->info['upcharge'];	
	}
	public function getTotal(){
		return $this->info['total'];	
	}
	
	public function creditError($error){
		echo json_encode(array('success'=>false,'error'=>$error));
		die;
	}
	public function authorizeTransaction(){
		$result = Braintree_Customer::create([
    		'paymentMethodNonce' => $this->info['payment_method_nonce']
		]);
		$verification = $result->creditCardVerification;
		if($result->success==0){
			$this->creditError('Error please try again: '.$verification->processorResponseText);
			return false;
		}else{		
			if(isset($result->customer->paymentMethods[0]->token)){
				$this->paymentToken=$result->customer->paymentMethods[0]->token;
				return $this->paymentToken;
			}else{
				$this->creditError('Error please try again: '.$verification->processorResponseText);
				return false;
			}
		}	
	}
	
	public function processTransaction($charge_amount,$order_total){
		//recursive
		$final_run=false;
		if($charge_amount<$order_total){
			$charge_amount=$order_total;
			$final_run=true;
		}

	
		$result = Braintree_Transaction::sale([
			'amount' =>round($charge_amount,2),
			'paymentMethodNonce' => $this->info['payment_method_nonce'],
			'options' => [
			  'submitForSettlement' => false,
			  'storeInVaultOnSuccess' => false
			],
			'descriptor' => array('name'=>$this->info['configuration']['braintree_descriptor']['name'],'phone'=>$this->info['configuration']['braintree_descriptor']['phone'],'url'=>' ')
		]);
		
		
		if($result->success==0){
			if($result->transaction){
				if($result->transaction->status=='gateway_rejected'){
					$this->creditError('Gateway Rejected '.$result->transaction->gatewayRejectionReason);
					return false;
				}else if($result->transaction->status=='processor_declined'){
					$this->creditError('Card Declined');
					return false;
				}else{
					$this->creditError('Unable to process card');
					return false;
				}
			}else{
				$addon='';
				if(isset($result->message)){
					$addon = $result->message;
				}
				$this->creditError('Error please try again 3 '.$addon);
				return false;
			}
		}else if($result->success==1){
			$this->info['status']=$result->transaction->status;
			$this->info['authorization_amount']=$result->transaction->amount;
			$this->info['transaction_id']=$result->transaction->id;
			$this->info['credit_card_token']='faketoken';
		
			$this->insertBraintree();
			return true;
				
		}else{
			$this->creditError('Error please try again 4');
			return false;
		}	
	}
	
private function insertBraintree(){
		global $db;
		$credit_sql = '
		INSERT INTO braintree_info 
			(orders_id,transaction_id,credit_card_token,authorization_amount,settlement_amount,status)
		VALUES 
			("'.$this->orders_id.'","'.$this->info['transaction_id'].'","'.$this->info['credit_card_token'].'","'.$this->info['authorization_amount'].'",0,"'.$this->info['status'].'")';
			$db->query($credit_sql);
			
			
			$main_time = date('m/d/y g:ia',strtotime('now'));

		 $commentString='';
		 $commentString.='Transaction Id: '.$this->info['transaction_id']." \n";
		 $commentString.='Payment Type: Credit Card'." \n";
		 $commentString.='Timestamp: '.$main_time." \n";
		 $commentString.='Payment Status: '.$this->info['status']." \n";
		 $commentString.='Auth Amount: '.$this->info['authorization_amount']." \n";
		 $commentString =addslashes($commentString);
		$db->query("INSERT INTO orders_status_history ( orders_id, orders_status_id, date_added, customer_notified, comments, updated_by) 
		VALUES ('".$this->orders_id."', '1', '".date('Y-m-d H:i:s',strtotime('now'))."', '0', '".$commentString."', '')");
		$this->old_status = intval($this->old_status);
		$db->query("update orders set orders_status = $this->old_status where orders_id = $this->orders_id");
		echo json_encode(array('success'=>true,'orders_id'=>$this->orders_id));
		return true;
	
}	
public function fastOrderGenerate($mark_cancel_run_credit = false){
	global $db;
	ini_set('display_errors',false);
	$up_from_future=0;
	if(isset($this->info['asapselect']) && isset($this->info['timeselector'])){
		if($this->info['asapselect']=='asap'){
			$set_status=1;
		}else{
			$set_status=9;
			$up_from_future=1;	
		}
		$date_deliver = date('Y-m-d H:i:s',strtotime($this->info['timeselector']));
	}else{
		$set_status=1;
		$date_deliver=date('Y-m-d H:i:s',strtotime('now'));
	}
	if(strtotime($date_deliver)<(strtotime('now')-5000)){
		echo json_encode(array('success'=>false,'error'=>'Order had a bad time selected'));
		die;
	}
	
	$customers_name=$this->info['name'];
	$city=$this->info['city'];
	$postcode=$this->info['zip'];
	$state=$this->info['state'];
	$address=$this->info['company'].' '.$this->info['address'].' '.$this->info['apt'];
	$address=addslashes($address);
	$phone=$this->info['phone'];
	$gh_id=0;
	$is_adjusted_order=0;
	$categories_id=$this->info['categories_id'];
	$this->info['email']=explode(',',$this->info['email']);
	$this->info['email']=$this->info['email'][0];
	$email=$this->info['email'];
	$payment_method='Invoice';
	$payment_method_code='invoice';
	$customers_id=$this->info['configuration']['customers_id'];
	if($this->info['type']=='Credit'){
		$payment_method='Credit Card';
		$payment_method_code='braintree_api';
		$is_cash=0;
		
		/* if(!isset($this->info['transaction_id']) || $this->info['transaction_id']==false){
			echo json_encode(array('success'=>false,'error'=>'Order failed to process credit card'));
			die;
		} */
		

	}else if($this->info['type']=='Cash'){
		$payment_method='Cash';
		$payment_method_code='cod';	
		$is_cash=1;
	}else if($this->info['type']=='Invoice'){
		$payment_method='Invoice';
		$payment_method_code='invoice';
		$is_cash=0;	
	}
	//orders total table
	$disp_tax=0;
	if(isset($this->info['configuration']['tax_rate'])){
		$disp_tax=	floatval($this->info['configuration']['tax_rate'])*100;
	}
	//orders products table
	$tmp1[]=array('products_options_values'=>$this->info['categories_name'],'options_values_price'=>'','price_prefix'=>'');
	$products_array[]=array('name'=>'Misc Charge','price'=>$this->info['subtotal'],'final_price'=>$this->info['subtotal'],'quantity'=>1,'tax'=>$disp_tax,'model'=>'',
	'options'=>$tmp1);

//	$tmp2[]=array('products_options_values'=>'Wok','options_values_price'=>'','price_prefix'=>'');
//	$products_array[]=array('name'=>'Fake Product','price'=>0,'final_price'=>0,'quantity'=>0,'tax'=>0,'model'=>'',
//	'options'=>$tmp2);
		$this->old_status = $set_status;
		if($mark_cancel_run_credit){
			$set_status=6;
		}
		$order_table="
		INSERT INTO orders 
		(
		categories_id,
		customers_id,
		customers_city,
		customers_name,
		customers_postcode,
		customers_state,
		customers_street_address,
		customers_telephone,
		delivery_city,
		delivery_name,
		delivery_postcode,
		delivery_state,
		delivery_street_address,
		date_deliver,
		date_purchased,
		distance_to_deliver,
		duration_to_deliver,
		last_modified,
		orders_status,
		order_tax,
		order_total,
		customers_address_format_id,
		delivery_address_format_id,
		customers_country,
		customers_email_address,
		delivery_country,
		billing_country,
		grubhub_orders_id,
		payment_method,
		payment_module_code,
		currency,
		currency_value,
		billing_city,
		billing_name,
		billing_postcode,
		billing_state,
		billing_street_address,
		billing_address_format_id,
		shipping_method,
		shipping_module_code,
		adjusted_order,
		new_payment_flag,
		cash_order,
		customers_lat,
		customers_lng,
		updated_from_future
		)
		VALUES
		(
		'".$categories_id."',
		'".$customers_id."',
		'".addslashes($city)."',
		'".addslashes($customers_name)."',
		'".addslashes($postcode)."',
		'".addslashes($state)."',
		'".addslashes($address)."',
		'".addslashes($phone)."',
		'".addslashes($city)."',
		'".addslashes($customers_name)."',
		'".addslashes($postcode)."',
		'".addslashes($state)."',
		'".addslashes($address)."',
		'".addslashes($date_deliver)."',
		now(),
		3,
		1,
		now(),
		'".$set_status."',
		'".$this->info['tax']."',
		'".$this->info['total']."',
		2, 
		2,
		'United States',
		'".addslashes($email)."',
		'United States',
		'United States',
		'".$gh_id."',
		'".$payment_method."',
		'".$payment_method_code."',
		'USD',
		1.0,
		'".addslashes($city)."',
		'".addslashes($customers_name)."',
		'".addslashes($postcode)."',
		'".addslashes($state)."',
		'".addslashes($address)."',
		2,
		'Delivery',
		'flat',
		'".$is_adjusted_order."',
		1,
		'".$is_cash."',
		'".$this->info['configuration']['restaurant_coordinates']['lat']."',
		'".$this->info['configuration']['restaurant_coordinates']['lng']."',
		'".$up_from_future."'
		
		)";
		$db->query($order_table);
		$orders_id=$db->lastInsertId();
		$this->orders_id = $orders_id;
		
	

		//TODO CHECK
		$value_array=array($this->info['subtotal'],$this->info['delivery'],$this->info['tax'],$this->info['tip'],$this->info['total']);
		$class_array=array('ot_subtotal','ot_shipping','ot_tax','ot_tip','ot_total');
		$title_array=array('Subtotal:','Delivery:','Sales Tax:','Gratuity:','Total:');
		$sort_array=array(100,200,351,800,999);
		for($i=0;$i<count($value_array);$i++){
		  $orders_total="
		  INSERT INTO orders_total
		  (
			  orders_id,title,text,value,class,sort_order
		  )
		  VALUES
		  (
			  '".$orders_id."','".$title_array[$i]."','".money_format('$%i', floatval($value_array[$i]))."','".$value_array[$i]."','".$class_array[$i]."','".$sort_array[$i]."'
		  )";
		  $db->query($orders_total);
		}
	
		

		foreach($products_array as $p){
			$orders_products="
			INSERT INTO orders_products
				(products_model,orders_id,products_id,products_name,products_price,final_price,products_quantity,products_tax)
			VALUES
				('".$p['model']."','".$orders_id."',0,'".$p['name']."',".$p['price'].",".$p['final_price'].",".$p['quantity'].",".$p['tax'].")";
				
			$db->query($orders_products);
			$orders_products_id=$db->lastInsertId();
			
			
			foreach($p['options'] as $o){
				$orders_products_attributes="
				INSERT INTO orders_products_attributes
					(orders_id,orders_products_id,products_options_values,options_values_price,price_prefix)
				VALUES
					('".$orders_id."','".$orders_products_id."','".$o['products_options_values']."','".$o['options_values_price']."','".$o['price_prefix']."')";
				$db->query($orders_products_attributes);
			}	
		}
			$this->info['special']=addslashes($this->info['special']);
			$new_spec= "#".$this->info['wokorder']." ".$this->info['special'];
		$db->query("insert into orders_status_history (orders_id,orders_status_id,date_added,comments,updated_by) values ($orders_id,$set_status,NOW(),'".$new_spec."','Dispatch')");
		

		
	/*	if(in_array(intval($categories_id),array(12180,12181,12182,12268,12293,12304,12590,12601,12602,12747))){
			mail('9203766009@messaging.sprintpcs.com','New Oshkosh Order','Order Id: '. $orders_id);
		}  */
		
		$cats_admin_id = $db->query("select a.admin_id from admin as a inner join orders as o on o.categories_id = a.categories_id where o.orders_id = ".$orders_id)->fetch(PDO::FETCH_COLUMN);
		$this->updateOrdersTrue($cats_admin_id,$orders_id,$set_status);
		
		if($mark_cancel_run_credit){
			
			return array('success'=>true,'orders_id'=>$orders_id);
		}else{
			echo json_encode(array('success'=>true,'orders_id'=>$orders_id));
			return true;
		}
		
	
	}
	private function updateOrdersTrue($admin_id,$orders_id,$orders_status_id){
			global $db;
			$admin_id=intval($admin_id);
			$orders_id=intval($orders_id);
			$orders_status_id=intval($orders_status_id);
			if($admin_id==0 || $orders_id==0 || $orders_status_id==0){
				return false;
			}
			$db->query("INSERT INTO orders_history (admin_id,orders_id,orders_status_id) VALUES ($admin_id,$orders_id,$orders_status_id)");
			return true;
	}
}
?>