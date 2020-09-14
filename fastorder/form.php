<?php

 if($_SERVER["HTTPS"] != "on"){

	 header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);exit();

  }
include_once dirname(__FILE__) . '/../db_config.php';

if(defined('_DB_SERVER')){
	define('DB_SERVER',_DB_SERVER);
	define('DB_DATABASE',_DB_DATABASE);
	define('DB_SERVER_USERNAME',_DB_SERVER_USERNAME);
	define('DB_SERVER_PASSWORD',_DB_SERVER_PASSWORD);
}else{
	define('DB_SERVER','192.168.1.11');
	define('DB_DATABASE','fooddudestaging_staging');
	define('DB_SERVER_USERNAME','fooddudestaging_user');
	define('DB_SERVER_PASSWORD','3W.mmR=Q]#{U');
}

ini_set('display_errors',false);

ini_set('memory_limit', '-1');

ini_set("log_errors", 1);

ini_set("error_log", "logs/php_error.txt");

date_default_timezone_set('America/Chicago');

error_reporting(E_ALL);

$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);

$categories_id = intval(preg_replace('/[^0-9]/s', '', $_GET['r']));

$category_info = "SELECT categories_name,configuration from categories_description as cd inner join restaurant_configuration as rc on rc.categories_id=cd.categories_id where cd.categories_id = $categories_id limit 0,1";

$category_info = $db->query($category_info)->fetch(PDO::FETCH_ASSOC);



$category_info['configuration']= json_decode($category_info['configuration'],true);

if(!is_array($category_info['configuration'])){

	echo 'Error, please configure';

	die;

}



//if(isset($category_info['configuration']['delivery_fee']) && floatval($category_info['configuration']['delivery_fee'])>0){

	$delivery_fee = $category_info['configuration']['delivery_fee'];

//}else{

	//$delivery_fee = 4.99;

//}

if(isset($category_info['configuration']['tax_rate']) && floatval($category_info['configuration']['tax_rate'])>0){

	$tax_rate = $category_info['configuration']['tax_rate'];

}else{

	$tax_rate = 0;

}

?>

<!DOCTYPE html>

<html>

  <head>

    <meta name="format-detection" content="telephone=no">

        <meta name="msapplication-tap-highlight" content="no">

        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">

    <title>Food Dudes Delivery</title>





    <!-- <link rel="stylesheet" type="text/css" href="https://staging.fooddudesdelivery.com/cordova/www/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="https://staging.fooddudesdelivery.com/cordova/www/css/datepicker.css"> -->
    <link rel="stylesheet" type="text/css" href="../cordova/www/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../cordova/www/css/datepicker.css">

    <link rel="stylesheet" type="text/css" href="../cordova/www/mycss/datetimepicker.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- <script type="text/javascript" src="https://staging.fooddudesdelivery.com/cordova/www/js/bootstrap.js"></script>

	<script type="text/javascript" src="https://staging.fooddudesdelivery.com/cordova/www/js/chart.js"></script>

	<script type="text/javascript" src="https://staging.fooddudesdelivery.com/cordova/www/js/touch.js"></script>

    <script type="text/javascript" src="https://staging.fooddudesdelivery.com/cordova/www/js/moment.js"></script>

    <script type="text/javascript" src="https://staging.fooddudesdelivery.com/cordova/www/js/datepicker.js"></script>

    <script src="https://staging.fooddudesdelivery.com/cordova/www/js/react.js" type="text/javascript"></script>

    <script src="https://staging.fooddudesdelivery.com/cordova/www/js/reactdom.js" type="text/javascript"></script> -->

    <script type="text/javascript" src="../cordova/www/js/bootstrap.js"></script>
	<script type="text/javascript" src="../cordova/www/js/chart.js"></script>
	<script type="text/javascript" src="../cordova/www/js/touch.js"></script>
    <script type="text/javascript" src="../cordova/www/js/moment.js"></script>
    <script type="text/javascript" src="../cordova/www/js/datepicker.js"></script>
    <script src="../cordova/www/js/react.js" type="text/javascript"></script>
    <script src="../cordova/www/js/reactdom.js" type="text/javascript"></script>

    <script type="text/javascript" src="fastorderjs.js"></script>

     <script src="../cordova/www/myjs/datetimepicker.js"></script>

	<!-- <script src="https://staging.fooddudesdelivery.com/order_online/js/wokjs.js"></script> -->
	<script src="../order_online/js/wokjs.js"></script>

    <script>DEFINE={},DEFINE.BRAINTREE_JS_KEY="",DEFINE.CATEGORIES_ID=<?php echo $categories_id ?>,DEFINE.DELIVERY_FEE=<?php echo $delivery_fee ?>,DEFINE.TAX_RATE=<?php echo $tax_rate ?>,DEFINE.ACTIVE=<?php echo $category_info['configuration']['delivery']['active'] ?></script>

      <style>

		<?php 

		//if(!isset($category_info['configuration']['delivery']['cash']) || $category_info['configuration']['delivery']['cash']==0){

		//	echo '.cash_option{ display:none; }';

	//	}					

		if(!isset($category_info['configuration']['delivery']['credit']) || $category_info['configuration']['delivery']['credit']==0){

			echo '.credit_option{ display:none; }';

		}

		if(!isset($category_info['configuration']['invoice']) || $category_info['configuration']['invoice']==0){

			echo '.invoice{ display:none; }';

		}	

		?>

		#gwok{

			margin-left: -15px;

    		margin-right: -15px;	

		}

		.btn-default{

			margin-top:30px;

			margin-bottom:60px;

			font-size:26px;	

			color:white;

			text-shadow:0 1px 0 black;

			background-color:<?php echo $category_info['configuration']['primary_color']?>;

			

		}

		.btn-default:hover{

			text-shadow:0 1px 0 <?php echo $category_info['configuration']['primary_color']?>;

			background-color:white;

		}

		.loading{

			display:none;	

		}

		.noconfig{

			font-weight:bold;

			text-align:center;

			font-size:36px;	

		}

	</style>

  </head>

  <body>

  	 <div class="loading" id="backdrop" style="opacity:.7;background-color:black;z-index:100;width:100%;height:100%;position:fixed;top:0px"></div>

     <div class="loading" id="loading" style="font-size:26px;z-index:101;color:white;width:100%;height:100%;position:fixed;text-align:center;top:50%;">Loading...</div>

 	 <div class="alert alert-success" id="o_placed" role="alert" style="display:none;text-align:center;font-size:36px"></div>

     <div class="btn btn-default col-xs-12" id="another_btn" onClick="location.reload()" style="display:none;">Place Another</div>

     <div id="form_page">

  	<div class="h1" style="text-align:center; border-bottom:1px solid #ddd;padding:5px;margin-bottom:20px;	

			color:white;

			text-shadow:0 1px 0 black;

			background-color:<?php echo $category_info['configuration']['primary_color'] ;?>"><?php echo $category_info['categories_name']; ?></div>

    

    <div id="fast_order_box"></div>  

    </div>

  </body>

</html>

