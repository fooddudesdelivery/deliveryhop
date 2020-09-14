<?php
/*define('SERVER_NAME','192.168.1.132');
define('DATABASE_NAME','fooddudestaging_staging');
define('DATABASE_USER','root');
define('DATABASE_PASS','techno');*/

ini_set('display_errors',true);

if(isset($_POST['username']) && isset($_POST['password'])){
	
	require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');
	require_once (realpath(dirname(__FILE__)) . '/includes/functions/password_funcs.php');
	require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.base.php');
	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');
	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');
	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.zcPassword.php');
	//$db = new PDO("mysql:host=192.168.1.132;dbname=fooddudestaging_staging","root", "techno");
	include_once("db_connection.php");
	$login_sql = "SELECT customers_id,customers_email_address,customers_password,customers_authorization FROM customers where customers_email_address = :customers_email_address AND COWOA_account != 1 LIMIT 0,1";		
	$prep_login = $db->prepare($login_sql);
	$prep_login->bindValue(':customers_email_address', $_POST['username'], PDO::PARAM_STR);
	$prep_login->execute();
	$login = $prep_login->fetch(PDO::FETCH_ASSOC);
	//echo "<pre/>";
	//print_r($login['customers_password']);
	//exit;
	//$test = password_get_info($login['customers_password']);
	//echo "<pre/>"; print_r($test);exit;
	$result = zen_validate_password($_POST['password'], $login['customers_password']);
	
	
	if($result){
		//check for account status
		if($login['customers_authorization'] == 4){
			$out = array('success'=>false,'message'=>"Your account is blocked.");
		}else{
			$token = md5(time() . rand(99999, 999999));
			$statement = $db->prepare("INSERT INTO customer_token(userid, token)
	        VALUES(".$login['customers_id'].",'".$token."')");
			$statement->execute();
			//output
			$out = array('success'=>true,'token'=>$token);
		}
	}else{
		$out = array('success'=>false,'message'=>"Incorrect username or password.");
	}
	


}else{
	$out = array('success'=>false,'message'=>"Invalid data provided.");
}
echo json_encode($out);
die;

?>