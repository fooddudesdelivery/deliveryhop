<?php
/*define('SERVER_NAME','192.168.1.132');
define('DATABASE_NAME','fooddudestaging_staging');
define('DATABASE_USER','root');
define('DATABASE_PASS','techno');*/

ini_set('display_errors',true);

if(isset($_POST['username']) && isset($_POST['token'])){
	
	//$db = new PDO("mysql:host=192.168.1.132;dbname=fooddudestaging_staging","root", "techno");
	include_once("db_connection.php");
	$login_sql2 = "SELECT * FROM customers where customers_email_address = :username LIMIT 0,1";		
	$prep_login2 = $db->prepare($login_sql2);
	$prep_login2->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
	$prep_login2->execute();
	$login2 = $prep_login2->fetch(PDO::FETCH_ASSOC);
	/*echo "<pre/>";
	print_r($login2);
	exit;*/
	if(!empty($login2)){
		$userid = $login2['customers_id'];
		$login_sql = "SELECT * FROM customer_token where userid = :userid and token = :token LIMIT 0,1";		
		$prep_login = $db->prepare($login_sql);
		$prep_login->bindValue(':userid', $userid, PDO::PARAM_STR);
		$prep_login->bindValue(':token', $_POST['token'], PDO::PARAM_STR);
		$prep_login->execute();
		$login = $prep_login->fetch(PDO::FETCH_ASSOC);
		/*echo "<pre/>";
		print_r($login);
		exit;*/
		if($login){
			$sql = "delete from customer_token where userid=".$userid." and token='".$_POST['token']."'";
			$statement = $db->prepare($sql);
			$results = $statement->execute();
			//output
			if($results)
				$out = array('success'=>true,'message'=>"Logout Successfully.");
			else
				$out = array('success'=>false,'message'=>"Invalid data provided.");	
		}else{
			$out = array('success'=>false,'message'=>"Invalid data provided.");
		}
	}else{
		$out = array('success'=>false,'message'=>"Invalid data provided.");
	}


}else{
	$out = array('success'=>false,'message'=>"Invalid data provided");
}
echo json_encode($out);
die;

?>