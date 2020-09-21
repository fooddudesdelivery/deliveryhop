<?php
	ini_set('display_errors',true);
	$validate=1;
	if(!isset($_POST['first_name'])){ $validate=0;}else $fname = $_POST['first_name'];
	if(isset($_POST['last_name'])) $lname = $_POST['last_name'];
	if(isset($_POST['company_name'])) $company_name = $_POST['company_name'];
	if(!isset($_POST['street_address'])){ $validate=0; }else $street_address = $_POST['street_address'];
	if(isset($_POST['apt'])) $apt = $_POST['apt'];
	if(!isset($_POST['state'])){ $validate=0; }else $state = $_POST['state'];
	if(!isset($_POST['city'])){ $validate=0; }else $city = $_POST['city'];
	if(!isset($_POST['postal_code'])){ $validate=0; }else $postal_code = $_POST['postal_code'];
	if(!isset($_POST['phone'])){ $validate=0; }else $phone = $_POST['phone'];
	if(!isset($_POST['email_address'])){ $validate=0; }else $email_address = $_POST['email_address'];
	if(!isset($_POST['password'])){ $validate=0; }else $password = $_POST['password'];
	if($validate){
		define('IS_ADMIN_FLAG', false);
		require_once (realpath(dirname(__FILE__)) . '/includes/configure.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/classes/vendors/password_compat-master/lib/password.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/functions/functions_general.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/functions/password_funcs.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.base.php');
		require_once (realpath(dirname(__FILE__)) . '/includes/classes/class.zcPassword.php');
		include_once("db_connection.php");
		$login_sql = "SELECT count(*) as total FROM customers where customers_email_address = :customers_email_address LIMIT 0,1";
		$prep_login = $db->prepare($login_sql);
		$prep_login->bindValue(':customers_email_address', $_POST['email_address'], PDO::PARAM_STR);
		$prep_login->execute();
		$login = $prep_login->fetch(PDO::FETCH_ASSOC);
		if ($login['total'] == 0) {
			$sql_data_array = array('customers_firstname' => $fname,
								'customers_lastname' => $lname,
								'customers_email_address' => $email_address,
								'customers_telephone' => $phone,
								'customers_default_address_id' => 0,
								'customers_password' => zen_encrypt_password($password),
							);

			$is_subscription = 0;
			if(isset($_POST['is_subscription']))
				$is_subscription = $_POST['is_subscription'];
				$statement = $db->prepare("INSERT INTO customers(customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_password, customers_newsletter)
				VALUES('".$fname."','".$lname."','".$email_address."','".$phone."','".zen_encrypt_password($password)."','".$is_subscription."')");
			$insert = $statement->execute();
			$userid = $db->lastInsertId();
			$token = md5(time() . rand(99999, 999999));
			$statement = $db->prepare("INSERT INTO customer_token(userid, token)
			VALUES(".$userid.",'".$token."')");
			$statement->execute();
			// Add address to the address book
			$statement = $db->prepare("INSERT INTO address_book(customers_id, entry_firstname,entry_lastname,entry_street_address,entry_postcode,entry_city,entry_country_id,entry_zone_id,entry_company,entry_suburb)
				VALUES(".$userid.",'".$fname."','".$lname."','".$street_address."','".$postal_code."','".$city."','223',".$state.",'".$company_name."','".$apt."')");
			$insert = $statement->execute();

			$statement = $db->prepare("INSERT INTO address_book(customers_id, entry_firstname,entry_lastname,entry_street_address,entry_postcode,entry_city,entry_country_id,entry_zone_id,entry_company,entry_suburb)
				VALUES(".$userid.",'".$fname."','".$lname."','".$street_address."','".$postal_code."','".$city."','223',0,'".$company_name."','".$apt."')");
			$insert = $statement->execute();
			$address_id = $db->lastInsertId();
			// Update default address of customer
			$sql = "UPDATE customers
				SET customers_default_address_id = :default_address
				WHERE customers_id = :customersID";
			$sql = $db->prepare($sql);
			$sql->bindValue(':default_address', $address_id, PDO::PARAM_INT);
			$sql->bindValue(':customersID', $userid, PDO::PARAM_INT);
			$sql->Execute();
			// if billing address is different
			if(isset($_POST['billing_first_name']) && $_POST['billing_first_name']!=''){
				$statement = $db->prepare("INSERT INTO address_book(customers_id, entry_firstname,entry_lastname,entry_street_address,entry_postcode,entry_city,entry_country_id,entry_zone_id,entry_company,entry_suburb)
					VALUES(".$userid.",'".$_POST['billing_first_name']."','".$_POST['billing_last_name']."','".$_POST['billing_street_address']."','".$_POST['billing_postal_code']."','".$_POST['billing_city']."','223',".$_POST['billing_state'].",'".$_POST['billing_company_name']."','".$_POST['billing_apt']."')");
				$insert = $statement->execute();
			}

			// Send email
			$email_text = "Dear ".$fname;
			$email_text .= "<br/><br/>We wish to welcome you to ".SITE_NAME.".";
			$email_text .= "<br/><br/>With your account, you can now take part in the various services we have to offer you. Some of these services include:";
			$email_text .= "<br/><br/>Permanent Cart - Any items added to your online cart remain there until you remove them, or check them out.";
			$email_text .= "<br/><br/>Address Book - We can now deliver your items to another address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.";
			$email_text .= "<br/><br/>Order History - View your history of purchases that you have made with us.";
			$email_text .= "<br/><br/>Items Reviews - Share your opinions on items with our other customers.";
			$email_text .= "<br/><br/>For help with any of our online services, please email the store-owner: service@deliverhop.app";
			$email_text .= "<br/><br/>Sincerely,";
			$email_text .= "<br/><br/>".SITE_NAME;
			$email_text .= "<br/>Store Owner";
			$email_text .= "<br/><br/>".SITE_FRONT_URL;
			$email_text .= "<br/><br/>This email address was given to us by you or by one of our customers. If you did not signup for an account, or feel that you have received this email in error, please send an email to ".SERVICE_EMAIL;
			$email_text .= "<br/><br/>This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.";
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
			define('EMAIL_SUBJECT', 'Welcome to '.STORE_NAME);
			$to = $email_address;
			$subject = EMAIL_SUBJECT;
			require_once "mail/PHPMailer-master/PHPMailerAutoload.php";
			$mail = new PHPMailer;
			$mail->SMTPAuth = true;
			ini_set ("SMTP","localhost");
			ini_set("sendmail_from", EMAIL_FROM);
			$mail->Host = "ssl://smtp.gmail.com"; // Specify main and backup SMTP servers
			$mail->SMTPAuth = true; // Enable SMTP authentication
			$mail->Username = SMTP_EMAIL; // SMTP username
			$mail->Password = SMTP_PASSWORD; // SMTP password
			$mail->SMTPSecure = false; // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 465; // TCP port to connect to
			$mail->setFrom(EMAIL_FROM, STORE_NAME, 0);
			$mail->addAddress($to);
			$mail->addReplyTo($to, 'testtest');
			$mail->isHTML(true); // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body = $email_text;
			$mail->AltBody = SITE_NAME;
			if(!$mail->send()){
				//echo 'Message could not be sent.';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
			}else{
				//echo 'Message has been sent';
			}
			// Send email
			$out = array('success'=>true,'token'=>$token);
		}else{
			$out = array('success'=>false,'message'=>"This email address already registered.");
		}
	}else{
		$out = array('success'=>false,'message'=>"Invalid data provided.");
	}
	echo json_encode($out);
	die;
?>