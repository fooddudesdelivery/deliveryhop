	<?php
	if(isset($_GET['order_id'])){
		$order_id = $_GET['order_id'];
		require_once (realpath(dirname(__FILE__)) . '/aAsd23fadfAd2565Hccxz/auto_send.php');
		$auto = new AutoSend;
		$res = $auto->send($_GET['order_id']);
	}
	
