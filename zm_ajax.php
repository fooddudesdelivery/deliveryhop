<?php

include_once dirname(__FILE__) . '/db_config.php';

require ('includes/application_top.php');
// ajax receiving bank
/* if(isset($_POST['set_tz'])){
	$_SESSION['fake_tz']=$_POST['set_tz'];
	echo ' ';
	die;
} */
if(isset($_POST['zm_check_cart'])){
	//check cart returns categories_id is true , 0 if false
	print_r(zm_check_cart_for_available());	
}

if(isset($_POST['recalc_zip'])){
	$_POST['recalc_zip']=intval($_POST['recalc_zip']);
	$new_zone_id = $db->Execute('select zone_id from zones where zone_code=(select state from real_tax_rates where zipcode="'.$_POST['recalc_zip'].'" ) ');
	$db->Execute('update address_book set entry_zone_id ="'.$new_zone_id->fields['zone_id'].'" where address_book_id="'.$_SESSION['sendto'].'"' );
	echo json_encode(array('done'=>1));
}
//isDomainAvailible('http://staging.fooddudesdelivery.com');
function isDomainAvailible($domain)
       {
               //check, if a valid url is provided
               if(!filter_var($domain, FILTER_VALIDATE_URL))
               {
					    mail(_DOMAIN_TEXT_EMAIL_ADDRESS_1, _DOMAIN_TEXT_EMAIL_SUBJECT, _DOMAIN_UNREACHABLE);
               }

               //initialize curl
               $curlInit = curl_init($domain);
               curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
               curl_setopt($curlInit,CURLOPT_HEADER,true);
               curl_setopt($curlInit,CURLOPT_NOBODY,true);
               curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

               //get answer
               $response = curl_exec($curlInit);

               curl_close($curlInit);

               if ($response){

			   }else{
				   	/*mail('zachfagerness@gmail.com,zachf181@gmail.com,zach@staging.fooddudesdelivery.com','WARNING','staging.fooddudesdelivery.com is unreachable');
				    mail('3203106216@tmomail.net','WARNING','staging.fooddudesdelivery.com is unreachable');*/
				    mail(_DOMAIN_TEXT_EMAIL_ADDRESS_1.','._DOMAIN_TEXT_EMAIL_ADDRESS_2.','._DOMAIN_TEXT_EMAIL_ADDRESS_3,_DOMAIN_TEXT_EMAIL_SUBJECT,_DOMAIN_TEXT_UNREACHABLE);
				    mail(_DOMAIN_TEXT_EMAIL_ADDRESS_4,_DOMAIN_TEXT_EMAIL_SUBJECT,_DOMAIN_TEXT_UNREACHABLE);
			   }
       }
	   

if(isset($_POST['zm_time_zone'])){
// Calculate seconds from offset
		list($hours, $minutes) = explode(':', $_POST['zm_time_zone']);
		$seconds = $hours * 60 * 60 + $minutes * 60;
		// Get timezone name from seconds
		$tz = timezone_name_from_abbr('', $seconds, 1);
		// Workaround for bug #44780
		if($tz === false) $tz = timezone_name_from_abbr('', $seconds, 0);
		// Set timezone
		$possible_tz=array('America/New_York','America/Chicago','America/Denver','America/Phoenix','America/Los_Angeles','America/Anchorage','America/Adak','America/Adak','Pacific/Honolulu');
		if(!in_array($tz,$possible_tz)){
			$tz='America/Chicago';
		}
		date_default_timezone_set($tz);
		
		$_SESSION['new_timezone']=$tz;

		echo 1;
}
if(isset($_POST['zm_check_cart_create_account'])){
	print_r( zm_check_cart());	
}

if(isset($_POST['zm_create_address_separated'])){
	print_r(zm_create_address_separated($_POST['zm_create_address_separated'],$_POST['save_address']));	
}

if(isset($_POST['zm_get_restaurant_closed_dates'])){
	print_r(json_encode( zm_get_restaurant_closed_dates()));	
}

if(isset($_POST['zm_check_current_res_redirect'])){
	print_r( zm_check_current_res_redirect());	
}

if(isset($_POST['zm_find_available_cities'])){
	print_r(json_encode( zm_find_available_cities($_POST['lat'],$_POST['lng'],$_POST['address'])));	
}


if(isset($_POST['zm_error_warning'])){
	 zm_error_warning($_POST['zm_error_warning']);	
}


if(isset($_POST['zm_checkout_time_check'])){
	echo zm_checkout_time_check();	
}

if(isset($_POST['zm_check_min_and_checkout'])){
	print_r( zm_check_min_and_checkout());	
}


if(isset($_POST['zm_find_available_restaurants'])){
	zm_find_available_restaurants($_POST['zm_find_available_restaurants']);	
}

if(isset($_POST['zm_session_add_delivery_time'])){
	zm_session_add_delivery_time($_POST['zm_session_add_delivery_time']);	
}


if(isset($_POST['zm_time_code'])){
	print_r(json_encode(zm_time_code($_POST['zm_time_code'])));	
}

if(isset($_POST['zm_delete_cart'])){
	zm_delete_cart();	
}

if(isset($_POST['add_message_to_stack'])){
	add_message_to_stack($_POST['add_message_to_stack'],$_POST['optional']);	
}
?>