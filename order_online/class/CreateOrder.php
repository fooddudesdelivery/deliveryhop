<?php
include(__DIR__.'/Display.php');
class CreateOrder extends Display{
	private $ordersStatusId = 1;
	
	
	
	public function runCreateOrder(){
		if
		(
			$this->ordersMain() &&
			$this->ordersTotal() &&
			$this->ordersProducts() &&
			$this->ordersStatusHistory() &&
			$this->ordersNotes() &&
			$this->chargeIfCredit() &&
			$this->autoDispatch()
		)
		{
			return true;
		}else{
			$this->addError(ERROR_TOP_LEVEL_CREATE_ORDER);
			return false;
		}
	}
	
//	
	private function chargeIfCredit(){
		if($this->Link['payment_type']==PAYMENT_CREDIT){

			if($this->Link['delivery'] == 0 && $this->Config['pickup']['credit'] == 0){
				return false;
			}
			if($this->authorizeTransaction()){
					$card_ins = $this->creditCardInfo();
			
					$id = intval($this->Link['orders_id']);
					if($id < 2){
						return false;
					}
					
					//idk why not spacing by line with \ n
					$commentString='';
					$commentString.='Transaction Id: '.$this->Link['braintree_info']['transaction_id']." \n";
					$commentString.='Payment Type: Credit Card'." \n";
					$commentString.='Timestamp: '.$this->Link['braintree_info']['timestamp']." \n";
					$commentString.='Payment Status: '.$this->Link['braintree_info']['status']." \n";
					$commentString.='Auth Amount: '.$this->Link['braintree_info']['authorization_amount']." \n";
					$orders = $this->db->prepare("INSERT INTO notes ( order_id,note_type, timestamp, note) VALUES ($id, 2, 'NOW()',  :comm)");
					$orders->bindValue(':comm', $commentString, PDO::PARAM_STR);
					$orders->execute();
					
					$this->db->query("update orders set orders_status = 1 where orders_id = $id");
					return true;
				
			}

		}else{
			return true;
		}
	}
	
	private function updateOrdersTrueHistory($orders_id,$orders_status_id){
			$orders_id=intval($orders_id);
			$orders_status_id=intval($orders_status_id);
			if( $orders_id==0 || $orders_status_id==0){
				return false;
			}
			$this->db->query("INSERT INTO orders_history (admin_id,orders_id,orders_status_id) VALUES ((select a.admin_id from admin as a inner join orders as o on o.categories_id = a.categories_id where o.orders_id = $orders_id limit 1),$orders_id,$orders_status_id)");
			return true;
	}
	
	
	
	private function autoDispatch(){
		$this->updateOrdersTrueHistory($this->Link['orders_id'],1);
		if($this->Link['delivery']==1){
			return true;
		}else{
			$this->updateOrdersTrueHistory($this->Link['orders_id'],2);
			try{
				include (__DIR__."/../../aAsd23fadfAd2565Hccxz/auto_send.php");
				$auto = new AutoSend;
				$auto->send(intval($this->Link['orders_id']),true);
				return true;
			}catch(Exception $e){
				return true;
			}
			
		}
	}
	
