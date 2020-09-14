<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping_adresss.<br />
 * Allows customer to change the shipping address.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_shipping_address_default.php 4852 2006-10-28 06:47:45Z drbyte $
 */
  $_SESSION['changed_address']=1;
?>
<div id="stText"></div>
<div id="stBreak"></div>
<script>
$(document).ready(function(e) {

    $("#stateZone").children("option").each(function(index, element) {
        if($(this).text().toLowerCase()=='<?php echo strtolower($_SESSION['address_separated'][0]['state']) ?>'){
			$(this).attr('selected',true);
		}else{
			$(this).attr('selected',false);
		}
    });
});

</script>
<div class="centerColumn col-md-10 col-md-offset-1" id="checkoutShipAddressDefault">

<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'), 'post', 'onsubmit="return check_form_optional(checkout_address);" class="create_acct_form"'); ?>
<!--<h1 id="checkoutShipAddressDefaultHeading"><?php echo HEADING_TITLE; ?></h1>-->

<?php if ($messageStack->size('checkout_address') > 0) echo $messageStack->output('checkout_address'); ?>

<?php
  if ($process == false || $error == true) {
?>
<fieldset>

<legend ><?php echo TITLE_SHIPPING_ADDRESS; ?></legend>

     <address class="back"><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?></address>
    <div class="instructions"><?php if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) echo TEXT_CREATE_NEW_SHIPPING_ADDRESS; ?></div>
 </fieldset>
<br class="clearBoth" />

<?php
     if (true) {
?>
<?php
/**
 * require template to display new address form
 */
  require($template->get_template_dir('tpl_modules_checkout_new_address.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_checkout_new_address.php');
?>
<?php
    }
    if (FALSE) {
?>
<br class="clearBoth" />
<fieldset>
<legend><?php echo TABLE_HEADING_ADDRESS_BOOK_ENTRIES; ?></legend>
<?php
      require($template->get_template_dir('tpl_modules_checkout_address_book.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_checkout_address_book.php');
?>
</fieldset>
<?php
     }
  }

?>
<br class="clearBoth" />
<div class="buttonRow pull-right"><?php echo zen_draw_hidden_field('action', 'submit'); ?><input type="submit" value="<?php echo BUTTON_CONTINUE_ALT; ?>" class="pt-button "></div>
<div class="buttonRow pull-left hiddenField"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>
<br class="clearBoth" />
<?php
  if ($process == true) {
?>
<br class="clearBoth" />
<div class="buttonRow pull-left"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '" class="pt-button">' . BUTTON_BACK_ALT . '</a>'; ?></div>
<br class="clearBoth" />
<?php
  }
?>
</form>
</div>