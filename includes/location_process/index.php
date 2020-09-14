<?php include ("Location.php");
	include_once dirname(__FILE__) . '/../../db_config.php';
	if(defined('_DB_SERVER')){
		define('SERVER_NAME',_DB_SERVER);
		define('DATABASE_NAME',_DB_DATABASE);
		define('DATABASE_USER',_DB_SERVER_USERNAME);
		define('DATABASE_PASS',_DB_SERVER_PASSWORD);
	}else{
		mail('sunil.kalwani@fooddudesdelivery.com','Connection Failure',"/public_html/includes/location_process/index.php");
		define('SERVER_NAME','192.168.1.11');
		define('DATABASE_NAME','fooddudestaging_staging');
		define('DATABASE_USER','fooddudestaging_user');
		define('DATABASE_PASS','3W.mmR=Q]#{U');
	}
	try{
		$db = new PDO("mysql:host=".SERVER_NAME.";dbname=".DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){
		//$this->addError("Connection failed: " . $e->getMessage());
	}

	$Location = new Location;
	if(isset($_POST['mapquestError'])){
		$mpe=json_decode($_POST['mapquestError'], true);
		$Location->getLatLngRoutes($mpe);
		die;
	}

	if(isset($_POST['update_routes'])){
		$vv=json_decode($_POST['update_routes'], true);
		$Location->updateRoutes($vv);
		die;
	}

	if(isset($_POST['address_info'])){
		$Location->runLocation();
		die;
	}
?>
	<script type="text/javascript" src="src/GoogleProcess.js"></script>
	<script>
		$(document).ready(function(e) {
			window.goog = new GoogleProcess();
		});
	</script>
<body>
	<div id="alert" class="alert alert-danger" style="display:none"></div>
	<input id="google_text" class="form-control"></input>
	<input id="google_button" type="button" class="btn btn-default col-xs-12" value="Go">
</body>
