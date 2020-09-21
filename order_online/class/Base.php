<?php

require(__DIR__.'/../configure.php');

require(__DIR__.'/../public_configure.php');

require(__DIR__.'/../vendor/autoload.php');

abstract class Base{

	protected $CategoriesId=0;

	protected $Link=array();

	protected $Config=array();

	protected $db=null;

	protected $inTest = false;

	private $postKeys=array(KEY_CALCULATETOTAL,KEY_PLACEORDER,KEY_CHECKTIME);

	protected $headPanelCount = 0 ;



	

	function __construct(){
		
		ini_set('display_errors',false);

		ini_set('memory_limit', '-1');

		ini_set("log_errors", 1);

		ini_set("error_log", "logs/php_error.txt");

		date_default_timezone_set('America/Chicago');

		error_reporting(E_ALL);

		

		try {

			$this->db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}

		catch(PDOException $e)

		{

			$this->addError("Connection failed: " . $e->getMessage());

		}

		

		Braintree_Configuration::environment(BRAINTREE_ENVIROMENT);

		Braintree_Configuration::merchantId(BRAINTREE_MERCHANT_ID);

		Braintree_Configuration::publicKey(BRAINTREE_PUBLIC_KEY);

		Braintree_Configuration::privateKey(BRAINTREE_PRIVATE_KEY);

		

		

	}

	

	public function insertKey($categories_id){

		$this->Link['categories_id']=$categories_id;

		if(!$this->checkCategoriesId()){

			return false;

		}

		if(!$this->getConfig()){

			return false;

		}
		$this->getTimezone();
		
		$this->inTime();
		
		return true;

	}

