<?php
ini_set('display_errors',true);
ini_set('memory_limit', '-1');
ini_set("log_errors", 1);
error_reporting(E_ALL);

if(!defined('_DB_SERVER')){
	define('_DB_SERVER', 'localhost');
	define('_DB_SERVER_USERNAME', 'root');
	define('_DB_SERVER_PASSWORD', '123456');
	define('_DB_DATABASE', 'fooddudes');
}
define('_DB_CONNECTION_FAILURE_EMAIL_ADDRESS', 'developers@fooddudesdelivery.com');
define('_DB_CONNECTION_FAILURE_EMAIL_SUBJECT', 'Connection Failure');

define('HTTP_SERVER', 'http://localhost');
define('HTTPS_SERVER', 'http://localhost');

define('_SITE_DOMAIN_NAME', 'localhost/deliveryhop');
define('_SITE_FRONT_URL', HTTP_SERVER.'/deliveryhop');
define('_SITE_IMAGES_URL', HTTP_SERVER.'/deliveryhop/images/');
define('_SITE_ADMIN_URL', HTTP_SERVER.'/fooddudesdelivery/aAsd23fadfAd2565Hccxz/');
define('_CORDOVA_URL', HTTP_SERVER.'/deliveryhop/cordova/www/');
define('_GOOGLE_MAP_API_V3_KEY', 'AIzaSyCurmjA1Drp5oqMD2T_yBgojqvg-l5k0XU');

define('_ORDER_ONLINE', HTTP_SERVER.'/deliveryhop/order_online/');
define('_ORDER_ONLINE_FUTURE_INDEX', HTTP_SERVER.'/deliveryhop/order_online/future_index.php?key=');
define('_ORDER_ONLINE_DEV_FUTURE_INDEX', HTTP_SERVER.'/deliveryhop/order_online_dev/future_index.php?key=');
define('_FASTORDER_FORM', HTTP_SERVER.'/deliveryhop/fastorder/form.php?r=');

//EMAILS
define('_SERVICE_EMAIL', 'service@staging.fooddudesdelivery.com');
define('_CC_ADMIN_EMAIL', 'dcarlson@staging.fooddudesdelivery.com');
define('_NO_REPLY', 'no-reply@staging.fooddudesdelivery.com');
define('_NO_REPLY_2', 'noreply@staging.fooddudesdelivery.com');
define('_BLACKLIST', 'gh@staging.fooddudesdelivery.com');
define('_FROM_EMAIL', 'text@staging.fooddudesdelivery.com');
define('_ORDER_EMAIL', 'order@staging.fooddudesdelivery.com');

//FAX DEFAULT
define('_FAX_TO_1', '@rcfax.com');
define('_FAX_FROM_1', 'fax@staging.fooddudesdelivery.com');
define('_FAX_SUBJECT_1', '');

//FAX BACKUP
define('_FAX_TO_2', '@fooddudestagingsdelivery.fax.onjive.com');
define('_FAX_FROM_2', 'fax@staging.fooddudesdelivery.com');
define('_FAX_SUBJECT_2', '379860961');

//PAYPAL_SECURITY
define('_X_PAYPAL_SECURITY_USERID', 'dcarlson_api2.staging.fooddudesdelivery.com');
define('_X_PAYPAL_SECURITY_PASSWORD', 'Y3M9XLN5KTVUKJ2T');
define('_X_PAYPAL_SECURITY_SIGNATURE', 'AQDropOQ3gOJwZlDuy-qE4mUXjqdA7nXdagYdIlfhsNjnyk5mRmRXUh9');

//TCPDF
define('_PDF_SERVICE_EMAIL', _SERVICE_EMAIL);
define('_PDF_SERVICE_PHONE', '(800) 599-5770  Tel');
define('_PDF_SERVICE_FAX', '(800) 599-2974 Fax');

//GV
define('_GV_LINK_TEXT', 'staging.fooddudesdelivery');

//domain unreachable
define('_DOMAIN_TEXT_EMAIL_ADDRESS_1', 'zachfagerness@gmail.com');
define('_DOMAIN_TEXT_EMAIL_ADDRESS_2', 'zachf181@gmail.com');
define('_DOMAIN_TEXT_EMAIL_ADDRESS_3', 'zach@gmail.com');
define('_DOMAIN_TEXT_EMAIL_ADDRESS_4', '3203106216@tmomail.net');
define('_DOMAIN_TEXT_EMAIL_SUBJECT', 'WARNING');
define('_DOMAIN_TEXT_UNREACHABLE', 'staging.fooddudesdelivery is unreachable');

//Sales Report
define('_SALES_REPORT_EMAIL_ADDRESS', _DOMAIN_TEXT_EMAIL_ADDRESS_1);
define('_SALES_REPORT_EMAIL_SUBJECT', 'CSV Sales Report');
define('_SALES_REPORT_NO_REPLY_EMAIL', _NO_REPLY_2);

/**
 * ReCaptcha V2
 * Localhost: fddevs@gmail.com Abc@1234
 */
define('_RECAPTCHA_SITE_KEY', '6LfDmcwZAAAAAJERAx62vlwSzl8uMPZtGPc6CsPS');
define('_RECAPTCHA_SECRET_KEY', '6LfDmcwZAAAAABNzwzeH2D9XdmqomE-G3Lte6ZH2');
?>