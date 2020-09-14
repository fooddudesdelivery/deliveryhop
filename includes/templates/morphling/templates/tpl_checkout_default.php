<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007-2008 Numinix Technology http://www.numinix.com    |
// |                                                                      |
// | Portions Copyright (c) 2003-2006 Zen Cart Development Team           |
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
//  $Id: tpl_checkout_default.php 105 2010-02-09 04:45:40Z numinix $
//
?>
<?php echo $payment_modules->javascript_validation(); ?>

<div class="centerColumn" id="checkout">
<?php  echo $_SESSION['new_billing_address'];?>
<?php echo zen_draw_form('checkout_payment', $form_action_url, 'post', 'id="checkout_payment"'); ?>
<?php  $unsettip=false;?>
<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions');$unsettip=true; ?>
<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping');$unsettip=true; ?>
<?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment');$unsettip=true; ?>
<?php  if($_SESSION['braintreestack']){
echo '<div class="messageStack messageStackCaution larger xx">'.$_SESSION['braintreestack'].'</div>';
unset($_SESSION['braintreestack']);	
$unsettip=true;

}

if($unsettip){
	$_SESSION['add_tip']=0;
	$_SESSION['decoy_tip']=0;
}?>
<span id="checkoutOrderHeading" class="fec-page-step hiddenField">
	<?php echo HEADING_TITLE_ORDER_TOTAL; ?>
</span>

<?php include(DIR_WS_TEMPLATE . 'templates/tpl_checkout_stacked.php'); ?>
				
<?php if ($order->content_type != 'virtual') {
	$title_checkout = TITLE_CONTINUE_CHECKOUT_PROCEDURE;
} else {
	$title_checkout = TITLE_CONTINUE_CHECKOUT_PROCEDURE_VIRTUAL;
}
?>
<div class="fec-container fec-button-container">
	<?php if (FEC_ONE_PAGE == 'false') { ?>
		<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT, 'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'); ?></div>
		<div class="fec-infomation"><?php echo TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>
	<?php } else { ?>
		<div class="buttonRow forward final_checkout_btn"><?php echo zen_image_button(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT, 'onmouseover="submitFunction()" id="main_checkout_btn"'); ?></div>
		<div class="fec-infomation hiddenField" ><?php echo TEXT_CONFIRM_CHECKOUT; ?></div>
	<?php } ?>
</div>
</form>
</div>
