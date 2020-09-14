<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=address_book_process.<br />
 * Allows customer to add a new address book entry
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_process_default.php 18695 2011-05-04 05:24:19Z drbyte $
 */
?>
<div class="centerColumn" id="addressBookProcessDefault">
<?php if (!isset($_GET['delete'])) echo zen_draw_form('addressbook', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL'), 'post', 'onsubmit="return check_form(addressbook);"'); ?>
      

<h1 id="addressBookProcessDefaultHeading" class="page-default-heading"><?php if (isset($_GET['edit'])) { echo HEADING_TITLE_MODIFY_ENTRY; } elseif (isset($_GET['delete'])) { echo HEADING_TITLE_DELETE_ENTRY; } else { echo HEADING_TITLE_ADD_ENTRY; } ?></h1>
    
<?php if ($messageStack->size('addressbook') > 0) echo $messageStack->output('addressbook'); ?>    

<?php
  if (isset($_GET['delete'])) {
?>
<p class="text-danger"><?php echo DELETE_ADDRESS_DESCRIPTION; ?></p>

<address><?php echo zen_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'); ?></address>
<br class="clearBoth" />
 

<div class="buttonRow pull-left">
<?php echo zen_draw_form('delete_address', zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'action=deleteconfirm', 'SSL'), 'post'); ?>
<?php echo zen_draw_hidden_field('delete', $_GET['delete']); ?>
<input type="submit" value="<?php echo BUTTON_DELETE_ALT; ?>" class="pt-button pt-button-vs">
</form>
</div>
<!--<div class="buttonRow pull-left"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '" class="pt-button pt-button-vs">' . BUTTON_BACK_ALT . '</a>'; ?></div>-->
<?php
  } else {
?>
<?php
/**
 * Used to display address book entry form
 */
?>
<?php   require($template->get_template_dir('tpl_modules_address_book_details.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_address_book_details.php'); ?>

<br class="clearBoth" />
<?php
    if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
?>
<div class="buttonRow pull-left">
	<?php echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']); ?>
	<input type="submit" class="pt-button pt-button-vs" value="<?php echo BUTTON_UPDATE_ALT; ?>">
</div>
<!--<div class="buttonRow pull-left"><?php //echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '" class="pt-button pt-button-vs">&larr; ' . BUTTON_BACK_ALT . '</a>'; ?></div>-->
    
<?php
    } else {
?>
<div class="buttonRow pull-left">
	<?php echo zen_draw_hidden_field('action', 'process'); ?>
	<input type="submit" value="<?php echo BUTTON_SUBMIT_ALT; ?>" class="pt-button">
</div>
<!--<div class="buttonRow pull-left"><a href="<?php //echo zen_back_link(true); ?>" class="pt-button"><?php echo BUTTON_BACK_ALT; ?></a></div>-->
<?php
    }
  }
?>
<?php if (!isset($_GET['delete'])) echo '</form>'; ?>
</div>