<?php
$is_daylight_savings=true;
function orderGeneratePizzaDepot($post){
	global $db;
	$customers_name=$post['name'];
	$city=$post['city'];
	$postcode=$post['zip'];
	$state='WI';
	$address=$post['address'];
	$phone=$post['phone'];
	$gh_id=0;
	$is_adjusted_order=0;
	$categories_id=11977;
	$email='';
	$payment_method='Invoice';
	$payment_method_code='invoice';
	$company = addslashes($post['company']);
	if($post['type']=='Credit'){
		$payment_method='Credit Card';
		$payment_method_code='braintree_api';
		$is_cash=0;
	}else{
		$payment_method='Cash';
		$payment_method_code='cod';	
		$is_cash=1;
	}
	//orders total table
	$salestax=$post['tax'];
	$subtotal=$post['subtotal'];
	$tip=$post['tip'];
	$delivery_fee=$post['delivery'];
	$total=$salestax+$subtotal+$delivery_fee+$tip;
	//orders products table
	$tmp1[]=array('products_options_values'=>'PizzaDepot','options_values_price'=>'','price_prefix'=>'');
	$products_array[]=array('name'=>'Misc Charge','price'=>$post['subtotal'],'final_price'=>$post['subtotal'],'quantity'=>1,'tax'=>0,'model'=>'',
	'options'=>$tmp1);
//	$tmp2[]=array('products_options_values'=>'Wok','options_values_price'=>'','price_prefix'=>'');
//	$products_array[]=array('name'=>'Fake Product','price'=>0,'final_price'=>0,'quantity'=>0,'tax'=>0,'model'=>'',
//	'options'=>$tmp2);
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
		customers_company,
		delivery_company,
		billing_company
		)
		VALUES
		(
		'".$categories_id."',
		41328,
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
		now(),
		now(),
		3,
		1,
		now(),
		1,
		'".$salestax."',
		'".$total."',
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
		'".$company."',
		'".$company."',
		'".$company."'
		)";
		$db->Execute($order_table);
		$orders_id=$db->Insert_ID();
		$value_array=array($subtotal,$delivery_fee,$salestax,$tip,$total);
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
			  '".$orders_id."','".$title_array[$i]."','".money_format('$%i', $value_array[$i])."','".$value_array[$i]."','".$class_array[$i]."','".$sort_array[$i]."'
		  )";
		  $db->Execute($orders_total);
		}
		foreach($products_array as $p){
			$orders_products="
			INSERT INTO orders_products
				(products_model,orders_id,products_id,products_name,products_price,final_price,products_quantity,products_tax)
			VALUES
				('".$p['model']."','".$orders_id."',0,'".$p['name']."',".$p['price'].",".$p['final_price'].",".$p['quantity'].",".$p['tax'].")";
			$db->Execute($orders_products);
			$orders_products_id=$db->Insert_ID();
			foreach($p['options'] as $o){
				$orders_products_attributes="
				INSERT INTO orders_products_attributes
					(orders_id,orders_products_id,products_options_values,options_values_price,price_prefix)
				VALUES
					('".$orders_id."','".$orders_products_id."','".$o['products_options_values']."','".$o['options_values_price']."','".$o['price_prefix']."')";
				$db->Execute($orders_products_attributes);
			}	
		}
		$speci = addslashes($post['special']).'--  Order Number #'.$post['wokorder'];
		$db->Execute("insert into orders_status_history (orders_id,orders_status_id,date_added,comments,updated_by) values ($orders_id,1,now(),'".$speci."','Dispatch')");
		if(isset($_GET['payment_method_nonce'])){
		$credit_sql = '
		INSERT INTO braintree_info 
			(orders_id,transaction_id,credit_card_token,authorization_amount,settlement_amount,status)
		VALUES 
			("'.$orders_id.'","'.$post['transaction_id'].'","'.$post['credit_card_token'].'","'.$post['authorization_amount'].'",0,"'.$post['status'].'")';
			$db->Execute($credit_sql);
		$main_time = date('m/d/y g:ia',strtotime('now'));
			$commentString = "Transaction ID: :transID: " .
                "\nPayment Type: :pmtType: " .
                ($main_time != '' ? "\nTimestamp: :pmtTime: " : "") .
                "\nPayment Status: :pmtStatus: " .
                (trim($post['authorization_amount']) != '' ? "\nAmount: :orderAmt: " : "");
        $commentString = $db->bindVars($commentString, ':transID:', $post['transaction_id'], 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtType:', 'Credit Card', 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtTime:', $main_time, 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtStatus:', $post['status'], 'noquotestring');
        $commentString = $db->bindVars($commentString, ':orderAmt:', $post['authorization_amount'], 'noquotestring');
		$db->Execute("INSERT INTO orders_status_history ( orders_id, orders_status_id, date_added, customer_notified, comments, updated_by) 
		VALUES ('".$orders_id."', '1', '".date('Y-m-d H:i:s',strtotime('now'))."', '0', '".$commentString."', '')");
		}
		$_SESSION['new_id']=$orders_id;
		return true;
}
function orderGenerateGinger($post){
	global $db;
	$customers_name=$post['name'];
	$city=$post['city'];
	$postcode=$post['zip'];
	$state='WI';
	$address=$post['address'];
	$phone=$post['phone'];
	$gh_id=0;
	$is_adjusted_order=0;
	$categories_id=70;
	$email='';
	$payment_method='Invoice';
	$payment_method_code='invoice';
	$company = addslashes($post['company']);
	if($post['type']=='Credit'){
		$payment_method='Credit Card';
		$payment_method_code='braintree_api';
		$is_cash=0;
	}else{
		$payment_method='Cash';
		$payment_method_code='cod';	
		$is_cash=1;
	}
	//orders total table
	$salestax=$post['tax'];
	$subtotal=$post['subtotal'];
	$tip=$post['tip'];
	$delivery_fee=$post['delivery'];
	$total=$salestax+$subtotal+$delivery_fee+$tip;
	//orders products table
	$tmp1[]=array('products_options_values'=>'GingeRootz','options_values_price'=>'','price_prefix'=>'');
	$products_array[]=array('name'=>'Misc Charge','price'=>$post['subtotal'],'final_price'=>$post['subtotal'],'quantity'=>1,'tax'=>0,'model'=>'',
	'options'=>$tmp1);
//	$tmp2[]=array('products_options_values'=>'Wok','options_values_price'=>'','price_prefix'=>'');
//	$products_array[]=array('name'=>'Fake Product','price'=>0,'final_price'=>0,'quantity'=>0,'tax'=>0,'model'=>'',
//	'options'=>$tmp2);
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
		customers_company,
		delivery_company,
		billing_company
		)
		VALUES
		(
		'".$categories_id."',
		41328,
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
		now(),
		now(),
		3,
		1,
		now(),
		1,
		'".$salestax."',
		'".$total."',
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
		'".$company."',
		'".$company."',
		'".$company."'
		)";
		$db->Execute($order_table);
		$orders_id=$db->Insert_ID();
		$value_array=array($subtotal,$delivery_fee,$salestax,$tip,$total);
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
			  '".$orders_id."','".$title_array[$i]."','".money_format('$%i', $value_array[$i])."','".$value_array[$i]."','".$class_array[$i]."','".$sort_array[$i]."'
		  )";
		  $db->Execute($orders_total);
		}
		foreach($products_array as $p){
			$orders_products="
			INSERT INTO orders_products
				(products_model,orders_id,products_id,products_name,products_price,final_price,products_quantity,products_tax)
			VALUES
				('".$p['model']."','".$orders_id."',0,'".$p['name']."',".$p['price'].",".$p['final_price'].",".$p['quantity'].",".$p['tax'].")";
			$db->Execute($orders_products);
			$orders_products_id=$db->Insert_ID();
			foreach($p['options'] as $o){
				$orders_products_attributes="
				INSERT INTO orders_products_attributes
					(orders_id,orders_products_id,products_options_values,options_values_price,price_prefix)
				VALUES
					('".$orders_id."','".$orders_products_id."','".$o['products_options_values']."','".$o['options_values_price']."','".$o['price_prefix']."')";
				$db->Execute($orders_products_attributes);
			}	
		}
		$speci = addslashes($post['special']).'--  Order Number #'.$post['wokorder'];
		$db->Execute("insert into orders_status_history (orders_id,orders_status_id,date_added,comments,updated_by) values ($orders_id,1,now(),'".$speci."','Dispatch')");
		if(isset($_GET['payment_method_nonce'])){
		$credit_sql = '
		INSERT INTO braintree_info 
			(orders_id,transaction_id,credit_card_token,authorization_amount,settlement_amount,status)
		VALUES 
			("'.$orders_id.'","'.$post['transaction_id'].'","'.$post['credit_card_token'].'","'.$post['authorization_amount'].'",0,"'.$post['status'].'")';
			$db->Execute($credit_sql);
		$main_time = date('m/d/y g:ia',strtotime('now'));
			$commentString = "Transaction ID: :transID: " .
                "\nPayment Type: :pmtType: " .
                ($main_time != '' ? "\nTimestamp: :pmtTime: " : "") .
                "\nPayment Status: :pmtStatus: " .
                (trim($post['authorization_amount']) != '' ? "\nAmount: :orderAmt: " : "");
        $commentString = $db->bindVars($commentString, ':transID:', $post['transaction_id'], 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtType:', 'Credit Card', 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtTime:', $main_time, 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtStatus:', $post['status'], 'noquotestring');
        $commentString = $db->bindVars($commentString, ':orderAmt:', $post['authorization_amount'], 'noquotestring');
		$db->Execute("INSERT INTO orders_status_history ( orders_id, orders_status_id, date_added, customer_notified, comments, updated_by) 
		VALUES ('".$orders_id."', '1', '".date('Y-m-d H:i:s',strtotime('now'))."', '0', '".$commentString."', '')");
		}
		$_SESSION['new_id']=$orders_id;
		return true;
}
function orderGenerateZaroty($post){
	global $db;
	$customers_name=$post['name'];
	$city=$post['city'];
	$postcode=$post['zip'];
	$state='ND';
	$address=$post['address'];
	$phone=$post['phone'];
	$gh_id=0;
	$is_adjusted_order=0;
	$categories_id=92;
	$email='';
	$payment_method='Invoice';
	$payment_method_code='invoice';
	$company = addslashes($post['company']);
	if($post['type']=='Credit'){
		$payment_method='Credit Card';
		$payment_method_code='braintree_api';
		$is_cash=0;
	}else{
		$payment_method='Cash';
		$payment_method_code='cod';	
		$is_cash=1;
	}
	//orders total table
	$salestax=$post['tax'];
	$subtotal=$post['subtotal'];
	$tip=0;
	$delivery_fee=$post['delivery'];
	$total=$salestax+$subtotal+$delivery_fee;
	//orders products table
	$tmp1[]=array('products_options_values'=>'SuperBuffet','options_values_price'=>'','price_prefix'=>'');
	$products_array[]=array('name'=>'Misc Charge','price'=>$post['subtotal'],'final_price'=>$post['subtotal'],'quantity'=>1,'tax'=>0,'model'=>'',
	'options'=>$tmp1);
//	$tmp2[]=array('products_options_values'=>'Wok','options_values_price'=>'','price_prefix'=>'');
//	$products_array[]=array('name'=>'Fake Product','price'=>0,'final_price'=>0,'quantity'=>0,'tax'=>0,'model'=>'',
//	'options'=>$tmp2);
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
		customers_company,
		delivery_company,
		billing_company
		)
		VALUES
		(
		'".$categories_id."',
		41328,
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
		now(),
		now(),
		3,
		1,
		now(),
		1,
		'".$salestax."',
		'".$total."',
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
		'".$company."',
		'".$company."',
		'".$company."'
		)";
		$db->Execute($order_table);
		$orders_id=$db->Insert_ID();
		$value_array=array($subtotal,$delivery_fee,$salestax,$tip,$total);
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
			  '".$orders_id."','".$title_array[$i]."','".money_format('$%i', $value_array[$i])."','".$value_array[$i]."','".$class_array[$i]."','".$sort_array[$i]."'
		  )";
		  $db->Execute($orders_total);
		}
		foreach($products_array as $p){
			$orders_products="
			INSERT INTO orders_products
				(products_model,orders_id,products_id,products_name,products_price,final_price,products_quantity,products_tax)
			VALUES
				('".$p['model']."','".$orders_id."',0,'".$p['name']."',".$p['price'].",".$p['final_price'].",".$p['quantity'].",".$p['tax'].")";
			$db->Execute($orders_products);
			$orders_products_id=$db->Insert_ID();
			foreach($p['options'] as $o){
				$orders_products_attributes="
				INSERT INTO orders_products_attributes
					(orders_id,orders_products_id,products_options_values,options_values_price,price_prefix)
				VALUES
					('".$orders_id."','".$orders_products_id."','".$o['products_options_values']."','".$o['options_values_price']."','".$o['price_prefix']."')";
				$db->Execute($orders_products_attributes);
			}	
		}
		$speci = addslashes($post['special']).'--  Order Number #'.$post['wokorder'];
		$db->Execute("insert into orders_status_history (orders_id,orders_status_id,date_added,comments,updated_by) values ($orders_id,1,now(),'".$speci."','Dispatch')");
		if(isset($_GET['payment_method_nonce'])){
		$credit_sql = '
		INSERT INTO braintree_info 
			(orders_id,transaction_id,credit_card_token,authorization_amount,settlement_amount,status)
		VALUES 
			("'.$orders_id.'","'.$post['transaction_id'].'","'.$post['credit_card_token'].'","'.$post['authorization_amount'].'",0,"'.$post['status'].'")';
			$db->Execute($credit_sql);
		$main_time = date('m/d/y g:ia',strtotime('now'));
			$commentString = "Transaction ID: :transID: " .
                "\nPayment Type: :pmtType: " .
                ($main_time != '' ? "\nTimestamp: :pmtTime: " : "") .
                "\nPayment Status: :pmtStatus: " .
                (trim($post['authorization_amount']) != '' ? "\nAmount: :orderAmt: " : "");
        $commentString = $db->bindVars($commentString, ':transID:', $post['transaction_id'], 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtType:', 'Credit Card', 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtTime:', $main_time, 'noquotestring');
        $commentString = $db->bindVars($commentString, ':pmtStatus:', $post['status'], 'noquotestring');
        $commentString = $db->bindVars($commentString, ':orderAmt:', $post['authorization_amount'], 'noquotestring');
		$db->Execute("INSERT INTO orders_status_history ( orders_id, orders_status_id, date_added, customer_notified, comments, updated_by) 
		VALUES ('".$orders_id."', '1', '".date('Y-m-d H:i:s',strtotime('now'))."', '0', '".$commentString."', '')");
		}
		return true;
}
//function get_menus(){
//	global $db;
//	$rr= $db->Execute('select c.categories_id from categories as c inner join categories_description as cd 
//	on cd.categories_id=c.categories_id where categories_name="Menu 1"');
//	while(!$rr->EOF){
//		$rk=$db->Execute('select categories_id from categories where parent_id="'.$rr->fields['categories_id'].'"');
//		$gg[$rr->fields['categories_id']][]=$rk->fields['categories_id'];
//	$rr->MoveNext();	
//	}
//
//		return json_encode($gg);
//}
  function zm_get_products_model($product_id) {
    global $db;
    $product_query = "select products_model
                      from products
                      where products_id = '" . (int)$product_id . "' ";
    $product = $db->Execute($product_query);
    return $product->fields['products_model'];
  }
    function zm_get_products_virtual($product_id) {
    global $db;
    $product_query = "select products_virtual
                      from products
                      where products_id = '" . (int)$product_id . "' ";
    $product = $db->Execute($product_query);
    return $product->fields['products_virtual'];
  }
