<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=create-account_success.<br />
 * Displays confirmation that a new account has been created.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_create_account_success_default.php 4886 2006-11-05 09:01:18Z drbyte $
 */
?>
<div class="centerColumn" id="createAcctSuccess">
<h1 id="createAcctSuccessHeading" class="page-default-heading"><?php echo HEADING_TITLE; ?></h1>

<div id="createAcctSuccessMainContent" class="content"><?php echo TEXT_ACCOUNT_CREATED; ?></div>

<?php
if(REWARD_POINTS_NEW_ACCOUNT_REWARD!=0 && isset($RewardPoints))
 if(REWARD_POINTS_NEW_ACCOUNT_REWARD>0 && GetCustomersRewardPoints($_SESSION['customer_id'])==0)
  $RewardPoints->AddRewardPoints($_SESSION['customer_id'],REWARD_POINTS_NEW_ACCOUNT_REWARD);
 else
  if(REWARD_POINTS_NEW_ACCOUNT_REWARD<0 && GetCustomersPendingPoints($_SESSION['customer_id'])==0)
   $RewardPoints->AddPendingPoints($_SESSION['customer_id'],abs(REWARD_POINTS_NEW_ACCOUNT_REWARD));
?>

<fieldset>
<legend><?php echo PRIMARY_ADDRESS_TITLE; ?></legend>
<?php
/**
 * Used to loop thru and display address book entries
 */
  foreach ($addressArray as $addresses) {
?>
<p class="addressBookDefaultName important"><?php echo zen_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></p>

<address><?php echo zen_address_format($addresses['format_id'], $addresses['address'], true, ' ', '<br />'); ?></address>

<div class="buttonRow"><?php echo '<a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL') . '" class="pt-button pt-button-vs"><i class="fa fa-edit"></i> ' . BUTTON_EDIT_SMALL_ALT . '</a> <a href="' . zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete=' . $addresses['address_book_id'], 'SSL') . '" class="pt-button pt-button-vs"><i class="fa fa-trash-o"></i> ' . BUTTON_DELETE_ALT . '</a>'; ?></div>
<?php
  }
?>
</fieldset>

<?php if($_SESSION['cart']->count_contents()>0){  ?>
<div class="buttonRow pull-right"><?php echo '<a href="'.HTTP_SERVER.'?main_page='.FILENAME_CHECKOUT.'" class="pt-button pt-button-m">' . BUTTON_CONTINUE_ALT . ' &rarr;</a>'; ?></div>
<?php }else{ ?>
<div class="buttonRow pull-right"><?php echo '<a href="'.HTTP_SERVER.'?main_page='.FILENAME_DEFAULT.'&l=1" class="pt-button pt-button-m">' . BUTTON_CONTINUE_ALT . ' &rarr;</a>'; ?></div>
<?php  } ?>
<div class="clearfix"></div>
</div>
