<?php
/**
 * Page Template
 *
 * Display information related to GV redemption (could be redemption details, or an error message)
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_gv_redeem_default.php 4155 2006-08-16 17:14:52Z ajeh $
 */
?>
<style>
#gvRedeemDefaultMessage {
	font-size: 18px;
	}
</style>
<div class="centerColumn" id="gvRedeemDefault">

<!--<h1 id="gvRedeemDefaultHeading"><?php echo HEADING_TITLE; ?></h1>-->

<p id="gvRedeemDefaultMessage" class="content"><?php echo sprintf($message, $_GET['gv_no']); ?></p>

<p id="gvRedeemDefaultMessage" class="content"><?php //echo TEXT_INFORMATION; ?></p>
<br class="clearBoth" />



<div class="buttonRow left"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '" class="pt-button">' . BUTTON_CONTINUE_ALT . '</a>'; ?></div>

</div>