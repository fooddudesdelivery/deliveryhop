<?php
require ('includes/configure.php');
global $db;
date_default_timezone_set(SITE_TIMEZONE);
$db_custom = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
$missing_order_totals = $db_custom->query("SELECT orders_id, order_tax, order_total FROM orders WHERE NOT EXISTS (SELECT orders_id, order_total FROM orders_total WHERE orders_total.orders_id = orders.orders_id) AND payment_module_code IN ('GV/DC', 'paypalwpp', 'braintree_api','invoice') AND (TIMESTAMPDIFF(SECOND,date_purchased,now()) > 5 AND TIMESTAMPDIFF(SECOND,date_purchased,now()) <= 180)")->fetchAll(PDO::FETCH_ASSOC);

$order_nos = array();
foreach($missing_order_totals as $key => $order){
	$order_nos[] = $order["orders_id"];
	$sql = $db_custom->query("UPDATE orders SET payment_method='Cash', payment_module_code='cod', cash_order='1' WHERE orders_id='".$order["orders_id"]."'");
	$subtotal = $delivery_fee = $salestax = $tip = $total = 0;
	$salestax = $order["order_tax"];
	$total = $order["order_total"];
	$subtotal = $total-$salestax;
	$value_array=array($subtotal, $delivery_fee, $salestax, $tip, $total);
	$class_array=array('ot_subtotal', 'ot_shipping', 'ot_tax', 'ot_tip', 'ot_total');
	$title_array=array('Subtotal:', 'Delivery:', 'Sales Tax:', 'Gratuity:', 'Total:');
	$sort_array=array(100, 200, 351, 800, 999);
	for($i=0;$i<count($value_array);$i++){
		$orders_total="INSERT INTO orders_total (orders_id,title,text,value,class,sort_order) VALUES ('".$order["orders_id"]."', '".$title_array[$i]."', '".money_format('$%i', $value_array[$i])."', '".$value_array[$i]."', '".$class_array[$i]."', '".$sort_array[$i]."')";
		$db_custom->query($orders_total);
	}
}

if(!empty($order_nos)){
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$param = '-f '.SERVICE_EMAIL;
	$email_to = SERVICE_EMAIL;
	$subject = "Missing Order Totals: Orders List On ".date("m/d/Y")." At ".date("h:i:s");
	$message = $subject."<br />";
	$message .= implode("<br />", $order_nos);
	$sent = mail("$email_to", $subject, $message,$headers,$param);
}