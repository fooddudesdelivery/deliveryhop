<?php



define('IS_ADMIN_FLAG', true);
define('ERROR_REPORT',false);
date_default_timezone_set('America/Chicago');

include_once dirname(__FILE__) . '/db_config.php';

if(ERROR_REPORT==true){
	ini_set('display_errors',true);
	error_reporting(E_ALL);
}
ini_set("log_errors", 1);
ini_set("error_log", "logs/restaurant_log_".date('m_d_y').".log");
require('includes/restaurant_login/init.php');
require('includes/restaurant_login/phpsync.php');
$gcpm = new GCMPushMessage();
$db = new queryFactory();
$db->connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);


if(isset($_POST['complete_order'])){
	$_POST['complete_order']=intval($_POST['complete_order']);
	if($_POST['complete_order']<1){
		die;
	}
	$db->Execute("update orders set orders_status=13 where orders_id = '".$_POST['complete_order']."'");
	$db->Execute("insert into orders_status_history (orders_id,orders_status_id,date_added,updated_by) values (".$_POST['complete_order'].",13,'".date('Y-m-d H:i:s',strtotime('now'))."','Restaurant')");
	
	die;
}
	if(isset($_GET['r_session'])){
		//setcookie("r_session",$_GET['r_session'], time()+90000, "/", "staging.fooddudesdelivery.com", true, true);
    setcookie("r_session",$_GET['r_session'], time()+90000, "/", _SITE_DOMAIN_NAME, true, true);
		session_id($_GET['r_session']);
	}
	if(isset($_POST['android_sync'])){
		session_id($_POST['r_session']);
	}
	if(isset($_COOKIE['r_session'])){
		session_id($_COOKIE['r_session']);
	}
	$islogout=false;
	zen_session_start();
	


//function validate_android($device_id){
//	global $db;
//	//$device_id = str_replace(' ','',$device_id);
//	$sql = $db->Execute('select admin_id,categories_id from cloud_device_id_matrix where device_id="'.$device_id.'"');	
//	
//	if($sql->fields['admin_id'] && $sql->fields['categories_id']){
//
//		$categories_info = $db->Execute('select send_method_code,fax,cloud_print_id,email from categories_description where categories_id="'.$sql->fields['categories_id'].'"');
//		$login_sql = $db->Execute('select admin_display_name,admin_profile,categories_id,admin_id from admin where admin_id="'.$sql->fields['admin_id'].'"');
//				$_SESSION['admin_id']=$login_sql->fields['admin_id'];
//				$_SESSION['categories_id']=$login_sql->fields['categories_id'];
//				$_SESSION['admin_display_name']=$login_sql->fields['admin_display_name'];
//				$_SESSION['dispatch']['send_method_code']=$categories_info->fields['send_method_code'];
//				$_SESSION['dispatch']['fax']=$categories_info->fields['fax'];
//				$_SESSION['dispatch']['cloud_print_id']=$categories_info->fields['cloud_print_id'];
//				$_SESSION['dispatch']['email']=$categories_info->fields['email'];
//				$_SESSION['device_id']=$device_id;
//
//	}
//	
//}
//	if(isset($_GET['device_id'])){
//		validate_android($_GET['device_id']);
//	}
//	if(isset($_SESSION['device_id'])){
//		add_android($_SESSION['admin_id'],$_SESSION['categories_id'],$_SESSION['device_id']);
//	}	

