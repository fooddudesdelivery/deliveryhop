<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_newsletters.<br />
 * Subscribe/Unsubscribe from General Newsletter
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_newsletters_default.php 2896 2006-01-26 19:10:56Z birdbrain $
 */
?>
<div class="centerColumn" id="acctNewslettersDefault">
<?php echo zen_draw_form('account_newsletter', zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

<fieldset>
<legend><?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER; ?></legend>
<div class="checkbox">
	<label class="checkboxLabel" for="newsletter">
	<?php echo zen_draw_checkbox_field('newsletter_general', '1', (($newsletter->fields['customers_newsletter'] == '1') ? true : false), 'id="newsletter"'); ?>
	<?php echo MY_NEWSLETTERS_GENERAL_NEWSLETTER_DESCRIPTION; ?></label>
</div>
<br>
</fieldset>

<div class="buttonRow pull-left"><input type="submit" value="<?php echo BUTTON_UPDATE_ALT; ?>" class="pt-button"></div> 
<!--<div class="buttonRow pull-left"><?php //echo '<a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '" class="pt-button">' . BUTTON_BACK_ALT . '</a>'; ?></div>-->
<div class="clearfix"></div>

</form>
</div>