<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

  $show_price_slider = false;

  if(!zen_has_category_subcategories($current_category_id) && zen_count_products_in_category($current_category_id) > 0 && $current_page_base != 'product_info'){
    $show_price_slider = true;
  }

  if($show_price_slider == true){

    $min = 0;
    $max = pt_get_max_product_price($current_category_id);
    
    if (isset($_GET['pfrom']) && $_GET['pfrom'] != '' && $_GET['pfrom'] >= 0){
      $min_start = $_GET['pfrom'];
    }else{
      $min_start = $min;
    }
    if (isset($_GET['pto']) && $_GET['pto'] != '' && $_GET['pto'] >= 0){
      $max_start = $_GET['pto'];
    }else{
      $max_start = $max;
    }

    $curr = pt_get_currency($_SESSION['currency']);
  
    $title =  TEXT_FILTER_BY_PRICE;
    $title_link = false;

    require($template->get_template_dir('tpl_price_slider.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_price_slider.php');
    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);

  }