function get_stack_error(){
	global $db;
	$note_array=array();
							$status3 = $db->Execute('select c.comments,a.parent_id from categories_description as c inner join categories as a on a.categories_id = c.categories_id where c.categories_id=1');
			$note_array[2]=$status3->fields['comments'];	
	if(isset($_SESSION['address_separated'])){
		$city = '';
		$city = $_SESSION['address_separated'][0]['city'];
			$status1 = $db->Execute('select c.comments,a.parent_id  from categories_description as c inner join categories as a on a.categories_id = c.categories_id where categories_name LIKE "%'.$city.'%" ');
			$note_array[0]=$status1->fields['comments'];
			if($status1->fields['parent_id']){
							$status2 = $db->Execute('select c.comments,a.parent_id from categories_description as c inner join categories as a on a.categories_id = c.categories_id where  c.categories_id="'.$status1->fields['parent_id'].'" ');
							$note_array[1]=$status2->fields['comments'];
			}
	}
	//print_r($note_array);
	if($note_array[2] && $note_array[2]!=''&& $note_array[2]!='na'){
		return $note_array[2];
	}else if($note_array[1] && $note_array[1]!=''&& $note_array[1]!='na'){
		return $note_array[1];	
	}else if($note_array[0] && $note_array[0]!='' && $note_array[0]!='na'){
		return $note_array[0];
	}else{
		return 2;
	}
}
function last_resort_category_id(){
	global $db;
	$category_id=0;
	if(isset($_SESSION['cart'])){
		$products=$_SESSION['cart']->get_product_id_array();
		$first_id = zen_get_products_category_id($products[0]);
		$sql_id= $db->Execute('
			SELECT parent_id
			FROM categories
			WHERE categories_id
			IN (
				SELECT parent_id
				FROM categories
				WHERE categories_id ="'.$first_id.'"
			)
			LIMIT 0 , 1');
		$first_name=zen_get_categories_name($sql_id->fields['parent_id']);
		$sql_name = $db->Execute('
			SELECT cd.base_city, cd.categories_id, cd.categories_name, cd.lat, cd.lng
			FROM categories_description AS cd
			WHERE cd.categories_name = "'.$first_name.'"
			LIMIT 0 , 300');
		$category_array=array();
		while (!$sql_name->EOF) {
			$category_array[]=array(
			'categories_id'=>$sql_name->fields['categories_id'],
			'categories_name'=>$sql_name->fields['categories_name'],
			'base_city'=>$sql_name->fields['base_city'],
			'lat'=>$sql_name->fields['lat'],
			'lng'=>$sql_name->fields['lng']);
			$sql_name->MoveNext();
  		}
	}
	if(is_array($category_array) && count($category_array)==1){
		$category_id=$category_array[0]['categories_id'];
	}
	if(is_array($category_array) && isset($_SESSION['city_shipping'])&& $category_id==0){
		$category_id=find_id_by_city_name($category_array);
	}
	if(isset($_SESSION['customers_lat_lng']) && is_array($category_array) && $category_id==0){
		$category_id = find_id_by_coords($category_array);
	}
	return $category_id;
}
function front_city_name_array(){
	global $db;
    $city_name_array = array();
 	$cityid_name = $db->Execute("SELECT cd.categories_name, c.parent_id
	FROM categories_description AS cd
	INNER JOIN categories AS c ON cd.categories_id = c.categories_id
	WHERE c.parent_id
	IN (
	SELECT categories_id
	FROM categories
	WHERE parent_id =1
	)
	and c.categories_id not in (1915)");
	$count1= 0;
 	while (!$cityid_name->EOF) {
   		$city_name_array[$count1] = $cityid_name->fields['categories_name'];
		$count1++;
    	$cityid_name->MoveNext();
  	}	
	return $city_name_array;	
}
function getRestaurantCopies(){
		include_once dirname(__FILE__) . '/../../../db_config.php';
		if(defined('_DB_SERVER')){
			$db_custom = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);
		}else{
			mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/includes/functions/extra_functions/functions_zm.php");
			$db_custom = new PDO("mysql:host=".'192.168.1.11'.";dbname=".'fooddudestaging_staging', 'fooddudestaging_user', '3W.mmR=Q]#{U');
		}
	  $restaurant_copy ="SELECT categories_name FROM categories_description AS cd INNER JOIN categories AS c ON c.categories_id = cd.categories_id WHERE c.parent_id IN ( SELECT categories_id FROM categories WHERE parent_id IN ( SELECT categories_id FROM categories WHERE parent_id =1 ) ) GROUP BY categories_name HAVING count( categories_name ) >1 LIMIT 0 , 999999";
	  $restaurant_copy = $db_custom->query($restaurant_copy)->fetchAll(pdo::FETCH_COLUMN);
	  foreach($restaurant_copy as &$n){ $n='"'.$n.'"'; }
	  $restaurant_copy = implode(',',$restaurant_copy);
	  $restaurant_copy = "select cd.categories_id, categories_name, address, parent_id from categories_description as cd inner join categories as c on c.categories_id = cd.categories_id where categories_name in($restaurant_copy)";
	  $restaurant_copy = $db_custom->query($restaurant_copy)->fetchAll(pdo::FETCH_ASSOC);
	  $copies=array();
	  foreach($restaurant_copy as $co){
		  $copies[]=$co['categories_id'];
	  }
	  return $copies;
}
function getRestaurantInfo($id){
	$id = intval($id);
		if($id == 0){
			return;
		}
		include_once dirname(__FILE__) . '/../../../db_config.php';
		if(defined('_DB_SERVER')){
			$db_custom = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);
		}else{
			mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/aAsd23fadfAd2565Hccxz/functions_zm.php");
			$db_custom = new PDO("mysql:host=".'192.168.1.11'.";dbname=".'fooddudestaging_staging', 'fooddudestaging_user', '3W.mmR=Q]#{U');
		}
	  $restaurant_copy = "select phone,cd.categories_id, categories_name, address, parent_id from categories_description as cd inner join categories as c on c.categories_id = cd.categories_id where c.categories_id =$id ";
	  $restaurant_copy = $db_custom->query($restaurant_copy)->fetch(pdo::FETCH_ASSOC);
	  return $restaurant_copy;
}
function getRestaurantDistance($rlist){
		if(count($rlist)<2 || !isset($_SESSION['customers_lat_lng'])){
			return array();	
		}
		include_once dirname(__FILE__) . '/../../../db_config.php';
		if(defined('_DB_SERVER')){
			$db_custom = new PDO("mysql:host="._DB_SERVER.";dbname="._DB_DATABASE, _DB_SERVER_USERNAME, _DB_SERVER_PASSWORD);
		}else{
			mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/includes/functions/extra_functions/functions_zm.php");
	  		$db_custom = new PDO("mysql:host=".'192.168.1.11'.";dbname=".'fooddudestaging_staging', 'fooddudestaging_user', '3W.mmR=Q]#{U');
		}
	  $restaurant_copy ="SELECT categories_name FROM categories_description AS cd INNER JOIN categories AS c ON c.categories_id = cd.categories_id WHERE c.parent_id IN ( SELECT categories_id FROM categories WHERE parent_id IN ( SELECT categories_id FROM categories WHERE parent_id =1 ) ) GROUP BY categories_name HAVING count( categories_name ) >1 LIMIT 0 , 999999";
	  $restaurant_copy = $db_custom->query($restaurant_copy)->fetchAll(pdo::FETCH_COLUMN);
	  foreach($restaurant_copy as &$n){ $n='"'.$n.'"'; }
	  $restaurant_copy = implode(',',$restaurant_copy);
	  $restaurant_copy = "select cd.categories_id, categories_name, address, parent_id from categories_description as cd inner join categories as c on c.categories_id = cd.categories_id where categories_name in($restaurant_copy)";
	  $restaurant_copy = $db_custom->query($restaurant_copy)->fetchAll(pdo::FETCH_ASSOC);
	  $copies=array();
	  foreach($restaurant_copy as $co){
		  $copies[]=$co['categories_id'];
	  }
	  $relevant_duplicates=array();
	  foreach($rlist as $li){
		  if(in_array($li,$copies)){
			  $relevant_duplicates[]=$li;
		  }
	  }
	  $info = $db_custom->query('select lat,lng,categories_name,categories_id from categories_description where categories_id in ('.implode(',',$relevant_duplicates).')');
	  $final=array();
	  foreach($info as $i){
		  $final[$i['categories_name']][]=array( 'lat'=>$i['lat'],'lng'=>$i['lng'],'categories_name'=>$i['categories_name'],'categories_id'=>$i['categories_id']);
	  }
	$lat1=$_SESSION['customers_lat_lng'][0];
	$lon1=$_SESSION['customers_lat_lng'][1];
	$distance_array= array();
	$fda=array();
	foreach($final as $cba){
		foreach($cba as $ca){
		//print_r($ca);
		$lat2=$ca['lat'];	
		$lon2=$ca['lng'];
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$distance_array[$ca['categories_id']]= $miles;
		}
		$fda[]=$distance_array;
	}
	$lolfinal=array();
	foreach($fda as $f){
		$lolfinal[]=array_search(max($f),$f);
	}
	  return $lolfinal;
}
function find_id_by_coords($category_array){
	$lat1=$_SESSION['customers_lat_lng'][0];
	$lon1=$_SESSION['customers_lat_lng'][1];
	$distance_array= array();
	foreach($category_array as $ca){
		$lat2=$ca['lat'];	
		$lon2=$ca['lng'];
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$distance_array[$ca['categories_id']]= $miles;
	}
	$category_id = array_keys($distance_array, min($distance_array));
	return $category_id[0];
}
function find_id_by_city_name($category_array){
	$category_id=0;
	$customers_city = strtoupper($_SESSION['city_shipping']);
	if($customers_city=='ST CLOUD'){$customers_city='SAINT CLOUD';}
	foreach($category_array as $ca){
		if($category_id==0){
			if(strtoupper($ca['base_city'])==$customers_city){
				$category_id=$ca['categories_id'];
			}
		}
	}
	return $category_id;
}
function admin_master_pass($pass){
	global $db;
	$pass_sql = $db->Execute('select admin_pass from admin where admin_profile=1');
	$iffalse = false;
	 while (!$pass_sql->EOF) {
		 if(!$iffalse){
			$iffalse = zen_validate_password($pass, $pass_sql->fields['admin_pass']);
		 }
		$pass_sql->MoveNext();
  	}
	return $iffalse;
}
function zm_test(){
	return 'good';	
}
//function checkout_scan_time(){
//	global $db;
//	if($_SESSION['delivery_time']==1){
//		$now = strtotime('now');
//		$day = strtolower(date(strtotime('now')));
//		$menus = array_unique($_SESSION['real_menu']);
//		$val_menus = array_values($menus);
//		$restaurant_id = zen_categories_lookup($val_menus[0],'parent_id');
//		$padding_sql = $db->Execute('select time_pad_close from categories_description where categories_id="'.$restaurant_id.'"');
//		$times = $db->Execute('select categories_id, '.$day.'_end_first as today from categories_description where categories_id in ('.array_to_sql($menus).')');
//		$padding = floatval($padding_sql->fields['time_pad_close'])*15;
//		$unavailable_menu = array();
//		while (!$times->EOF) {
//			
//			$menu_now = strtotime('now '.$times->fields['today']);
//			if(($now-$padding)>$menu_now){
//				$unavailable_menu[]=$times->fields['categories_id'];
//	 		}
//     	$times->MoveNext();
//    	}
//		if(count($unavailable_menu)>0){
//			return 7;
//		}else{
//			return 1;
//		}
//	}else{
//		return 1;
//	}
//}
function iszach(){
	return $_SERVER['REMOTE_ADDR']=='50.188.211.151';
}
function zach($d){
	if($_SERVER['REMOTE_ADDR']=='50.188.211.151'){
			print_r($d); 
	}
}
function zm_any_error($msg,$optional){
	global $db;
	if(isset($_SESSION['customer_id'])){
		$customer=$_SESSION['customer_id'];
	}else{
		$customer=0;
	}
	$msg=$msg.' '.$optional;
	$msg =  zen_sanitize_string($msg);
	$db->Execute('insert into javascript_errors (message,timestamp,customer_id) values ("'.$msg.'",NOW(),"'.(int)$customer.'")');
	return 1;
}
function get_keys_for_duplicate_values($my_arr, $clean = false) {
    if ($clean) {
        return array_unique($my_arr);
    }
    $dups = $new_arr = array();
    foreach ($my_arr as $key => $val) {
      if (!isset($new_arr[$val])) {
         $new_arr[$val] = $key;
      } else {
        if (isset($dups[$val])) {
           $dups[$val][] = $key;
        } else {
           $dups[$val] = array($key);
        }
      }
    }
    return $dups;
}
function array_to_sql($array){
	foreach($array as $a){
		$tmp[]="'".$a."'";
	}
	$sql=implode(',',$tmp);
	return $sql;
}
function zm_address_format($address){
	// check me periodically
//$address[0]['street']=str_replace(' North Dakota',' ND',$address[0]['street']);
//$address[0]['street']=str_replace(' South Dakota',' N',$address[0]['street']);
//$address[0]['street']=str_replace(' Minnesota',' W',$address[0]['street']);
//$address[0]['street']=str_replace(' East',' E',$address[0]['street']);
//$address[0]['street']=str_replace(' Street',' St',$address[0]['street']);
//$address[0]['street']=str_replace(' Avenue',' Ave',$address[0]['street']);
return $address;
}
function check_address($address){
	if(!isset($_SESSION['address_separated']) || !isset($_SESSION['restaurant_info'])){
		return 1;
	}
	//$_SESSION['address_separated']=zm_address_format($_SESSION['address_separated']);
	$old_address = $_SESSION['address_separated'];
	$new_address=json_decode($address,true);
	$dif = count(array_diff(array_values($old_address[0]),array_values($new_address[0])));
	if($dif>0){
		return 1;
	}else{
		return 0;
	}
}
function zm_check_route_matrix($address){
	global $db;
	$check_if_exists_sql='select route_matrix from address_route_matrix where street_number="'.addslashes(strtoupper($address[0]['street_number'])).'" and street="'.addslashes(strtoupper($address[0]['street'])).'" and zip="'.addslashes(strtoupper($address[0]['postcode'])).'" limit 0,1';
	$check_if_exists=$db->Execute($check_if_exists_sql);
	$matrix = array();
	while(!$check_if_exists->EOF){
		$matrix[]=$check_if_exists->fields['route_matrix'];
		$check_if_exists->MoveNext();
	}
	if(count($matrix)==1){
		$_SESSION['restaurant_info']=json_decode(base64_decode($matrix[0]),true);
		$_SESSION['address_separated']=$address;
		//if(count($_SESSION['restaurant_info'])){
			return true;
		//}else{
		//	return false;	
		//}
	}else{
		return false;
	}
}
function zm_is_location_open(){
	global $db;
	$loc = $db->Execute('select categories_status from categories where categories_id = 1');	
	if($loc->fields['categories_status']==1){
		return true;
	}else{
		return false;
	}
}
function zm_find_available_cities($lat,$lng,$address){
	//if(isset($_SESSION['fooddudestaging_login'])){
		$data=array();
		$_SESSION['customers_lat_lng']=array($lat,$lng);
	//}
//	$check_addr = check_address($address);
//	if($check_addr==0){
//		$data['same_address']=1;
//		return $data;
//	}
if(!zm_is_location_open()){
	$data['closed_fooddudestaging']=zen_categories_lookup(1,'comments');
	return $data;
}
$json_ranges = zm_get_city_json_ranges();
$closed_cities = check_if_city_closed();
$available_cities = zm_get_city_available($json_ranges,$lat,$lng);
foreach($available_cities as $a){
	if(in_array($a,$closed_cities)){
		$comm = zen_categories_lookup($a,'comments');
		if($comm==''){
			$comm=' ';
		}
		$data['closed_city']=$comm;
		return $data;
	}
}
if($available_cities){
		$check_matrix= zm_check_route_matrix(json_decode($address,true));
		if($check_matrix){
			$data['same_address']=1;
			return $data;
		}
	$get_restaurant_info = zm_get_first_subcategories_by_array($available_cities);
}else{
	//$closed_cities = check_if_city_closed();
	//$data['closed_cities']=json_encode($closed_cities);
	$data['no_cities']=1;
	return $data;
}
$_SESSION['customers_lat_lng']=array($lat,$lng);
$mapquest_array[]=array('latLng'=>array('lat'=>$lat,'lng'=>$lng));
foreach($get_restaurant_info as $ri){
	$mapquest_array[]=array('latLng'=>array('lat'=>$ri['lat'],'lng'=>$ri['lng']));
}
return $mapquest_array;	
}
function zm_get_first_subcategories_by_array($available_cities) {
    global $db;
	$subcategories_array = array();
    $subcategories_query = "select c.categories_id,cd.lat,cd.lng
                            from categories as c
							inner join categories_description as cd on cd.categories_id = c.categories_id
                            where parent_id in (" . array_to_sql($available_cities) . ") and cd.lat!='na' and cd.lng!='na' and cd.lat!='' and cd.lng!='' and c.categories_status='1' order by categories_name";
    $subcategories = $db->Execute($subcategories_query);
//
    while (!$subcategories->EOF) {
      $subcategories_array[] = array('lat'=>$subcategories->fields['lat'],
	 								 'lng'=>$subcategories->fields['lng']);
	  $id_array[]=$subcategories->fields['categories_id'];
      $subcategories->MoveNext();
    }
	$_SESSION['found_restaurant_ids']=$id_array;
	return  $subcategories_array;
}
function zm_get_city_available($new_master_array,$lat,$lng){
	$available_cities = array();
	//return $new_master_array;
	foreach($new_master_array as $city_id =>$ri){
	$dejson_range = base64_decode($ri);
	$pointLocation = new pointLocation();
	$points = array($lng.' '.$lat);
	$polygon = json_decode($dejson_range,true);
	if(is_array($polygon)){
			array_push($polygon, $polygon[0]);
	//print_r($polygon);
	//pointless rearrangemnt of lat,lng to lng lat
		for($ff=0;$ff<count($polygon);$ff++){
			$temp= explode(",",$polygon[$ff]);
			$polygon[$ff] = $temp[1]." ".$temp[0];
		}
		foreach($points as $key => $point) {
   			$if_inside_range = $pointLocation->pointInPolygon($point, $polygon) ;
		}
	}else{
		$if_inside_range='outside';
	}
	if($if_inside_range=='inside'){
		$available_cities[]=$city_id;
	}
	}
	return $available_cities;
}
//checkout final timecheck
function check_if_city_closed(){
	global $db;
	$closed_cities=$db->Execute('select cd.categories_id from categories as c inner join categories_description as cd on c.categories_id=cd.categories_id where c.categories_status=0 and parent_id in(select categories_id from categories where parent_id=1)');
	$closed=array();
	while(!$closed_cities->EOF){
		$closed[]=$closed_cities->fields['categories_id'];
		$closed_cities->MoveNext();	
	}
	return $closed;
}
function redo(){
global $db;
$tt = $db->Execute('select fax,categories_id from categories_description');	
	while (!$tt->EOF) {
	 $db->Execute('update categories_description set fax="'.str_replace(' ','',$tt->fields['fax']).'" where categories_id="'.$tt->fields['categories_id'].'"');
     $tt->MoveNext();
    }
}
  function zm_get_product_path($products_id) {
	  if(is_array($products_id)){
		  $products_id = $products_id[0];
	  }
	  // zm edit
    global $db;
    $cPath = '';
	$real_ids = $_SESSION['real_menu'];
//    $category_query = "select p.products_id, p.master_categories_id
//                       from " . TABLE_PRODUCTS . " p
//                       where p.products_id = '" . (int)$products_id . "' limit 1";
//
//
//    $category = $db->Execute($category_query);
      $categories = array();
      zen_get_parent_categories($categories, $real_ids[$products_id]);
      $categories = array_reverse($categories);
      $cPath = implode('_', $categories);
      if (zen_not_null($cPath)) $cPath .= '_';
      $cPath .= $real_ids[$products_id];
    return $cPath;
  }
function zm_checkout_time_check(){
	global $db;
	if($_SESSION['is_gift_card']){
		return 1;
	}
	if($_SESSION['delivery_time']==1){
		$menus = array_unique($_SESSION['real_menu']);
		$val_menus = array_values($menus);
		if(!$val_menus[0]){
			$val_menus[0]=$val_menus[1];
		}
		$restaurant_id = zen_categories_lookup($val_menus[0],'parent_id');
//		$city_id = zen_categories_lookup($restaurant_id,'parent_id');
//		$state_id = zen_categories_lookup($city_id,'parent_id');
//		$s_c_tz = $db->Execute("SELECT timezone FROM timezones WHERE categories_id=$state_id");
//		$s_c_tz = $s_c_tz->fields['timezone'];
//		//echo $s_c_tz;
//		if($s_c_tz==NULL){
//			date_default_timezone_set('America/Chicago');
//			$_SESSION['new_tz']='America/Chicago';
//		}else{
//			date_default_timezone_set($s_c_tz);	
//			$_SESSION['new_tz']=$s_c_tz;
//		}
		$now = strtotime('now');
		$day = strtolower(date('l',strtotime('now')));
		$padding_sql = $db->Execute('select time_pad_close from categories_description where categories_id="'.$restaurant_id.'"');
		$times = $db->Execute('select categories_id, '.$day.'_end_first as today from categories_description where categories_id in ('.array_to_sql($menus).')');
		$padding = floatval($padding_sql->fields['time_pad_close'])*15*60;
		$unavailable_menu = array();
		while (!$times->EOF){
			$menu_now = strtotime('now '.$times->fields['today'])-$padding;
			if($now>$menu_now){
				$unavailable_menu[]=$times->fields['categories_id'];
	 		}
     	$times->MoveNext();
    	}
		if(count($unavailable_menu)>0){
			return 7;
		}else{
			return 1;
		}
	}else{
		return 1;
	}
}
//function zm_checkout_time_check(){
//	//whoally untested
//	//return 1;
//	global $messageStack;
//		$id_array = $_SESSION['cart']->get_product_id_array();
//		foreach($id_array as $id){
//			$menu_id = zm_get_menu_id_from_product($id);
//			$good_to_place=zm_check_product_time($menu_id);
//			if(!$good_to_place){
//				$out_of_time_products[]=$id;
//			}
//		}
//		$parent_id=zm_get_restaurant_id_from_product($id_array[0]);
//	if($_SESSION['delivery_time']==1){
//		$dev_time = strtotime('now');
//		
//		$breaks=zm_get_day_breaks(date("l", $dev_time),$parent_id);
//		if($breaks['end']>zm_float_time($dev_time) && $breaks['start']<zm_float_time($dev_time)){
//			foreach($out_of_time_products as $o){
//				$product_names[]=zen_products_lookup($o);
//			}
//			return implode(',',$product_names);	
//		}
//
//		if(count($out_of_time_products)==0){
//
//			return 1;	
//		}else{
//		 
//			foreach($out_of_time_products as $o){
//				$product_names[]=zen_products_lookup($o);
//			}
//			return implode(',',$product_names);
//		}
//	}else{
//			return 1;
//	}
//	
//}
function zm_error_warning($msg){
	global $db;
	$msg=zen_sanitize_string($msg);
	$db->Execute('insert into important_error (msg) values ("'.$msg.'")');
	echo 1;
}
//more mix
function zm_determine_visible_status($id){
	$status='Processing';
	//new = process
	//rest confirmed = placed
	//delivered =deliverered
	//canceled
	//refund 
	//shipped =na
	//future = pending
	if($id==1 || $id==3 ||$id==5){
		$status='Processing';
	}else if($id==2 || $id==4 || $id==7){
		$status='Placed';
	}else if($id==8){
		$status='Picked Up';
	}else if($id==10||$id==11||$id==12){
		$status='Delivered';
	}else if($id==9){
		$status='Pending';
	}else if($id==6){
		$status='Canceled';
	}
	return $status;	
}
//timecode
function zm_times_are_good_cart($products_id,$new_menu_id,$new_cat){
	global $messageStack;
	if(isset($_SESSION['new_tz'])){
		date_default_timezone_set($_SESSION['new_tz']);
	}
	//$new_menu_id = zm_get_menu_id_from_product($products_id);
	//products menu restaurant
	if($_SESSION['cart']->count_contents()>0){
		$id_array = $_SESSION['cart']->get_product_id_array();
		$same_menu = true;
		$menu_keys = array_values($_SESSION['real_menu']);
		for($k=0;$k<count($menu_keys);$k++){
			//echo $id_array[$k].' '.$new_menu_id.' '.$menu_keys[$k].'<br /> ';
			if($menu_keys[$k]!=$new_menu_id){
				$same_menu = false;
				$menu_id_that_was_different = $menu_keys[$k];
			}
		}
		//possible just force same menu...
		if(!$same_menu){
			$compare_times_switch=zm_compare_product_times($menu_id_that_was_different,$new_menu_id);
			//if true its good if false do not allow
			if(!$compare_times_switch){
				$messageStack->add_session('header',"The selected products menu times don't overlap with the menu times in your cart",'error');
				zen_redirect(zen_href_link('index', 'cPath='.$new_cat));
				die;
			}
		}else{
			$cant_order_time_same_menu = zm_check_product_time($new_menu_id);
			if(!$cant_order_time_same_menu){
				$msg = "The selected product isn't available for your selected time";
				$messageStack->add_session('header',$msg,'error');
				zen_redirect(zen_href_link('index', 'cPath='.$new_cat));
				die;
			}
		}
	}else{
		$cant_order_time = zm_check_product_time($new_menu_id);
		if($_SESSION['fooddudestaging_login']){
			//echo $cant_order_time;
		}
		if(!$cant_order_time){
			$msg = "The selected product isn't available at your selected time";
			$messageStack->add_session('header',$msg,'error');
			zen_redirect(zen_href_link('index', 'cPath='.$new_cat));
			die;
		}
	}
	return true;
}
function zm_get_cuisine($id){
	global $db;
	$info = $db->Execute('select cuisine from categories_description  where categories_id='.$id.'');
		return $info->fields['cuisine'];
}
function zm_check_min_and_checkout(){
	if($_SESSION['is_gift_card'] || $_SESSION['is_gift_card_non_rewards']){
		return 1;
	}
	if($_SESSION['cart']->count_contents()>0){
		$product_array=$_SESSION['cart']->get_product_id_array();
		$min = zm_analyze_min_order_top_down(zm_get_product_path($product_array[0]));
		if($min==0 || !$min){
			$min=15;	
		}
		if(floatval($min)<=floatval($_SESSION['cart']->show_total())){
			$min_met=1;
		}else{
			$min_met=floatval($min);	
		}
	}else{
		$min_met=15;
	}
	return $min_met;
}
function zm_check_min_and_checkout_header(){
		if($_SESSION['is_gift_card'] || $_SESSION['is_gift_card_non_rewards']){
		return 1 ;
	}
	if($_SESSION['cart']->count_contents()>0){
		$product_array=$_SESSION['cart']->get_product_id_array();
		$min = zm_analyze_min_order_top_down(zm_get_product_path($product_array[0]));
		if($min==0 || !$min){
			$min=15;	
		}
		if(floatval($min)<=floatval($_SESSION['cart']->show_total())){
			$min_met=1;
		}else{
			$min_met=floatval($min);	
		}
	}else{
		$min_met=15;
	}
	if($_SESSION['cart']->show_total()<$min_met){
		add_message_to_stack('The current restaurant has a '.money_format('$%i',$min_met).' minimum.');
		  zen_redirect(zen_href_link(FILENAME_SHOPPING_CART));
		  die;
	}
}
function zm_get_min_order($cArray){
	global $db;
	foreach($cArray as $c){
		$id_list_a[]="'".$c."'";
	}
	$comments_sql = $db->Execute('select categories_id,min_order from categories_description  where categories_id in ('.implode(',',$id_list_a).')');
	 while (!$comments_sql->EOF) {
     $comment_array[$comments_sql->fields['categories_id']] = $comments_sql->fields['min_order'];
     $comments_sql->MoveNext();
    }
	return $comment_array;
}
function zm_analyze_min_order_top_down($cPath){
	$cArray = array_reverse(explode("_",$cPath));
	$specs = zm_get_min_order($cArray);
	$dieAntwood= '';
		while($i<count($cArray) && $dieAntwood ==''){
			if($specs[$cArray[$i]] != "" && $specs[$cArray[$i]] != "na" ){
			  $dieAntwood = $specs[$cArray[$i]];
			}
		$i++;
		}
	if($dieAntwood==''){$dieAntwood="";}
	return $dieAntwood;
}
function zm_get_eta($cArray){
	global $db;
	$comments_sql = $db->Execute('select categories_id,estimated_delivery_time from categories_description  where categories_id in ('.array_to_sql($cArray).')');
	 while (!$comments_sql->EOF) {
     $comment_array[$comments_sql->fields['categories_id']] = $comments_sql->fields['estimated_delivery_time'];
     $comments_sql->MoveNext();
    }
	return $comment_array;
}
function zm_analyze_eta_top_down($cPath){
	$cArray = explode("_",$cPath);
	$specs = zm_get_eta($cArray);
	$dieAntwood= '';
	//print_r($cArray);
	$i=0;
 	$cArray= array_reverse($cArray);
		while($i<count($cArray) && $dieAntwood ==''){
			if($specs[$cArray[$i]] != "" && $specs[$cArray[$i]] != "na" ){
			  $dieAntwood = $specs[$cArray[$i]];
			}
		$i++;
		}
	if($dieAntwood==''){$dieAntwood="";}
	return $dieAntwood;
}
function zm_check_current_res_redirect(){
	if(in_array($_SESSION['current_page_category_id'],array_keys($_SESSION['restaurant_info']))|| $_SESSION['current_page_category_id']==1915){
		return 1;
	}else{
		return 0;	
	}
}
function zm_get_comments($cArray){
	global $db;
	foreach($cArray as $c){
		$id_list_a[]="'".$c."'";
	}
	$comments_sql = $db->Execute('select categories_id,comments from categories_description  where categories_id in ('.implode(',',$id_list_a).')');
	 while (!$comments_sql->EOF) {
     $comment_array[$comments_sql->fields['categories_id']] = $comments_sql->fields['comments'];
     $comments_sql->MoveNext();
    }
	return $comment_array;
}
function zm_analyze_comments_top_down($cPath){
	$cArray = explode("_",$cPath);
	$specs = zm_get_comments($cArray);
	$dieAntwood= '';
	$i=0;
	$f= count($cArray);
	$cArray= array_reverse($cArray);
		while($i<$f && $dieAntwood ==''){
			//echo $specs[$cArray[$i]];
			if($specs[$cArray[$i]] != "" && $specs[$cArray[$i]] != "na" ){
			  $dieAntwood = $specs[$cArray[$i]];
			}
		$i++;
		}
	if($dieAntwood==''){$dieAntwood="";}
	return $dieAntwood;
}
function zm_check_product_time($menu_id){
	global $db;
				//if true its good if false do not allow
//if(isset($_GET['cPath'])){
//	$s_c_tz = explode('_',$_GET['cPath']);
//	$s_c_tz = $s_c_tz[1];
//	if(is_numeric($s_c_tz)){
//	  $s_c_tz = $db->Execute("SELECT timezone FROM timezones WHERE categories_id=$s_c_tz");
//	  $s_c_tz = $s_c_tz->fields['timezone'];
//	  //echo $s_c_tz;
//	  if($s_c_tz==NULL){
//		  date_default_timezone_set('America/Chicago');
//		  $_SESSION['new_tz']='America/Chicago';
//	  }else{
//		  date_default_timezone_set($s_c_tz);	
//		  $_SESSION['new_tz']=$s_c_tz;
//	  }
//	}
//}
	if($_SESSION['delivery_time']==1){
		$now=strtotime('now');
	}else{
		$now=$_SESSION['delivery_time'];
	}
	$tmp_array[]=$menu_id;
	$times=zm_get_sibling_times(0,$tmp_array);
	//$restaurant_id = zen_categories_lookup($menu_id,'parent_id');
	//$get_time_pad_close = zm_get_timepad_close($restaurant_id);
	//print_r($times);
	$day= date('N',$now)-1;
	$good_to_place=false;
		foreach($times as $id => $si){
			for($v=0;$v<count($si[0]);$v++){
		//echo date('l',$now).' '.date('l',$si[0][$v]).' '.zm_n($si[0][$v]).' '.zm_n($now).' '.zm_n($si[1][$v]).'<br /> ';
				if(zm_n($si[0][$v])<=zm_n($now) && (zm_n($si[1][$v]))-1500>=zm_n($now) && date('l',$now)==date('l',$si[0][$v])){
					//$open_menus[] = $id;
		$good_to_place=true;
				}else{
				}
			}
		}
	return $good_to_place;	
}
function zm_compare_product_times($different,$new){
			//if true its good if false do not allow
    if(isset($_SESSION['new_tz'])){
		date_default_timezone_set($_SESSION['new_tz']);
	}
	if($_SESSION['delivery_time']==1){
		$now=strtotime('now');
	}else{ 
	//probably need to offset this 
	// TODO SOON ZM
		$now=$_SESSION['delivery_time'];
	}
	$tmp_array1[]=$different;
	$tmp_array2[]=$new;
	$dif_times=zm_get_sibling_times(0,$tmp_array1);
	$new_times=zm_get_sibling_times(0,$tmp_array2);
	$day= date('N',$now)-1;
	$good_to_place=true;
		foreach($dif_times as $id => $si){
		//echo zm_date($si[0][$day]).' x '. zm_date($now) .' m '. zm_date($si[1][$day]) .'<br />';
			if($si[0][$day]<$now && $si[1][$day]>$now){
			}else{
				$good_to_place=false;	
			}
		}
		foreach($new_times as $id => $si){
		//echo zm_date($si[0][$day]).' x '. zm_date($now) .' m '. zm_date($si[1][$day]) .'<br />';
			if($si[0][$day]<$now && $si[1][$day]>$now){
			}else{
				$good_to_place=false;	
			}
		}
	return $good_to_place;	
}
function zm_session_add_delivery_time($time){
	// FIND ME
	global $is_daylight_savings;
	if($time>1){
		if(isset($_POST['tz'])){
			switch($_POST['tz']){
			  case '-04:00':
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
						  $time = $time + (3600 * 2);
					  break;
					  case 'America/Chicago':
						  $time = $time + (3600 * 1);
					  break;
					  case 'America/New_York':
					  break;
				  }
			  break;	
			  case '-05:00':
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
						  $time = $time + (3600 * 1);
					  break;
					  case 'America/Chicago':
					  break;
					  case 'America/New_York':
						  $time = $time - (3600 * 1);
					  break;
				  }
			  break;
			  case '-06:00':
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
					  break;
					  case 'America/Chicago':
						  $time = $time - (3600 * 1);
					  break;
					  case 'America/New_York':
						  $time = $time - (3600 * 2);
					  break;
				  }
			  break;	
			  case '-07:00':
				  //$date = $date - (3600 * 1000);
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
						  $time = $time - (3600 * 1);
					  break;
					  case 'America/Chicago':
					  break;
					  case 'America/New_York':
					  break;
				  }
			  break;
		  }
		}
	}
	if(!$is_daylight_savings){
		$time = $time + (3600 * 1);
	}
	$_SESSION['delivery_time']=$time;
	echo 1;
}
function zm_get_day_breaks($day,$categories_id){
	global $db;
	$day = strtolower($day);
	$break_sql = $db->Execute('select '.$day.'_break as start, '.$day.'_break_length as end from categories_description where categories_id="'.$categories_id.'" and '.$day.'_break !="" and '.$day.'_break_length !="" ');
	$breaks['start']=floatval(str_replace(':','',$break_sql->fields['start']));
	$breaks['end']=floatval(str_replace(':','',$break_sql->fields['end']));
	if($breaks['start']!='' && $breaks['end']!=''){
		return $breaks;
	}else{
		return false;
	}
}
function zm_float_time($e){
	$ret = floatval(str_replace(':','',date('H:i',$e)));	
	return $ret;
}
function zm_time_code($date){
	global $is_daylight_savings;
//	if(isset($_POST['tz'])){
//		list($hours, $minutes) = explode(':', $_POST['tz']);
//		$seconds = $hours * 60 * 60 + $minutes * 60;
//		// Get timezone name from seconds
//		$tz = timezone_name_from_abbr('', $seconds, 1);
//		// Workaround for bug #44780
//		if($tz === false) $tz = timezone_name_from_abbr('', $seconds, 0);
//		// Set timezone
//		$possible_tz=array('America/New_York','America/Chicago','America/Denver','America/Phoenix','America/Los_Angeles','America/Anchorage','America/Adak','America/Adak','Pacific/Honolulu');
//		if(!in_array($tz,$possible_tz)){
//			$tz='America/Chicago';
//		}
//		
//		date_default_timezone_set($tz);
//		//$date = $date - (3600 * 1000);
//	}
		//$_SESSION['new_timezone']=$tz;
	//}
	//if(isset($_SESSION['new_tz'])){
	  //date_default_timezone_set($_SESSION['new_tz']);
	  if(isset($_POST['tz'])){
		  switch($_POST['tz']){
			  case '-04:00':
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
						  $date = $date + (3600 * 2000);
					  break;
					  case 'America/Chicago':
						  $date = $date + (3600 * 1000);
					  break;
					  case 'America/New_York':
					  break;
				  }
			  break;	
			  case '-05:00':
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
						  $date = $date + (3600 * 1000);
					  break;
					  case 'America/Chicago':
					  break;
					  case 'America/New_York':
						  $date = $date - (3600 * 1000);
					  break;
				  }
			  break;
			  case '-06:00':
				  switch($_SESSION['new_tz']){
					  case 'America/Denver':
					  break;
					  case 'America/Chicago':
						  $date = $date - (3600 * 1000);
					  break;
					  case 'America/New_York':
						  $date = $date - (3600 * 2000);
					  break;
				  }
			  break;	
			  case '-07:00':
				  //$date = $date - (3600 * 1000);
				 switch($_SESSION['new_tz']){
					  case 'America/Denver':
						  $date = $date - (3600 * 1000);
					  break;
					  case 'America/Chicago':
					  break;
					  case 'America/New_York':
					  break;
				  }
			  break;
		  }
	  }
	//}
	//IF NOT DAYLIGHT SAVINGS COMMENT OUT THIS LINE
	if(!$is_daylight_savings){
		$date = $date + (3600 * 1000);
	}
	$timecode = array();
	//
	$todays_date = date('m-d-y',strtotime('now'));
	$received_date = date('m-d-y',$date/1000);
	$received_date_format = date('m/d/Y',$date/1000);
	$received_day = date('N',$date/1000)-1;
	$received_day_long = strtolower(date('l',$date/1000));
	//echo $received_day;
	if($_SESSION['cart']->count_contents()>0){
		$menu_id[]= zm_menu_path_from_cpath(zm_get_product_path($_SESSION['cart']->get_product_id_array()));
		if($todays_date==$received_date){
			$time_array = zm_get_asap_times_for_today_with_cart($menu_id);
			$asap=true;
		}else{
			$time_array = zm_get_times_for_future_with_cart($menu_id,$received_day);
			$asap=false;
		}
	}else{
		if($todays_date==$received_date){
			$time_array =  zm_get_asap_times_for_today();
			$asap=true;
		}else{
			$time_array =  zm_get_times_for_future($received_day);
			$asap=false;
		}	
	}
	asort($time_array);
	if(date('H:i:s',$time_array[0])=='00:00:00'){
		$timecode[2]='Closed';
		return $timecode;
	}
	if($received_date=='12-25-15'){
		//christmas fix
		//$timecode[2]='Closed';
		//return $timecode;
	}
	if($asap){
		if(count($time_array)>0){
			$max_today_time = max($time_array);//strtotime( date('Y-m-d H:i:s',)); 
			$min_today_time = min($time_array);//strtotime( date('Y-m-d H:i:s',)); 
			$current_today_time =strtotime('now');//strtotime( date('Y-m-d H:i:s',));
			if($max_today_time>$current_today_time && $current_today_time>$min_today_time){
				foreach($time_array as $t){
					if($t>$current_today_time){
						$difference_time[]=$t-$current_today_time;
					}
				}
				if(is_array($difference_time)){
					if(min($difference_time)>=900){
						$timecode[2]='Select Time';
					}else{
						$timecode[1]='ASAP';
					}
				}else{
					$timecode[2]='Select Time';
				}
			}else if($max_today_time<$current_today_time && $current_today_time>$min_today_time){
				$timecode[2]='Closed';
			}else if($current_today_time<$min_today_time){
				$timecode[2]='Select Time';
			}
		}else{
			$timecode[2]='Closed';
		}
	}else{
		$timecode[2]='Select Time';
	}
	$restaurant_id = zm_get_restaurant_id_for_timecode();
	$t=0;
	$get_time_pad_close = zm_get_timepad_close($restaurant_id);
	$get_time_pad_open=zm_get_timepad_open($restaurant_id);
	$breaks=zm_get_day_breaks($received_day_long,$restaurant_id);
	if($asap){
		if(strtotime('now')<$min_today_time){
			$sent = 0;
		}else{
			if($timecode[1]=='ASAP'){
				$sent = (strtotime('now')+ASAP_FRONT_PAD);
			}else{
				$sent = strtotime('now');
			}
		}
		if($max_today_time-strtotime('now') <= $get_time_pad_close*15*60){
			unset($timecode[1]);
			$timecode[2]='Closed';
		}
  		foreach($time_array as $et){
			if($t>=$get_time_pad_open  && $et>$sent ){
				if($breaks['start']<zm_float_time($et) && $breaks['end']>zm_float_time($et) ){
				}else{
					$timecode[date('H:i',$et)]=date('g:ia',$et);
				}
			}
			$t++;
		}
		if($breaks['start']<zm_float_time(strtotime('now')) && 
		$breaks['end']-($get_time_pad_open*25)>zm_float_time(strtotime('now')) ){
					if($_SESSION['fooddudestaging_login']){
			//echo $breaks['end']-($get_time_pad_open*25);
		}
			unset($timecode[1]);
			$timecode[2]='Select Time';
		}
	}else{
  		foreach($time_array as $et){
			if($t>=$get_time_pad_open ){
				//zach(date('g:ia',$et));
			//zach(' ');
				if($breaks['start']<zm_float_time($et) && $breaks['end']>zm_float_time($et)){
				}else{
					$timecode[date('H:i',$et)]=date('g:ia',$et);
				}
			}
			$t++;
		}
	}
	$closed=false;
	$closed_this_day =zm_get_restaurant_closed_dates_for_open_next($restaurant_id);
	if(is_array($closed_this_day) && count($closed_this_day)>0){
		foreach($closed_this_day as $c){
			if($received_date_format==$c){
				$closed=true;
			}
		}
	}
	if($closed){
		unset($timecode);
		$_SESSION['delivery_time']=2;
		$timecode[2]='Closed';
		return $timecode;
	}
	return $timecode;
}
function convert_timezone_to_offset($tz){
	$offset = 0;
	if($_SESSION['customers_ip_address'] == '97.116.48.206'){
			/*  	switch($tz){
					case 'eastern':
						$offset = 4;
					break;
					case 'central':
						$offset = 0;
					break;
					case 'mountain':
						$offset = -4;
					break;
					case 'western':
						$offset = -8;
					break;
				}  */
	}
	return $offset;
}
function zm_get_timepad_open($id){
	global $db;
	//ini_set('display_errors',true);
	$get_tz = $db->Execute("select timezone from categories_description where categories_id = (select parent_id from categories where categories_id =".intval($id).") limit 1");
	$converted = convert_timezone_to_offset($get_tz->fields['timezone']);
	///
	//echo $get_tz->fields['timezone'].' x '.$converted;die;
	$timepad = $db->Execute('select time_pad_open from categories_description where categories_id="'.$id.'"');
	if(($timepad->fields['time_pad_open'])=='na' || ($timepad->fields['time_pad_open'])==''){
		$ret=0;
	}else{
		$ret=floatval($timepad->fields['time_pad_open']);
	}
	$ret = $ret + $converted;
	return $ret;
}
function zm_get_timepad_close($id){
	global $db;
	//ini_set('display_errors',true);
	$get_tz = $db->Execute("select timezone from categories_description where categories_id = (select parent_id from categories where categories_id =".intval($id).") limit 1");
	$converted = convert_timezone_to_offset($get_tz->fields['timezone']);
	$timepad = $db->Execute('select time_pad_close from categories_description where categories_id="'.$id.'"');
	if(($timepad->fields['time_pad_close'])=='na' || ($timepad->fields['time_pad_close'])==''){
		$ret=0;
	}else{
		$ret=floatval($timepad->fields['time_pad_close']);
	}
	$ret = $ret + $converted;
	return $ret;
}
function zm_get_times_for_future_with_cart($menu_id,$day){
		$times = zm_get_sibling_times(0,$menu_id);
		foreach($times as $t){
			$start[]=$t[0][$day];
			$end[]=$t[1][$day];
		}
		for($b=0;$b<count($end);$b++){
    			for ($i=$start[$b];$i<=$end[$b];$i = $i + 15*60){
					$future_time_array[]=$i;
    			}
		}
		$future_time_array=array_unique($future_time_array);
	return $future_time_array;
}
function zm_get_asap_times_for_today_with_cart($menu_id){
		$now = strtotime('now');
		$day= date('N',$now)-1;
		$times = zm_get_sibling_times(0,$menu_id);
		foreach($times as $t){
			$start[]=$t[0][$day];
			$end[]=$t[1][$day];
		}
		for($b=0;$b<count($end);$b++){
    			for ($i=$start[$b];$i<=$end[$b];$i = $i + 15*60){
					$asap_time_array[]=$i;
    			}
		}
		$asap_time_array=array_unique($asap_time_array);
	return $asap_time_array;
}
function zm_get_times_for_future($day){
		$parent_id = zm_get_restaurant_id_for_timecode();
		$times = zm_get_sibling_times($parent_id,2);
		foreach($times as $t){
			$start[]=$t[0][$day];
			$end[]=$t[1][$day];
		}
		//todo change
		for($b=0;$b<count($end);$b++){
    			for ($i=$start[$b];$i<=$end[$b];$i = $i + 15*60){
					$future_time_array[]=$i;
    			}
		}
		$future_time_array=array_unique($future_time_array);
	return $future_time_array;
}
function zm_get_asap_times_for_today(){
		$parent_id = zm_get_restaurant_id_for_timecode();
		$now = strtotime('now');
		$day= date('N',$now)-1;
		$times = zm_get_sibling_times($parent_id,2);
		foreach($times as $t){
			$start[]=$t[0][$day];
			$end[]=$t[1][$day];
		}
		for($b=0;$b<count($end);$b++){
    			for ($i=$start[$b];$i<=$end[$b];$i = $i + 15*60){
					$asap_time_array[]=$i;
    			}
		}
		$asap_time_array=array_unique($asap_time_array);
	return $asap_time_array;
}
function zm_format_option_list_for_today($time_array){
	$optionList .='<option value="'. date('H:i:s',$now).'" >ASAP</option>';		
     foreach($time_array as $et){
		$optionList .='<option value="'. date('H:i:s',$et).'"  ';
		if($_SESSION['delivery_time']== $et){
		$optionList .=' selected="selected" ';
		}
		$optionList .='>'. date('g:i a',$et).'</option>';	  
	 }
	return $optionList;
}
//function roundToQuarterHour($timestring) {
//	$frac = 900;
//	$r = $timestring % $frac;
//	$new_time = $timestring + ($frac-$r);
//	return $new_time;
//}
function zm_get_restaurant_id_for_timecode(){
	//$timecode_carray=explode('_',$_GET['cPath']);
	$timecode_restaurant_id = $_SESSION['current_page_category_id'];
	return $timecode_restaurant_id;
}
function zm_get_restaurant_id_for_current_page(){
	$timecode_carray=explode('_',$_GET['cPath']);
	$timecode_restaurant_id = $timecode_carray[count($timecode_carray)-1];
	return $timecode_restaurant_id;
}
function zm_menu_path_from_cpath($cpath){
	$tc = explode('_',$cpath);
	$new_path = $tc[4];
	return $new_path; 
}
//ini_set('display_errors',true);
function zm_check_when_open_next($parent_id,$sibling_time=0){
		$now = strtotime('now');
		$day= date('N',$now)-1;
		$today= date('Y-m-d',$now);
		$sibling_times = zm_get_sibling_times($parent_id,$sibling_time);
		$hours_array=array();
		$day_array=array();
		foreach($sibling_times as $id => $si){
			for($n=0;$n<count($si[0]);$n++){
					$hours_array[]= date('H:i:s',$si[0][$n]);	
					$day_array[]= date('Y-m-d',$si[0][$n]);						
			}
		}
	$index = array_search($today,$day_array);
	for($v=0;$v<$index;$v++){
		$item = $hours_array[$v];
       	unset($hours_array[$v]);
       	array_push($hours_array, $item);
	}
		$hours_array = array_values($hours_array);	
		for($j=0;$j<count($hours_array);$j++){
			$real_s_times[$j]=strtotime('+'.$j.' days today '.$hours_array[$j]);
			//echo zm_date($real_s_times[$j]);
		}
		if($parent_id==0){
			$check_id = $_SESSION['cat_id_for_closed_dates'];
		}else{
			$check_id = $parent_id;
		}
		$closed_dates ='';
		$closed_dates = zm_get_restaurant_closed_dates_for_open_next($check_id );
		foreach($real_s_times as $id => $si){
				//print_r($parent_id.' '.zm_date($si[0][$day+$jl])).'<br />';
			if($si>$now && date('H:i:s',$si)!='00:00:00'){
				if(!in_array(date('m/d/Y',$si),$closed_dates)){
					$open_time_array[] =$si;
				}
			}
		}
		$define_txt = "Opens";
		if($parent_id!=0){
			$get_time_pad_open = zm_get_timepad_open($parent_id);
		}else{
			$sub_key=array_keys($sibling_times);
			$parent_id=zen_categories_lookup($sub_key[0],'c.parent_id');
			$get_time_pad_open = zm_get_timepad_open($parent_id);
		}
		$min_temp = min($open_time_array)+$get_time_pad_open*15*60;
		if (date("l", $min_temp)==date("l", $now)){
				$temp_day = $define_txt;
		}else{
				$temp_day = $define_txt.' '.date("D", $min_temp);
		}
		//ZACH FAGERNESS//
		$next_date = date("g:ia", $min_temp);//shift_timezones_idk($current_timezone,date("g:ia", $min_temp));
		$next_open = $temp_day." at ".$next_date;	
		$breaks=zm_get_day_breaks(date("l", $now),$parent_id);
		if($breaks['end']>zm_float_time(strtotime('now')) && $breaks['start']<zm_float_time(strtotime('now'))){	
			$v=str_split($breaks['end']);
			$next_format = date('g:ia',strtotime('now '.$v[0].$v[1].':'.$v[2].$v[3]));
			$next_open = "Opens Today at ".$next_format;//shift_timezones_idk($current_timezone,$next_format);	
		}
	return $next_open;
}
function shift_timezones_idk($city_tz,$time){
	//return $time;
	//
	$fake_tz = 'America/Chicago';
	switch($_SESSION['fake_tz']){
		case '-04:00':
			$fake_tz = 'America/New_York';
		break;
		case '-05:00':
			$fake_tz = 'America/Chicago';
		break;
		case '-06:00':
			$fake_tz = 'America/Denver';
		break;
	}
	$time = strtotime($time);
	if(isset($city_tz)){
			switch($city_tz){
			  case 'eastern':
				  switch($fake_tz){
					  case 'America/Denver':
						  $time = $time + (3600 * 2);
					  break;
					  case 'America/Chicago':
						  $time = $time + (3600 * 1);
					  break;
					  case 'America/New_York':
					  break;
				  }
			  break;	
			  case 'central':
				  switch($fake_tz){
					  case 'America/Denver':
						  $time = $time + (3600 * 1);
					  break;
					  case 'America/Chicago':
					  break;
					  case 'America/New_York':
						  $time = $time - (3600 * 1);
					  break;
				  }
			  break;
			  case 'mountain':
				  switch($fake_tz){
					  case 'America/Denver':
					  break;
					  case 'America/Chicago':
						  $time = $time - (3600 * 1);
					  break;
					  case 'America/New_York':
						  $time = $time - (3600 * 2);
					  break;
				  }
			  break;	
			  case 'western':
				  //$date = $date - (3600 * 1000);
				  switch($fake_tz){
					  case 'America/Denver':
						  $time = $time - (3600 * 1);
					  break;
					  case 'America/Chicago':
					  break;
					  case 'America/New_York':
					  break;
				  }
			  break;
		  }
		}
		return date('g:ia',$time);
}
function zm_mod_date($day){
	return strtotime(date('m/d/Y H:i:s',(strtotime(date('m/d/Y',strtotime('now'))).' '.date('g:i',$day))));
}
function zm_n($time,$pad=0){
	return(date('His',$time-$pad));
}
function zm_check_if_menu_open($parent_id,$order_time=1){
	//echo '<br />'.$parent_id;
	if($parent_id==' ' || $parent_id==''){
		return false;
	}
	global $db;
	$sibling_times = zm_get_sibling_times($parent_id);
	if($order_time==1 || abs(strtotime('now')-$order_time) < 5){
		$now = strtotime('now');
		$asap = true;
	}else{
		$asap = false;
		$now =$order_time;
	}
	$day= date('N',$now)-1;
	if($now != 0 ){
		if($_SESSION['customers_ip_address'] == '97.116.48.206'){
			//$now = $now + 3600;
		}
	}
	//$restaurant_id = zen_categories_lookup($parent_id,'parent_id');
	//$padding_sql = $db->Execute('select time_pad_close,time_pad_open from categories_description where categories_id="'.$parent_id.'"');
	$pado = zm_get_timepad_open($parent_id) * 15 * 60;//floatval(intval($padding_sql->fields['time_pad_open'])*15*60);
	$padc = zm_get_timepad_close($parent_id) * 15 * 60;//floatval(intval($padding_sql->fields['time_pad_close'])*15*60);
	$closed_dates = zm_get_restaurant_closed_dates_for_open_next($parent_id );
	if(!$asap){
		$pado=0;
		$padc=0;
	}
	//TODO
	if(true){
			if(count($sibling_times)>0 && is_array($sibling_times)){
				foreach($sibling_times as $id => $si){
					for($v=0;$v<count($si[0]);$v++){
				        $op= strtotime(date('m/d/y H:i:s',strtotime(date('m/d/y',$now).date(' H:i:s',$si[0][$v]))));
						$cl= strtotime(date('m/d/y H:i:s',strtotime(date('m/d/y',$now).date(' H:i:s',$si[1][$v]))));
						if($op<=$now && ($cl-$padc)>=$now && date('l',$now)==date('l',$si[0][$v])){
						$breaks=zm_get_day_breaks(date("l", $now),$parent_id);
							if($breaks['end']-100>zm_float_time($now) && $breaks['start']<zm_float_time($now)){	
							}else{
								if(date('H:i',$si[0][$v])!='00:00'){
									if(!in_array(date('m/d/Y',$si[0][$v]),$closed_dates)){
										$open_menus[] = $id;
									}
								}
							}
						}
					}
				}
			}
			return $open_menus;	
	}
	if(count($sibling_times)>0 && is_array($sibling_times)){
		foreach($sibling_times as $id => $si){
			for($v=0;$v<count($si[0]);$v++){
		//echo date('l',$now).' '.date('l',$si[0][$v]).' '.zm_n($si[0][$v]).' '.zm_n($now).' '.zm_n($si[1][$v]).'<br /> ';
				if(zm_n($si[0][$v])<=zm_n($now) && zm_n($si[1][$v],$pado)>=zm_n($now) && date('l',$now)==date('l',$si[0][$v])){
				$breaks=zm_get_day_breaks(date("l", $now),$parent_id);
					if($breaks['end']-100>zm_float_time($now) && $breaks['start']<zm_float_time($now)){	
					}else{
						if(date('H:i',$si[0][$v])!='00:00'){
							if(!in_array(date('m/d/Y',$si[0][$v]),$closed_dates)){
								$open_menus[] = $id;
							}
						}
					}
				}
			}
		}
	}
	return $open_menus;	
}
function zm_get_sub_siblings($parent_id) {
    global $db;
    $id_array = array();
    $subcategories_query = "select categories_id,categories_status
                            from " . TABLE_CATEGORIES . "
                            where parent_id = '" . (int)$parent_id . "' and categories_status = 1";
    $subcategories = $db->Execute($subcategories_query);
    while (!$subcategories->EOF) {
     $id_array[] = $subcategories->fields['categories_id'];
     $subcategories->MoveNext();
    }
	return $id_array;
}
function zm_get_sibling_times($parent_id,$siblings=2){
	global $db;
	if(!$siblings || $siblings==2){
		$siblings = zm_get_sub_siblings($parent_id);		
	}
	if(count($siblings)>0){
		$sibling_specs  = zm_location_times($siblings);
		//TODO ZACH
		$cstuff =  explode('_',$_GET['cPath']);
		//iszach()
		if(true){
			if(isset($_POST['zm_time_code']) || count($cstuff)==4){
				$future_time_offset = $db->Execute("select future_time_offset,c.categories_id  from categories_description as cd inner join categories as c on c.categories_id = cd.categories_id where future_time_offset!=0 and parent_id = $parent_id ");
				$offset_array=array();
				while(!$future_time_offset->EOF){
					$offset_array[]=array('future_pad'=>$future_time_offset->fields['future_time_offset'],'categories_id'=>$future_time_offset->fields['categories_id']);
					$future_time_offset->MoveNext();
				}
				if(count($offset_array)>0){
					$now = strtotime('now');
					foreach($sibling_specs as $keys=>&$smm){
						$future_pad=0;
						foreach($offset_array as $fu){
							if($fu['categories_id'] == $keys){
								$future_pad=$fu['future_pad'];
							}
						}
						if($future_pad > 0 ){
							$max  = strtotime('+'.$future_pad .' minutes now');
							foreach($smm['start_time'] as $key=>&$s){
								if(strtotime($key.' '.$s) < $max){
									$dif = (strtotime($key.' '.$s)-$now )/3600;
									if($dif > 0 && $dif < 24){
										$new_s=date('H:i',strtotime('+'.$future_pad.' minutes now'));
										if(intval($new_s)>intval($s)){
											$new_time = explode(':',$new_s);
											$new_time[1] = round($new_time[1] / 15) * 15;
											if($new_time[1]>=60){
												$new_time[0]++;
												$new_time[1] = $new_time[1]-60;
											}
											$s = $new_time[0].':'.$new_time[1];
										}
									}else{
										$s = '00:00';
										unset($sibling_specs[$keys]['start_time'][$key]);
										unset($sibling_specs[$keys]['end_time'][$key]);
									}
								}
							}
						}
					}
				}
				//end zach
			} 
		}
		$sibling_times = zm_analyze_siblings($sibling_specs,$siblings);
	}else{
		$sibling_times=0;	
	}
	if($_SESSION['customers_ip_address'] == '97.116.48.206'){
	/* 	$c_level = zm_get_c_level($_GET['cPath']);
		if($c_level == 3){
			$timezone_sql = $db->Execute("select timezone from categories_description where categories_id = ".$parent_id);
			$timezone = $timezone_sql->fields['timezone'];
			foreach($sibling_times as $key=>&$st){
			}
		} */
		//$tmp_m = explode('_',$_GET['cPath']);
		//$tmp_a = $tmp_m[count($tmp_m)-1];
		//print_r($c_level,$tmp_a);
	}
	return $sibling_times;
}
function zm_analyze_siblings($specs,$id_array){
////
	$day = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
	$today = strtolower(date('l', strtotime("now")));
	if($today=="monday"){
		$mondays="today"; 	
	}else{
		$mondays="last monday";	
	}
	$dieAntwood= array();
	$times = array('start_time','end_time');
// id start/end  day
	//$modifier = 1;
	//switch($_SESSION['new_tz']){
		//case 'America/Denver':
			//$modifier = -1;
		//break;
	//}
	for($i=0;$i<count($id_array);$i++){
	for($t=0;$t<count($times);$t++){
	for($d=0;$d<count($day);$d++){	
		$dieAntwood[$id_array[$i]][$t][$d] = strtotime("+".$d." days ".$mondays." "
		.$specs[$id_array[$i]][$times[$t]][$day[$d]]);
	}
	}
	}
	return $dieAntwood;
}
function zm_location_times($id_array){
		 global $db;
		 foreach($id_array as $id){
			$id_array_form[]="'".$id."'"; 
		 }
		 $id_list = implode(',',$id_array_form);
		$specs = [];
    $category_query = "select  c.categories_id,monday_start_first, tuesday_start_first,wednesday_start_first,thursday_start_first,friday_start_first,saturday_start_first,sunday_start_first, cuisine,monday_end_first,tuesday_end_first,wednesday_end_first,thursday_end_first,friday_end_first,saturday_end_first,sunday_end_first
                       from categories_description inner join categories as c on c.categories_id = categories_description.categories_id  where c.categories_status=1 and c.categories_id in(".$id_list.")" ;
    $category = $db->Execute($category_query);
	while (!$category->EOF) {
$specs[$category->fields['categories_id']]=array(
				'start_time' =>array('monday'=>$category->fields['monday_start_first'],
								  	 'tuesday'=>$category->fields['tuesday_start_first'],
									'wednesday'=>$category->fields['wednesday_start_first'],
									'thursday'=>$category->fields['thursday_start_first'],
									'friday'=>$category->fields['friday_start_first'],
									'saturday'=>$category->fields['saturday_start_first'],
									'sunday'=>$category->fields['sunday_start_first']),	
				'end_time' =>array('monday'=>$category->fields['monday_end_first'],
								  'tuesday'=>$category->fields['tuesday_end_first'],
								  'wednesday'=>$category->fields['wednesday_end_first'],
								  'thursday'=>$category->fields['thursday_end_first'],
									 'friday'=>$category->fields['friday_end_first'],
									'saturday'=>$category->fields['saturday_end_first'],
									'sunday'=>$category->fields['sunday_end_first'])					
					 );
	$category->MoveNext();
	}
    return $specs;
}
//misc functions
function update_company_shipping($sendto,$company){
	global $db;
	$db->Execute('update address_book set entry_company="'.$company.'" where address_book_id="'.$sendto.'"');
}
function update_suburb_shipping($sendto,$suburb){
	global $db;
	$db->Execute('update address_book set entry_suburb="'.$suburb.'" where address_book_id="'.$sendto.'"');	
}
function zm_get_restaurant_ips(){
	global $db;
	$res = $db->Execute('select * from ip_listing where code = 1');
	$ip_array = explode(',',$res->fields['ip']);
	return $ip_array;
}
function zm_get_fooddudestaging_ips(){
	global $db;
	$res = $db->Execute('select * from ip_listing where code = 0');
	$ip_array = explode(',',$res->fields['ip']);
	return $ip_array;
}
function zm_get_c_level($cPath_new){
	$full_cpath = zen_generate_category_path(end(zen_parse_category_path
	(str_replace('cPath=', '', $cPath_new))));
	$c_level = count($full_cpath[0]);	
	return $c_level;
}
function zm_find_appt_company(){
	global $db;
	$aptcom = array();
		$check_for_apt = $db->Execute('select entry_company,entry_suburb from address_book where customers_id='.(int)$customers_id.' and entry_street_address  LIKE "%'.$_SESSION['address_separated'][0]['street_number'].'%" and entry_postcode LIKE "%'.$_SESSION['address_separated'][0]['postcode'].'%"  ORDER BY entry_suburb DESC limit 0,1');
		$aptcom['apt']=$check_for_apt->fields['entry_suburb'];
		$aptcom['company']=$check_for_apt->fields['entry_company'];
	return $aptcom;
}
function zm_add_address_to_book(){
	global $db;
	//sanitize me
	$_SESSION['address_separated'][0]['short_state']=$_SESSION['address_separated'][0]['state'];
	$state_name = $_SESSION['address_separated'][0]['short_state'];
	//echo 'select zone_id,zone_country_id from zones where zone_code="'.$state_name.'"';
	$zone_info = $db->Execute('select zone_id,zone_country_id from zones where zone_name="'.$state_name.'"');
	$zone_id=$zone_info->fields['zone_id'];
	$zone_country_id=$zone_info->fields['zone_country_id'];
	$customers_id = $_SESSION['customer_id'];
	$customers_firstname = $_SESSION['customer_first_name'];
	$customers_lastname = $_SESSION['customer_last_name'];
    $customers_state=$_SESSION['address_separated'][0]['state'];
	$customers_street_address = $_SESSION['address_separated'][0]['street_number'].' '.$_SESSION['address_separated'][0]['street'];
	$customers_postcode = $_SESSION['address_separated'][0]['postcode'];
	$customers_city = $_SESSION['address_separated'][0]['city'];
	$veri_apt = $_SESSION['address_separated'][0]['apt'];
	$aptcom =zm_find_appt_company();
	if(strlen($veri_apt)>0){
		$appt=$veri_apt;
	}else if(strlen($aptcom['apt'])>0){
		$appt=$aptcom['apt'];
	}
	$com=$aptcom['company'];
	$check_for_id_sql = 'select address_book_id from address_book where customers_id='.(int)$customers_id.' and entry_street_address LIKE "%'.$_SESSION['address_separated'][0]['street_number'].'%" and entry_postcode="'.$customers_postcode.'" and entry_city="'.$customers_city.'" ORDER BY entry_suburb DESC limit 0,1';
	$insert_sql = 'insert into address_book (customers_id,entry_state,entry_firstname,entry_lastname,entry_street_address,entry_suburb,entry_company,entry_postcode,entry_city,entry_country_id,entry_zone_id) values ('.(int)$customers_id.',"'.$customers_state.'","'.$customers_firstname.'","'.$customers_lastname.'","'.$customers_street_address.'","'.$appt.'","'.$com.'","'.$customers_postcode.'","'.$customers_city.'","223","'.$zone_id.'")';
//checkout final timecheck
$find_address_book_id = $db->Execute($check_for_id_sql);
if(count($find_address_book_id->fields['address_book_id'])>0){
	$address_book_id = $find_address_book_id->fields['address_book_id'];
}else{
	$db->Execute($insert_sql);
	 $address_book_id = $db->Insert_ID();
	//$address_book_id = $find_address_book_id->fields['id'];
}
	if($_SESSION['sendto']==$_SESSION['billto']){
		$same_bill_send = true;
	}else{
		$same_bill_send = false;
	}
	if($same_bill_send){
		$_SESSION['billto']=$address_book_id;
	}
	$_SESSION['sendto']=$address_book_id;
	$db->Execute('update customers set customers_default_address_id="'.$address_book_id.'" where customers_id="'.(int)$customers_id.'"');
	$_SESSION['customer_default_address_id']=$address_book_id;
	$_SESSION['cart_address_id']=$address_book_id;
	return;
}
function zm_add_address_to_book_for_login(){
	global $db;
	//sanitize me
	$state_name = ucfirst(strtolower(str_replace(' ', '', $_SESSION['address_separated'][0]['short_state'])));
	$zone_info = $db->Execute('select zone_id,zone_country_id from zones where zone_code="'.$state_name.'"');
	$zone_id=$zone_info->fields['zone_id'];
	$zone_country_id=$zone_info->fields['zone_country_id'];
	$customers_id = $_SESSION['customer_id'];
	$customers_firstname = $_SESSION['customer_first_name'];
	$customers_lastname = $_SESSION['customer_last_name'];
    $customers_state=$_SESSION['address_separated'][0]['state'];
	$customers_street_address = $_SESSION['address_separated'][0]['street_number'].' '.$_SESSION['address_separated'][0]['street'];
	$customers_postcode = $_SESSION['address_separated'][0]['postcode'];
	$customers_city = $_SESSION['address_separated'][0]['city'];
	$veri_apt = $_SESSION['address_separated'][0]['apt'];
	$aptcom =zm_find_appt_company();
	if(strlen($veri_apt)>0){
		$appt=$veri_apt;
	}else if(strlen($aptcom['apt'])>0){
		$appt=$aptcom['apt'];
	}
	$com=$aptcom['company'];
	$check_for_id_sql = 'select address_book_id from address_book where customers_id='.(int)$customers_id.' and entry_street_address LIKE "%'.$_SESSION['address_separated'][0]['street_number'].'%" and entry_postcode="'.$customers_postcode.'" and entry_city="'.$customers_city.'" ORDER BY entry_suburb DESC limit 0,1';
	$insert_sql = 'insert into address_book (customers_id,entry_state,entry_firstname,entry_lastname,entry_street_address,entry_suburb,entry_company,entry_postcode,entry_city,entry_country_id,entry_zone_id) values ('.(int)$customers_id.',"'.$customers_state.'","'.$customers_firstname.'","'.$customers_lastname.'","'.$customers_street_address.'","'.$appt.'","'.$com.'","'.$customers_postcode.'","'.$customers_city.'","223","'.$zone_id.'")';
//checkout final timecheck
$find_address_book_id = $db->Execute($check_for_id_sql);
if(count($find_address_book_id->fields['address_book_id'])>0){
	$address_book_id = $find_address_book_id->fields['address_book_id'];
}else{
	$db->Execute($insert_sql);
	$find_address_book_id = $db->Execute('SELECT max( address_book_id ) as id
FROM address_book
WHERE customers_id ="'.(int)$customers_id.'"');
	$address_book_id = $find_address_book_id->fields['id'];
}
	$db->Execute('update customers set customers_default_address_id="'.$address_book_id.'" where customers_id="'.(int)$customers_id.'"');
	return (int)$address_book_id;
}
function random_address(){
		global $db;
		$rand=  rand (1000,40500);
		$address=$db->Execute('select entry_street_address, entry_city,entry_postcode,entry_suburb,entry_state from address_book where address_book_id ="'.$rand.'"');
		$j=$address->fields['entry_street_address'].' '.$address->fields['entry_suburb'].' '.$address->fields['entry_city'].', '.$address->fields['entry_state'].' '.$address->fields['entry_postcode'];
		return $j;
}
function zm_date($date){
	if(is_numeric($date)){
		$ret = date('m/d/y g:ia',$date);	
	}else{
		$ret = date('m/d/y g:ia',strtotime($date));
	}
	return $ret;
}
function zm_get_menu_count($cpath){
	global $db;
	$cat_path = explode('_',$cpath);
	$cat_id= $cat_path[count($cat_path)-1];
	$categories_query = $db->Execute("
		SELECT count( categories_id ) as c
		FROM categories
		WHERE parent_id =".(int)$cat_id."
		AND categories_status =1");
	return $categories_query->fields['c'];
}
function zm_restaurant_path_from_cpath($cpath){
	$tc = explode('_',$cpath);
	$new_path = $tc[3];
	return $new_path; 
}
function zm_get_current_restaurant_link(){
	$product_array = $_SESSION['cart']->get_product_id_array();
	$product_path= zm_get_product_path($product_array[0]);
	$link = zen_href_link(FILENAME_DEFAULT, 'cPath='.zm_restaurant_path_from_cpath($product_path));	
	return $link;
}
function zm_get_first_subcategories($parent_id) {
    global $db;
	$subcategories_array = array();
    $subcategories_query = "select cd.categories_id,cd.categories_name,cd.lat,cd.lng
                            from categories as c
							inner join categories_description as cd on cd.categories_id = c.categories_id
                            where parent_id = '" . (int)$parent_id . "' and cd.categories_id !='1914' order by categories_name";
    $subcategories = $db->Execute($subcategories_query);
    while (!$subcategories->EOF) {
      $subcategories_array[] = array('id'=>$subcategories->fields['categories_id'],
	 								 'lat'=>$subcategories->fields['lat'],
	 								 'lng'=>$subcategories->fields['lng'],
	  								'name'=>$subcategories->fields['categories_name']);
      $subcategories->MoveNext();
    }
	return  $subcategories_array;
}
function zm_check_cart(){
	if($_SESSION['cart']->count_contents()>0){
		$product_array = $_SESSION['cart']->get_product_id_array();
		$product_path= zm_get_product_path($product_array[0]);
		$categories_id = zm_restaurant_path_from_cpath($product_path);	
	}else{
		$real_menu_ids =array_values($_SESSION['real_menu']);
		$categories_id=	zen_categories_lookup($real_menu_ids[0],'parent_id');
		if(!$categories_id){
			$categories_id=0;
		}
	}
	return $categories_id;
}
function zm_check_cart_for_available(){
	if($_SESSION['cart']->count_contents()>0){
		$product_array = $_SESSION['cart']->get_product_id_array();
		$product_path= zm_get_product_path($product_array[0]);
		$categories_id = zm_restaurant_path_from_cpath($product_path);	
		$available_list = array_keys($_SESSION['restaurant_info_temp']);
		if(in_array($categories_id,$available_list)){
			$available=1;
		}else{
			$available=0;
		}
	}else{
		$available=1;
	}
	return $available;
}
function zm_delete_cart(){
	$_SESSION['cart']->remove_all();
	echo 1;
}
function zm_get_restaurant_closed_dates(){
	global $db;
	$date_sql = $db->Execute('select special_off_1 from categories_description where categories_id="'
	.intval($_SESSION['current_page_category_id']).'" and special_off_1 !="na" ');
	 return explode(',',$date_sql->fields['special_off_1']);
}
function zm_get_restaurant_closed_dates_for_open_next($id){
	global $db;
	$date_sql = $db->Execute('select special_off_1 from categories_description where categories_id="'
	.intval($id).'" and special_off_1 !="na"   ');
	$ex = explode(',',$date_sql->fields['special_off_1']);
	$new=array();
	foreach($ex as $x){
		if($x){
			$new[]=date('m/d/Y',strtotime($x));
		}
	}
	 return $new;
}
function zm_get_first_name(){
	global $db;
	if($_SESSION['customer_id']){
	$date_sql = $db->Execute('select customers_firstname,customers_lastname from customers where customers_id="'.intval($_SESSION['customer_id']).'"');
	 return $date_sql->fields['customers_firstname'];
	}else{
	return '';	
	}
}
function zm_get_customer_name(){
	global $db;
	if($_SESSION['customer_id']){
	$date_sql = $db->Execute('select customers_firstname,customers_lastname from customers where customers_id="'.intval($_SESSION['customer_id']).'"');
	 return $date_sql->fields['customers_firstname'].' '.$date_sql->fields['customers_lastname'];
	}else{
	return '';	
	}
}
function zm_add_to_route_matrix(){
	global $db;
	$address=$_SESSION['address_separated'][0];
	$address['street_number'] = addslashes(strtoupper($address['street_number']));
	$address['street'] =addslashes( strtoupper($address['street']));
	$address['city'] = addslashes(strtoupper($address['city']));
	$address['state'] = addslashes(strtoupper($address['state']));
	$address['postcode'] = addslashes(strtoupper($address['postcode']));
	$insert_matrix_sql='insert into address_route_matrix 
	(street_number,street,city,state,zip,route_matrix) values ("'.
	$address['street_number'].'","'.
	$address['street'].'","'.
	$address['city'].'","'.
	$address['state'].'","'.
	$address['postcode'].'","'.
	base64_encode(json_encode($_SESSION['restaurant_info'])).'")';
	$db->Execute($insert_matrix_sql);
}
function zm_create_address_separated($address,$save_address){
	if(true){
		$_SESSION['address_separated'] = array();
		$address = json_decode($address,true);
		$_SESSION['address_separated'][0]['street_number']=$address['street_number'];
		$_SESSION['address_separated'][0]['street']=$address['street'];
		$_SESSION['address_separated'][0]['postcode']=$address['zipcode'];
		$_SESSION['address_separated'][0]['city']=$address['city'];
		$_SESSION['address_separated'][0]['state']=$address['state'];
		$_SESSION['restaurant_info']=array();
		foreach(json_decode($_POST['routes'],true) as $info){
			$_SESSION['restaurant_info'][$info['categories_id']]=array( 'distance' => $info['distance'], 'duration' => $info['duration'], 'delivery_fee' => $info['delivery_fee'] );
		}
		$_SESSION['customers_lat_lng']=json_decode($_POST['latlng'],true);
	}else{
		$_SESSION['restaurant_info']=$_SESSION['restaurant_info_temp'];
		unset($_SESSION['restaurant_info_temp']);
		if(isset($_SESSION['address_separated'])){
			unset($_SESSION['address_separated']);
	}
	$_SESSION['address_separated'] = json_decode($address,true);
	//if(isset($_SESSION['fooddudestaging_login'])){
		if($save_address=='save'){
			zm_add_to_route_matrix();
		}
	//}
	}
	zm_delete_cart();
	//$_SESSION['address_separated']=zm_address_format($_SESSION['address_separated']);
	if(isset($_SESSION['customer_id'])){
		zm_add_address_to_book();
	}
	return 1;
}
//function zm_create_restaurant_info_session(){
//	$_SESSION['restaurant_info']=$_SESSION['restaurant_info_temp'];
//	unset($_SESSION['restaurant_info_temp']);
//	echo 1;
//}
function zm_check_cart_for_available_for_address($cat_id){
	if(isset($_SESSION['restaurant_info']) && is_array($_SESSION['restaurant_info'])){
		$available_list = array_keys($_SESSION['restaurant_info']);
		if(in_array($cat_id,$available_list)){
			$available=1;
		}else{
			$available=0;
		}
	}else{
		$available=0;	
	}
	return $available;
}
function zm_get_restaurant_id_from_product($product_id){
	   if(!is_numeric($product_id)){
		   $new_li_tmp= explode(':',$product_id);
		   $product_id = $new_li_tmp[0];
	   }else{
		   $product_id = $product_id;
	   }
		$product_path= zm_get_product_path($product_id);
		$categories_id = zm_restaurant_path_from_cpath($product_path);	
	return $categories_id;
}
function zm_get_menu_id_from_product($product_id){
	   if(!is_numeric($product_id)){
		   $new_li_tmp= explode(':',$product_id);
		   $product_id = $new_li_tmp[0];
	   }else{
		   $product_id = $product_id;
	   }
		$product_path= zm_get_product_path($product_id);
		$categories_id = zm_menu_path_from_cpath($product_path);	
	return $categories_id;
}
//function zm_get_city_names_coords(){
//	global $db;
//    $categories_array = [];
//    $categories_query = "
//		SELECT cd.categories_name, c.categories_id, c.parent_id,cd.lng,cd.lat
//		FROM categories_description AS cd
//		INNER JOIN categories AS c ON cd.categories_id = c.categories_id
//		WHERE c.parent_id
//		IN (
//			SELECT categories_id
//			FROM categories
//			WHERE parent_id =1
//		)";
//    $categories = $db->Execute($categories_query);
//    while (!$categories->EOF) {
//      $categories_array[] = array('categories_id' => $categories->fields['categories_id'],
//                                  'categories_name' =>  $categories->fields['categories_name'],
//								  'lat' =>  $categories->fields['lat'],
//								  'lng' =>  $categories->fields['lng']);
//      $categories->MoveNext();
//    }
//   return $categories_array;
//}
function this_is_ie(){
	preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
	if(count($matches)<2){
 	 preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
	}
	if(count($matches)<1){
		return 0;
	}else{
		return 1;
	}
}
function zm_find_available_restaurants($restaurant_info){
	global $db;
	$restaurant_info = json_decode($restaurant_info,true);
	$cPath=array();
	$i=0;
	$a=0;
	$restaurant_ids=$_SESSION['found_restaurant_ids'];
	unset($_SESSION['found_restaurant_ids']);
	for($l=0;$l<count($restaurant_ids);$l++){
		$restaurant_info[$l]['categories_id']=$restaurant_ids[$l];
	}
	foreach($restaurant_info as $ri){
		$parent = zen_generate_category_path($ri['categories_id']);
		foreach($parent[0] as $p){
			$id_array[]="'".$p['id']."'";
			$cPath[$i].=$p['id'].'_';
		}
		$i++;
	}
	$new_master_array=array();
	$ids=implode(',',array_unique($id_array));
	$info_array=zm_get_restaurant_info($ids);
	$columns = array_keys($info_array[1]);
	for($v=0;$v<count($cPath);$v++){
		$cArray = array_reverse (explode("_",$cPath[$v]));
		//$new_master_array[$v]['categories_id']=$cArray[count($cArray)-1];	
		for($c=0;$c<count($columns);$c++){
			$new_master_array[$cArray[count($cArray)-1]][$columns[$c]]=zm_analyze_specs($info_array,$cArray,$columns[$c]);
		}
	}
	//$restaurant_info = zm_get_city_ranges($new_master_array,$restaurant_info);
	$restaurant_info = zm_get_delivery_fees($new_master_array,$restaurant_info);
	$final_array=array();
	foreach($restaurant_info as $ri){
		if($ri['delivery_fee']!=0){
			$final_array[$ri['categories_id']]=array(
								'distance'=>$ri['distance'],
								'duration'=>$ri['duration'],
								'delivery_fee'=>floatval($ri['delivery_fee']));
		}	
	}
	if(count($final_array)==0){
		$final_array=0;	
	}
	$_SESSION['restaurant_info_temp']=$final_array;
	print_r(json_encode($final_array));
}
function add_message_to_stack($msg,$optional){
	global $messageStack;
	zm_any_error($msg,$optional);
	$messageStack->add_session('header',$msg,'error');
	echo 1;
	//die;
}
function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }
        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
    return $new_array;
}
function zm_get_delivery_fees($new_master_array,$restaurant_info){
	for($i=0;$i<count($restaurant_info);$i++){
		if($restaurant_info[$i]['distance']<$new_master_array[$restaurant_info[$i]['categories_id']]['max_travel_distance']&&$restaurant_info[$i]['duration']<$new_master_array[$restaurant_info[$i]['categories_id']]['max_travel_time']){
		if($restaurant_info[$i]['distance']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_5_distance']||$restaurant_info[$i]['duration']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_5_time']){
		   $restaurant_info[$i]['delivery_fee']=
		   $new_master_array[$restaurant_info[$i]['categories_id']]['tier_5_price'];
		}else if($restaurant_info[$i]['distance']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_4_distance']||$restaurant_info[$i]['duration']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_4_time']){
		   $restaurant_info[$i]['delivery_fee']=
		   $new_master_array[$restaurant_info[$i]['categories_id']]['tier_4_price'];			
		}else if($restaurant_info[$i]['distance']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_3_distance']||$restaurant_info[$i]['duration']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_3_time']){
		   $restaurant_info[$i]['delivery_fee']=
		   $new_master_array[$restaurant_info[$i]['categories_id']]['tier_3_price'];			
		}else if($restaurant_info[$i]['distance']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_2_distance']||$restaurant_info[$i]['duration']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_2_time']){
		   $restaurant_info[$i]['delivery_fee']=
		   $new_master_array[$restaurant_info[$i]['categories_id']]['tier_2_price'];			
		}else if($restaurant_info[$i]['distance']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_1_distance']||$restaurant_info[$i]['duration']>$new_master_array[$restaurant_info[$i]['categories_id']]['tier_1_time']){
		   $restaurant_info[$i]['delivery_fee']=
		   $new_master_array[$restaurant_info[$i]['categories_id']]['tier_1_price'];			
		}else{
			$restaurant_info[$i]['delivery_fee']=0;	
		}
		}else{
			$restaurant_info[$i]['delivery_fee']=0;	
		}
	}
	return $restaurant_info;
}
class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
    function pointLocation() {
    }
        function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $vertices_count = count($vertices);
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        // If the number of edges we passed through is odd, then it's in the polygon.
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
}
function zm_get_restaurant_info($ids){
	global $db;
	$info_sql = $db->Execute('select categories_id,max_travel_distance,max_travel_time ,tier_1_distance,tier_2_distance,tier_3_distance,tier_4_distance,tier_5_distance,tier_1_time,tier_2_time,tier_3_time,tier_4_time,tier_5_time,tier_1_price,tier_2_price,tier_3_price,tier_4_price,tier_5_price from categories_description where categories_id in('.$ids.')');
	while (!$info_sql->EOF) {
      $info_array[$info_sql->fields['categories_id']] = 
	  				  array('max_travel_distance' => $info_sql->fields['max_travel_distance'],
                            'max_travel_time' =>  $info_sql->fields['max_travel_time'],
							'tier_1_distance' =>  $info_sql->fields['tier_1_distance'],
							'tier_2_distance' =>  $info_sql->fields['tier_2_distance'],
							'tier_3_distance' =>  $info_sql->fields['tier_3_distance'],
                            'tier_4_distance' =>  $info_sql->fields['tier_4_distance'],
							'tier_5_distance' =>  $info_sql->fields['tier_5_distance'],
							'tier_1_price' =>  $info_sql->fields['tier_1_price'],
							'tier_2_price' =>  $info_sql->fields['tier_2_price'],
							'tier_3_price' =>  $info_sql->fields['tier_3_price'],
                            'tier_4_price' =>  $info_sql->fields['tier_4_price'],
							'tier_5_price' =>  $info_sql->fields['tier_5_price'],
							'tier_1_time' =>  $info_sql->fields['tier_1_time'],
							'tier_2_time' =>  $info_sql->fields['tier_2_time'],
                            'tier_3_time' =>  $info_sql->fields['tier_3_time'],
							'tier_4_time' =>  $info_sql->fields['tier_4_time'],
							'tier_5_time' =>  $info_sql->fields['tier_5_time']);
      $info_sql->MoveNext();
    }
	return $info_array;
}
function zm_get_city_json_ranges(){
	global $db;
	$info_sql = $db->Execute('
SELECT json_range, c.categories_id
FROM categories_description AS cd
INNER JOIN categories AS c ON c.categories_id = cd.categories_id
WHERE c.parent_id
IN (
SELECT categories_id
FROM categories
WHERE parent_id =1
)
');
	while (!$info_sql->EOF) {
      $info_array[$info_sql->fields['categories_id']] = $info_sql->fields['json_range'];
      $info_sql->MoveNext();
    }
	return $info_array;
}
function zm_analyze_specs($info_array,$cArray,$column){
	// this goes from the most sepcific category up
	$dieAntwood= '';
	$i= count($cArray)-1;
	while($i>0 && $dieAntwood ==''){
		if($info_array[$cArray[$i]][$column] != "" && $info_array[$cArray[$i]][$column] != "na" ){
			 $dieAntwood = $info_array[$cArray[$i]][$column];
			 //echo $info_array[$cArray[$i]][$column].'<br />';
		}
		$i--;
	}
	if($dieAntwood==''){$dieAntwood="NA";}
	//$dieAntwood= $specs.$cPath.$column.$para1.$para2;
	return $dieAntwood;
}
//address process functions

function check_with_restaurant_info($id){
	global $db;
	$sql_ = 'select
		categories_id, max_travel_distance, max_travel_time, estimated_delivery_time,
		tier_1_distance,tier_2_distance,tier_3_distance,tier_4_distance,tier_5_distance, 
		tier_1_time,tier_2_time,tier_3_time,tier_4_time,tier_5_time, 
		tier_1_price,tier_2_price,tier_3_price,tier_4_price,tier_5_price 
		from categories_description 
		where categories_id = '.$id;
	for ($i=1; $i < 6; $i++){ 
		$sql_ .= ' AND tier_'.$i.'_distance NOT IN ("na", " ", "") AND tier_'.$i.'_time NOT IN ("na", " ", "") AND tier_'.$i.'_price NOT IN ("na", " ", "") ';
	}
	
	$info_sql = $db->Execute($sql_);
	while (!$info_sql->EOF) {
      $info_array[$info_sql->fields['categories_id']] = 
	  				  array('estimated_delivery_time' => $info_sql->fields['estimated_delivery_time'],
	  				  		'max_travel_distance' => $info_sql->fields['max_travel_distance'],
                            'max_travel_time' =>  $info_sql->fields['max_travel_time'],
							'tier_1_distance' =>  $info_sql->fields['tier_1_distance'],
							'tier_2_distance' =>  $info_sql->fields['tier_2_distance'],
							'tier_3_distance' =>  $info_sql->fields['tier_3_distance'],
                            'tier_4_distance' =>  $info_sql->fields['tier_4_distance'],
							'tier_5_distance' =>  $info_sql->fields['tier_5_distance'],
							'tier_1_price' =>  $info_sql->fields['tier_1_price'],
							'tier_2_price' =>  $info_sql->fields['tier_2_price'],
							'tier_3_price' =>  $info_sql->fields['tier_3_price'],
                            'tier_4_price' =>  $info_sql->fields['tier_4_price'],
							'tier_5_price' =>  $info_sql->fields['tier_5_price'],
							'tier_1_time' =>  $info_sql->fields['tier_1_time'],
							'tier_2_time' =>  $info_sql->fields['tier_2_time'],
                            'tier_3_time' =>  $info_sql->fields['tier_3_time'],
							'tier_4_time' =>  $info_sql->fields['tier_4_time'],
							'tier_5_time' =>  $info_sql->fields['tier_5_time']);
      $info_sql->MoveNext();
    }
	return $info_array;	
}