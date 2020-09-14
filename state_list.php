<?php
/*define('SERVER_NAME','192.168.1.132');
define('DATABASE_NAME','fooddudestaging_staging');
define('DATABASE_USER','root');
define('DATABASE_PASS','techno');*/
//setHeader("Content-Type", "application/json");
ini_set('display_errors',true);


	
	/*require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');
	require_once (realpath(dirname(__FILE__)) . '/includes/functions/password_funcs.php');
	require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.base.php');*/
	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');
	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');
	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	////require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.zcPassword.php');
	//$db = new PDO("mysql:host=192.168.1.132;dbname=fooddudestaging_staging","root", "techno");
	include_once("db_connection.php");
	$login_sql = "SELECT * FROM zones where zone_country_id=223";		
	$prep_login = $db->prepare($login_sql);
	//$prep_login->bindValue(':customers_email_address', $_POST['username'], PDO::PARAM_STR);
	$prep_login->execute();
	//$login = $prep_login->fetch(PDO::FETCH_ASSOC);
	$state_list = array();
	$i=0;
	while($data = $prep_login->fetch(PDO::FETCH_ASSOC)){
		$state_list[$i]['zone_id'] = $data['zone_id'];
		$state_list[$i]['zone_name'] = $data['zone_name'];
		$i++;
	}
	if(!empty($state_list)){
		$out = array('success'=>true,'data'=>$state_list);
	}else{
		$out = array('success'=>false,'message'=>"Record not found.");
	}
	



echo json_encode($out);
die;

?>