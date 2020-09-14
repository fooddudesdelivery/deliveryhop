<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_payment_address.<br />
 * Allows customer to change the billing address.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_checkout_payment_address_default.php 4852 2006-10-28 06:47:45Z drbyte $
 */
?>
<div class="centerColumn col-md-10 col-md-offset-1" id="checkoutPayAddressDefault">

<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'), 'post', 'onsubmit="return check_form_optional(checkout_address);"'); ?>

<!--<h1 id="checkoutPayAddressDefaultHeading"><?php echo HEADING_TITLE; ?></h1>-->

<?php if ($messageStack->size('checkout_address') > 0) echo $messageStack->output('checkout_address'); ?>
<fieldset>
<legend><?php echo TITLE_PAYMENT_ADDRESS; ?></legend>

<address class="back"><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?></address>
<div class="instructions"><?php echo TEXT_SELECTED_PAYMENT_DESTINATION; ?></div>
</fieldset>
<br class="clearBoth" />

<?php
     if (true) {
?>
<?php
/**
 * require template to collect address details
 */
 require($template->get_template_dir('tpl_modules_checkout_new_address.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_checkout_new_address.php');
?>
<?php
    }
    if (false) {
?>
<br>
<fieldset>
<legend><?php echo TABLE_HEADING_NEW_PAYMENT_ADDRESS; ?></legend>
<?php
      require($template->get_template_dir('tpl_modules_checkout_address_book.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_checkout_address_book.php');
?>
</fieldset>
<?php
     }
?>
<br class="clearBoth" />
<div class="buttonRow pull-right"><?php echo zen_draw_hidden_field('action', 'submit'); ?><input type="submit" value="<?php echo BUTTON_CONTINUE_ALT; ?>" class="pt-button"></div>
<div class="buttonRow pull-left hiddenField"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>
<br class="clearBoth" />
<?php
  if ($process == true) {
?>
<br class="clearBoth" />
<div class="buttonRow pull-left"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '" class="pt-button">' . BUTTON_BACK_ALT . '</a>'; ?></div>
<br class="clearBoth" />
<?php
  }
?>
</form>
</div>