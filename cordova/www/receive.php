<?php
if(isset($_POST['restaurant'])){
	
	include ("php_functions/app.php");
	$app = new RestaurantBase;
	$input = json_decode($_POST['restaurant'],true);
	$app->receive($input['key'],$input['params']);
}
?>