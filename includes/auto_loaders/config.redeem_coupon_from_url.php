<?php
/*
//////////////////////////////////////////////////////////
//  REDEEM COUPON FROM URL                              //
//                                                      //
//  By ResponsiveZencart.com                            //
//                                                      //
//  Released under the GNU General Public License       //
//  see "LICENSE.txt" in the downloaded zip             //
//////////////////////////////////////////////////////////
*/

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$autoLoadConfig[200][] = array('autoType' => 'init_script',
	'loadFile' => 'redeem_coupon_from_url.php');
