<?php
/**
 * also_purchased_products.php
 *
 * @package modules
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: also_purchased_products.php 5369 2006-12-23 10:55:52Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
if (isset($_GET['products_id']) && SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS > 0 && MIN_DISPLAY_ALSO_PURCHASED > 0) {

  $also_purchased_products = $db->Execute(sprintf(SQL_ALSO_PURCHASED, (int)$_GET['products_id'], (int)$_GET['products_id']));

  $num_products_ordered = $also_purchased_products->RecordCount();

  $row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';

  // show only when 1 or more and equal to or greater than minimum set in admin
  if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED && $num_products_ordered > 0) {
    if ($num_products_ordered < SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS) {
      $col_width = floor(100/$num_products_ordered);
    } else {
      $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS);
    }

    while (!$also_purchased_products->EOF) {
      $also_purchased_products->fields['products_name'] = zen_get_products_name($also_purchased_products->fields['products_id']);

      $discount = pt_get_discount_amount($also_purchased_products->fields['products_id']);

      if($discount != ''){
        $sticker = '<div class="sale sticker">' . TEXT_SALE . $discount . '</div>';
      }else{
        $sticker = '';
      }

      $category_name = zen_get_categories_name_from_product($also_purchased_products->fields['products_id']);

      $products_rating = pt_get_products_rating($also_purchased_products->fields['products_id']); 

      if($products_rating > 0){
        $ratings = '<span class="product-rating">';
            for($i=1;$i<=5;$i++){
                if($i<=$products_rating){
                    $ratings .= '<i class="fa fa-star filled"></i>';
                }else{
                    $ratings .= '<i class="fa fa-star"></i>';
                }
            }
        $ratings .= '</span>';
      }else{
        $ratings = '';
      }

      $products_price = '<h3 class="product-price">' . zen_get_products_display_price($also_purchased_products->fields['products_id']) . '</h3>';

      if (zen_has_product_attributes($also_purchased_products->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {    
        $product_buynow = zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']);  
        $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_SELECT_OPTIONS_ALT . '</a>';        
      }else{
        $product_buynow = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $also_purchased_products->fields['products_id']);
        $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_IN_CART_ALT . '</a>';
      }

      if(STORE_STATUS != '0'){
        $the_button = '';
      }

      $list_box_contents[$row][$col] = array(
        'params' => 'class="' . ($this_is_home_page ? 'pt-carousel-item' : 'pt-list-item ' . pt_get_product_grid_class($flag_disable_left, $flag_disable_right)) . ' item-standard"',
        'text' => (($also_purchased_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<div class="product-img"><a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '">' . zen_image(DIR_WS_IMAGES . $also_purchased_products->fields['products_image'], $also_purchased_products->fields['products_name'], IMAGE_PRODUCT_NEW_WIDTH, IMAGE_PRODUCT_NEW_HEIGHT, 'class="img-responsive"') . '</a>') . $sticker . '<a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '" class="product-qv" data-toggle="pt-quickview">' . TEXT_QUICKVIEW . '</a></div><div class="product-detail">' . '<h3 class="product-name"><a href="' . zen_href_link(zen_get_info_page($also_purchased_products->fields['products_id']), 'products_id=' . $also_purchased_products->fields['products_id']) . '">' . $also_purchased_products->fields['products_name'] . '</a></h3><h4 class="product-cat">' . $category_name . '</h4>' . $products_price . $the_button .'</div>'
      );

      $col ++;
      if ($col > (SHOW_PRODUCT_INFO_COLUMNS_ALSO_PURCHASED_PRODUCTS - 1)) {
        $col = 0;
        $row ++;
      }
      $also_purchased_products->MoveNext();
    }
  }
  if ($also_purchased_products->RecordCount() > 0 && $also_purchased_products->RecordCount() >= MIN_DISPLAY_ALSO_PURCHASED) {
    $title = '<h2 class="centerBoxHeading">' . TEXT_ALSO_PURCHASED_PRODUCTS . '</h2>';
    $zc_show_also_purchased = true;
  }
}
?>