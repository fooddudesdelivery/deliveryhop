<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_password_forgotten_default.php 3712 2006-06-05 20:54:13Z drbyte $
 */
?>
<div style="min-height:390px">

<div class="centerColumn" id="passwordForgotten">
<?php echo zen_draw_form('password_forgotten', zen_href_link(FILENAME_PASSWORD_FORGOTTEN, 'action=process', 'SSL')); ?>

<?php if ($messageStack->size('password_forgotten') > 0) echo $messageStack->output('password_forgotten'); ?>

<fieldset>    
<legend><?php echo HEADING_TITLE; ?></legend>

<div id="passwordForgottenMainContent" class="content"><?php echo TEXT_MAIN; ?></div>

<p class="alert form-alert text-danger"><?php echo FORM_REQUIRED_INFORMATION; ?></p>
<br class="clearBoth" />

<div class="fec-field">
	<label class="inputLabel" for="email-address"><?php echo ENTRY_EMAIL_ADDRESS; ?></label>
	<?php echo zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address"') . '&nbsp;' . (zen_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="alert">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
</div>
</fieldset>
<br class="clearBoth" />
<div class="buttonRow pull-left"><input type="submit" value="<?php echo BUTTON_RESET; ?>" class="pt-button"></div> 
<!--<div class="buttonRow pull-left"><a href="<?php //echo zen_back_link(true); ?>" class="pt-button"><?php echo BUTTON_BACK_ALT; ?></a></div>-->

</form>
</div>
</div>