if(isset($_POST['authenticate'])){

	$admin_name = zen_db_input($_POST['username']);
	$admin_pass = zen_db_input($_POST['password']);
$login_sql = $db->Execute('select admin_display_name,admin_profile,categories_id,admin_id,admin_pass from admin where admin_name="'.$admin_name.'"');
		if($login_sql->fields['admin_id']){
			if(zen_validate_password($admin_pass,$login_sql->fields['admin_pass'])){
				$keygen = hash('sha256',date("Y-m-d")."vHoczctpbIG6SxRTgtREjExbfqaVO5ZGgjQALyIdmxdkgJ97EzXLszHjZE2bPdxH5zs2tw5qPEt00cUSPINjZlWmVOyjZZNDntv64l7AxT8rOyClf4F8nYxEkFckrZG3b5h7cbQlqQYqVdt04k1DRJwVr9QZqrBLWn1pFEnqV2kISU5HAjNZtwaJjXt7CMMTQK0aUMPi6jVewdoQrAdpwVHvJpNoiS7NEOstfNEmjHv6O5iAD0vAJP5uHwzTh6ot5jVv7pWeVTYEW9N7InJy4YLQiHRtwpDKwmnCoXdscCEc");
				$categories_info = $db->Execute('select send_method_code,fax,cloud_print_id,email from categories_description where categories_id="'.$login_sql->fields['categories_id'].'"');
				$_SESSION['admin_id']=$login_sql->fields['admin_id'];
				$_SESSION['categories_id']=$login_sql->fields['categories_id'];
				$_SESSION['admin_display_name']=$login_sql->fields['admin_display_name'];
				$_SESSION['dispatch']['send_method_code']=$categories_info->fields['send_method_code'];
				$_SESSION['dispatch']['fax']=$categories_info->fields['fax'];
				$_SESSION['dispatch']['cloud_print_id']=$categories_info->fields['cloud_print_id'];
				$_SESSION['dispatch']['email']=$categories_info->fields['email'];
				$_SESSION['sync'] = new Sync($_SESSION['categories_id'],$_SESSION['admin_id'],$_SESSION['dispatch'], $_SESSION['admin_display_name']);
				echo json_encode(array('authenticate'=>array('key'=>$keygen ,'categories_id'=>$login_sql->fields['admin_id'],'session_id'=>session_id())));
				$_SESSION['sync']->kill_db();
				
				die;
			}
		}
		echo json_encode(array('authenticate'=>array('key'=>'bad_login')));
	
	die;
}

if(!isset($_SESSION['admin_id'])){
	include('includes/restaurant_login/restaurant_login.php'); 
	die;
}
if(isset($_GET['logout']) ){
	$islogout=true;
	include('includes/restaurant_login/restaurant_login.php'); 
	die;
}

