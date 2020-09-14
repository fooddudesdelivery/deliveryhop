<?php

/**

* @package page

* @copyright Copyright 2003-2006 Zen Cart Development Team

* @copyright Portions Copyright 2003 osCommerce

* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

* @version $Id: Define Generator v0.1 $

*/



// DEFINTELY DON'T EDIT THIS FILE UNLESS YOU KNOW WHAT YOU ARE DOING!

include_once dirname(__FILE__) . '/../../../../db_config.php';

$zco_notifier->notify('NOTIFY_HEADER_START_RESTAURANT');



require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));



$error = false;



	if(isset($_POST['submit']) && $_POST['submit']=='restaurant_submit'){

		$error_restaurant=array();

		if(!$_POST['restaurant_name'] || $_POST['restaurant_name']==''){

			$error_restaurant[]='Please enter restaurant name.';

		}

		if(!$_POST['restaurant_address'] || $_POST['restaurant_address']==''){

			$error_restaurant[]='Please enter restaurant address.';

		}

		if(!$_POST['contact_name'] || $_POST['contact_name']==''){

			$error_restaurant[]='Please enter first and last name.';

		}

			if(!$_POST['phone_number'] || $_POST['phone_number']==''){

			$error_restaurant[]='Please enter phone number.';

		}

		if(!$_POST['email_address'] || $_POST['email_address']==''){

			$error_restaurant[]='Please enter email address.';

		}

		

		  $zco_notifier->notify('NOTIFY_RESTAURANT_CAPTCHA_CHECK');

		  

		if(count($error_restaurant)==0 && $error == false){

			$email_text = 'Restaurant Name: '.$_POST['restaurant_name'].'<br>';

			$email_text.= 'Restaurant Address: '.$_POST['restaurant_address'].'<br>';

			$email_text.= 'Contact Name: '.$_POST['contact_name'].'<br>';

			$email_text.= 'Phone Number: '.$_POST['phone_number'].'<br>';

			$email_text.= 'Email Address: '.$_POST['email_address'].'<br>';

    		$email_text.= 'Comments: '. zen_db_prepare_input(strip_tags($_POST['comments']));

			$headers = "MIME-Version: 1.0\r\n";

			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			//mail('service@staging.fooddudesdelivery.com','Restaurant Sign Up',$email_text,$headers);
			mail(_SERVICE_EMAIL,'Restaurant Sign Up',$email_text,$headers);

			//add_message_to_stack(' Your message has been sent.');

      		zen_redirect(zen_href_link(FILENAME_RESTAURANT, 'action=success'));

		}else{

		

		$error = true;

		

		if(!$_POST['restaurant_name'] || $_POST['restaurant_name']==''){

      		$messageStack->add('restaurant', 'Please enter restaurant name.');

		}

		if(!$_POST['restaurant_address'] || $_POST['restaurant_address']==''){

      		$messageStack->add('restaurant', 'Please enter restaurant address.');

		}

		if(!$_POST['contact_name'] || $_POST['contact_name']==''){

      		$messageStack->add('restaurant', 'Please enter first and last name.');

		}

			if(!$_POST['phone_number'] || $_POST['phone_number']==''){

      		$messageStack->add('restaurant', 'Please enter phone number.');

		}

		if(!$_POST['email_address'] || $_POST['email_address']==''){

      		$messageStack->add('restaurant', 'Please enter email address.');

		}

}

	}

	



	// include template specific file name defines

	$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_RESTAURANT, 'false');

	$breadcrumb->add(NAVBAR_TITLE);



$zco_notifier->notify('NOTIFY_HEADER_END_RESTAURANT');	

?>

