<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

// test if box should display
  $show_currencies= true;

  // don't display on checkout page:
  /*if (substr($current_page, 0, 8) != 'checkout') {
    $show_currencies= true;
  }*/

  if ($show_currencies == true) {
    if (isset($currencies) && is_object($currencies)) {

      reset($currencies->currencies);
      $currencies_array = array();
      while (list($key, $value) = each($currencies->currencies)) {
        $currencies_array[] = array('id' => $key, 'title' => $value['title'], 'code' => $value['code'], 'symbol' => $value['symbol_left']);
      }

      $hidden_get_variables = '';
      reset($_GET);
      while (list($key, $value) = each($_GET)) {
        if ( ($key != 'currency') && ($key != zen_session_name()) && ($key != 'x') && ($key != 'y') ) {
          $hidden_get_variables .= zen_draw_hidden_field($key, $value);
        }
      }

      if(count($currencies_array) <=1){
        //do nothing
      }else{
        require($template->get_template_dir('tpl_currencies_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_currencies_header.php');
      }
      
    }
  }
?>