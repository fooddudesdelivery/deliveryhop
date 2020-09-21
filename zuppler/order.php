<?php

require ('../includes/configure.php');
global $db;
date_default_timezone_set('America/Chicago');
// ini_set('display_errors',true);
// error_reporting(E_ALL);
ini_set('memory_limit', '-1');

$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

$result = array();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json;charset=ISO-8859-1');

if(isset($_GET['api']) && $_GET['api']=='create'){
	writeRequestResponseLog($_POST);
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dataset']) && !empty($_POST['dataset']) ) {

		global $db;
		$dataset = json_decode($_POST['dataset'],true);
		
		if (!empty($dataset)) {			
			$customer_id=$dataset['customer_id'];
			$customers_name=htmlentities($dataset['customers_name'],ENT_QUOTES);
			$city=$dataset['city'];
			$postcode=$dataset['postcode'];
			$state=$dataset['state'];
			$address=htmlentities($dataset['address'],ENT_QUOTES);
			$phone=$dataset['phone'];
			$gh_id=0;
			$is_adjusted_order=0;
			$categories_id=$dataset['restaurant_id'];
			$email=$dataset['email'];
			$payment_method=$dataset['payment_method'];
			$payment_module_code=$dataset['payment_module_code'];
			$shipping_method = $dataset['shipping_method'];
  			$shipping_module_code = $dataset['shipping_module_code'];
			
			//orders total table
			$total=$dataset['total'];
			$salestax=$dataset['salestax'];
			$subtotal=$dataset['subtotal'];
			$tip=$dataset['tip'];
			$delivery_fee=$dataset['delivery_fee'];
			$products_array = $dataset['products'];
			
			$coupon_code = $dataset['coupon_code'];
			$cc_type = $dataset['cc_type'];
			$cc_owner = $dataset['cc_owner'];
			$cc_number = $dataset['cc_number'];
			$cc_expires = $dataset['cc_expires'];
			$cc_cvv = $dataset['cc_cvv'];
			$zuppler_id=$dataset['zuppler_order_id'];
			$zuppler_order_uid=$dataset['order_uid'];
			$orders_status = $dataset['orders_status'];
			$special_instructions = htmlentities($dataset['special_instructions'],ENT_QUOTES);
			$comments = htmlentities($dataset['comments'],ENT_QUOTES);
			$date_deliver = $dataset['date_deliver'];
			$pickup_order = $dataset['pickup_order'];

			if($payment_module_code == 'cod' && strtolower($shipping_method) == 'delivery'){
				$cash_order = 1;
			}else{
				$cash_order = 0;
			}

			$order_table="
			INSERT INTO orders 
			(
			categories_id,
			zuppler_id,
			zuppler_order_uid,
			customers_city,
			customers_id,
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
			coupon_code,
			cc_type,
			cc_owner,
			cc_number,
			cc_expires,
			cc_cvv,
			pickup_order,
			cash_order

			)
			VALUES
			(
			'".$categories_id."',
			'".$zuppler_id."',			
			'".$zuppler_order_uid."',			
			'".$city."',
			'".$customer_id."',
			'".$customers_name."',
			'".$postcode."',
			'".$state."',
			'".$address."',
			'".$phone."',
			'".$city."',
			'".$customers_name."',
			'".$postcode."',
			'".$state."',
			'".$address."',
			'".date('Y-m-d H:i:s', strtotime($date_deliver))."',
			'".date('Y-m-d H:i:s')."',
			3,
			600,
			'".date('Y-m-d H:i:s')."',
			'".$orders_status."',
			'".$salestax."',
			'".$total."',
			2, 
			2,
			'United States',
			'".$email."',
			'United States',
			'United States',
			'".$gh_id."',
			'".$payment_method."',
			'".$payment_module_code."',
			'USD',
			1.0,
			'".$city."',
			'".$customers_name."',
			'".$postcode."',
			'".$state."',
			'".$address."',
			2,
			'".$shipping_method."',
			'".$shipping_module_code."',
			'".$is_adjusted_order."',
			'".$coupon_code."',
			'".$cc_type."',
			'".$cc_owner."',
			'".$cc_number."',
			'".$cc_expires."',
			'".$cc_cvv."',
			'".$pickup_order."',
			'".$cash_order."'
			
			)";
			//echo $order_table; die;
			$r = $db->query($order_table);
			$orders_id=$db->lastInsertId();
			//print_r($orders_id); die;
			if ($orders_id) {
					
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
				  $db->query($orders_total);
				}
			
				// add note
				if(!empty($special_instructions)){
					$insert_sql = "
					INSERT INTO notes( order_id, note_type, note, timestamp, made_by )
					VALUES ( $orders_id, '4', '$special_instructions', NOW() , 0 ) ";
					$db->query($insert_sql);
				}
				
				if(!empty($comments)){
					$insert_sql = "
					INSERT INTO notes( order_id, note_type, note, timestamp, made_by )
					VALUES ( $orders_id, '0', '$comments', NOW() , 0 ) ";
					$db->query($insert_sql);
				}

				foreach($products_array as $p){
					$orders_products="
					INSERT INTO orders_products
						(products_model,orders_id,products_id,products_name,products_price,final_price,products_quantity,products_tax)
					VALUES
						('".$p['model']."','".$orders_id."','".$p['products_id']."','".htmlentities($p['name'],ENT_QUOTES)."','".$p['price']."','".$p['final_price']."','".$p['quantity']."','".$p['tax']."')";
					
					if($db->query($orders_products)){
						$orders_products_id=$db->lastInsertId();
						foreach($p['options'] as $o){
							$orders_products_attributes="
							INSERT INTO orders_products_attributes
								(orders_id,orders_products_id,products_options_values,options_values_price,price_prefix,products_options_id,products_options_values_id)
							VALUES
								('".$orders_id."','".$orders_products_id."','".$o['products_options_values']."','".$o['options_values_price']."','".$o['price_prefix']."','".$o['products_options_id']."','".$o['products_options_values_id']."')";
							$db->query($orders_products_attributes);
						}	
					}
				}
				$notify = 0;
				if($orders_status == 9){
					$notify = 1;
				}				
				$db->query('insert into orders_status_history (orders_id,orders_status_id,date_added,updated_by,customer_notified) values  ("'.$orders_id.'","'.$orders_status.'",now(),"Zuppler","'.$notify.'")');
				$result['status'] = 200;
				$result['order_id'] = $orders_id;
				$result['msg'] = 'Order successfully created.';
			}else{
				http_response_code(400);
				$result['status'] = 400;
				$result['msg'] = 'Oops! something went wrond. Order not placed.';
			}
		}else{
			http_response_code(400);
			$result['status'] = 400;
			$result['msg'] = 'Invalid data provided.';
		}
	}else{
		http_response_code(404);
		$result['status'] = 404;
		$result['msg'] = 'Invalid data. Data not formated properly it should be json string in key dataset.';
	}
	echo json_encode($result);
	exit;
}else{
	http_response_code(400);
	echo  json_encode (['status'=>400, 'message'=>'Invalid request']);
	exit;
}