	private function ordersMain(){
		
		
		$categories_id=$this->CategoriesId;
		$customers_id=33;
		$customers_telephone=$this->Link['customer']['phone'];
		$customers_email_address=$this->Link['customer']['email'];
		$customers_lat=$this->Link['customer_coordinates']['lat'];
		$customers_lng=$this->Link['customer_coordinates']['lng'];
		
		
		$customers_name=$this->Link['customer']['name'];
		$customers_street_address=$this->Link['delivery_address']['street_number'].' '.$this->Link['delivery_address']['street'].' '.$this->Link['delivery_address']['apt'];
		$customers_city=$this->Link['delivery_address']['city'];
		$customers_state=$this->Link['delivery_address']['state'];
		$customers_postcode=$this->Link['delivery_address']['zipcode'];
		$customers_country='United States';

		$delivery_name=$this->Link['customer']['name'];
		$delivery_street_address=$this->Link['delivery_address']['street_number'].' '.$this->Link['delivery_address']['street'].' '.$this->Link['delivery_address']['apt'];
		$delivery_city=$this->Link['delivery_address']['city'];
		$delivery_state=$this->Link['delivery_address']['state'];
		$delivery_postcode=$this->Link['delivery_address']['zipcode'];
		$delivery_country='United States';
		
		$billing_name=$this->Link['customer']['name'];
		$billing_street_address=$this->Link['delivery_address']['street_number'].' '.$this->Link['delivery_address']['street'].' '.$this->Link['delivery_address']['apt'];
		$billing_city=$this->Link['delivery_address']['city'];
		$billing_state=$this->Link['delivery_address']['state'];
		$billing_postcode=$this->Link['delivery_address']['zipcode'];
		$billing_country='United States';
		
		$distance_to_deliver=$this->Link['distance'];
		$duration_to_deliver=$this->Link['duration'];
		$order_tax=$this->Link['totals']['tax'];
		$order_total=$this->Link['totals']['grand_total'];
		
		
		$cash_order=0;
		switch($this->Link['payment_type']){
			case PAYMENT_CASH:
			  $cash_order=1;
			  $payment_method='Cash';
			  $payment_module_code='cod';
			break;
			case PAYMENT_CREDIT:
			  $payment_method='Credit Card';
			  $payment_module_code='braintree_api';
				if($this->Link['delivery']==1){
					$this->ordersStatusId = 6;	
				}
			break;
			case PAYMENT_INSTORE:
			  $payment_method='In Store';
			  $payment_module_code='instore';
			break;
		}


		
		$orders_status=$this->ordersStatusId;
		$date_deliver=date('Y-m-d H:i:s');
		$date_purchased=date('Y-m-d H:i:s');
		$last_modified=date('Y-m-d H:i:s');
		$currency='USD';
		$currency_value=1.0;
		
		if($this->Link['delivery']==1){
			$shipping_method='Delivery';
			$shipping_module_code='flat';
			$pickup_order = 0;
		}else{
			$shipping_method='Pickup';
			$shipping_module_code='none';
			$pickup_order = 1;
		}
		
		$COWOA_order=1;

		
		//if($this->CategoriesId==11833){
			//$cash_order=0;
			//$payment_method='Invoice';
			//$payment_module_code='invoice';
		//}
		
		//if(in_array($this->CategoriesId,array(11833,62))){
			$new_payment_flag=1;
		//}else{
			//$new_payment_flag=0;	
		//}
		
		$order_table="
		INSERT INTO orders 
		(
		categories_id,
		customers_id,
		customers_telephone,
		customers_email_address,
		customers_lat,
		customers_lng,
		
		customers_name,
		customers_street_address,
		customers_city,
		customers_state,
		customers_postcode,
		customers_country,
		customers_address_format_id,
		
		delivery_name,
		delivery_street_address,
		delivery_city,
		delivery_state,
		delivery_postcode,
		delivery_country,
		delivery_address_format_id,
		
		billing_name,
		billing_street_address,
		billing_city,
		billing_state,
		billing_postcode,
		billing_country,
		billing_address_format_id,
		
		distance_to_deliver,
		duration_to_deliver,
		order_tax,
		order_total,
		payment_method,
		payment_module_code,
		cash_order,
		
		date_deliver,
		date_purchased,
		last_modified,
		orders_status,
		currency,
		currency_value,
		shipping_method,
		shipping_module_code,
		COWOA_order,
		new_payment_flag,
		online_order,
		pickup_order
		)
		VALUES
		(
		:categories_id,
		:customers_id,
		:customers_telephone,
		:customers_email_address,
		:customers_lat,
		:customers_lng,
		
		:customers_name,
		:customers_street_address,
		:customers_city,
		:customers_state,
		:customers_postcode,
		:customers_country,
		2,
		
		:delivery_name,
		:delivery_street_address,
		:delivery_city,
		:delivery_state,
		:delivery_postcode,
		:delivery_country,
		2,
		
		:billing_name,
		:billing_street_address,
		:billing_city,
		:billing_state,
		:billing_postcode,
		:billing_country,
		2,
		
		:distance_to_deliver,
		:duration_to_deliver,
		:order_tax,
		:order_total,
		:payment_method,
		:payment_module_code,
		:cash_order,
		
		:date_deliver,
		:date_purchased,
		:last_modified,
		:orders_status,
		:currency,
		:currency_value,
		:shipping_method,
		:shipping_module_code,
		:COWOA_order,
		$new_payment_flag,
		1,
		$pickup_order
		)";
		//
		$orders = $this->db->prepare($order_table);
		//
		$orders->bindValue(':categories_id', $categories_id, PDO::PARAM_STR);
		$orders->bindValue(':customers_id', $customers_id, PDO::PARAM_STR);
		$orders->bindValue(':customers_telephone', $customers_telephone, PDO::PARAM_STR);
		$orders->bindValue(':customers_email_address', $customers_email_address, PDO::PARAM_STR);
		$orders->bindValue(':customers_lat', $customers_lat, PDO::PARAM_STR);
		$orders->bindValue(':customers_lng', $customers_lng, PDO::PARAM_STR);

		$orders->bindValue(':customers_name', $customers_name, PDO::PARAM_STR);
		$orders->bindValue(':customers_street_address', $customers_street_address, PDO::PARAM_STR);
		$orders->bindValue(':customers_city', $customers_city, PDO::PARAM_STR);
		$orders->bindValue(':customers_state', $customers_state, PDO::PARAM_STR);
		$orders->bindValue(':customers_postcode', $customers_postcode, PDO::PARAM_STR);
		$orders->bindValue(':customers_country', $customers_country, PDO::PARAM_STR);
		
		$orders->bindValue(':delivery_name', $delivery_name, PDO::PARAM_STR);
		$orders->bindValue(':delivery_street_address', $delivery_street_address, PDO::PARAM_STR);
		$orders->bindValue(':delivery_city', $delivery_city, PDO::PARAM_STR);
		$orders->bindValue(':delivery_state', $delivery_state, PDO::PARAM_STR);
		$orders->bindValue(':delivery_postcode', $delivery_postcode, PDO::PARAM_STR);
		$orders->bindValue(':delivery_country', $delivery_country, PDO::PARAM_STR);
		
		$orders->bindValue(':billing_name', $billing_name, PDO::PARAM_STR);
		$orders->bindValue(':billing_street_address', $billing_street_address, PDO::PARAM_STR);
		$orders->bindValue(':billing_city', $billing_city, PDO::PARAM_STR);
		$orders->bindValue(':billing_state', $billing_state, PDO::PARAM_STR);
		$orders->bindValue(':billing_postcode', $billing_postcode, PDO::PARAM_STR);
		$orders->bindValue(':billing_country', $billing_country, PDO::PARAM_STR);
		
		$orders->bindValue(':distance_to_deliver', $distance_to_deliver, PDO::PARAM_STR);
		$orders->bindValue(':duration_to_deliver', $duration_to_deliver, PDO::PARAM_STR);
		$orders->bindValue(':order_tax', $order_tax, PDO::PARAM_STR);
		$orders->bindValue(':order_total', $order_total, PDO::PARAM_STR);
		$orders->bindValue(':payment_method', $payment_method, PDO::PARAM_STR);
		$orders->bindValue(':payment_module_code', $payment_module_code, PDO::PARAM_STR);
		$orders->bindValue(':cash_order', $cash_order, PDO::PARAM_STR);
		
		$orders->bindValue(':date_deliver', $date_deliver, PDO::PARAM_STR);
		$orders->bindValue(':date_purchased', $date_purchased, PDO::PARAM_STR);
		$orders->bindValue(':last_modified', $last_modified, PDO::PARAM_STR);
		$orders->bindValue(':orders_status', $orders_status, PDO::PARAM_STR);
		$orders->bindValue(':currency', $currency, PDO::PARAM_STR);
		$orders->bindValue(':currency_value', $currency_value, PDO::PARAM_STR);
		$orders->bindValue(':shipping_method', $shipping_method, PDO::PARAM_STR);
		$orders->bindValue(':shipping_module_code', $shipping_module_code, PDO::PARAM_STR);
		$orders->bindValue(':COWOA_order', $COWOA_order, PDO::PARAM_STR);

		//
		$orders->execute();
		//
		$this->Link['orders_id']=$this->db->lastInsertId();
		if(intval($this->Link['orders_id'])===0){
			return false;
		}
		//possibl move this to end
    	$online_json_sql = 'INSERT INTO online_json_order (link,orders_id) VALUES (:link,:orders_id)';
		$online_json = $this->db->prepare($online_json_sql);
		$online_json->bindValue(':link', json_encode($this->Link), PDO::PARAM_STR);
		$online_json->bindValue(':orders_id', $this->Link['orders_id'], PDO::PARAM_STR);
		$online_json->execute();
		
		//if(in_array(intval($categories_id),array(12180,12181,12182,12268,12293,12304,12590,12601,12602,12747))){
		//	mail('9203766009@messaging.sprintpcs.com','New Oshkosh Order','Order Id: '. $this->Link['orders_id']);
		//}
		return true;
	}
	
