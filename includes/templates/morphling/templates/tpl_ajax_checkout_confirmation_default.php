<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_confirmation.<br />
 * Displays final checkout details, cart, payment and shipping info details.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2014 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson   New in v1.5.4 $
 */
?>
<div class="centerColumn" id="checkoutConfirmDefault">

<h1 id="checkoutConfirmDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout_confirmation') > 0) echo $messageStack->output('checkout_confirmation'); ?>
<?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>

<div id="confirmation-tabs" class="pt-tabs">
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#checkoutBillto" role="tab" data-toggle="tab"><?php echo HEADING_BILLING_ADDRESS; ?></a></li> 
    <?php if ($_SESSION['sendto'] != false) { ?>
    <li><a href="#checkoutShipto" role="tab" data-toggle="tab"><?php echo HEADING_DELIVERY_ADDRESS; ?></a></li>
    <?php } ?>
    <li><a href="#checkoutComments" role="tab" data-toggle="tab"><?php echo HEADING_ORDER_COMMENTS; ?></a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade in active" id="checkoutBillto">
      <?php if (!$flagDisablePaymentAddressChange) { ?>
      <div class="buttonRow pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '" class="pt-button pt-button-s"><i class="fa fa-edit"></i> ' . BUTTON_EDIT_SMALL_ALT . '</a>'; ?></div>
      <?php } ?>
      <address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>

      <?php $class =& $_SESSION['payment']; ?>

      <h3 id="checkoutConfirmDefaultPayment" class="page-default-heading"><?php echo HEADING_PAYMENT_METHOD; ?></h3> 
      <p id="checkoutConfirmDefaultPaymentTitle" class="important"><?php echo $GLOBALS[$class]->title; ?></p>

      <?php
        if (is_array($payment_modules->modules)) {
          if ($confirmation = $payment_modules->confirmation()) {
      ?>
      <p><?php echo $confirmation['title']; ?></p>
      <?php } ?>
      <p>
        <?php for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) { ?>
        <div class="back"><?php echo $confirmation['fields'][$i]['title']; ?></div>
        <div><?php echo $confirmation['fields'][$i]['field']; ?></div>
        <?php } ?>
      </p>
      <?php
        }
      ?>
      <div class="clearfix"></div>
    </div>
    <?php if ($_SESSION['sendto'] != false) { ?>
    <div class="tab-pane fade" id="checkoutShipto">
      <div class="buttonRow pull-right"><?php echo '<a href="' . $editShippingButtonLink . '" class="pt-button pt-button-s"><i class="fa fa-edit"></i> ' . BUTTON_EDIT_SMALL_ALT . '</a>'; ?></div>
      <address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
      <?php if ($order->info['shipping_method']) { ?>
        <h3 id="checkoutConfirmDefaultShipment" class="page-default-heading"><?php echo HEADING_SHIPPING_METHOD; ?></h3>
        <p id="checkoutConfirmDefaultShipmentTitle" class="important"><?php echo $order->info['shipping_method']; ?></p>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="tab-pane fade" id="checkoutComments">
      <div class="buttonRow pull-right"><?php echo  '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"  class="pt-button pt-button-s"><i class="fa fa-edit"></i> ' . BUTTON_EDIT_SMALL_ALT . '</a>'; ?></div>
      <p><?php echo (empty($order->info['comments']) ? NO_COMMENTS_TEXT : nl2br(zen_output_string_protected($order->info['comments'])) . zen_draw_hidden_field('comments', $order->info['comments'])); ?></p>
    </div>

  </div>
</div>

<div class="buttonRow pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '" class="pt-button pt-button-s"><i class="fa fa-edit"></i> ' . BUTTON_EDIT_SMALL_ALT . '</a>'; ?></div>
<h2 id="checkoutConfirmDefaultHeadingCart" class="page-default-heading"><?php echo HEADING_PRODUCTS; ?></h2>
<div class="clearfix"></div>

<?php  if ($flagAnyOutOfStock) { ?>
<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
<?php    } else { ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?>


      <table border="0" width="100%" cellspacing="0" cellpadding="0" id="cartContentsDisplay">
        <tr class="tableHeading">
        <th scope="col" id="ccQuantityHeading" width="30"><?php echo TABLE_HEADING_QUANTITY; ?></th>
        <th scope="col" id="ccProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
<?php
  // If there are tax groups, display the tax columns for price breakdown
  if (sizeof($order->info['tax_groups']) > 1) {
?>
          <th scope="col" id="ccTaxHeading"><?php echo HEADING_TAX; ?></th>
<?php
  }
?>
          <th scope="col" id="ccTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
        </tr>
<?php // now loop thru all products to display quantity and price ?>
<?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { ?>
        <tr class="<?php echo $order->products[$i]['rowClass']; ?>">
          <td  class="cartQuantity"><?php echo $order->products[$i]['qty']; ?>&nbsp;x</td>
          <td class="cartProductDisplay"><?php echo $order->products[$i]['name']; ?>
          <?php  echo $stock_check[$i]; ?>

<?php // if there are attributes, loop thru them and display one per line
    if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) {
    echo '<div class="ccCartAttribsList"><ul>';
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
?>
      <li data-toggle="pt-tooltip" data-title="<?php echo $order->products[$i]['attributes'][$j]['option']; ?>"><?php echo nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])); ?></li>
<?php
      } // end loop
      echo '</ul></div>';
    } // endif attribute-info
