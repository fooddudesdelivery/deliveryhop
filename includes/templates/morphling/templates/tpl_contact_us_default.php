<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=contact_us.<br />
 * Displays contact us page form.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Sun Aug 19 09:47:29 2012 -0400 Modified in v1.5.1 $
 */
?>
<style>
	#contact_label{
		width:400px;
		font-weight:300;
	}
</style>
<div class="centerColumn" id="contactUsDefault">
	<?php
	if ($messageStack->size('contact') > 0) echo $messageStack->output('contact');
	echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send'));
		if(CONTACT_US_STORE_NAME_ADDRESS=='1'){ ?>
			<address><?php echo nl2br(STORE_NAME_ADDRESS); ?></address>
		<?php
		} ?>
		<?php
		if(isset($_GET['action']) && ($_GET['action']=='success')){ ?>
			<script>
				$(document).ready(function(e) {
					setTimeout(function(){
						window.location.replace("<?php echo HTTP_SERVER ?>");
					},5000);
				});
			</script>
			<div style="font-size:18px"><?php echo TEXT_SUCCESS; ?></div>
			<br class="clearBoth" />
			<div class="buttonRow"></div>
		<?php
		}else{
			if(DEFINE_CONTACT_US_STATUS>='1' and DEFINE_CONTACT_US_STATUS<='2'){ ?>
				<div id="contactUsNoticeContent" class="content">
					<?php
						/**
						 * require html_define for the contact_us page
						 */
						require($define_page);
					?>
				</div>
			<?php
			} ?>
			<div class='container'>
				<legend><?php echo HEADING_TITLE; ?></legend>
				<div class="alert forward hiddenField"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
			<?php
				// show dropdown if set
				if(CONTACT_US_LIST!=''){?>
					<label id="contact_label" class="inputLabel" for="send-to"><?php echo SEND_TO_TEXT; ?>
						<?php echo zen_draw_pull_down_menu('send_to',  $send_to_array, 0, 'id="send-to" class="form-control" ') . '<span class="alert hiddenField">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
					</label>
					<br class="clearBoth" />
			<?php
				}
			?>
			<label id="contact_label" class="inputLabel" for="contactname"><?php echo ENTRY_NAME; ?>
				<?php echo zen_draw_input_field('contactname', $name, ' size="40" id="contactname" class="form-control" ') . '<span class="alert hiddenField">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
			</label>
			<br class="clearBoth" />

			<label id="contact_label" class="inputLabel" for="email-address"><?php echo ENTRY_EMAIL; ?>
				<?php echo zen_draw_input_field('email', ($email_address), ' size="40" id="email-address" class="form-control" ') . '<span class="alert hiddenField">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
			</label>
			<br class="clearBoth" />

			<label id="contact_label" class="inputLabel" for="phonenumber" ><?php echo ENTRY_PHONE; ?>
				<?php echo zen_draw_input_field('phonenumber', $phone, ' size="40" id="phonenumber" class="form-control" '); ?>
			</label>
			<br class="clearBoth" />

			<label id="contact_label" class="inputLabel" for="enquiry"><?php echo ENTRY_ENQUIRY . '<span class="alert hiddenField">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
				<?php echo zen_draw_textarea_field('enquiry', '38', '5', $enquiry, 'id="enquiry" class="form-control"'); ?>
				<?php echo zen_draw_input_field('should_be_empty', '', ' size="40" id="CUAS" class="form-control" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
			</label>
			<br class="clearBoth" />
			<div class="buttonRow back"><?php echo recaptcha_get_html(); ?></div>
			<div class="buttonRow back"><?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?></div>
		<?php
		}?>
	</form>
</div>