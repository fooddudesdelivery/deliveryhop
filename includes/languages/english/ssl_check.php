<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: ssl_check.php 1969 2005-09-13 06:57:21Z drbyte $
//

define('NAVBAR_TITLE', 'Security Check');
define('HEADING_TITLE', 'Security Check');

define('TEXT_INFORMATION', 'We have detected that your browser has generated a different SSL Session ID than was used throughout our secure pages.');
define('TEXT_INFORMATION_2', 'For security reasons, you will need to logon to your account again to continue shopping online.');
define('TEXT_INFORMATION_3','Some browsers, such as Konqueror 3.1, do not have the capability to generate the required secure SSL Session ID automatically. If you use such a browser, we recommend switching to another browser to continue your online shopping with us. If you do not have another browser installed on your computer you can download a compatible one from: <a href="http://www.microsoft.com/ie/" target="_blank">Microsoft Internet Explorer</a>, <a href="http://channels.netscape.com/ns/browsers/download_other.jsp" target="_blank">Netscape</a>, or <a href="http://www.mozilla.org/releases/" target="_blank">Mozilla</a>.');
define('TEXT_INFORMATION_4','We have taken this security measure for your benefit, and apologize for any inconvenience it causes.');
define('TEXT_INFORMATION_5','Please contact the store owner if you have any questions relating to this requirement, or to continue purchasing items offline.');

define('BOX_INFORMATION_HEADING', 'Privacy and Security');
define('BOX_INFORMATION', 'We validate the SSL Session ID automatically generated by your browser on every secure page request made to this server.<br /><br />This validation assures that it is you who is navigating on this site with your account and not somebody else.');
?>
