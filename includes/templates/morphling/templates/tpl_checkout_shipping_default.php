<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping.<br />
 * Displays allowed shipping modules for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2009 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_shipping_default.php 14807 2009-11-13 17:22:47Z drbyte $
 */

 if($_SESSION['fooddudestaging_login']){
		//echo 'd'; 
 }
?>
<div class="centerColumn" id="checkoutShipping">

<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

<h1 id="checkoutShippingHeading" class="page-default-heading"><?php echo HEADING_TITLE; ?></h1>
<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>

<h2 id="checkoutShippingHeadingAddress" class="page-default-heading"><?php echo TITLE_SHIPPING_ADDRESS; ?></h2>

<div class="ship-to row">
  <div id="checkoutShipto" class="col-lg-6">
  <address class=""><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?></address>
  </div>
  <div class="col-lg-6">
    <?php if ($displayAddressEdit) { ?>
    <div class="buttonRow"><?php echo '<a href="' . $editShippingButtonLink . '" class="pt-button pt-button-m"><i class="fa fa-home"></i> ' . BUTTON_CHANGE_ADDRESS_ALT . '</a>'; ?></div>
    <?php } ?>  
    <?php echo TEXT_CHOOSE_SHIPPING_DESTINATION; ?>
  </div>
</div>

<?php if (zen_count_shipping_modules() > 0) { ?>

<h2 id="checkoutShippingHeadingMethod" class="page-default-heading"><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></h2>

<?php if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) { ?>

<div id="checkoutShippingContentChoose" class="important text-center"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></div>

<?php } elseif ($free_shipping == false) { ?>
<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></div>

<?php } ?>
<?php if ($free_shipping == true) { ?>
<div id="freeShip" class="important" ><?php echo FREE_SHIPPING_TITLE; ?>&nbsp;<?php echo $quotes[$i]['icon']; ?></div>
<div id="defaultSelected"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . zen_draw_hidden_field('shipping', 'free_free'); ?></div>

<?php
    } else {
      $radio_buttons = 0;
      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
      // bof: field set
// allows FedEx to work comment comment out Standard and Uncomment FedEx
//      if ($quotes[$i]['id'] != '' || $quotes[$i]['module'] != '') { // FedEx
      if ($quotes[$i]['module'] != '') { // Standard
?>
<div class="checkout-section">
  <div class="checkout-section-head"><?php echo $quotes[$i]['module']; ?>&nbsp;<?php if (isset($quotes[$i]['icon']) && zen_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></div>
    <?php if (isset($quotes[$i]['error'])) { ?>
      <div><?php echo $quotes[$i]['error']; ?></div>
    <?php } else {
      for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) { ?>
        <div class="shipping-detail">
    <?php
    // set the radio button to be checked if it is the method chosen
        $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);

        if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
          //echo '      <div id="defaultSelected" class="moduleRowSelected">' . "\n";
        //} else {
          //echo '      <div class="moduleRow">' . "\n";
        }
    ?>
    <?php if ( ($n > 1) || ($n2 > 1) ) { ?>
    <div class="shipping-quote"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></div>
    <?php } else { ?>
    <div class="shipping-quote"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></div>
    <?php } ?>

    <?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, 'id="ship-'.$quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']) .'"'); ?>
    <label for="ship-<?php echo $quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']); ?>" class="checkboxLabel" ><?php echo $quotes[$i]['methods'][$j]['title']; ?></label>
  </div>
  <div class="clearfix"></div>
<?php
      $radio_buttons++;
    }
  }
?>

</div>
<?php
    }
// eof: field set
      }
    }
?>

<?php
  } else {
?>
<h2 id="checkoutShippingHeadingMethod" class="page-default-heading"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
<?php
  }
?>

<textarea class="order-comment" name="comments" rows="3" cols="45" placeholder="<?php echo TABLE_HEADING_COMMENTS; ?>"></textarea>

<div class="clearfix"></div>

<div class="buttonRow pull-right"><button type="submit" class="pt-button pt-button-m"><?php echo BUTTON_CONTINUE_ALT; ?> &rarr;</button></div>
<div class="buttonRow pull-left"><?php echo '<strong>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</strong><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form>
</div>