<?php

/*define('SERVER_NAME','192.168.1.132');

define('DATABASE_NAME','fooddudestaging_staging');

define('DATABASE_USER','root');

define('DATABASE_PASS','techno');*/



ini_set('display_errors',true);

define('IS_ADMIN_FLAG', false);

define('SEND_EMAILS', true);

$_SESSION['languages_code']='en';

define('STORE_OWNER', '');

define('EMAIL_FOOTER_COPYRIGHT', '');



define('EMAIL_DISCLAIMER', '');

define('STORE_OWNER_EMAIL_ADDRESS', '');

define('EMAIL_SPAM_DISCLAIMER', '');

define('DATE_FORMAT', 'YYYY-mm-dd');

define('DATE_FORMAT_LONG', 'YYYY-mm-dd');

define('CHARSET', '');

define('TEXT_UNSUBSCRIBE', '');

//define('TEXT_UNSUBSCRIBE', '');



if(isset($_POST['username'])){

	$email_address = $_POST['username'];

	//require ('includes/application_top.php');

	require_once (realpath(dirname(__FILE__)) . '/includes/configure.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/modules/require_languages.php');

	require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/init_includes/init_general_funcs.php');

	require_once (realpath(dirname(__FILE__)) . '/includes/functions/password_funcs.php');



	require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.base.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	

	require_once (realpath(dirname(__FILE__)) . '/includes/functions/functions_general.php');



	//require_once (realpath(dirname(__FILE__)) . '/includes/restaurant_login/init.php');

	require_once (realpath(dirname(__FILE__)) . '/includes/functions/functions_email.php');

	



	//require_once (realpath(dirname(__FILE__)) . '/includes/restaurant_login/init.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.notifier.php');



	require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.zcPassword.php');



	//require_once (realpath(dirname(__FILE__)) . '/includes/test.php');

	require_once (realpath(dirname(__FILE__)) . '/includes/functions/html_output.php');



	//require_once (realpath(dirname(__FILE__)) . '/mail/config/config.php');

	//$db = new PDO("mysql:host=192.168.1.132;dbname=fooddudestaging_staging","root", "techno");

	include_once("db_connection.php");

	//define contant

	$get_config1 = "select * from configuration where configuration_key LIKE 'ENTRY_PASSWORD_MIN_LENGTH' OR configuration_key LIKE 'STORE_NAME' OR configuration_key LIKE 'EMAIL_FROM'";

  	$get_config = $db->prepare($get_config1);

  	//$get_config->bindValue(':emailAddress', $email_address, PDO::PARAM_STR);

  	$get_config->Execute();

  	$email_from = '';

  	$minimun_length=0;

  	$store_name = '';

  	//$get_config_data = $get_config->fetch(PDO::FETCH_ASSOC);

  	while($data = $get_config->fetch(PDO::FETCH_ASSOC)){

		if($data['configuration_key']=='EMAIL_FROM'){

			$email_from = $data['configuration_value'];

		}

		if($data['configuration_key']=='ENTRY_PASSWORD_MIN_LENGTH'){

			$minimun_length = $data['configuration_value'];

		}

		if($data['configuration_key']=='STORE_NAME'){

			$store_name = $data['configuration_value'];

		}



	}

	define('STORE_NAME', $store_name);

	define('ENTRY_PASSWORD_MIN_LENGTH', $minimun_length);

	define('EMAIL_FROM', $email_from);

	define('EMAIL_DISCLAIMER2', 'This email address was given to us by you or by one of our customers. If you feel that you have received this email in error, please send an email to %s ');

  define('EMAIL_SPAM_DISCLAIMER2','This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.');

	require_once (realpath(dirname(__FILE__)) . '/includes/languages/english/password_forgotten.php');

	//require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.phpmailer.php');

	//require_once (realpath(dirname(__FILE__)) . '/mail/index.php');



	//require_once (realpath(dirname(__FILE__)) . '/includes/languages/english/email_extras.php');

	/*echo "<pre/>";

	print_r(EMAIL_FROM);

	exit;*/

	/////////

	$check_customer_query1 = "SELECT customers_firstname, customers_lastname, customers_password, customers_id 

                           FROM customers

                           WHERE customers_email_address = :emailAddress

                           AND COWOA_account != 1";

  $check_customer_query = $db->prepare($check_customer_query1);

  $check_customer_query->bindValue(':emailAddress', $email_address, PDO::PARAM_STR);

  $check_customer = $check_customer_query->Execute();

  $check = $check_customer_query->fetch(PDO::FETCH_ASSOC);

  /*echo "<pre/>";

  print_r($check);

  exit;*/

  if (!empty($check)) {



    $new_password = zen_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);

    $crypted_password = zen_encrypt_password($new_password);



    $sql = "UPDATE customers

            SET customers_password = :password

            WHERE customers_id = :customersID";

    $sql = $db->prepare($sql);

    $sql->bindValue(':password', $crypted_password, PDO::PARAM_STR);

    $sql->bindValue(':customersID', $check['customers_id'], PDO::PARAM_INT);    

    $sql->Execute();

    //$check = $sql->fetch(PDO::FETCH_ASSOC);



    $html_msg['EMAIL_CUSTOMERS_NAME'] = $check['customers_firstname'] . ' ' . $check['customers_lastname'];

   /* $html_msg['EMAIL_MESSAGE_HTML'] = sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password);

    $html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>".EMAIL_DISCLAIMER2;

    $html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>".EMAIL_SPAM_DISCLAIMER2;*/



    $html_msg['EMAIL_MESSAGE_HTML'] = "A new password was requested from ".$_SERVER['REMOTE_ADDR'].".";

    $html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>Your new password to 'Food Dudes Delivery' is:";

	$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>".$new_password;

	$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>After you have logged in using the new password, you may change it by going

to the 'My Account' area.";

	$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/>This email address was given to us by you or by one of our customers. If you

feel that you have received this email in error, please send an email to

"._SERVICE_EMAIL;//service@staging.fooddudesdelivery.com

	$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>This email is sent in accordance with the US CAN-SPAM Law in effect

01/01/2004. Removal requests can be sent to this address and will be honored

and respected.";



    /*echo "<pre/>";

    print_r($html_msg);

    exit;*/

    //print_r(zen_validate_email($email_address));exit;

    // send the email

    $to = $email_address;

	$subject = EMAIL_PASSWORD_REMINDER_SUBJECT;

	$txt = $html_msg['EMAIL_MESSAGE_HTML'];

	//$headers = "From: ".EMAIL_FROM . "\r\n";

	/*$headers = "MIME-Version: 1.0" . "\r\n";

	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";



	// More headers

	$headers .= 'From: {FROM_EMAIL}' ."\r\n";



	$sent = @mail($to,$subject,$txt,$headers);

	var_dump($sent);

	exit;*/

	//echo $to.' and sub-> '.EMAIL_PASSWORD_REMINDER_SUBJECT.' and from-> '.EMAIL_FROM;

	 //SMTP

	//echo EMAIL_FROM;exit;

	require_once "mail/PHPMailer-master/PHPMailerAutoload.php";

		$mail = new PHPMailer;

		//$mail->IsSMTP();

		//$mail->SMTPAuth = false;

		$mail->SMTPAuth = true;

		$mail->SMTPDebug = 0;                               // Enable verbose debug output

		

		//$mail->isSMTP();                                      // Set mailer to use SMTP

		ini_set ("SMTP","localhost");

		ini_set("sendmail_from",EMAIL_FROM);

		$mail->Host = "ssl://smtp.gmail.com";  // Specify main and backup SMTP servers

		$mail->SMTPAuth = true ;                              // Enable SMTP authentication

		$mail->Username = 'fooddudestagingsdelivery2@gmail.com';                 // SMTP username

		$mail->Password = 'fooddudestagings';                          // SMTP password

		$mail->SMTPSecure = false ;                         // Enable TLS encryption, `ssl` also accepted

		$mail->Port = 465;                                    // TCP port to connect to

		

		$mail->setFrom(EMAIL_FROM, STORE_NAME, 0);

		//$to_address = $to;

		

		$mail->addAddress($to);

		

		//$mail->addAddress($to);

		$mail->addReplyTo($to, 'testtest');

		

		$mail->isHTML(true);                                  // Set email format to HTML

		

		$mail->Subject = $subject;

		$mail->Body    = $txt;

		$mail->AltBody = 'Fooddude';

		//$mail->sender(EMAIL_FROM,EMAIL_FROM);

		

		if(!$mail->send()) {

			//echo 'Message could not be sent.';

			echo 'Mailer Error: ' . $mail->ErrorInfo;

		} else {

			//echo 'Message has been sent';

		}

	//SMTP

	//exit;

	

    //$sent = zen_mail($check['customers_firstname'] . ' ' . $check['customers_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password), STORE_NAME, EMAIL_FROM, $html_msg,'password_forgotten','',1);

    //var_dump($sent);exit;

    //testemail($check['customers_firstname'] . ' ' . $check['customers_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password), STORE_NAME, EMAIL_FROM, $html_msg);

    //header('Location: http://foodsocial.com/index.php?main_page=applogin');

    //echo "testt";exit;

    //$messageStack->add_session('login', SUCCESS_PASSWORD_SENT, 'success');



    //zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));

    $out = array('success'=>true,'message'=>SUCCESS_PASSWORD_SENT);

  } else {

    $out = array('success'=>false,'message'=>"Email address not exist.");

  }

	

	

}else{

	$out = array('success'=>false,'message'=>"Invalid data provided.");

}

echo json_encode($out);

die;



?>