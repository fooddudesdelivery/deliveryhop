<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_payment.<br />
 * Displays the allowed payment modules, for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_payment_default.php 19358 2011-08-24 17:36:50Z drbyte $
 */
?>
<?php

if($_SESSION['fooddudestaging_login']){
	
}

?>
<?php echo $payment_modules->javascript_validation(); ?>
<div class="centerColumn" id="checkoutPayment">
<?php echo zen_draw_form('checkout_payment', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post'); ?>
<?php echo zen_draw_hidden_field('action', 'submit'); ?>

<h1 id="checkoutPaymentHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>
<?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment'); ?>

<?php if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') { ?>
  <h3 class="page-default-heading"><?php echo TABLE_HEADING_CONDITIONS; ?></h3>
  <div class="checkoutPaymentConditions">
    <?php echo TEXT_CONDITIONS_DESCRIPTION;?>
    <div class="checkbox">
      <label class="checkboxLabel important" for="conditions">
        <?php echo  zen_draw_checkbox_field('conditions', '1', false, 'id="conditions"');?>
        <?php echo TEXT_CONDITIONS_CONFIRM; ?>
      </label>
    </div>
  </div>
<?php } ?>

<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      if (!$payment_modules->in_special_checkout()) {
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>
<h2 id="checkoutPaymentHeadingAddress" class="page-default-heading"><?php echo TITLE_BILLING_ADDRESS; ?></h2>
<div class="bill-to row">
  <div id="checkoutBillto" class="col-lg-6">
    <address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?></address>
  </div>
  <div class="col-lg-6">
    <?php if (MAX_ADDRESS_BOOK_ENTRIES >= 2) { ?>
    <div class="buttonRow"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '" class="pt-button pt-button-m"><i class="fa fa-home"></i> ' . BUTTON_CHANGE_ADDRESS_ALT . '</a>'; ?></div>
    <?php } ?>
    <?php echo TEXT_SELECTED_BILLING_DESTINATION; ?>
  </div>
</div>
<div class="clearfix"></div>
<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      }
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>

<div id="checkoutOrderTotals" class="checkout-section">
  <div id="checkoutPaymentHeadingTotal" class="checkout-section-head"><?php echo TEXT_YOUR_TOTAL; ?></div>
  <div class="payment-detail">
    <div class="payment-detail-inner">
      <?php
        if (MODULE_ORDER_TOTAL_INSTALLED) {
          $order_totals = $order_total_modules->process();
      ?>
      <?php $order_total_modules->output(); ?>
      <?php
        }
      ?>
    </div>
  </div>
  <div class="clearfix"></div>

<?php 
    // BOF ORDER_TOTAL TIP MODIFICATION
	if(MODULE_ORDER_TOTAL_TIP_STATUS == 'true') {
?>
<label class="inputLabel" for="add_tip" id="add_tipLabel"><?php echo ENTRY_ADD_TIP; ?></label>
<?php echo zen_draw_input_field('add_tip', ($_SESSION['add_tip'] ? $_SESSION['add_tip'] : ''), 'size="5" id="add_tip"'); ?>
<br class="clearBoth" id="add_tipBreak" />

<?php 
	}
    // EOF ORDER_TOTAL TIP MODIFICATION
?>

</div>

<?php
  $selection =  $order_total_modules->credit_selection();
  if (sizeof($selection)>0) {
    for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
      if ($_GET['credit_class_error_code'] == $selection[$i]['id']) {
?>
<div class="messageStackError"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>

<?php
      }
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
<div class="checkout-section">
  <div class="checkout-section-head"><?php echo $selection[$i]['module']; ?></div>
  <div class="payment-detail">
    <?php echo $selection[$i]['redeem_instructions']; ?>
    <div class="gvBal important"><?php echo $selection[$i]['checkbox']; ?></div>
    <label class="inputLabel"<?php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
    <?php echo $selection[$i]['fields'][$j]['field']; ?>
  </div>
</div>
<?php
      }
    }
?>

<?php
    }
?>

<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      if (!$payment_modules->in_special_checkout()) {
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>
<div class="checkout-section">
  <div class="checkout-section-head"><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></div>
    <div class="payment-detail payment-method">
    <?php
      if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
    ?>

    <?php
        if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
          echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
        }
        if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
          echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
        }
    ?>
    <br class="clearBoth" />
    <?php } ?>

    <?php
      $selection = $payment_modules->selection();

      if (sizeof($selection) > 1) {
    ?>
    <p class="important text-center"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p>
    <?php
      } elseif (sizeof($selection) == 0) {
    ?>
    <p class="important text-center"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></p>

    <?php
      }
    ?>

    <?php
      $radio_buttons = 0;
      for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
    ?>
    <?php
        if (sizeof($selection) > 1) {
            if (empty($selection[$i]['noradio'])) {
     ?>
    <?php echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); ?>
    <?php   } ?>
    <?php
        } else {

    ?>
    <?php echo zen_draw_hidden_field('payment', $selection[$i]['id'], 'id="pmt-'.$selection[$i]['id'].'"'); ?>
    <?php
        }
    ?>
    <label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel"><?php echo $selection[$i]['module']; ?></label>

    <?php
        if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod') {
    ?>
    <div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
    <?php
        } else {
          // echo 'WRONG ' . $selection[$i]['id'];
    ?>
    <?php
        }
    ?>
    <br class="clearBoth" />

    <?php
        if (isset($selection[$i]['error'])) {
    ?>
        <div><?php echo $selection[$i]['error']; ?></div>

    <?php
        } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
    ?>

    <div class="ccinfo">
    <?php
          for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
    ?>
    <label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo $selection[$i]['fields'][$j]['title']; ?></label><?php echo $selection[$i]['fields'][$j]['field']; ?>
    <br class="clearBoth" />
    <?php
          }
    ?>
    </div>
    <br class="clearBoth" />
    <?php
        }
        $radio_buttons++;
    ?>
    <br class="clearBoth" />
    <?php
      }
    ?>
  </div>
</div>
<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      } else {
        ?><input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" /><?php
      }
      // ** END PAYPAL EXPRESS CHECKOUT ** ?>

<textarea class="order-comment" name="comments" rows="3" cols="45" placeholder="<?php echo TABLE_HEADING_COMMENTS; ?>"></textarea>

<div class="clearfix"></div>      

<div class="buttonRow pull-right" id="paymentSubmit"><button type="submit" class="pt-button pt-button-m" <?php echo 'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'; ?>><?php echo BUTTON_CONTINUE_ALT; ?> &rarr;</button></div>
<div class="buttonRow pull-left"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form>
</div>
