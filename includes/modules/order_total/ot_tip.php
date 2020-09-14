<?php
/**
 * ot_tip order-total module
 *
 * @package orderTotal
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @copyright Portions Copyright (c) 2002 Thomas Plänkers http://www.oscommerce.at
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ot_tip.php  2009-07-23 Neville Kerr $
 */
/**
 * Tip Order Totals Module
 *
 */

  class ot_tip {
    var $title, $output;

    function ot_tip() {
      $this->code = 'ot_tip';
      $this->title = MODULE_ORDER_TOTAL_TIP_TITLE;
      $this->description = MODULE_ORDER_TOTAL_TIP_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_TIP_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_TIP_SORT_ORDER;

      $this->output = array();
    }

    function process() {
      global $order, $currencies;
		if($_SESSION['is_gift_card'] || $_SESSION['is_gift_card_non_rewards']){
			return;
		}
      if (MODULE_ORDER_TOTAL_TIP_STATUS == 'true') {
		if(isset($_POST['update_total'])){
			$update=$_POST['update_total'];
			foreach($update as $up){
				if($up['code']=='ot_tip'){
					$_SESSION['add_tip']=$up['value'];
				}
			}
		}
		if(!isset($_SESSION['add_tip'])){
			$_SESSION['add_tip']=0;
		}
        if (isset($_SESSION['add_tip'])) {
		$_SESSION['add_tip'] = money_format('%i',$_SESSION['add_tip']);
          $order->info['total'] += $_SESSION['add_tip'];
		   
		  $this->output[] = array('title' => $this->title . ':',
                                  'text' => $currencies->format($_SESSION['add_tip'], true,  $order->info['currency'], $order->info['currency_value']),
                                  'value' => $_SESSION['add_tip']);
								  
        }
		
	  } 

    }

    function check() {
      global $db;
      if (!isset($this->_check)) {
        $check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_TIP_STATUS'");
        $this->_check = $check_query->RecordCount();
      }

      return $this->_check;
    }
//lagt tilk servicepakke her!!!!
    function keys() {
      return array('MODULE_ORDER_TOTAL_TIP_STATUS', 'MODULE_ORDER_TOTAL_TIP_SORT_ORDER');
    }

    function install() {
      global $db;
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Tip', 'MODULE_ORDER_TOTAL_TIP_STATUS', 'true', 'Do you want this module to display?', '6', '1','zen_cfg_select_option(array(\'true\', \'false\'), ', now())");
      $db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_TIP_SORT_ORDER', '950', 'Sort order of display.', '6', '2', now())");
    }


    function remove() {
      global $db;
      $keys = '';
      $keys_array = $this->keys();
      $keys_size = sizeof($keys_array);
      for ($i=0; $i<$keys_size; $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      $db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }
  }
?>