if(isset($_SESSION['device_id']) && isset($_GET['device_id'])){
	if($_SESSION['device_id']!=$_GET['device_id']){
	$db->Execute('INSERT INTO cloud_device_id_matrix (admin_id,categories_id,device_id)
		VALUES ("'.$_SESSION['admin_id'].'","'.$_SESSION['categories_id'].'","'.$_GET['device_id'].'")
		ON DUPLICATE KEY UPDATE 
 		categories_id="'.$_SESSION['categories_id'].'",admin_id="'.$_SESSION['admin_id'].'",active=1');
	$_SESSION['device_id']=$_GET['device_id'];
	
	}
	
}


if(isset($_POST['sync']) || isset($_POST['android_sync'])){

		$_SESSION['sync']->receive($_POST['sync']);		
		die;
}

$_SESSION['sync'] = new Sync($_SESSION['categories_id'],$_SESSION['admin_id'],$_SESSION['dispatch'], $_SESSION['admin_display_name']);
$_SESSION['sync']->kill_db();
require('includes/restaurant_login/restaurant_includes.php');  
?>
</head>
<body>
<!--top nav bar-->
 <nav class='navbar navbar-default navbar-fixed-top'>
      <div class='container'>
        <div class='navbar-header'>
          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
            <span class='sr-only'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
          <a class='navbar-brand' id="main_brand"><?php echo $_SESSION['admin_display_name'] ?>  <i class="glyphicon glyphicon-refresh"></i></a>
        </div>
        
        <div id='navbar' class='navbar-collapse collapse'>
          <ul class='nav navbar-nav'>
          <?php if($_SESSION['categories_id']==11833){ ?>

          <?php } ?>
            <li id='current-orders' class='nav-bar-btn active z_nav_select'><a>Current Orders</a></li>
            <li id='past-orders' class='nav-bar-btn z_nav_select'><a>All Orders</a></li>
           	<!--<li id='refresh-btn' ><a>Refresh</a></li>-->
            <!--<li id="screen_refresh" class="z_function z_click"><a>Refresh</a></li>-->
<!--            <li id="play_sound" class=" "><a>Play</a></li>
-->            <li id="logout"><a>Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
<div class='navbar navbar-default'></div>




<!--time selector for past order-->
<div id='time-select' class='container'>
	<div id='reportrange'  style='margin-bottom:20px;background: #fff; cursor: pointer; padding: 13px 20px; border: 1px solid #ef6f00'>
    	<i class='glyphicon glyphicon-calendar fa fa-calendar'></i>
    	<span></span> <b class='caret'></b>
	</div>
</div>


<!--main page container-->

<div id='main_order_container' class='container'>
<!-- <div id="reprint" class='z_function btn btn-default'>print</div>-->
<?php 

//echo session_id();
	echo $_SESSION['sync']->display_restaurant_table();

?>
</div>



<!-- Price Change Modal Start -->
<div class='modal fade' id='price-modal' tabindex='-1' role='dialog' aria-labelledby='price-modal-title'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header text-center'>
        <button style="margin-top:0px;height:30px;width:30px;font-size:30px" type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'><i class="glyphicon glyphicon-remove"></i></span></button>
        <h2 class='modal-title' id='price-modal-title'>Order #<span id='modal-order-number'></span></h2>
      </div>
      <div class='modal-body popup-container-body container-fluid'>
    	   <div id='price-modal-alert' class='alert alert-danger' style='display:none'></div>
      	   <fieldset>
           <legend>Change Price</legend>
           		<div class='col-sm-12 col-xs-12 col-md-10 col-md-offset-1 modal-section'>
               		 <textarea id='price-change-comment' class='form-control' placeholder='Please enter why you are changing the order price here'></textarea>
                </div>
            	<span class='input-group input-group-lg col-md-4 col-md-offset-1 modal-section'>
  					<span id='increase-total' class='input-group-addon total-change'>
                	    <i class='glyphicon glyphicon-arrow-up'></i>
                	</span>
  					<input id='adjustment-input' type='number' class='form-control text-center'>
  					<span id='decrease-total' class='input-group-addon total-change'>
                  	 	<i class='glyphicon glyphicon-arrow-down'></i>
               		</span>
				</span>
            	<span id='save-btn' class='btn btn-lg btn-default col-xs-12 col-sm-12 col-md-4 col-md-offset-2 modal-section'>
            		Update
            	</span>
           </fieldset>
            
           <!--<fieldset>
           <legend>Reprint</legend>-->
           	<div style='height:75px;'></div>
            <div id="reprint" class='z_function btn btn-lg btn-default col-sm-12 col-xs-12 col-md-10 col-md-offset-1 modal-section'>
               Resend Order
           	</div>
           <!--</fieldset>-->
      </div>
      <div class='modal-footer'>
        
      </div>
    </div>
  </div>
</div>
<!--  Modal End  -->






<!-- Config Modal Start -->
<div class='modal fade' id='config-modal' tabindex='-1' role='dialog' aria-labelledby='config-modal-title'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header text-center'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h2 class='modal-title' id='config-modal-title'>Options</h2>
      </div>
      <div class='modal-body popup-container-body container-fluid'>
    	   <div id='config-modal-alert' class='alert alert-danger' style='display:none'></div>
      </div>
      <div class='modal-footer'>
        
      </div>
    </div>
  </div>
</div>
<!--  Modal End  -->



</body>
</html>
<?php  $_SESSION['sync']->kill_db(); ?>
