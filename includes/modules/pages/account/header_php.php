 <?php
/**
 * Header code file for the customer's Account page
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 4824 2006-10-23 21:01:28Z drbyte $
 */
// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ACCOUNT');
$customer_has_gv_balance = false;
$customer_gv_balance = false;

if(!$_SESSION['customer_id']){
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}
$gv_query = "SELECT amount
			FROM " . TABLE_COUPON_GV_CUSTOMER . "
			WHERE customer_id = :customersID";

$gv_query = $db->bindVars($gv_query, ':customersID', $_SESSION['customer_id'], 'integer');
$gv_result = $db->Execute($gv_query);

if($gv_result->RecordCount() && $gv_result->fields['amount'] > 0){
	$customer_has_gv_balance = true;
	$customer_gv_balance = $currencies->format($gv_result->fields['amount']);
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$breadcrumb->add(NAVBAR_TITLE);
$orders_query = "SELECT cd.categories_name,o.orders_id, o.date_purchased, o.delivery_name,o.date_deliver,
							o.delivery_country,o.delivery_street_address,o.delivery_city, o.billing_name, o.billing_country,
							ot.text as order_total, s.orders_status_name,o.orders_status
				FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . "  ot, " . TABLE_ORDERS_STATUS . " s, categories_description cd
				WHERE o.customers_id = :customersID
				AND o.orders_id = ot.orders_id
				AND o.categories_id = cd.categories_id
				AND ot.class = 'ot_total'
				AND o.orders_status = s.orders_status_id
				AND s.language_id = :languagesID
				ORDER BY orders_id DESC LIMIT 3";

$orders_query = $db->bindVars($orders_query, ':customersID', $_SESSION['customer_id'], 'integer');
$orders_query = $db->bindVars($orders_query, ':languagesID', $_SESSION['languages_id'], 'integer');
$orders = $db->Execute($orders_query);

$ordersArray = array();
while (!$orders->EOF) {
	if (zen_not_null($orders->fields['delivery_name'])) {
		$order_name = $orders->fields['delivery_name'];
		$order_country = $orders->fields['delivery_country'];
	} else {
		$order_name = $orders->fields['billing_name'];
		$order_country = $orders->fields['billing_country'];
	}

	$ordersArray[] = array('orders_id'=>$orders->fields['orders_id'],
		'date_purchased'=>$orders->fields['date_purchased'],
		'delivery_city'=>$orders->fields['delivery_city'],
		'delivery_street_address'=>$orders->fields['delivery_street_address'],
		'date_deliver'=>$orders->fields['date_deliver'],
		'orders_status'=>$orders->fields['orders_status'],
		'order_name'=>$order_name,
		'order_country'=>$order_country,
		'categories_name'=>$orders->fields['categories_name'],
		'orders_status_name'=>$orders->fields['orders_status_name'],
		'order_total'=>$orders->fields['order_total']
	);

	$orders->MoveNext();
}

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ACCOUNT');
?>