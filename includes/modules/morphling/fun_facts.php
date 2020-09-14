<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

  if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
  }

  $facts = array();

  $customers = $db->Execute("select count(*) as count from " . TABLE_CUSTOMERS);
  $products = $db->Execute("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1'");
  $categories = $db->Execute("select count(*) as count from " . TABLE_CATEGORIES . " where categories_status = '1'");
  $success_order = $db->Execute("select sum(order_total) as total from " . TABLE_ORDERS . " where orders_status = '3'");
  
  $facts = array(
    array(
    'id'    => 'customers',
    'text'  => DEFINE_CUSTOMERS_FACT,  
    'value' => $customers->fields['count']
    )
  );