	protected function getTimezone(){
		$time_zone = $this->db->query("
		SELECT timezone FROM timezones WHERE categories_id=
		(
			SELECT parent_id FROM categories WHERE categories_id=
			(
				SELECT parent_id FROM categories WHERE categories_id=$this->CategoriesId
			)
		)
		")->fetch(PDO::FETCH_ASSOC);
		
		if($time_zone==NULL || $time_zone==FALSE){
			date_default_timezone_set('America/Chicago');
		}else{
			date_default_timezone_set($time_zone['timezone']);
		}
	}

	protected function checkCategoriesId(){

		if(!isset($this->Link['categories_id'])){

			$this->addError(ERROR_INVALID_CATEGORIES_ID,2);

			return false;

		}

		$this->Link['categories_id']=intval($this->Link['categories_id']);

		if(!is_int($this->Link['categories_id']) || $this->Link['categories_id']<1 ){

			$this->addError(ERROR_INVALID_CATEGORIES_ID,2);

			return false;

		}

		$this->CategoriesId=$this->Link['categories_id'];

		return true;

	}


	public function doTheThing(){



			if($_GET['ajax']=='product'){

				$ajaxproducts = $this->getAttributesAjax($_GET['products_id'],$_GET['menu_id']);

				if(is_array($ajaxproducts)){

				$this->displayPageAjax('ajaxproduct',$ajaxproducts);

				}

				die;

			}

			



	}




	public function runTheTrap(){

		if(isset($_POST['Link'])){

			$this->Link=json_decode($_POST['Link'],true);

		}else{

			$this->addError(ERROR_FAILED_TO_LINK);

			return false;

		}

		

		$this->checkCategoriesId();


		
		if

		(

			$this->configureThis() &&

			$this->validateConfig() &&

			$this->validateLink() &&

			$this->callToAction()

		){

			return true;

		}else{

			return false;

		}

		

	}

	

	private function callToAction(){

		

		switch($this->Link['key']){



			case KEY_CALCULATETOTAL: 

				if(!$this->runTotal()){

					return false;

				}

			break;
			case KEY_CHECKTIME:
				//this is done earlier $this->runTime();
			break;
			

			case KEY_PLACEORDER:
				
				$this->Link['order_complete']=false;

				

				//fix this
             
				if(count($this->Link['open_menus'])<1){

					$this->addError('Sorry, we are closed');

					return false;

				}

				

				if(!$this->runTotal()){

					return false;

				}

				if($this->runCreateOrder()){
					$this->Link['order_complete']=true;
				}else{
					return false;
				}



				$this->sendCustomerReceipt($this->Link['orders_id']);

				

			break;

			

			default:

				$this->addError(ERROR_DEFAULT_SWITCH_KEY);

				return false;			

			break;

		}

		$this->printJSON($this->Link);

		return true;

	}



	//

	// utility stuff

	//
	public function phoneFormat($number){
		// could be improved
		$splode = str_split($number);
		if(count($splode )!==10){
			return '';
		}
		return '('.$splode[0].$splode[1].$splode[2].')'.' '.$splode[3].$splode[4].$splode[5].'-'.$splode[6].$splode[7].$splode[8].$splode[9];
	}


	protected function moneyFormat($money){

		return money_format('$%i',$money);
//
		//return $money;

	}

	

	protected function addError($error_message,$threat_level=0){

		

		if(!$this->CategoriesId){

			$cat_id=0;

		}else{

			$cat_id=$this->CategoriesId;

		}

		try{

			$error_m = date('m-d-Y g:i:s').' -'.$cat_id.' -'.$_SERVER['REMOTE_ADDR'].'-> '.$error_message."\n";

			error_log($error_m,3,"logs/class_error_log.txt");

		}catch(Exception $e){

			//lol

			return false;

		}

		

		if($threat_level==2){

			if(isset($_POST['Link'])){

				$threat_level=0;	

			}else{

				$threat_level=1;		

			}	

		}

		

		switch($threat_level){

			case 0:

			//ajax error

				print_r(json_encode(array('error'=>$error_message)));

				die;

			break;	

			case 1:

			//display error

				echo'<div style="position:absolute;width:100%;height:100%;background-color:transparent"><div style="left:8px;position:relative;max-width:800px;margin:0 auto;min-height:100%;z-index:999999;background-color:white;text-align:center;font-weight:bold;font-size:25px;line-height:50px">Online ordering is temporarily unavailable</div></div>';

				die;

			break;

			case 'notify':

			

			

			break;

			case 'midnight':

			//doom

			

			break;

		}

		return true;

	}

	

	public function printJSON($param){

		if($param===false){

			$this->addError('ERRORRASASDASD');

			return false;

		}

		print_r(json_encode($param));

		return true;

	}



	//

	//end util stuff

	//



	

	//

	///begin js start

	//

	public function generateJsDefines(){

		//probably make this better

		$Text  = php_strip_whitespace("public_configure.php"); 

		$Text  = str_replace("<?php","",$Text);

		$Text  = str_replace("<?","",$Text);

		$Text  = str_replace("?>","",$Text);

		$Text  = str_replace("'","",$Text);

		$Text  = str_replace("define","",$Text);

		$Text  = str_replace(")","",$Text);

		$Text  = str_replace("(","",$Text);

		$Lines = explode(";",$Text);

		echo '<script>';

		echo 'DEFINE={};'." \n ";

		foreach ($Lines as $Line) {

			if(strpos($Line,',')){

				$splode = explode(",",$Line);

				echo 'DEFINE.'.str_replace(" ","",$splode[0]).'="'.$splode[1].'";'." \n ";

			}

		}

		echo 'DEFINE.BRAINTREE_JS_KEY="'.$this->getClientId().'"';

		echo '</script>';

	}

	

	public function printJsonInit(){

		$this->startLink();
		
		$this->Link['open_menus'] = $this->checkTime(0,'delivery');
		
		$return_array=array('Config'=>$this->getConfig(),'Link'=>$this->Link);

		

		//probably move this

		if($this->Config['delivery']['active']==1 && $this->Config['pickup']['active']==0){

			$return_array['Link']['delivery']=1;

		}else if($this->Config['delivery']['active']==0 && $this->Config['pickup']['active']==1){

			$return_array['Link']['delivery']=0;

		}

		if(isset($_GET['invoice_payment'])){

			$return_array['Link']['invoice_payment']=1;

		}else{

			$return_array['Link']['invoice_payment']=0;	

		}
		
		
		
		
		$this->printJSON($return_array);

	}

	

	private function startLink(){

		$link='{

		"categories_id": '.$this->CategoriesId.',

		"key": "",

		"duration": 0,

		"distance": 0,

		"delivery": 0,

		"math_distance": 0,

		"tax_rate": 0,

		"payment_type": "",

		"braintree_nonce":"",

		"orders_comments":"",

		"cart_count":0,

		"customer_coordinates": {

			"lat" : "",

			"lng" : ""

		},

		"open_menus": [],

		"customer": {

		  "name": "",

		  "phone": "",

		  "email": ""

		},

		"delivery_address": {

		  "street_number": "",

		  "street": "",

		  "apt": "",

		  "city": "",

		  "zipcode": 0,

		  "state": "",

		  "establishment":""

		},

		"totals": {

		  "tip": 0.0,

		  "delivery_fee": 0.0,

		  "subtotal": 0.0,

		  "tax": 0.0,

		  "grand_total": 0.0

		},

		"cart": []

	  }';

		$this->Link=json_decode($link,true);

		$this->Link['open_menus']=$this->getOpenMenus();

		

	}