?>
        </td>

<?php // display tax info if exists ?>
<?php if (sizeof($order->info['tax_groups']) > 1)  { ?>
        <td class="cartTotalDisplay">
          <?php echo zen_display_tax_value($order->products[$i]['tax']); ?>%</td>
<?php    }  // endif tax info display  ?>
        <td class="cartTotalDisplay">
          <?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
          if ($order->products[$i]['onetime_charges'] != 0 ) echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
?>
        </td>
      </tr>
<?php  }  // end for loopthru all products ?>
      </table>

<?php
  if (MODULE_ORDER_TOTAL_INSTALLED) {
    $order_totals = $order_total_modules->process();
?>
<div id="orderTotals"><?php $order_total_modules->output(); ?></div>
<?php
  }
?>

<?php
  echo zen_draw_form('checkout_confirmation', $form_action_url, 'post', 'id="checkout_confirmation" onsubmit="submitonce();"');
?>
<div id="processButtonHolder"></div>
<?php
   if (is_array($payment_modules->modules)) {
     $processButtonOptions = $payment_modules->process_button_ajax();
     if (isset($processButtonOptions['ccFields']) && count($processButtonOptions['ccFields'])> 0 ) {
       foreach  ($processButtonOptions['ccFields'] as $newField => $oldField)
       {
?>
<input type="hidden" name="<?php echo $newField; ?>" value="">
<?php if (!is_array($oldField)) { ?>
<script>
$(document).ready(function () {
    $(":input[name='<?php echo $newField; ?>']").val($(":input[name='<?php echo $oldField; ?>']").val());
});
</script>
<?php } else { ?>

<script>
    $(document).ready(function () {
     var oldField = window['<?php echo $oldField['name']; ?>'](<?php echo $oldField['args']; ?>);
     $(":input[name='<?php echo $newField; ?>']").val(oldField);
    });
</script>
<?php } ?>
<?php
       }
     }
     if (isset($processButtonOptions['extraFields']) && count($processButtonOptions['extraFields'])> 0 ) {
       foreach  ($processButtonOptions['extraFields'] as $fieldName => $fieldValue)
       {
?>
<input type="hidden" name="<?php echo $fieldName; ?>"  value="<?php echo $fieldValue; ?>">
<?php
       }
     }
   }
?>
<div class="buttonRow pull-right"><button type="submit" name="btn_submit" id="btn_submit" class="pt-button pt-button-m"><i class="fa fa-check-square-o"></i> <?php echo BUTTON_CONFIRM_ORDER_ALT; ?></button></div>

</form>
<div class="buttonRow pull-left"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</div>