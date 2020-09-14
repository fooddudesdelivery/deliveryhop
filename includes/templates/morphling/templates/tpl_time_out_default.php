<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_time_out_default.php 6620 2007-07-17 05:52:19Z drbyte $
 */
?>
<div class="centerColumn" id="timeoutDefault">
<?php
    if ($_SESSION['customer_id']) {
?>
<h1 id="timeoutDefaultHeading" class="page-default-heading"><?php echo HEADING_TITLE_LOGGED_IN; ?></h1>
<p id="timeoutDefaultContent" class="content"><?php echo TEXT_INFORMATION_LOGGED_IN; ?></p>
<?php
  } else {
?>
<h1 id="timeoutDefaultHeading" class="page-default-heading"><?php echo HEADING_TITLE; ?></h1>

<p id="timeoutDefaultContent" class="content"><?php echo TEXT_INFORMATION; ?></p>
<br class="clearBoth">
<?php echo zen_draw_form('login', zen_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
<fieldset>
<legend><?php echo HEADING_RETURNING_CUSTOMER; ?></legend>

<div class="form-group">
	<label class="inputLabel" for="login-email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
	<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="login-email-address" class="timeoutbox"'); ?>
</div>

<div class="form-group">
	<label class="inputLabel" for="login-password"><?php echo ENTRY_PASSWORD; ?></label>
	<?php echo zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password') . ' id="login-password" class="timeoutbox"'); ?>
</div>

<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']); ?>
</fieldset>
<br class="clearBoth">
<div class="buttonRow pull-right"><input type="submit" value="<?php echo BUTTON_LOGIN_ALT; ?>" class="pt-button"></div>
<div class="buttonRow pull-left"><?php echo '<a href="' . zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '" class="pt-button">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?></div>
</form>
<br class="clearBoth" />
<?php
 }
 ?>
</div>