	private function getOpenMenus(){

			if($this->runTime()){

				return $this->Link['open_menus'];	

			}else{

				return array();	

			}

	}





	

	public function getConfig(){

		

		if(!$this->configureThis()){

			return false;

		}

		if(!$this->validateConfig()){

			return false;

		}

		

		

		if(isset($_GET['instore_ordering'])){

			

			$this->Config['instore_ordering']=1;

		}else{

			$this->Config['instore_ordering']=0;

				

		}

		return $this->Config;

	}

	

	

	private function configureThis(){

		$config ='

		SELECT cd.min_order,cd.categories_name,cd.address,cd.phone,cd.comments,cd.lat,cd.lng,rc.configuration 

		FROM restaurant_configuration as rc inner join categories_description as cd on cd.categories_id = rc.categories_id 

		WHERE cd.categories_id = :categories_id 

		LIMIT 0,1';

		$config =$this->db->prepare($config);

		$config ->bindValue(':categories_id', $this->CategoriesId, PDO::PARAM_INT);

		$config ->execute();

		$config =$config->fetch();



		$first_config=

		array(

			'restaurant_name'=>str_replace("'",'',$config['categories_name']),

			'restaurant_comments'=>$config['comments'],

			'restaurant_phone'=>$config['phone'],

			'min_order'=>floatval($config['min_order']),

			'restaurant_address'=>$config['address'],

			'tax_rate'=>isset($config['tax_rate']) ? floatval($config['tax_rate']) : .08375 ,

			'restaurant_coordinates'=>array('lat'=>$config['lat'],'lng'=>$config['lng'])

	   );

	 		

			$new_config = json_decode($config['configuration'],true);

			

			if(!is_array($new_config)){

				$this->addError('Bad Configuration',2);

				return false;

			}

		    $first_config=array_merge($first_config,$new_config);

			$this->Config= array_merge($first_config,$this->getLocationConfig());

			if($this->Config['min_order']==0){

				$this->Config['min_order']=15;

			}

//$this->Config['pickup']['active']=0;

//$this->Config['delivery']['active']=1;

		return true;

	}

	

	private function validateConfig(){

		  

		  if(!isset($this->Config['restaurant_coordinates']) || !isset($this->Config['restaurant_coordinates']['lat']) || !isset($this->Config['restaurant_coordinates']['lng'])){

			  $this->addError(ERROR_NO_LAT_OR_LNG_CONFIG,2);

			  return false;

		  }

		  

		  if(in_array($this->Config['restaurant_coordinates']['lat'],array('',' ','na',null)) || in_array($this->Config['restaurant_coordinates']['lng'],array('',' ','na',null))){

			  $this->addError(ERROR_NO_LAT_OR_LNG_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['delivery']) || !is_array($this->Config['delivery'])){

			  $this->addError(ERROR_NO_DELIVERY_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['delivery']['active'])){

			  $this->addError(ERROR_NO_DELIVERY_ACTIVE_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['delivery']['credit'])){

			  $this->addError(ERROR_NO_DELIVERY_CREDIT_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['delivery']['cash'])){

			  $this->addError(ERROR_NO_DELIVERY_CASH_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['pickup'])){

			  $this->addError(ERROR_NO_PICKUP_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['pickup']['active'])){

			  $this->addError(ERROR_NO_PICKUP_ACTIVE_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['pickup']['credit'])){

			  $this->addError(ERROR_NO_PICKUP_CREDIT_CONFIG,2);

			  return false;	

		  }

		  

		  if(!isset($this->Config['pickup']['instore'])){

			  $this->addError(ERROR_NO_PICKUP_INSTORE_CONFIG,2);

			  return false;	

		  }

		  

		  

		return true;

	}

	

	//

	///end js start

	//

	



