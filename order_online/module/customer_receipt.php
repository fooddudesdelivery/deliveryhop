<?php
$orders_sql = "
SELECT o.orders_id, o.customers_telephone, o.customers_email_address, o.delivery_name, o.delivery_company, o.delivery_street_address, o.delivery_suburb, o.delivery_city, o.delivery_postcode, o.delivery_state, o.payment_method, o.payment_module_code, o.shipping_method, o.shipping_module_code, o.date_purchased, o.orders_status, o.categories_id, o.date_deliver,cd.categories_name
FROM orders AS o
INNER JOIN categories_description as cd on cd.categories_id = o.categories_id
WHERE orders_id =$orders_id
LIMIT 0 , 1";

$orders_products_sql="
SELECT op.orders_products_id, op.products_id, op.products_model, op.products_name, op.products_price, op.final_price, op.products_tax, op.products_quantity, op.onetime_charges
FROM orders_products AS op
INNER JOIN orders AS o ON o.orders_id = op.orders_id
WHERE o.orders_id =$orders_id
LIMIT 0 , 99999";

$orders_products_attributes_sql="
SELECT opa.orders_products_id, opa.products_options, opa.products_options_values, opa.options_values_price, opa.price_prefix
FROM orders_products_attributes AS opa
INNER JOIN orders AS o ON o.orders_id = opa.orders_id
WHERE o.orders_id =$orders_id
LIMIT 0 , 99999";

$orders_total_sql = "SELECT orders_id,title,text,value,class FROM orders_total where orders_id = $orders_id ORDER BY sort_order";

$order = $this->db->query($orders_sql)->fetch();
$orders_products = $this->db->query($orders_products_sql);
$orders_products_attributes = $this->db->query($orders_products_attributes_sql);
$orders_total = $this->db->query($orders_total_sql);

$email_string='';
$email_string.='<table style="text-align:center;width:auto">
	<tr><td style="font-weight:bold;">'.$order['categories_name'].' Receipt</td></tr>
    <tr><td>Order #'.$order['orders_id'].'</td></tr>
    <tr><td>'.date('m/d/y g:ia',strtotime($order['date_purchased'])).'</td></tr>
    <tr><td>'.$order['shipping_method'].'</td></tr>
    <tr><td><hr></td></tr>
    <tr><td style="font-weight:bold;">Customer</td></tr>
    <tr><td>'.$order['delivery_name'].'</td></tr>
    <tr><td>'.$order['customers_telephone'].'</td></tr>
    <tr><td>'.$order['customers_email_address'].'</td></tr>
    <tr><td><hr></td></tr>';
	if(intval($order['delivery_postcode'])!=0){
    $email_string.='<tr><td style="font-weight:bold;">Address</td></tr>';
    if($order['delivery_company']!=''){
    	$email_string.='<tr><td>'.$order['delivery_company'].'</td></tr>';
    }
	
    $email_string.='<tr><td>'.$order['delivery_street_address'].' '.$order['delivery_suburb'].'</td></tr>
    <tr><td>'.$order['delivery_city'].' '.$order['delivery_state'].' '.$order['delivery_postcode'].'</td></tr>
    <tr><td><hr></td></tr>';
	}
    $email_string.='<tr><td style="font-weight:bold;">Items</td></tr>';
     foreach($orders_products as $op){ 
         $email_string.='
		 <tr><td>'.$op['products_quantity'].'x '.$op['products_name'].' '.money_format('$%i',floatval($op['products_quantity'])*floatval($op['final_price'])).'</td></tr>';
		 if(intval($op['onetime_charges'])!=0){
			$email_string.='<tr><td>Extra Charge: '.$op['onetime_charges'].'</td></tr>'; 
		 }
		 foreach($orders_products_attributes as $opa){
			 if($opa['orders_products_id']==$op['orders_products_id']){
				 if(intval($opa['options_values_price'])==0){
					 $attr_price='';
				 }else{
					 $attr_price=' '.$opa['price_prefix'].money_format('$%i',$opa['options_values_price']);
				 }
				 $email_string.='<tr><td> -'.$opa['products_options_values'].$attr_price.'</td></tr>';
			 }
		 }
		  $email_string.='<tr><td></td></tr>';
     } 
    $email_string.='<tr><td><hr></td></tr>
    <tr><td style="font-weight:bold;">Totals</td></tr>
    <tr><td></td></tr>';
	
	foreach($orders_total as $ot){
		
		$email_string.='<tr><td style="text-align:right;">'.$ot['title'].' '.$ot['text'].'</td></tr>';
	}
	$email_string.='<tr><td><hr></td></tr>
    <tr><td style="font-weight:bold;">Payment</td></tr>
    <tr><td>'.$order['payment_method'].'</td></tr>
</table>';
return array('message'=>$email_string,'email'=>$order['customers_email_address'],'restaurant'=>$order['categories_name']);