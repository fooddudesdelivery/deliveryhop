<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_discount_coupon_default.php 18695 2011-05-04 05:24:19Z drbyte $
 */
?>
<div class="centerColumn" id="discountcouponInfo">
<!--<h1 id="discountcouponInfoHeading"><?php echo HEADING_TITLE; ?></h1>-->

<p id="discountcouponInfoMainContent" class="content">
<?php if ((DEFINE_DISCOUNT_COUPON_STATUS >= 1 and DEFINE_DISCOUNT_COUPON_STATUS <= 2) && $text_coupon_help == '') {
  require($define_page);
 } else {
  echo $text_coupon_help;
} ?>
</p>
<br class="clearBoth" />

<?php echo zen_draw_form('discount_coupon', zen_href_link(FILENAME_DISCOUNT_COUPON, 'action=lookup', 'NONSSL', false)); ?>
<fieldset>
<legend><?php echo TEXT_DISCOUNT_COUPON_ID_INFO; ?></legend>
<div class="form-group">
	<label class="inputLabel" for="lookup-discount-coupon"><?php echo TEXT_DISCOUNT_COUPON_ID; ?></label>
	<?php echo zen_draw_input_field('lookup_discount_coupon', $_POST['lookup_discount_coupon'], 'size="40" id="lookup-discount-coupon"');?>
</div>
</fieldset>
<br class="clearBoth" />
<?php if ($text_coupon_help == '') { ?>
<div class="buttonRow pull-right"><input type="submit" value="<?php echo BUTTON_SEND_ALT; ?>" class="pt-button"></div>
<?php } else { ?>
<div class="buttonRow pull-left"><?php echo '<a href="' . zen_href_link(FILENAME_DISCOUNT_COUPON) . '" class="pt-button">' . BUTTON_CANCEL_ALT . '</a>&nbsp;&nbsp;<input type="submit" value="' . BUTTON_SEND_ALT . '" class="pt-button">'; ?></div>
<?php } ?>
<div class="buttonRow pull-left"><a href="<?php echo zen_back_link(true); ?>" class="pt-button"><?php echo BUTTON_BACK_ALT; ?></a></div>
<br class="clearBoth" />
</form>
</div>
