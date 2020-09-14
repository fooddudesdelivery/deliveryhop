<?php
/**
 * ot_total order-total module
 *
 * @package orderTotal
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ot_servicefee.php 6101 2012-10-19 10:30:22Z ajeh $
 */
  class ot_servicefee {
    var $title, $output;

    function ot_servicefee() {
      $this->code = 'ot_servicefee';
      $this->title = MODULE_ORDER_TOTAL_SERVICEFEE_TITLE;
      $this->description = MODULE_ORDER_TOTAL_SERVICEFEE_DESCRIPTION;
      $this->sort_order = MODULE_ORDER_TOTAL_SERVICEFEE_SORT_ORDER;

      $this->output = array();
    }

    function process() {
      global $order, $currencies;

      if (MODULE_ORDER_TOTAL_SERVICEFEE_ORDER_FEE == 'true' && $_SESSION['fooddudestaging_login']==1) {

      $pass = true;
	  
      if (MODULE_ORDER_TOTAL_SERVICEFEE_ZONE > 0) {
// bof: check zone and add extra fee
        global $db;
        $pass = false;
        $check_flag = false;
// based on Delivery zone $order->delivery to use Payment zone change to $order->billing in two places
        $check = $db->Execute("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_ORDER_TOTAL_SERVICEFEE_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while (!$check->EOF) {
          if ($check->fields['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check->fields['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
          $check->MoveNext();
        }

        if ($check_flag == false) {
          $pass = false;
        } else {
          $pass = true;
        }
// eof: check zone and add extra fee
      }

        if ($pass == true) {
//echo 'TEST EXTRA CHARGE PASS!';
            $tax_address = zen_get_tax_locations();
            $tax = zen_get_tax_rate(MODULE_ORDER_TOTAL_SERVICEFEE_TAX_CLASS, $tax_address['country_id'], $tax_address['zone_id']);
            $tax_description = zen_get_tax_description(MODULE_ORDER_TOTAL_SERVICEFEE_TAX_CLASS, $tax_address['country_id'], $tax_address['zone_id']);

// calculate from flat fee or percentage
            if (substr(MODULE_ORDER_TOTAL_SERVICEFEE_FEE, -1) == '%') {
              $order_fee = ($order->info['subtotal'] * (MODULE_ORDER_TOTAL_SERVICEFEE_FEE/100));
            } else {
              $order_fee = MODULE_ORDER_TOTAL_SERVICEFEE_FEE;
            }

            $order->info['tax'] += zen_calculate_tax($order_fee, $tax);
            $order->info['tax_groups']["$tax_description"] += zen_calculate_tax($order_fee, $tax);
            $order->info['total'] += $order_fee + zen_calculate_tax($order_fee, $tax);
            if (DISPLAY_PRICE_WITH_TAX == 'true') {
              $order_fee += zen_calculate_tax($order_fee, $tax);
            }

            $this->output[] = array('title' => $this->title . ':',
                                    'text' => $currencies->format($order_fee, true, $order->info['currency'], $order->info['currency_value']),
                                    'value' => $order_fee);
        } else {
//echo 'TEST EXTRA CHARGE NO PASS!';
        }
      }
    }

    function check() {
	  global $db;
      if (!isset($this->_check)) {
        $check_query = "select configuration_value
                        from " . TABLE_CONFIGURATION . "
                        where configuration_key = 'MODULE_ORDER_TOTAL_SERVICEFEE_STATUS'";

        $check_query = $db->Execute($check_query);
        $this->_check = $check_query->RecordCount();
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_SERVICEFEE_STATUS', 'MODULE_ORDER_TOTAL_SERVICEFEE_SORT_ORDER', 'MODULE_ORDER_TOTAL_SERVICEFEE_ORDER_FEE', 'MODULE_ORDER_TOTAL_SERVICEFEE_FEE', 'MODULE_ORDER_TOTAL_SERVICEFEE_TAX_CLASS', 'MODULE_ORDER_TOTAL_SERVICEFEE_ZONE');
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('This module is installed', 'MODULE_ORDER_TOTAL_SERVICEFEE_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_SERVICEFEE_SORT_ORDER', '450', 'Sort order of display.', '6', '2', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Allow Service Fee', 'MODULE_ORDER_TOTAL_SERVICEFEE_ORDER_FEE', 'false', 'Do you want to allow service fees?', '6', '3', 'zen_cfg_select_option(array(\'true\', \'false\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, date_added) values ('Service Fee', 'MODULE_ORDER_TOTAL_SERVICEFEE_FEE', '5.00', 'For Percentage Calculation - include a % Example: 10%<br />For a flat amount just enter the amount - Example: 5 for $5.00', '6', '5', '', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_ORDER_TOTAL_SERVICEFEE_TAX_CLASS', '0', 'Use the following tax class on the service fee.', '6', '7', 'zen_get_tax_class_title', 'zen_cfg_pull_down_tax_classes(', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Extra Charge Zone', 'MODULE_ORDER_TOTAL_SERVICEFEE_ZONE', '0', 'If a zone is selected, only enable this Extra charge for that zone.', '6', '0', 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(', now())");
    }

    function remove() {
      global $db;
      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key like 'MODULE\_ORDER\_TOTAL\_SERVICEFEE\_%'");

    }
  }