	private function creditCardInfo(){
		if($this->Link['payment_type']!==PAYMENT_CREDIT){
			return true;
		}
		if(!isset($this->Link['braintree_info']) || !isset($this->Link['braintree_info']['transaction_id'])){
			return false;
		}
		$credit_sql = '
		INSERT INTO braintree_info 
			(orders_id,transaction_id,authorization_amount,settlement_amount,status)
		VALUES 
			(:orders_id,:transaction_id,:authorization_amount,0,:status)';
			
		$credit = $this->db->prepare($credit_sql);
		$credit->bindValue(':orders_id', intval($this->Link['orders_id']), PDO::PARAM_INT);
		$credit->bindValue(':transaction_id', $this->Link['braintree_info']['transaction_id'], PDO::PARAM_STR);
		//$credit->bindValue(':credit_card_token', $this->Link['braintree_info']['credit_card_token'], PDO::PARAM_STR);
		$credit->bindValue(':authorization_amount', $this->Link['braintree_info']['authorization_amount'], PDO::PARAM_STR);
		$credit->bindValue(':status', $this->Link['braintree_info']['status'], PDO::PARAM_STR);
		$credit->execute();
		return true;
	}
	
	private function ordersTotal(){
		if($this->Link['delivery']===0){
			$this->Link['totals']['delivery_fee']=0;
		}
		$value_array=array
		(
			$this->Link['totals']['subtotal'],
			$this->Link['totals']['delivery_fee'],
			$this->Link['totals']['tax'],
			$this->Link['totals']['tip'],
			$this->Link['totals']['grand_total']
		);
		
		$class_array=array('ot_subtotal', 'ot_shipping', 'ot_tax',     'ot_tip',    'ot_total');
		$title_array=array('Subtotal:',   'Delivery:',   'Sales Tax:', 'Gratuity:', 'Total:');
		$sort_array= array(100,           200,           351,          800,          999);
		
		for($i=0;$i<count($value_array);$i++){
			$orders_total_sql="
			INSERT INTO orders_total
				( orders_id, title, text, value, class, sort_order)
			VALUES
				(:orders_id,:title,:text,:value,:class,:sort_order)";
			$orders_total = $this->db->prepare($orders_total_sql);
			
			$orders_total->bindValue(':orders_id', $this->Link['orders_id'] , PDO::PARAM_STR);
			$orders_total->bindValue(':title', $title_array[$i] , PDO::PARAM_STR);
			$orders_total->bindValue(':text', money_format('$%i', $value_array[$i]) , PDO::PARAM_STR);
			$orders_total->bindValue(':value', $value_array[$i] , PDO::PARAM_STR);
			$orders_total->bindValue(':class', $class_array[$i] , PDO::PARAM_STR);
			$orders_total->bindValue(':sort_order', $sort_array[$i] , PDO::PARAM_STR);
			$orders_total->execute();
		}
		return true;
	}

	
	public function ordersProducts(){

		foreach($this->Link['cart'] as &$o){

			//298 11-1 13-1477
			$orders_products_sql='
			INSERT INTO orders_products 
			
			(products_id, products_name, products_model, products_price, products_priced_by_attribute, final_price, products_quantity, products_tax,orders_id )
			SELECT 
			p.products_id, pd.products_name,p.products_model, p.products_price, p.products_priced_by_attribute, :final_price,:products_quantity,:products_tax,:orders_id
			
			FROM products AS p
			INNER JOIN products_description AS pd ON pd.products_id = p.products_id
			WHERE p.products_id =:products_id';

					
			$orders_products = $this->db->prepare($orders_products_sql);		
			
			$orders_products->bindValue(':orders_id', $this->Link['orders_id'] , PDO::PARAM_STR);
			$orders_products->bindValue(':products_id', $o[0] , PDO::PARAM_STR);
			$orders_products->bindValue(':products_quantity', $o[1] , PDO::PARAM_STR);
			$orders_products->bindValue(':final_price', $o[4] , PDO::PARAM_STR);
			$orders_products->bindValue(':products_tax', $this->Link['tax_rate']*100 , PDO::PARAM_STR);
			
			$orders_products->execute();	
			$orders_products_id=$this->db->lastInsertId();	
					
			$this->ordersProductsAttributes($o,$orders_products_id);
		}
		return true;
	}
	
	
	
