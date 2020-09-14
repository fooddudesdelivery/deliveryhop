<?php
/**
 * Specials
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: main_template_vars.php 18802 2011-05-25 20:23:34Z drbyte $
 */

if (MAX_DISPLAY_SPECIAL_PRODUCTS > 0 ) {
  $specials_query_raw = "SELECT p.products_id, p.products_image, pd.products_name,
                          p.master_categories_id
                         FROM (" . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id and p.products_id = pd.products_id and p.products_status = '1'
                         AND s.status = 1
                         AND pd.language_id = :languagesID
                         ORDER BY s.specials_date_added DESC";

  $specials_query_raw = $db->bindVars($specials_query_raw, ':languagesID', $_SESSION['languages_id'], 'integer');
  $specials_split = new splitPageResults($specials_query_raw, MAX_DISPLAY_SPECIAL_PRODUCTS);
  $specials = $db->Execute($specials_split->sql_query);
  $row = 0;
  $col = 0;
  $list_box_contents = array();
  $title = '';

  $num_products_count = $specials->RecordCount();
  if ($num_products_count) {
    if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS==0 ) {
      $col_width = floor(100/$num_products_count);
    } else {
      $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS);
    }

    $list_box_contents = array();
    while (!$specials->EOF) {

      $category_name = zen_get_categories_name_from_product($specials->fields['products_id']);

      $product_path = zen_href_link(zen_get_info_page($specials->fields['products_id']), 'cPath=' . zen_get_generated_category_path_rev($specials->fields['master_categories_id']) . '&products_id=' . $specials->fields['products_id']);
      
      if (zen_has_product_attributes($specials->fields['products_id']) or PRODUCT_LIST_PRICE_BUY_NOW == '0') {    
        $product_buynow = $product_path;     
        $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_SELECT_OPTIONS_ALT . '</a>';     
      }else{
        $product_buynow = zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $specials->fields['products_id']);
        $the_button = '<a href="' . $product_buynow . '" class="pt-button pt-button-vs">' . BUTTON_IN_CART_ALT . '</a>';
      }

      $products_price = '<h3 class="product-price">' . zen_get_products_display_price($specials->fields['products_id']) . '</h3>';

      $products_rating = pt_get_products_rating($specials->fields['products_id']); 

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

      $discount = pt_get_discount_amount($specials->fields['products_id']);

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
        'text' => (($specials->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : '<div class="product-img"><a href="' . $product_path . '">' . zen_image(DIR_WS_IMAGES . $specials->fields['products_image'], $specials->fields['products_name'], IMAGE_PRODUCT_NEW_WIDTH, IMAGE_PRODUCT_NEW_HEIGHT, 'class="img-responsive"') . '</a>') . $sticker . '<a href="' . $product_path . '" class="product-qv" data-toggle="pt-quickview">' . TEXT_QUICKVIEW . '</a></div><div class="product-detail">' . '<h3 class="product-name"><a href="' . $product_path . '">' . $specials->fields['products_name'] . '</a></h3><h4 class="product-cat">' . $category_name . '</h4>' . $products_price . $the_button .'</div>'
      );

      $col ++;
      if ($col > (SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS - 1)) {
        $col = 0;
        $row ++;
      }
      $specials->MoveNext();
    }
    require($template->get_template_dir('tpl_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_specials_default.php');
  }
}