/*Pickuped in Store
$html = [
	'customers_name'	=> 		'Pawan Kumar',
	'city'				=> 		'saintcloud',
	'postcode'			=> 		'000',
	'state'				=> 		'MN',
	'address'			=> 		'622 FAKE ADDRESS',
	'phone'				=> 		'3203106216',
	'categories_id'		=> 		11833,
	'email'				=> 		'pawan.kumar@matellio.com',
	'payment_method'	=> 		'cod',
	'payment_module_code'=> 	'cod',
	'total'				=> 		0,
	'salestax'			=> 		0,
	'subtotal'			=> 		0,
	'tip'				=> 		0,
	'delivery_fee'		=> 		0,
	'coupon_code',		=> 		'11dasd21',
	'cc_type',			=> 		'visa',
	'cc_owner',			=> 		'Card owner name',
	'cc_number',		=> 		'xxxxxxxxxxxxxxxx',
	'cc_expires',		=> 		'06/2020',
	'cc_cvv'			=> 		'xxx',
	'products'			=> [
		[
			'name'	=>	'Fake Product',
			'price'	=>	0,
			'final_price'=>0,
			'quantity'=>0,
			'tax'=>0,
			'model'=>'',
			'options'=>[
				'products_options_values'=>'Wok',
				'options_values_price'=>'',
				'price_prefix'=>''
			]
		],
		[
			'name'	=>	'Fake Product',
			'price'	=>	0,
			'final_price'=>0,
			'quantity'=>0,
			'tax'=>0,
			'model'=>'',
			'options'=>[
				'products_options_values'=>'Wok',
				'options_values_price'=>'',
				'price_prefix'=>''
			]
		],
	]
];

echo json_encode($html);
exit;
*/

function writeRequestResponseLog($data) {
    $apiLog = fopen("../cache/zuppler-Log.txt", "a+");    
    $text = "\n\n\n**************************************************************************************************\n";
    $text .= '"Date":'.date('Y-m-d H:i:s')."\n";            
    $text .= json_encode($data);
    fwrite($apiLog, $text);
    fclose($apiLog);
}

?>