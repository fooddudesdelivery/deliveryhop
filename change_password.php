<?php
header("Access-Control-Allow-Origin: *");
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
if(isset($_GET['email'])){
	$email_address = $_GET['email'];

	if(!email_validation($email_address)){
		// invalid email address
		$out = array('success'=>false, 'message'=>"Please Enter Valid Email Address.");
	} else {
		require_once (realpath(dirname(__FILE__)) . '/includes/configure.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/functions/password_funcs.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.base.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/functions/functions_general.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/functions/functions_email.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.zcPassword.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/functions/html_output.php');
		include_once("db_connection.php");
		$get_config1 = "select * from configuration where configuration_key LIKE 'ENTRY_PASSWORD_MIN_LENGTH' OR configuration_key LIKE 'STORE_NAME' OR configuration_key LIKE 'EMAIL_FROM'";
		$get_config = $db->prepare($get_config1);
		$get_config->Execute();
		$email_from = '';
		$minimun_length=0;
		$store_name = '';

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
		$check_customer_query1 = "SELECT admin_name, admin_pass, admin_id FROM admin WHERE admin_email = :emailAddress";
		$check_customer_query = $db->prepare($check_customer_query1);
		$check_customer_query->bindValue(':emailAddress', $email_address, PDO::PARAM_STR);
		$check_customer = $check_customer_query->Execute();
		$check = $check_customer_query->fetch(PDO::FETCH_ASSOC);
		if (!empty($check)) {
			$new_password = zen_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
			//$crypted_password = zen_encrypt_password($new_password);
			$crypted_password = password_hash($new_password, PASSWORD_DEFAULT);
			$sql = "UPDATE admin SET admin_pass = :password WHERE admin_id = :admin_id";
			$sql = $db->prepare($sql);
			$sql->bindValue(':password', $crypted_password, PDO::PARAM_STR);
			$sql->bindValue(':admin_id', $check['admin_id'], PDO::PARAM_INT);
			$sql->Execute();
			$html_msg['EMAIL_CUSTOMERS_NAME'] = $check['admin_name'];
			$html_msg['EMAIL_MESSAGE_HTML'] = "A new password was requested from ".$_SERVER['REMOTE_ADDR'].".";
			$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>Your new password to 'Food Dudes Delivery' is:";
			$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>".$new_password;
			$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>After you have logged in using the new password, you may change it by going to the 'Settings' area.";
			$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/>This email address was given to us by you or by one of our customers. If you feel that you have received this email in error, please send an email to service@fooddudesdelivery.com";
			$html_msg['EMAIL_MESSAGE_HTML'] .= "<br/><br/>This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.";
			$to = $email_address;
			$subject = EMAIL_PASSWORD_REMINDER_SUBJECT;
			$txt = $html_msg['EMAIL_MESSAGE_HTML'];
			require_once "mail/PHPMailer-master/PHPMailerAutoload.php";
			$mail = new PHPMailer;
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 0;                               // Enable verbose debug output
			ini_set ("SMTP","localhost");
			ini_set("sendmail_from",EMAIL_FROM);
			$mail->Host = "ssl://smtp.gmail.com";  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true ;                              // Enable SMTP authentication
			$mail->Username = 'fooddudesdelivery2@gmail.com';                 // SMTP username
			$mail->Password = 'fooddudes';                          // SMTP password
			$mail->SMTPSecure = false ;                         // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465;                                    // TCP port to connect to
			$mail->setFrom(EMAIL_FROM, STORE_NAME, 0);
			$mail->addAddress($to);
			$mail->addReplyTo($to, '');
			$mail->isHTML(true); // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $txt;
			$mail->AltBody = 'Fooddude';
			if(!$mail->send()) {
				$out = array('success'=>false,'message'=>"Not able to sent email.");
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				$out = array('success'=>true,'message' => SUCCESS_PASSWORD_SENT);
			}
		} else {
			$out = array('success'=>false,'message'=>"Email address not exist.");
		}
	}
} else {
	$out = array('success'=>false, 'message'=>"Please Enter Email.");
}
echo json_encode($out);
die;

function email_validation($str) { 
    return (!preg_match( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) ? FALSE : TRUE; 
} 