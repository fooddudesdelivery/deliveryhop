<?php 
//require ('../includes/application_top.php');
require ('../includes/configure.php');
global $db;
date_default_timezone_set('America/Chicago');
//ini_set('display_errors',true);
//  error_reporting(E_ALL);
ini_set('memory_limit', '-1');
//ini_set('max_execution_time', 6000); 
//ini_set('default_socket_timeout', 6000);

$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

$result = array();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json;charset=ISO-8859-1');
if(isset($_GET['api']) && $_GET['api']=='restaurant'){
	if(isset($_GET['restaurant_id']) && !empty($_GET['restaurant_id'])){
		global $db;
		$restaurants = $db->query("SELECT *
			FROM categories AS c
			INNER JOIN categories_description AS cd ON cd.categories_id = c.categories_id
				WHERE c.categories_id = ".$_GET['restaurant_id']."
				order by categories_name
		")->fetchAll(PDO::FETCH_ASSOC);
		// categories_status = 1 and

	}else{
		$restaurants = restaurantList();
	}

	if (!empty($restaurants)) {
		$url = isset($_SERVER["HTTPS"]) ? HTTPS_SERVER : HTTP_SERVER;	
		foreach ($restaurants as $key => $restaurant) {

			$restPickupoHour = $db->query("SELECT * FROM pickup_hours ph where ph.categories_id = ".$restaurant['categories_id'].' and pickup_on = 1 and delivery_on = 1  order by ph.pickup_hours_id desc')->fetchAll(PDO::FETCH_ASSOC);
			$pickup_hours = ["monday"=>["open"=>"","close"=>""],"tuesday"=>["open"=>"","close"=>""],"wednesday"=>["open"=>"","close"=>""],"thursday"=>["open"=>"","close"=>""],"friday"=>["open"=>"","close"=>""],"saturday"=>["open"=>"","close"=>""],"sunday"=>["open"=>"","close"=>""]];
			$delivery_hours = ["monday"=>["open"=>"","close"=>""],"tuesday"=>["open"=>"","close"=>""],"wednesday"=>["open"=>"","close"=>""],"thursday"=>["open"=>"","close"=>""],"friday"=>["open"=>"","close"=>""],"saturday"=>["open"=>"","close"=>""],"sunday"=>["open"=>"","close"=>""]];
			if(!empty($restPickupoHour)){			
				$pickup_hours = json_decode($restPickupoHour[0]['pickup_hours'],true);
				$delivery_hours = json_decode($restPickupoHour[0]['delivery_hours'],true);
			}
			
			$result[] = 
			[
				"r_id" => $restaurant['categories_id'],
				'status' => ($restaurant['categories_status']==0 || $restaurant['categories_status_app']==0 ) ? 0 : 1,
				"r_name" => $restaurant['categories_name'],
				"r_cuisine" => normaliseUrlString($restaurant['cuisine']),
				"r_description" => $restaurant['categories_description'],
				"r_address" => $restaurant['address'],
				"r_phone" => $restaurant['phone'],
				"r_lat" => $restaurant['lat'],
				"r_lng" => $restaurant['lng'],
				"r_lng" => $restaurant['lng'],
				"r_base_city" => $restaurant['base_city'],
				"r_real_city" => $restaurant['real_city'],
				//"r_report_email" => $restaurant['report_email'],
				"r_comments" => $restaurant['comments'],
				"r_image" => $url.'/images/'.$restaurant['categories_image'],
				'r_timezone' => $restaurant['timezone'],
				'r_is_daylight_saving' => $restaurant['is_daylight_saving'],
				"r_break_hours" => [
					'monday' 	=> [
						"open" => $restaurant['monday_break'],
						"close"	=>$restaurant['monday_break_length']
						],
					'tuesday' 	=> [
						"open" => $restaurant['tuesday_break'],
						"close"	=>$restaurant['tuesday_break_length']
						],
					'wednesday' => [
						"open" => $restaurant['wednesday_break'],
						"close"	=>$restaurant['wednesday_break_length']
						],
					'thursday' 	=> [
						"open" => $restaurant['thursday_break'],
						"close"	=>$restaurant['thursday_break_length']
						],
					'friday' 	=> [
						"open" => $restaurant['friday_break'],
						"close"	=>$restaurant['friday_break_length']
						],
					'saturday' 	=> [
						"open" => $restaurant['saturday_break'],
						"close"	=>$restaurant['saturday_break_length']
						],
					'sunday' 	=> [
						"open" => $restaurant['sunday_break'],
						"close"	=>$restaurant['sunday_break_length']
						],
				],			
				"r_pickup_hours"	=> $pickup_hours,
				"r_delivery_hours"=> $delivery_hours

			];
			
		}
		if(isset($_GET['restaurant_id']) && !empty($_GET['restaurant_id'])){
			echo json_encode($result[0]);
		}else{
			echo json_encode($result);
		}
		exit;
	}else{
		http_response_code(404);
		echo  json_encode (['status'=>404, 'message'=>'No restaurant exists in the system with supplied id']);
		exit;	
	}
	
	
}else if(isset($_GET['api']) && $_GET['api']=='menues'){
	if(isset($_GET['restaurant_id']) && !empty($_GET['restaurant_id'])){
		global $db;
		$restaurants = $db->query("SELECT *
			FROM categories AS c
			INNER JOIN categories_description AS cd ON cd.categories_id = c.categories_id
				WHERE c.categories_id = ".$_GET['restaurant_id']."
				order by categories_name
		")->fetchAll(PDO::FETCH_ASSOC);
		// categories_status = 1 and
		
	}else{
		$restaurants = restaurantList();
	}

	if (!empty($restaurants)) {
		
		$result = array();
		foreach ($restaurants as $key_res => $restaurant) {
			$restPickupoHour = $db->query("SELECT * FROM pickup_hours ph where ph.categories_id = ".$restaurant['categories_id'].' and pickup_on = 1 and delivery_on = 1  order by ph.pickup_hours_id desc')->fetchAll(PDO::FETCH_ASSOC);
			$pickup_hours = ["monday"=>["open"=>"","close"=>""],"tuesday"=>["open"=>"","close"=>""],"wednesday"=>["open"=>"","close"=>""],"thursday"=>["open"=>"","close"=>""],"friday"=>["open"=>"","close"=>""],"saturday"=>["open"=>"","close"=>""],"sunday"=>["open"=>"","close"=>""]];
			$delivery_hours = ["monday"=>["open"=>"","close"=>""],"tuesday"=>["open"=>"","close"=>""],"wednesday"=>["open"=>"","close"=>""],"thursday"=>["open"=>"","close"=>""],"friday"=>["open"=>"","close"=>""],"saturday"=>["open"=>"","close"=>""],"sunday"=>["open"=>"","close"=>""]];
			if(!empty($restPickupoHour)){			
				$pickup_hours = json_decode($restPickupoHour[0]['pickup_hours'],true);
				$delivery_hours = json_decode($restPickupoHour[0]['delivery_hours'],true);
			}
			$url = isset($_SERVER["HTTPS"]) ? HTTPS_SERVER : HTTP_SERVER;	
			$result[$key_res] = 
			[
				"r_id" => $restaurant['categories_id'],
				'status' => ($restaurant['categories_status']==0 || $restaurant['categories_status_app']==0 ) ? 0 : 1,
				"r_name" => normaliseUrlString($restaurant['categories_name']),
				"r_cuisine" => normaliseUrlString($restaurant['cuisine']),
				"r_description" => normaliseUrlString($restaurant['categories_description']),
				"r_address" => $restaurant['address'],
				"r_phone" => $restaurant['phone'],
				"r_lat" => $restaurant['lat'],
				"r_lng" => $restaurant['lng'],
				"r_lng" => $restaurant['lng'],
				"r_base_city" => $restaurant['base_city'],
				"r_real_city" => $restaurant['real_city'],
				//"r_report_email" => $restaurant['report_email'],
				"r_comments" => $restaurant['comments'],
				"r_image" => $url.'/images/'.$restaurant['categories_image'],
				'r_timezone' => $restaurant['timezone'],
				'r_is_daylight_saving' => $restaurant['is_daylight_saving'],
				"r_break_hours" => [
					'monday' 	=> [
						"open" => $restaurant['monday_break'],
						"close"	=>$restaurant['monday_break_length']
						],
					'tuesday' 	=> [
						"open" => $restaurant['tuesday_break'],
						"close"	=>$restaurant['tuesday_break_length']
						],
					'wednesday' => [
						"open" => $restaurant['wednesday_break'],
						"close"	=>$restaurant['wednesday_break_length']
						],
					'thursday' 	=> [
						"open" => $restaurant['thursday_break'],
						"close"	=>$restaurant['thursday_break_length']
						],
					'friday' 	=> [
						"open" => $restaurant['friday_break'],
						"close"	=>$restaurant['friday_break_length']
						],
					'saturday' 	=> [
						"open" => $restaurant['saturday_break'],
						"close"	=>$restaurant['saturday_break_length']
						],
					'sunday' 	=> [
						"open" => $restaurant['sunday_break'],
						"close"	=>$restaurant['sunday_break_length']
						],
				],			
				"r_pickup_hours"	=> $pickup_hours,
				"r_delivery_hours"=> $delivery_hours

			];
			$cat_one = categoryList($restaurant['categories_id']);
			//print_r($cat_one);
			$category=array();
			if(!empty($cat_one)){
				foreach ($cat_one as $key_one => $value_one) {
					$category[$key_one]=[
						'categories_id' => $value_one['categories_id'],
						'status' => ($value_one['categories_status']==0 || $value_one['categories_status_app']==0 ) ? 0 : 1, //categories_status_app
						//'categories_image' 	=> $value_one['categories_image'],
						'parent_id' 	=> $value_one['parent_id'],
						'sort_order' 	=> $value_one['sort_order'],
						'categories_name' 	=> normaliseUrlString($value_one['categories_name']),
						'categories_description' 	=> normaliseUrlString($value_one['categories_description']),
						"open_hours" => [
							'monday' 	=> [
								"open" => $value_one['monday_start_first'],
								"close"	=>$value_one['monday_end_first']
								],
							'tuesday' 	=> [
								"open" => $value_one['tuesday_start_first'],
								"close"	=>$value_one['tuesday_end_first']
								],
							'wednesday' => [
								"open" => $value_one['wednesday_start_first'],
								"close"	=>$value_one['wednesday_end_first']
								],
							'thursday' 	=> [
								"open" => $value_one['thursday_start_first'],
								"close"	=>$value_one['thursday_end_first']
								],
							'friday' 	=> [
								"open" => $value_one['friday_start_first'],
								"close"	=>$value_one['friday_end_first']
								],
							'saturday' 	=> [
								"open" => $value_one['saturday_start_first'],
								"close"	=>$value_one['saturday_end_first']
								],
							'sunday' 	=> [
								"open" => $value_one['sunday_start_first'],
								"close"	=>$value_one['sunday_end_first']
								],
						],
						'timezone' 	=> $value_one['timezone'],
						'is_daylight_saving' 	=> $value_one['is_daylight_saving'],
					];
					$subCategory=array();
					$cat_two = categoryList($value_one['categories_id']);
					//print_r($cat_two);
					if(!empty($cat_two)){
						foreach ($cat_two as $key_two => $value_two) {
							$subCategory[$key_two]=[
								'categories_id' => $value_two['categories_id'],
								'status' => ($value_two['categories_status']==0 || $value_two['categories_status_app']==0 ) ? 0 : 1, //categories_status_app
								//'categories_image' 	=> $value_two['categories_image'],
								'parent_id' 	=> $value_two['parent_id'],
								'sort_order' 	=> $value_two['sort_order'],
								'categories_name' 	=> normaliseUrlString($value_two['categories_name']),
								'categories_description' 	=> normaliseUrlString($value_two['categories_description'])						
							];
							$product = products($value_two['categories_id']);
							$itmes = array();
							foreach ($product as $key_product => $value_product) {
								$itmes[$key_product]=[
									'products_id' => $value_product['products_id'],
									'status' => (int)$value_product['products_status'],
									'products_name' => normaliseUrlString($value_product['products_name']),
									'products_price' => $value_product['products_price'],
									'products_description' => normaliseUrlString($value_product['products_description']),
									'parent_id' => $value_product['master_categories_id'],
									'products_quantity_order_min' => $value_product['products_quantity_order_min'],
									'products_quantity_order_max' => $value_product['products_quantity_order_max'],
									'sort_order' => $value_product['products_ordered'],
								];
								$options = productOptions($value_product['products_id']);
								$itemOption = array();
								foreach ($options as $key_option => $value_option) {
									$itemOption[$key_option]=[
										'product_id' => $value_option['products_id'],
										'products_attributes_id' => $value_option['products_attributes_id'],
										'options_id' => $value_option['options_id'],
										'option_type' => $value_option['products_options_types_name'],
										'option_name' => normaliseUrlString($value_option['products_options_name']),
										'options_values_id' => $value_option['options_values_id'],
										'products_options_values_name' => normaliseUrlString($value_option['products_options_values_name']),
										'options_values_price' => $value_option['options_values_price']
									];
								
								}
								$itmes[$key_product]['options'] = $itemOption;
							}
							$subCategory[$key_two]['items']=$itmes;
						}
					}
					$category[$key_one]['subCategory'] = $subCategory;
				}
			}
			$result[$key_res]['categories'] = $category;
		}
		if(isset($_GET['restaurant_id']) && !empty($_GET['restaurant_id'])){
			echo json_encode($result[0]);
		}else{
			echo json_encode($result);
		}
		exit;
	}else{
		http_response_code(404);
		echo  json_encode (['status'=>404, 'message'=>'No restaurant exists in the system with supplied id']);
		exit;	
	}

}else if(isset($_GET['api']) && $_GET['api']=='restaurant_config'){
	if(isset($_GET['restaurant_id']) && !empty($_GET['restaurant_id'])){
		global $db;
		$rest_config = $db->query("SELECT configuration from restaurant_configuration where categories_id=".$_GET['restaurant_id'])->fetch(PDO::FETCH_ASSOC);
		if (!empty($rest_config)) {
			# code...
		$rest_config = json_decode($rest_config['configuration'],true);
		$tax_rate = is_numeric($rest_config['tax_rate']) ? $rest_config['tax_rate'] : 0.08375;
		$delivery_fee = is_numeric($rest_config['delivery_fee']) ? $rest_config['delivery_fee'] : 3.99;
		$active = isset($rest_config['delivery']['active']) ? $rest_config['delivery']['active'] : 0;
		$invoice = isset($rest_config['invoice']) ? $rest_config['invoice'] : 0;
		$payment_types = array('cash'=>$rest_config['delivery']['cash'],'credit'=>$rest_config['delivery']['credit'],'invoice'=>$invoice);
		echo json_encode(array('tax_rate'=>$tax_rate,'delivery_fee'=>$delivery_fee,'active'=>$active,'payment'=>$payment_types));
		exit;
		}else{
			http_response_code(404);
			echo  json_encode (['status'=>404, 'message'=>'No restaurant exists in the system with supplied id']);
			exit;	
		}
	}else{
		http_response_code(400);
		echo  json_encode (['status'=>400, 'message'=>'Invalid request']);
		exit;
	}
}else{
	http_response_code(400);
	echo  json_encode (['status'=>400, 'message'=>'Invalid request']);
	exit;
}

/*
	All enable restaurant list
*/
function restaurantList(){
	global $db;
	$restaurants = $db->query("SELECT *
		FROM categories AS c
		INNER JOIN categories_description AS cd ON cd.categories_id = c.categories_id
			WHERE parent_id
			IN (
				SELECT categories_id FROM categories WHERE parent_id
				IN ( SELECT categories_id FROM categories WHERE parent_id =1) 
			) 			
			order by categories_name
	")->fetchAll(PDO::FETCH_ASSOC);
	return $restaurants;
}
//and categories_status = 1
/*
	All category of perticular restaurant 
*/
function categoryList($parent_id){
	global $db;
	$catagory = $db->query("SELECT 
		c.categories_id,
		c.categories_status,
		c.categories_status_app,
		categories_image,
		parent_id,
		sort_order,
		categories_name,
		categories_description,
		monday_start_first,
		tuesday_start_first,
		wednesday_start_first,
		thursday_start_first,
		friday_start_first,
		saturday_start_first,
		sunday_start_first,
		monday_end_first,
		tuesday_end_first,
		wednesday_end_first,
		thursday_end_first,
		friday_end_first,
		saturday_end_first,
		sunday_end_first,
		/*json_range,*/
		timezone,
		is_daylight_saving

		FROM categories AS c
		INNER JOIN categories_description AS cd ON cd.categories_id = c.categories_id
			WHERE c.parent_id = ".$parent_id."
			order by categories_name 
	")->fetchAll(PDO::FETCH_ASSOC);
	return $catagory;
}

// and categories_status = 1

/*
	category products
*/
function products($category = 0){
	global $db;

	$products = $db->query("SELECT * from products_to_categories pc 
	INNER JOIN products_description AS pd ON pd.products_id = pc.products_id
	INNER JOIN products AS p ON p.products_id = pc.products_id
	WHERE pc.categories_id = ".$category)->fetchAll(PDO::FETCH_ASSOC);

	return $products;
}

function productOptions($product_id = 0){
	global $db;
	$options = $db->query("SELECT * FROM `products_attributes` pa INNER JOIN products_options as po on po.products_options_id = pa.options_id INNER JOIN products_options_types as pot on pot.products_options_types_id = po.products_options_type INNER JOIN products_options_values as pov on pov.products_options_values_id = pa.options_values_id WHERE pa.`products_id` = ".$product_id."
		and pa.options_values_id != 0")->fetchAll(PDO::FETCH_ASSOC);

	return $options;
}

function normaliseUrlString($str){

  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');

  return str_replace($a, $b, utf8_encode($str));

}
?>