	private function validateLink(){

		//check key	



		

		if(!isset($this->Link['key']) || !in_array($this->Link['key'],$this->postKeys)){

			$this->addError(ERROR_INVALID_POST_KEY);

			return false;

		}

		//check open

		if(!$this->runTime()){

			$this->addError(ERROR_VALIDATE_OPEN_MENUS);

			return false;	

		}
		if($this->Link['key']==KEY_CHECKTIME){
			return true;
		}
		

		//check delivery boolean

		if(!isset($this->Link['delivery'])){

			$this->addError(ERROR_SPECIFY_DELIVERY);

			return false;

		}else{

			$this->Link['delivery']= intval($this->Link['delivery']);

			if($this->Link['delivery']!==0 && $this->Link['delivery']!==1){

				$this->addError(ERROR_DELIVERY_NOT_BOOLEAN);

				return false;

			}

		}

		

		//check delivery === 1 stuff

		if($this->Link['delivery']===1){

			//has address

			if(!isset($this->Link['delivery_address']) || !is_array($this->Link['delivery_address'])){

				$this->addError(ERROR_NO_DELIVERY_ADDRESS);

				return false;

			}

			

			

			//has zipcode

			if(!isset($this->Link['delivery_address']['zipcode'])){

				$this->addError(ERROR_NO_ZIPCODE);

				return false;

			}else{

				$tax_zip = intval(preg_replace("/[^0-9]/","",$this->Link['delivery_address']['zipcode']));

				if($tax_zip<501 || $tax_zip>99950){

					$this->addError(ERROR_BAD_ZIPCODE);

					return false;

				}

				//strlen($tax_zip)!==5 ||

				$this->Link['delivery_address']['zipcode']=$tax_zip;

			}

			

			//has coordinates

			if(!isset($this->Link['customer_coordinates']) || !isset($this->Link['customer_coordinates']['lat']) ||!isset($this->Link['customer_coordinates']['lng'])){

				$this->addError(ERROR_COORDS_COUNT);	

				return false;

			}

			$lat = floatval($this->Link['customer_coordinates']['lat']);	

			$lng = floatval($this->Link['customer_coordinates']['lng']);

			if($lat != $this->Link['customer_coordinates']['lat'] || $lng != $this->Link['customer_coordinates']['lng'] || $lat==0 || $lng==0){

				//intentional ==

				$this->addError(ERROR_COORDS_NOT_DOUBLE);	

				return false;

			}

			$this->Link['customer_coordinates']['lat']=$lat;

			$this->Link['customer_coordinates']['lng']=$lng;



			//add or validate tip

			if(!isset($this->Link['totals']['tip'])){

				$this->Link['totals']['tip']=0.0;

			}else{

				$this->Link['totals']['tip']=floatval(preg_replace("/[^0-9.]/","",$this->Link['totals']['tip']));

			}



		}//isset delivery && ===1

		

		//check cart

		if(isset($this->Link['cart'])){

			if(!is_array($this->Link['cart'])){

				$this->addError(ERROR_NO_CART);	

				return false;

			}

			if(count($this->Link['cart'])<1){

				$this->addError(ERROR_NO_CART);	

				return false;

			}

			

			foreach($this->Link['cart'] as &$cart){

				

				//check count of item array

				//if(count($cart)!==4 && count($cart)!==5 && count($cart)!==6){

//					$this->addError(ERROR_MALFORMED_CART);	

//					return false;

//				}

				

				//check product id

				if(!is_int($cart[0])){

					$cart[0]=intval($cart[0]);

					if($cart[0]<1){

						$this->addError(ERROR_BAD_PRODUCT_ID);	

						return false;

					}

				}

				//check quantity

				$cart[1]=floatval($cart[1]);

				if($cart[1]<1){

					$this->addError(ERROR_BAD_QUANTITY);	

					return false;

				}



				if(!is_array($cart[3]) || count($cart[3])<1){

					$this->addError(ERROR_BAD_OPTIONS);	

					return false;

				}

				//check options

				foreach($cart[3] as &$c){

					if($c==='0'){

						$c=0;

					}

					if($c!==0){

						if(!strpos($c,'-')){

							$this->addError(ERROR_NO_DASH_IN_OPTION);	

							return false;

						}

						$splode=explode('-',$c);

						if(intval($splode[0])!=$splode[0] || intval($splode[1])!=$splode[1]){

							$this->addError(ERROR_MALFORMED_OPTIONS);	

							return false;

						}

						if($splode[0]<1 || $splode[1]<1){

							$this->addError(ERROR_MALFORMED_OPTIONS);	

							return false;

						}

					}//if

				}//foreach options

			}//foreach cart

		}//isset cart

		

		switch($this->Link['key']){

			case KEY_CALCULATETOTAL:

				if(!isset($this->Link['cart'])){

					$this->addError(ERROR_NO_CART);	

					return false;

				}

			break;

			case KEY_PLACEORDER:

				if(!isset($this->Link['braintree_nonce']) && $this->Link['payment_type']==PAYMENT_CREDIT){

					$this->addError(ERROR_NO_NONCE);	

					return false;

				}

			break;

			default:

				$this->addError(ERROR_INVALID_POST_KEY);

				return false;

			break;

		}

		

		if(!$this->setDefaults()){

			return false;

		}



		//and finally...

		return true;

	}//eof validation

	

	