	private function ordersProductsAttributes(&$o,$orders_products_id){
		
		if(strlen($o[2])>2){
			
			$special_instructions_sql='
			insert into orders_products_attributes 
			(orders_id, orders_products_id, products_options, products_options_values)
			VALUES
			(:orders_id,:orders_products_id,:products_options,:products_options_values)';
			
			$special_instructions = $this->db->prepare($special_instructions_sql);	
			
			$special_instructions->bindValue(':orders_id', $this->Link['orders_id'], PDO::PARAM_STR);
			$special_instructions->bindValue(':orders_products_id', $orders_products_id , PDO::PARAM_STR);
			$special_instructions->bindValue(':products_options', SPECIAL_INSTRUCTIONS_STRING, PDO::PARAM_STR);
			$special_instructions->bindValue(':products_options_values', addslashes($o[2]) , PDO::PARAM_STR);
			
			$special_instructions->execute();
		}

		foreach($o[3] as $options){
			if($options===0){
				break;
			}
			
			$splode = explode('-',$options);
	
			$orders_products_attributes_sql="
				INSERT INTO orders_products_attributes
				
					( orders_id, orders_products_id, products_options, products_options_values,
					options_values_price,price_prefix,product_attribute_is_free,attributes_price_base_included,products_options_id,
					products_options_values_id,attributes_discounted)
					
				SELECT 
				
					:orders_id,:orders_products_id,po.products_options_name,pov.products_options_values_name,
					pa.options_values_price,pa.price_prefix,pa.product_attribute_is_free,pa.attributes_price_base_included,:products_options,
					:products_options_values,pa.attributes_discounted
					
				FROM products_attributes AS pa
				INNER JOIN products_options AS po ON pa.options_id = po.products_options_id
				INNER JOIN products_options_values AS pov ON pa.options_values_id = pov.products_options_values_id
				
				WHERE po.products_options_id = :products_options 
				AND pov.products_options_values_id = :products_options_values
				AND pa.products_id= :products_id";
					
			$orders_products_attributes = $this->db->prepare($orders_products_attributes_sql);	
				
			$orders_products_attributes->bindValue(':orders_id', $this->Link['orders_id'], PDO::PARAM_STR);
			$orders_products_attributes->bindValue(':orders_products_id', $orders_products_id , PDO::PARAM_STR);
			$orders_products_attributes->bindValue(':products_id', $o[0] , PDO::PARAM_STR);
			$orders_products_attributes->bindValue(':products_options', $splode[0] , PDO::PARAM_STR);
			$orders_products_attributes->bindValue(':products_options_values', $splode[1] , PDO::PARAM_STR);
			
			$orders_products_attributes->execute();
					
		}
		return true;	
	}
	
