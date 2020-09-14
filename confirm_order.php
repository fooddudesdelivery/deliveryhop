<?php  
if(isset($_GET['order_number'])){
	require('includes/application_top.php');	
	$orders_id=intval($_GET['order_number']);
	if($orders_id<105697){
		echo "<script>setTimeout(function(){window.close();},1000)</script>";
		die;
	}
	$db->Execute('update orders set orders_status=4 where orders_id="'.$orders_id.'" and orders_status in (5,2)');
	$db->Execute('insert into orders_status_history (orders_id,orders_status_id,updated_by,date_added) values ("'.$orders_id.'",4,"Email Auto Confirm",now())');
	echo 'Thank You! Order #'.$orders_id.' is confirmed.';
	echo "<script>setTimeout(function(){window.close();},10000)</script>";
}
die;
?>