	private function setDefaults(){

		//do i need all of them? or any?



		if(!isset($this->Link['totals']['delivery_fee'])){

			$this->Link['totals']['delivery_fee'] = 0;

		}

		if(!isset($this->Link['math_distance'])){

			$this->Link['math_distance'] = 0;

		}

		if(!isset($this->Link['distance'])){

			$this->Link['distance'] = 0;

		}

		if(!isset($this->Link['duration'])){

			$this->Link['duration'] = 0;

		}



		if(!isset($this->Link['delivery_address'])){

			$this->Link['delivery_address'] = array();

		}

		

		if(!isset($this->Link['delivery_address']['street_number'])){

			$this->Link['delivery_address']['street_number'] = '';

		}

		

		if(!isset($this->Link['delivery_address']['street'])){

			$this->Link['delivery_address']['street'] = '';

		}

		

		if(!isset($this->Link['delivery_address']['apt'])){

			$this->Link['delivery_address']['apt'] = '';

		}

		

		if(!isset($this->Link['delivery_address']['city'])){

			$this->Link['delivery_address']['city'] = '';

		}

		

		if(!isset($this->Link['delivery_address']['state'])){

			$this->Link['delivery_address']['state'] = '';

		}

		

		if(!isset($this->Link['delivery_address']['zipcode'])){

			$this->Link['delivery_address']['zipcode'] = 0;

		}

		

		if(!isset($this->Link['customer_coordinates'])){

			$this->Link['customer_coordinates'] = array();

		}

		

		if(!isset($this->Link['customer_coordinates']['lat'])){

			$this->Link['customer_coordinates']['lat'] = 0;

		}

		

		if(!isset($this->Link['customer_coordinates']['lng'])){

			$this->Link['customer_coordinates']['lng'] = 0;

		}

		

		if(!isset($this->Link['payment_type'])){

			$this->Link['payment_type'] = PAYMENT_CASH;

		}

		

		

		

		return true;

	}

	

	

	

	public function testCase($which='random'){

		$this->inTest=true;

		$which='test_'.$which;

		$this->{$which}();	

	}



	

	

