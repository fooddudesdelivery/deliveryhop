<?php

/**

* @package page

* @copyright Copyright 2003-2006 Zen Cart Development Team

* @copyright Portions Copyright 2003 osCommerce

* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

* @version $Id: Define Generator v0.1 $

*/

include_once dirname(__FILE__) . '/../../../../db_config.php';

// DEFINTELY DON'T EDIT THIS FILE UNLESS YOU KNOW WHAT YOU ARE DOING!

$zco_notifier->notify('NOTIFY_HEADER_START_DRIVER');



require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));



$error = false;



	if(isset($_POST['submit']) && $_POST['submit']=='driver_submit'){

	

		$error_driver=array();

		if(!$_POST['above21_driver'] || $_POST['above21_driver']==0){

			$error_driver[]='Must be above 21.';

		}

		if(!$_POST['firstname_driver'] || $_POST['firstname_driver']==''){

			$error_driver[]='Please enter your name.';

		}

		if(!$_POST['phone_driver'] || $_POST['phone_driver']==''){

			$error_driver[]='Please enter your phone number.';

		}

		if(!$_POST['email_driver'] || $_POST['email_driver']==''){

			$error_driver[]='Please enter your email.';

		}

		

		$zco_notifier->notify('NOTIFY_DRIVER_CAPTCHA_CHECK');

		

		if(count($error_driver)==0 && $error == false){

		

			$email_text = 'First Name: '.$_POST['firstname_driver'].'<br>';

			$email_text.= 'Last Name: '.$_POST['lastname_driver'].'<br>';

			$email_text.= 'Phone Numer: '.$_POST['phone_driver'].'<br>';

			$email_text.= 'Email Address: '.$_POST['email_driver'].'<br>';

		//	$email_text.= 'Vehicle: '.$_POST['car_driver'].'<br>';

			$email_text.= 'City: '.$_POST['city_driver'].'<br>';

    		$email_text.= 'Comments: '. zen_db_prepare_input(strip_tags($_POST['comments']));

			//$email_text.= 'Comments: '.$_POST['comments_driver'].'<br>';

			$headers = "MIME-Version: 1.0\r\n";

			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			//mail('service@staging.fooddudesdelivery.com','Driver Application',$email_text,$headers);
			mail(_SERVICE_EMAIL,'Driver Application',$email_text,$headers);
			//add_message_to_stack(' Your message has been sent.');

      		zen_redirect(zen_href_link(FILENAME_DRIVER, 'action=success'));

		}else{

		$error = true;



		if(!$_POST['above21_driver'] || $_POST['above21_driver']==0){

      		$messageStack->add('driver', 'Must be age 21 or older.');

    }		

		if(!$_POST['firstname_driver'] || $_POST['firstname_driver']==''){	

		     $messageStack->add('driver', 'Please enter your first name.');

    }			

		if(!$_POST['lastname_driver'] || $_POST['lastname_driver']==''){	

		     $messageStack->add('driver', 'Please enter your last name.');

    }			



			if(!$_POST['phone_driver'] || $_POST['phone_driver']==''){

			  $messageStack->add('driver', 'Please enter your phone number.');

    }			

		if(!$_POST['email_driver'] || $_POST['email_driver']==''){

		      $messageStack->add('driver', 'Please enter a valid email.');

    }			



		}

			

	}



	// include template specific file name defines

	$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_DRIVER, 'false');

	$breadcrumb->add(NAVBAR_TITLE);

	

	$city_list = $db->Execute('

		SELECT cd.categories_name

		FROM categories_description AS cd

		INNER JOIN categories AS c ON c.categories_id = cd.categories_id

		WHERE parent_id

		IN  (

			SELECT categories_id

			FROM categories

			WHERE parent_id =1

			)

		AND categories_name!="All Cities"

	');

	$select_options='';

	while(!$city_list->EOF){

		$select_options.='<option>'.$city_list->fields['categories_name'].'</option>';

		$city_list->MoveNext();	

	}

	

	$zco_notifier->notify('NOTIFY_HEADER_END_DRIVER');



?>

