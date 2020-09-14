<?php
/**
 * upcoming_products module
 *
 * @package modules
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: upcoming_products.php 18923 2011-06-13 03:40:09Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$expected_query = '';

$display_limit = zen_get_upcoming_date_range();

$limit_clause = "  order by " . (EXPECTED_PRODUCTS_FIELD == 'date_expected' ? 'date_expected' : 'products_name') . " " . (EXPECTED_PRODUCTS_SORT == 'asc' ? 'asc' : 'desc') . "
                   limit " . (int)MAX_DISPLAY_UPCOMING_PRODUCTS;

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $expected_query = "select p.products_id, pd.products_name, p.products_image, products_date_available as date_expected, p.master_categories_id
                     from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                     where p.products_id = pd.products_id
                     and p.products_status = 1
                     and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'" .
                     $display_limit .
                     $limit_clause;
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma

    $expected_query = "select p.products_id, pd.products_name, p.products_image, products_date_available as date_expected, p.master_categories_id
                       from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                       where p.products_id = pd.products_id
                       and p.products_id in (" . $list_of_products . ")
                       and p.products_status = 1
                       and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' " .
                       $display_limit .
                       $limit_clause;
  }
}

$row = 0;
$col = 0;
$list_box_contents = array();

if ($expected_query != '') $expected = $db->Execute($expected_query);
if ($expected_query != '' && $expected->RecordCount() > 0) {
  while (!$expected->EOF) {
    if (!isset($productsInCategory[$expected->fields['products_id']])) $productsInCategory[$expected->fields['products_id']] = zen_get_generated_category_path_rev($expected->fields['master_categories_id']);
    $expectedItems[] = $expected->fields;

    $product_path = zen_href_link(zen_get_info_page($expected->fields['products_id']), 'cPath=' . $productsInCategory[$expected->fields['products_id']] . '&products_id=' . $expected->fields['products_id']);

    $discount = pt_get_discount_amount($expected->fields['products_id']);

    if($discount != ''){
      $sticker = '<div class="sale sticker">' . TEXT_SALE . $discount . '</div>';
    }else{
      $sticker = '';
    }

    $category_name = zen_get_categories_name_from_product($expected->fields['products_id']);

    $products_price = '<h3 class="product-price">' . zen_get_products_display_price($expected->fields['products_id']) . '</h3>';

    if (zen_has_product_attributes($expected->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {    
      $product_buynow = $product_path;  
      $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_SELECT_OPTIONS_ALT . '</a>';        
    }else{
      $product_buynow = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $expected->fields['products_id']);
      $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_IN_CART_ALT . '</a>';
    }

    $products_rating = pt_get_products_rating($expected->fields['products_id']); 

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

    if(STORE_STATUS != '0'){
      $the_button = '';
    }

    $list_box_contents[$row][$col] = array(
      'params' => 'class="' . ($this_is_home_page ? 'pt-carousel-item' : 'pt-list-item ' . pt_get_product_grid_class($flag_disable_left, $flag_disable_right)) . ' item-standard"',
      'text' => (($expected->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<div class="product-img"><a href="' . $product_path . '">' . zen_image(DIR_WS_IMAGES . $expected->fields['products_image'], $expected->fields['products_name'], IMAGE_PRODUCT_NEW_WIDTH, IMAGE_PRODUCT_NEW_HEIGHT, 'class="img-responsive"') . '</a>') . $sticker . '<a href="' . $product_path . '" class="product-qv" data-toggle="pt-quickview">' . TEXT_QUICKVIEW . '</a></div><div class="product-detail">' . '<h3 class="product-name"><a href="' . $product_path . '">' . $expected->fields['products_name'] . '</a></h3><h4 class="product-cat">' . $category_name . '</h4>' . $products_price . $the_button .'</div>'
    );

    $col ++;

    $expected->MoveNext();
  }
  //require($template->get_template_dir('tpl_modules_upcoming_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_upcoming_products.php');
}
