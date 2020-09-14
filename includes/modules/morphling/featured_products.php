<?php
/**
 * featured_products module - prepares content for display
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: featured_products.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = '';
$list_of_products = '';
$featured_products_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = f.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = 1 and f.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
    $featured_products_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id
                                from (" . TABLE_PRODUCTS . " p
                                left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
                                left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id)
                                where p.products_id = f.products_id
                                and p.products_id = pd.products_id
                                and p.products_status = 1 and f.status = 1
                                and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                and p.products_id in (" . $list_of_products . ")";
  }
}
if ($featured_products_query != '') $featured_products = $db->ExecuteRandomMulti($featured_products_query, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($featured_products_query == '') ? 0 : $featured_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS == 0) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS);
  }
  while (!$featured_products->EOF) {
    $category_name = zen_get_categories_name_from_product($featured_products->fields['products_id']);

    if (!isset($productsInCategory[$featured_products->fields['products_id']])) $productsInCategory[$featured_products->fields['products_id']] = zen_get_generated_category_path_rev($featured_products->fields['master_categories_id']);

    $product_path = zen_href_link(zen_get_info_page($featured_products->fields['products_id']), 'cPath=' . $productsInCategory[$featured_products->fields['products_id']] . '&products_id=' . $featured_products->fields['products_id']);
    
    if (zen_has_product_attributes($featured_products->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {    
      $product_buynow = $product_path;  
      $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_SELECT_OPTIONS_ALT . '</a>';        
    }else{
      $product_buynow = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products->fields['products_id']);
      $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_IN_CART_ALT . '</a>';
    }

    $products_price = '<h3 class="product-price">' . zen_get_products_display_price($featured_products->fields['products_id']) . '</h3>';

    $products_rating = pt_get_products_rating($featured_products->fields['products_id']); 

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
    
    $discount = pt_get_discount_amount($featured_products->fields['products_id']);

    if($discount != ''){
      $sticker = '<div class="sale sticker">' . TEXT_SALE . $discount . '</div>';
    }else{
      $sticker = '';
    }

    if(STORE_STATUS != '0'){
      $the_button = '';
    }    

    $list_box_contents[$row][$col] = array(
      'params' => 'class="' . ($this_is_home_page ? 'pt-carousel-item' : 'pt-list-item ' . pt_get_product_grid_class($flag_disable_left, $flag_disable_right)) . ' item-standard"',
      'text' => (($featured_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<div class="product-img"><a href="' . $product_path . '">' . zen_image(DIR_WS_IMAGES . $featured_products->fields['products_image'], $featured_products->fields['products_name'], IMAGE_PRODUCT_NEW_WIDTH, IMAGE_PRODUCT_NEW_HEIGHT, 'class="img-responsive"') . '</a>') . $sticker . '<a href="' . $product_path . '" class="product-qv" data-toggle="pt-quickview">' . TEXT_QUICKVIEW . '</a></div><div class="product-detail">' . '<h3 class="product-name"><a href="' . $product_path . '">' . $featured_products->fields['products_name'] . '</a></h3><h4 class="product-cat">' . $category_name . '</h4>' . $products_price . $the_button .'</div>'
    );

    $col ++;
    if ($col > (SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS - 1)) {
      $col = 0;
      $row ++;
    }
    $featured_products->MoveNextRandom();
  }

  if ($featured_products->RecordCount() > 0) {
    if (isset($new_products_category_id) && $new_products_category_id !=0) {
      $category_title = zen_get_categories_name((int)$new_products_category_id);
      $title = '<h2 class="centerBoxHeading">' . TABLE_HEADING_FEATURED_PRODUCTS . ($category_title != '' ? ' - ' . $category_title : '') . '</h2>';
    } else {
      $title = '<h2 class="centerBoxHeading">' . TABLE_HEADING_FEATURED_PRODUCTS . '</h2>';
    }      
    $zc_show_featured = true;
  }
}
?>