	private function ordersNotes(){
		$orders_notes_sql="
		INSERT INTO notes
			( order_id, note_type, note, made_by)
		VALUES
			(".$this->Link['orders_id'].",4,:note,0)";	
		$orders_notes = $this->db->prepare($orders_notes_sql);
		$orders_notes->bindValue(':note', $this->Link['orders_comments'] , PDO::PARAM_STR);
		$orders_notes->execute();
		return true;
	}
	
	private function ordersStatusHistory(){
		$orders_status_history_sql="
		INSERT INTO orders_status_history
			( orders_id, orders_status_id, comments, updated_by, date_added)
		VALUES
			(:orders_id,:orders_status_id,:comments,:updated_by, NOW())";
			
		$orders_status_history = $this->db->prepare($orders_status_history_sql);
		
		
		$orders_status_history->bindValue(':orders_id', $this->Link['orders_id'] , PDO::PARAM_STR);
		$orders_status_history->bindValue(':orders_status_id', 1 , PDO::PARAM_STR);
		$orders_status_history->bindValue(':comments', $this->Link['orders_comments'] , PDO::PARAM_STR);
		$orders_status_history->bindValue(':updated_by', $this->Link['customer']['name'], PDO::PARAM_STR);
		
		$orders_status_history->execute();
		return true;
	}
		
		
  
}
?>