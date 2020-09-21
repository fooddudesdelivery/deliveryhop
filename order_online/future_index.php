<?php 
if(isset($_GET['close'])){
	die;	
}
require(__DIR__.'/class/CreateOrder.php');
$ohm=new CreateOrder;
if(isset($_GET['ajax'])){
	$ohm->doTheThing();
	die;
}
if(isset($_POST['Link'])){
	$ohm->runTheTrap();
	die;
}
$ohm->insertKey($_GET['key']);

?>
<!doctype html>
<html>
<head>
<!--CREATED BY ZACH FAGERNESS-->
<?php $ohm->displayPage('htmlhead'); ?>

</head>
<body id="main_body" onLoad="BeginJs()">
<div id="close_x" class="hidden-sm hidden-xs"><i class="glyphicon glyphicon-remove"></i></div>
<div id="scrollme">
<div id="browser_min" >




<?php $ohm->runDisplay();?>


<?php $ohm->displayPage('footer');?>
</div>
</div>
<?php $ohm->displayPage('script'); ?>

</body>

</html>
