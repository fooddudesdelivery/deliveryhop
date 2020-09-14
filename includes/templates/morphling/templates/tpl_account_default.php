<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account.<br />
 * Displays previous orders and options to change various Customer Account settings
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Sun Aug 5 20:48:10 2012 -0400 Modified in v1.5.1 $
 */
?>
<style>
#lookup-gv-redeem {
	height: 34px;
	vertical-align: middle;
}

#accountLinksWrapper {
	font-size: 18px;
	line-height: 36px;
	}
 
</style>

<div class="centerColumn" id="accountDefault">

<!--<h1 id="accountDefaultHeading" class="page-default-heading"><?php //echo HEADING_TITLE; ?></h1>-->

<?php if ($messageStack->size('account') > 0) echo $messageStack->output('account'); ?>

<?php
    if (zen_count_customer_orders() > 0) {
  ?>
<?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '" class="pt-button pt-button-vs pull-right">' . OVERVIEW_SHOW_ALL_ORDERS . '</a>'; ?>
<div class="clearfix"></div>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="prevOrders">
<!--<caption><p class="important"><?php //echo OVERVIEW_PREVIOUS_ORDERS; ?></p></caption>-->
    <tr class="tableHeading">
    <th style="text-align:center" scope="col"><?php echo TABLE_HEADING_ORDER_NUMBER; ?></th>
        <th style="text-align:center" scope="col">Restaurant</th>
   <!-- <th scope="col"><?php //echo TABLE_HEADING_DATE_ORDER; ?></th>-->
    <th class="hidden-xs" style="text-align:center" scope="col"><?php echo TABLE_HEADING_DATE_DELIVER; ?></th>
    <th class="hidden-xs" scope="col"><?php echo TABLE_HEADING_SHIPPED_TO; ?></th>
    <th style="text-align:center" scope="col"><?php echo TABLE_HEADING_STATUS; ?></th>
    <th style="text-align:center" scope="col"><?php echo TABLE_HEADING_TOTAL; ?></th>
    <th class="hidden-xs" style="text-align:center" scope="col"><?php echo TABLE_HEADING_VIEW; ?></th>
  </tr>
<?php
  foreach($ordersArray as $orders) {
?>
  <tr>
      <td style="text-align:center"><?php echo $orders['orders_id']; ?></td>
 	<!-- <td><?php //echo zm_date($orders['date_purchased']); ?></td>-->
      <td style="text-align:center"><?php echo $orders['categories_name'] ?></td>
    <td class="hidden-xs" style="text-align:center"><?php echo zm_date($orders['date_deliver']); ?> CST</td>
    <td class="hidden-xs"><address><?php echo zen_output_string_protected($orders['order_name']) . '<br />' . $orders['delivery_street_address'].' '.$orders['delivery_city']; ?></address></td>
    <td style="text-align:center"><?php echo zm_determine_visible_status($orders['orders_status']); ?></td>
    <td style="text-align:center"><?php echo $orders['order_total']; ?></td>
    <td class="hidden-xs" style="text-align:center"><?php echo '<a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '" class="pt-button pt-button-vs"> ' . BUTTON_VIEW_SMALL_ALT . '</a>'; ?></td>
  </tr>

<?php
  }
?>
</table>
<?php
  }
?>
<br class="clearBoth" />
<div class="row">
<div id="accountLinksWrapper" class="col-md-4 col-md-offset-1">
<legend><?php echo MY_ACCOUNT_TITLE; ?></legend>
<ul id="myAccountGen">
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . MY_ACCOUNT_HISTORY . '</a>'; ?></li>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . MY_ACCOUNT_INFORMATION . '</a>'; ?></li>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></li>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">' . MY_ACCOUNT_PASSWORD . '</a>'; ?></li>



<?php
  if ((int)ACCOUNT_NEWSLETTER_STATUS > 0 or CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS !='0') {
?>


<?php
  if ((int)ACCOUNT_NEWSLETTER_STATUS > 0) {
?>
<li><?php echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></li>
<?php } //endif newsletter unsubscribe ?>
<?php
  if (CUSTOMERS_PRODUCTS_NOTIFICATION_STATUS == '1') {
?>
<!--<li><?php //echo ' <a href="' . zen_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></li>-->

<?php } //endif product notification ?>
</ul>

<?php } // endif don't show unsubscribe or notification ?>
</div>
<div class='col-md-4 col-md-offset-1'>

<?php
// only show when there is a GV balance
  if ($customer_has_gv_balance ) {
?>
<fieldset class="acct-gift">

<div id="sendSpendWrapper">
<?php require($template->get_template_dir('tpl_modules_send_or_spend.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_send_or_spend.php'); ?>
</div>

</fieldset>
<?php
  }
?>
<fieldset class="acct-gift">
<legend><?php echo REWARD_POINT_TITLE; ?></legend>
<?php
	$total_points=getCustomersRewardPoints($_SESSION['customer_id']);
	if(defined(MODULE_ORDER_TOTAL_REWARD_POINTS_STATUS) && MODULE_ORDER_TOTAL_REWARD_POINTS_STATUS==true)
	{
		$redeem_ratio=GetRedeemRatio($_SESSION['customer_id']);
		$points_value=$currencies->format($total_points*$redeem_ratio);
	}
	else
	 if(defined(MODULE_ORDER_TOTAL_REWARD_POINTS_DISCOUNT_STATUS) && MODULE_ORDER_TOTAL_REWARD_POINTS_DISCOUNT_STATUS==true)
	 {
		$row=GetRewardPointDiscountRow($total_points);
		$value=($row!=null?$row['discount']:0);
		 
		if(MODULE_ORDER_TOTAL_REWARD_POINTS_DISCOUNT_TYPE==0)
		 $points_value=$value."%";
		else
		 $points_value=$currencies->format($value);
	 }
	
	echo '<label class="inputLabel">'.REWARD_POINT_PROMPT.' '. $total_points .'</label>'; 
	echo '<br class="clearBoth" />';
	echo '<label class="inputLabel">'.REWARD_POINT_VALUE_PROMPT.' '. $points_value .'</label>';
?>
</fieldset>


<fieldset class="acct-gift">
<form action="<?php echo zen_href_link(FILENAME_GV_REDEEM, '', 'SSL',
false); ?>" method="get">
<?php echo zen_draw_hidden_field('main_page',FILENAME_GV_REDEEM) .
zen_draw_hidden_field('goback','true') . zen_hide_session_id(); ?>

<legend><?php echo TEXT_GV_REDEEM_INFO; ?></legend>
<label class="inputLabel" for="lookup-gv-redeem"><?php echo
TEXT_GV_REDEEM_ID; ?></label>



<div class="buttonRow forward"><?php echo zen_draw_input_field('gv_no', $_GET['gv_no'], 'size="25"
id="lookup-gv-redeem"');?><?php echo
zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_REDEEM_ALT); ?></div>
</form>
</fieldset>

</div>
</div>

<br class="clearBoth" />
</div>