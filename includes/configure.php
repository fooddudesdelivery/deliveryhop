<?php
/**
 * @package Configuration Settings circa 1.5.4
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * File Built by zc_install on 2020-09-07 08:13:38
 */

/*************** NOTE: This file is similar, but DIFFERENT from the "admin" version of configure.php. ***********/
/*************** The 2 files should be kept separate and not used to overwrite each other. ***********/

// Define the webserver and path parameters
// HTTP_SERVER is your Main webserver: eg-http://www.your_domain.com
// HTTPS_SERVER is your Secure webserver: eg-https://www.your_domain.com
define('HTTP_SERVER', 'http://localhost');
define('HTTPS_SERVER', 'http://localhost');

// Use secure webserver for checkout procedure?
define('ENABLE_SSL', 'false');

// NOTE: be sure to leave the trailing '/' at the end of these lines if you make changes!
// * DIR_WS_ * = Webserver directories (virtual/URL)
// these paths are relative to top of your webspace ... (ie: under the public_html or httpdocs folder)
define('DIR_WS_CATALOG', '/deliveryhop/');
define('DIR_WS_HTTPS_CATALOG', '/deliveryhop/');

define('DIR_WS_IMAGES', 'images/');
define('DIR_WS_INCLUDES', 'includes/');
define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
define('DIR_WS_DOWNLOAD_PUBLIC', DIR_WS_CATALOG . 'pub/');
define('DIR_WS_TEMPLATES', DIR_WS_INCLUDES . 'templates/');
define('DIR_WS_PHPBB', '/');

// * DIR_FS_* = Filesystem directories (local/physical)
// the following path is a COMPLETE path to your Zen Cart files. eg: /var/www/vhost/accountname/public_html/store/
define('DIR_FS_CATALOG', 'D:/xampp/htdocs/deliveryhop/');
// the following path is a COMPLETE path to the /logs/ folder eg: /var/www/vhost/accountname/public_html/store/logs and no trailing slash
define('DIR_FS_LOGS', 'D:/xampp/htdocs/deliveryhop/logs');
define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');
define('DIR_WS_UPLOADS', DIR_WS_IMAGES . 'uploads/');
define('DIR_FS_UPLOADS', DIR_FS_CATALOG . DIR_WS_UPLOADS);
define('DIR_FS_EMAIL_TEMPLATES', DIR_FS_CATALOG . 'email/');

// define our database connection
define('DB_TYPE', 'mysql');
define('DB_PREFIX', '');
define('DB_CHARSET', 'utf8');
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '123456');
define('DB_DATABASE', 'fooddudes');

// The next 2 "defines" are for SQL cache support.
// For SQL_CACHE_METHOD, you can select from:  none, database, or file
// If you choose "file", then you need to set the DIR_FS_SQL_CACHE to a directory where your apache 
// or webserver user has write privileges (chmod 666 or 777). We recommend using the "cache" folder inside the Zen Cart folder
// ie: /path/to/your/webspace/public_html/zen/cache   -- leave no trailing slash  
define('SQL_CACHE_METHOD', 'none'); 
define('DIR_FS_SQL_CACHE', 'D:/xampp/htdocs/deliveryhop/cache');
define('SESSION_WRITE_DIRECTORY', 'D:/xampp/htdocs/deliveryhop/cache');

/**
 * ReCaptcha V2
 * Account: fddevs@gmail.com Abc@1234 (Local)
 */
define('RECAPTCHA_SITE_KEY', '6LfDmcwZAAAAAJERAx62vlwSzl8uMPZtGPc6CsPS');
define('RECAPTCHA_SECRET_KEY', '6LfDmcwZAAAAABNzwzeH2D9XdmqomE-G3Lte6ZH2');

/**
 * Google MAP API Key
 */
define('GOOGLE_MAP_API_V3_KEY', 'AIzaSyAb3ib6j9Vgl_XtfriXePpd4gyFSNY8rc4');

define('AUTHOR_NAME', 'David Carlson');
define('SITE_NAME', 'Deliver Hop');
define('SITE_DOMAIN', 'deliverhop.app');
define('SITE_FRONT_URL', HTTPS_SERVER.'/deliveryhop');
define('SITE_ADMIN_URL', HTTPS_SERVER.'/fooddudesdelivery/aAsd23fadfAd2565Hccxz/');
define('CORDOVA_URL', SITE_FRONT_URL.'/cordova/www/');
define('SITE_TIMEZONE', 'America/Chicago');

//https://itunes.apple.com/us/app/food-dudes/id1180442819?mt=8

define('SERVICE_EMAIL', 'service@deliverhop.app');
// How to handle this
define('FAX_FROM', 'fax@deliverhop.app');
// SMTP Credentials
define('SMTP_EMAIL', 'deliverhopsdelivery2@gmail.com');
define('SMTP_PASSWORD', 'deliverhops');