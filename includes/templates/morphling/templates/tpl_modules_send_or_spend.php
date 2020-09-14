<?php
/**
 * Module Template
 *
 * Template stub used to display Gift Certificates box
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_send_or_spend.php 2987 2006-02-07 22:30:30Z drbyte $
 */

  include(DIR_WS_MODULES . zen_get_module_directory('send_or_spend.php'));
?>
<legend><?php echo BOX_HEADING_GIFT_VOUCHER; ?></legend>
    <p><?php echo GV_SEND_ZM; ?></p>
    <p><?php echo  TEXT_BALANCE_IS . $customer_gv_balance; ?></p>
    <div class="buttonRow pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_GV_SEND, '', 'SSL') . '" class="pt-button pt-button-m"><i class="fa fa-gift"></i> ' . BUTTON_SEND_A_GIFT_CERT_ALT . '</a>'; ?></div>
<div class="clearfix"></div>