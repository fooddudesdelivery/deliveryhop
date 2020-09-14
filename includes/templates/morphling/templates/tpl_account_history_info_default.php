<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_edit.<br />
 * Displays information related to a single specific order
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_history_info_default.php 19103 2011-07-13 18:10:46Z wilt $
 */
?>
<div class="centerColumn" id="accountHistInfo">

<p class="text-right" style="padding-bottom:8px">
<?php
    if(isset($_GET['order_id'])){
        $search = intval($_GET['order_id']);
        if($search>0){
           $lename= $db->Execute("select categories_name from categories_description as cd inner join orders as o on o.categories_id = cd.categories_id where o.orders_id = $search");
            echo 'Restaurant: '.$lename->fields['categories_name'];
        }
    }
    
?>
 <br class="clearBoth" />
<?php //echo HEADING_ORDER_DATE . ' ' . zm_date($order->info['date_purchased']); ?>
<?php echo HEADING_DELIVER_DATE. ' ' . zm_date($order->info['date_deliver']); ?> CST
<br class="clearBoth" />
</p>

<table border="0" width="100%" cellspacing="0" cellpadding="0" summary="Itemized listing of previous order, includes number ordered, items and prices">
    <tr class="tableHeading">
        <th style="text-align:center" width="15%" scope="col" id="myAccountQuantity"><?php echo HEADING_QUANTITY; ?></th>
        <th style="text-align:center" scope="col" id="myAccountProducts"><?php echo HEADING_PRODUCTS; ?></th>
<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>
        <th scope="col" id="myAccountTax"><?php echo HEADING_TAX; ?></th>
<?php
 }
?>
        <th style="text-align:center" width="15%" scope="col" id="myAccountTotal"><?php echo HEADING_TOTAL; ?></th>
    </tr>
<?php
  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
  ?>
    <tr>
        <td style="text-align:center" class="accountQuantityDisplay"><?php echo  $order->products[$i]['qty'] . QUANTITY_SUFFIX; ?></td>
        <td class="accountProductDisplay"><?php echo  $order->products[$i]['name'];

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      echo '<ul id="orderAttribsList">';
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<li>' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])) . '</li>';
      }
        echo '</ul>';
    }
?>
        </td>
<?php
    if (sizeof($order->info['tax_groups']) > 1) {
?>
        <td class="accountTaxDisplay"><?php echo zen_display_tax_value($order->products[$i]['tax']) . '%' ?></td>
<?php
    }
?>
        <td style="text-align:center" class="accountTotalDisplay">
        <?php 
         $ppe = zen_round(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), $currencies->get_decimal_places($order->info['currency']));
         $ppt = $ppe * $order->products[$i]['qty']; 
        //        echo $currencies->format(zen_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : '') 
        echo $currencies->format($ppt, true, $order->info['currency'], $order->info['currency_value']) . ($order->products[$i]['onetime_charges'] != 0 ? '<br />' . $currencies->format(zen_add_tax($order->products[$i]['onetime_charges'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) : ''); 
        ?></td>
    </tr>
<?php
  }
?>
</table>
<br class="clearBoth" />

<div id="orderTotals">
<?php
  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
?>
     <div class="amount totalBox larger forward"><?php echo $order->totals[$i]['text'] ?></div>
     <div class="lineTitle larger forward"><?php echo $order->totals[$i]['title'] ?></div>
<br class="clearBoth" />
<?php
  }
?>

</div>

<?php
/**
 * Used to display any downloads associated with the cutomers account
 */
  if (DOWNLOAD_ENABLED == 'true') require($template->get_template_dir('tpl_modules_downloads.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_downloads.php');
?>


<?php
/**
 * Used to loop thru and display order status information
 */
if (sizeof($statusArray)) {
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" id="myAccountOrdersStatus" summary="Table contains the date, order status and any comments regarding the order">
<caption><center><p id="orderHistoryStatus" class="important"><?php echo HEADING_ORDER_HISTORY; ?></p></center></caption>
    <tr class="tableHeading">
        <th style="text-align:center" width="20%" scope="col" id="myAccountStatusDate"><?php echo TABLE_HEADING_STATUS_DATE; ?></th>
        <th style="text-align:center" width="20%" scope="col" id="myAccountStatus"><?php echo TABLE_HEADING_STATUS_ORDER_STATUS; ?></th>
        <th style="text-align:center" scope="col" id="myAccountStatusComments"><?php echo TABLE_HEADING_STATUS_COMMENTS; ?></th>
       </tr>
<?php

$dont_repeat = array();
  foreach ($statusArray as $statuses) {
	  if(!in_array(zm_determine_visible_status($statuses['orders_status_id']),$dont_repeat)){
	  $dont_repeat[]=zm_determine_visible_status($statuses['orders_status_id']);
?>
    <tr>
        <td style="text-align:center"><?php echo zm_date($statuses['date_added']); ?> CST</td>
        <td style="text-align:center"><?php echo zm_determine_visible_status($statuses['orders_status_id']); ?></td>
        <td style="text-align:center"><?php echo (empty($statuses['comments']) ? '&nbsp;' : nl2br(zen_output_string_protected($statuses['comments']))); ?></td> 
     </tr>
<?php
	  }
  }
?>
</table>
<br>
<?php } ?>

<div class="row">
  <div id="myAccountShipInfo" class="floatingBox col-lg-6">
  <?php
    if ($order->delivery != false) {
  ?>
  <p class="important"><?php echo HEADING_DELIVERY_ADDRESS; ?></p>
  <address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
  <?php
    }
  ?>

  <p class="important"><?php echo HEADING_PAYMENT_METHOD; ?></p>
  <div style="padding-bottom: 20px"><?php echo $order->info['payment_method']; ?></div>

  </div>

  <div id="myAccountPaymentInfo" class="floatingBox col-lg-6">
  <p class="important"><?php echo HEADING_BILLING_ADDRESS; ?></p>
  <address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>

  </div>
</div>

</div>