	private function test_random(){

		$test_return = array();

		$rand = rand(95398,100000);

		//$rand=90398;

		$test_query_orders=" 

		SELECT 

		  categories_id,

		  customers_lat,

		  customers_lng,

		  customers_name,

		  customers_telephone,

		  customers_email_address,

		  delivery_street_address as street,

		  delivery_suburb as apt,

		  delivery_city as city,

		  delivery_postcode as zipcode,

		  delivery_state as state

		FROM orders

		WHERE orders_id=$rand

		LIMIT 0,1

		";

		$test_orderss = $this->db->query($test_query_orders);

		foreach($test_orderss as $test_orders){

			$test_return['categories_id']=$test_orders['categories_id'];

			$test_return['key']=$this->postKeys[rand(0,count($this->postKeys)-1)];

			$test_return['customer_coordinates']['lat']=$test_orders['customers_lat'];

			$test_return['customer_coordinates']['lng']=$test_orders['customers_lng'];

			$test_return['delivery']=1;//rand(0,1);

			

			$splode=explode(' ',$test_orders['customers_name']);

			$test_return['customer']['firstname']=$splode[0];

			$test_return['customer']['lastname']=$splode[1];

			$test_return['customer']['phone']=$test_orders['customers_telephone'];

			$test_return['customer']['email']=$test_orders['customers_email_address'];

			

			if($test_return['delivery']==1){

				$splode = explode(' ',$test_orders['street']);

				$test_return['delivery_address']['street_number']=$splode[0];

				$test_return['delivery_address']['street']=str_replace($splode[0].' ','',$test_orders['street']);

				$test_return['delivery_address']['apt']=$test_orders['apt'];

				$test_return['delivery_address']['city']=$test_orders['city'];

				$test_return['delivery_address']['zipcode']=$test_orders['zipcode'];

				$test_return['delivery_address']['state']=$test_orders['state'];		

			}

			

		}



		$test_return['totals']['tip']=rand(1,10);

		$test_query_products=" 

		SELECT 

		  op.products_id,

		  po.products_options_id,

		  pov.products_options_values_id

		FROM orders_products as op

		INNER JOIN orders_products_attributes as opa

		ON opa.orders_products_id = op.orders_products_id

		inner join products_options as po 

		on po.products_options_name = opa.products_options

		inner join products_options_values as pov 

		on pov.products_options_values_name = opa.products_options_values

		WHERE op.orders_id=$rand

		";

		$test_products = $this->db->query($test_query_products);

		$vv=array();

		foreach($test_products as $products){

			$vv[]=array(

			'products_id'=>$products['products_id'],

			'products_options'=>$products['products_options_id'],

			'products_options_values'=>$products['products_options_values_id']);

		}

		$out=array();

		$ids=array();

		foreach($vv as $v1){

			$ids[]=	$v1['products_id'];

		}

		if(count($ids)<1){

			sleep(1);

			echo 'sleep <br>';

			$this->test_random();

		}

		foreach(array_unique($ids) as $v1){

			 $option=array();

			foreach($vv as $v2){

				if($v1==$v2['products_id']){

					$option[]=$v2['products_options'].'-'.$v2['products_options_values'];

				}

			}

			$out[]=array($v1,rand(1,5),' Special Instructions ',$option);

		}

		$test_return['cart']=$out;

	

		if(count($test_return['cart'])<1){

			sleep(1);

			echo 'sleep <br>';

			$this->test_random();

		}

		$this->Link=$test_return;

		return true;

	}

//end of base	
	public function getChartData($categories_id,$ranges){
		//this is for reports v2
		if(!is_array($categories_id)){

			return false;

		}		

		

		$categories_id = implode(',',$categories_id);	

		$start = $ranges[0];

		$end = $ranges[1];

		if($start==0 || $end==0){

			$start = date('Y-m-d 00:00:00');

			$end = date('Y-m-d 23:59:59');

		}else{

			$start = date($start.' 00:00:00');

			$end = date($end.' 23:59:59');

		}

		

		$date_search = strtotime($start)<1430456400 ? 'date_purchased' : 'date_deliver';

		$where= " WHERE $date_search  > '$start' AND $date_search < '$end' ";

		$chart_sql = "

		SELECT orders_id,$date_search as date_deliver

		FROM orders

		$where

		AND categories_id in($categories_id)

		LIMIT 0 , 999999";



		$chart_data =  $this->db->query($chart_sql)->fetchAll(PDO::FETCH_ASSOC);

		print_r(json_encode($chart_data ));

	}

	public function getChartDataManager($categories_id,$ranges){
		//this is for reports v2
		if(!is_array($categories_id)){

			$categories_id = array($categories_id);

		}		

		

		$categories_id = implode(',',$categories_id);	

		$start = $ranges[0];

		$end = $ranges[1];

		if($start==0 || $end==0){

			$start = date('Y-m-d 00:00:00');

			$end = date('Y-m-d 23:59:59');

		}else{

			$start = date($start.' 00:00:00');

			$end = date($end.' 23:59:59');

		}

		

		$date_search = strtotime($start)<1430456400 ? 'date_purchased' : 'date_deliver';

		$where= " WHERE $date_search  > '$start' AND $date_search < '$end' ";

		$chart_sql = "

		SELECT orders_id,$date_search as date_deliver

		FROM orders

		$where

		AND categories_id in(select categories_id from categories where parent_id in ($categories_id))

		and orders_status=10

		LIMIT 0 , 999999";



		$chart_data =  $this->db->query($chart_sql)->fetchAll(PDO::FETCH_ASSOC);

		print_r(json_encode($chart_data ));

	}
}

?>