<?php

require(__DIR__.'/class/CreateOrder.php');
$ohm=new CreateOrder;
ini_set('display_errors',false);


if(isset($_POST['acceptOrder'])){
	//$ohm->acceptOrder(intval($_POST['acceptOrder']));
}
if(isset($_POST['checkNewOrder'])){
	//$ohm->checkNewOrder(intval($_POST['checkNewOrder']));
}

if(isset($_POST['flare'])){
	$ohm->alertServer($_POST['flare']);
	die;
}
if(isset($_POST['device_id'])){
	$ohm->mobileLogin($_POST['device_id']);
	//print_r(json_encode(array('categories_id'=>44)));
	die;
}
if(isset($_POST['login_info'])){
	//print_r(json_encode(json_decode($_POST['login_info'],true)));
	$ohm->mainLogin(json_decode($_POST['login_info'],true));
}
if(isset($_POST['params'])){
	
	$params = json_decode($_POST['params'],true);
		//print_r($params);
	if(isset($params['key'])){
	
		if(isset($params['timeframe']) && $params['timeframe']!='past'){
			$ohm->restaurantPage($params['key'],$params['timeframe']);
			die;
		}
		if(isset($params['timeRanges'])){
			$ohm->restaurantPage($params['key'],'past',$params['timeRanges']);
			die;
		}
		if(isset($params['chartData'])){

			$ohm->getChartData($params['key'],$params['chartData']);
			die;
		}
		if(isset($params['exportData'])){
			$ohm->getExportData($params['key'],$params['exportData']);
			die;
		}
		if(isset($params['searchId']) && $params['searchId'] !=0){
			$ohm->searchOrdersId($params['key'],$params['searchId']);
			die;
		}
	}
	
	if(isset($params['parent_key'])){
		$ohm->getChartDataManager($params['parent_key'],$params['chartData']);
		die;
	}
	die;
}

?>