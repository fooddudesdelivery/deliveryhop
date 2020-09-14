<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

function pt_get_framework_config($key = 'PT_COMMON_SETTINGS'){
  global $db;
  $config = array();
  $config_sql = $db->Execute("select config_key, config_value
                             from " . TABLE_PT_FRAMEWORK . " 
                             where config_key = '" . $key . "'");
  if($config_sql->RecordCount() > 0){
    while (!$config_sql->EOF) {
      $config[] = array(
                    'config_key'   => $config_sql->fields['config_key'],
                    'config_value' => $config_sql->fields['config_value']
                  );
      $config_sql->MoveNext();
    }
  }

  return $config[0]['config_value'];
}

function pt_parse_framework_config($data = ''){
  $config_array = json_decode($data, true);

  return $config_array;
}

function pt_get_menu($menu_id = ''){

  $data = pt_get_framework_config('PT_MENU_LOCATION_' . $menu_id);
  $content = pt_parse_framework_config($data);
	//print_r($content);
  return $content['menu_item'];

}

function pt_get_currency($code = ''){
  global $db;
  $code = zen_db_prepare_input($code);

  if($code == ''){
    $currency_sql = "select *
                    from " . TABLE_CURRENCIES;
  }else{
    $currency_sql = "select *
                    from " . TABLE_CURRENCIES . "
                    where code = '" . $code . "' LIMIT 1";
  }

    $currency = $db->Execute($currency_sql);

    return $currency->fields;
}

function pt_get_default_currency(){
  global $db;

  $currency_sql = "select *
                    from " . TABLE_CURRENCIES . "
                    where value = 1";

  $currency = $db->Execute($currency_sql);

  return $currency->fields;

}

function pt_get_language_code($id = '') {
  global $db;

  $check_language= $db->Execute("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$id . "'");

  return $check_language->fields['code'];

}

function pt_get_language_name($id = '') {
  global $db;

  $check_language= $db->Execute("select name from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$id . "'");

  return $check_language->fields['name'];

}

function pt_get_slider(){

  //$slides   = pt_get_slider_slide();
  //$layers  = pt_get_slider_layer();

//  $content = '<section class="pt-slider ">';
//
//    $content .= '<div class="pt-slider-inner image-container">';
//	

if (is_this_ie()=='no'){
	
	$content.='
<div class="front-img-far-outer">
<div class="front-img-outer">
    <div class="front-img-inner">
        <img src="images/pepper/background_index.jpg">
    </div>
</div>
</div>
';


}else{
	  $content.='
<div class="front-img-far-outer-ie">
<div class="front-img-outer-ie">
    <div class="front-img-inner-ie">
        <img src="images/pepper/background_index.jpg">
    </div>
</div>
</div>
';
	
	
}

		//$content.= '<img src="images/pepper/food2%20%281%29.jpg">';
//      $content .= '<ul>';
//
//      if(is_array($slides['pt_slide'])){
//        foreach ($slides['pt_slide'] as $key => $slide) {
//          $content .= '<li id="slide-' . $slide['id'] . '" data-transition="' . $slide['transition'] . '" data-slotamount="' . $slide['slot'] . '" data-masterspeed="' . $slide['duration'] . '"' . ($slide['delay'] > 0 ? ' data-delay="' . $slide['delay'] . '"' : '') . '>';
//          if($slide['bg_img'] == ''){
//            $content .= '<img src="' . DIR_WS_TEMPLATE_IMAGES . 'transparent.png" alt="" style="background-color:' . $slide['bg_color'] . '">';
//          }else{
//            $content .= '<img src="' . $slide['bg_img'] . '" alt="" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">';
//          }
//          if(is_array($layers['pt_layer'])){
//            foreach ($layers['pt_layer'] as $layer) {
//              if($layer['parent_id'] == $slide['id']){
//                $content .= '<div id="layer-' . $layer['id'] . '" class="tp-caption ' . $layer['animation'] . ' ' . pt_get_animation_out($layer['animation']) . ' tp-resizeme" data-start="' . $layer['start'] . '" ' . ($layer['end'] != '' ? 'data-end="' . $layer['end'] . '" ' : '') . 'data-x="' . (($layer['layer_x'] != 'undefined' && $layer['layer_x'] != 'custom') ? $layer['layer_x'] : $layer['layer_x_custom']) . '" data-y="' . (($layer['layer_y'] != 'undefined' && $layer['layer_y'] != 'custom')  ? $layer['layer_y'] : $layer['layer_y_custom']) . '" data-easing="' . $layer['easing'] . '" data-speed="' . $layer['speed'] . '" style="color:' . $layer['color'] . ';background-color:' . $layer['bg_color'] . ';">';
//                if($layer['img'] == ''){
//                  $content .= zen_decode_specialchars($layer['content']);
//                }else{
//                  $content .= '<img src="' . $layer['img'] . '" alt="layer' . $layer['id'] . 'img" class="img-responsive">';
//                }
//                $content .= '</div>';
//              }
//            }
//          }
//          $content .= '</li>';
//        }
//      }
//
//      $content .= '</ul>';
//    $content .= '</div>';
//  $content .= '</section>' . "\n";

  return $content;
}

function pt_get_slider_slide(){

  $data = pt_get_framework_config('PT_SLIDER_SLIDE');
  $slides = pt_parse_framework_config($data);

  return $slides; 

}

function pt_get_slider_layer(){

  $data = pt_get_framework_config('PT_SLIDER_LAYER');
  $layers = pt_parse_framework_config($data);

  return $layers; 
  
}

function pt_get_animation_out($in = ''){

  $out = array(
    'sft'               => 'stt',
    'sfb'               => 'stb',
    'sfr'               => 'str',
    'sfl'               => 'stl',
    'lft'               => 'ltt',
    'lfb'               => 'ltb',
    'lfr'               => 'ltr',
    'lfl'               => 'ltl',
    'skewfromleft'      => 'skewtoleft',
    'skewfromright'     => 'skewtoright',
    'skewfromleftshort' => 'skewtoleftshort',
    'skewfromrightshort'=> 'skewtorightshort',
    'fade'              => 'fadeout',
    'randomrotate'      => 'randomrotateout'
  );   

  return $out[$in];

}

function pt_get_products_rating($pid = '') {
  global $db;
  $rating_query = $db->Execute("SELECT avg(reviews_rating) as avg 
                               from " . TABLE_REVIEWS . " r
                               where products_id='" . (int)$pid . "' limit 1");
  if ($rating_query->EOF) {
    return 0;
  } else {
    return round($rating_query->fields['avg']);
  }
}

function pt_get_products_rating_count($pid = '') {
  global $db;
  $rating_query = $db->Execute("SELECT count(reviews_rating) as count 
                               from " . TABLE_REVIEWS . " r
                               where products_id='" . (int)$pid . "' limit 1");
  if ($rating_query->EOF) {
    return 0;
  } else {
    return $rating_query->fields['count'];
  }
}

function pt_get_blocks_config($id = ''){

  $blocks = pt_parse_framework_config(pt_get_framework_config('PT_HOME_BLOCKS'));
  $data = array();

  foreach ($blocks['block_contents'] as $key => $value) {
    if($key == $id){
      $data = $value;
    }
  }

  return $data;

}

// Price Functions Improvement
function pt_get_discount_amount($products_id) {
  global $db, $currencies;

  $show_sale_discount = '';

  $display_normal_price = zen_get_products_base_price($products_id);
  $display_special_price = zen_get_products_special_price($products_id, true);
  $display_sale_price = zen_get_products_special_price($products_id, false);

  if (SHOW_SALE_DISCOUNT_STATUS == '1' and ($display_special_price != 0 or $display_sale_price != 0)) {
    if ($display_sale_price) {
      if (SHOW_SALE_DISCOUNT == 1) {
        if ($display_normal_price != 0) {
          $show_discount_amount = number_format(100 - (($display_sale_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS);
        } else {
          $show_discount_amount = '';
        }
        $show_sale_discount = $show_discount_amount . PRODUCT_PRICE_DISCOUNT_PERCENTAGE;

      } else {
        $show_sale_discount = $currencies->display_price(($display_normal_price - $display_sale_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT;
      }
    } else {
      if (SHOW_SALE_DISCOUNT == 1) {
        $show_sale_discount = number_format(100 - (($display_special_price / $display_normal_price) * 100),SHOW_SALE_DISCOUNT_DECIMALS) . PRODUCT_PRICE_DISCOUNT_PERCENTAGE;
      } else {
        $show_sale_discount = $currencies->display_price(($display_normal_price - $display_special_price), zen_get_tax_rate($product_check->fields['products_tax_class_id'])) . PRODUCT_PRICE_DISCOUNT_AMOUNT;
      }
    }
  }

  return $show_sale_discount;

}

function pt_get_full_product_url($pid = ''){

  $product_path = zen_href_link(zen_get_info_page($pid), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id($pid)) . '&products_id=' . $pid);

  return $product_path;

}


function pt_get_full_categories_url($pid = ''){

  $product_path = zen_href_link(FILENAME_DEFAULT, 'cPath=' . zen_get_generated_category_path_rev($pid) );

  return $product_path;

}
function pt_get_suggestion_markup($pid = ''){

  $content = '';

  $content .= '<div class="product-suggestion">';
    $content .= '<a href="' . pt_get_full_product_url($pid) . '" class="products-link"><span class="products-img">' . zen_image(DIR_WS_IMAGES . pt_get_products_image($pid), zen_get_products_name($pid), 60, 60) . '</span>';
      $content .= '<div class="products-name">' . zen_get_products_name($pid) . '</div>';
      $content .= '<div class="products-price">' . zen_get_products_display_price((int)$pid) . '</div>';
    $content .= '</a><div class="clearfix"></div>';
  $content .= '</div>'; 

  return $content;

}
function pt_get_suggestion_markup_categories($pid = ''){

  $content = '';

  $content .= '<div class="product-suggestion">';
    $content .= '<a href="' . pt_get_full_categories_url($pid) . '" class="products-link"><span class="products-img">' . zen_image(DIR_WS_IMAGES . zen_get_categories_image($pid), zen_get_categories_name($pid), 60, 60) . '</span>';
      $content .= '<div class="products-name">' . zen_get_categories_name($pid) . '</div>';
    $content .= '</a><div class="clearfix"></div>';
  $content .= '</div>'; 

  return $content;

}
function pt_get_products_image($pid = ''){
  global $db;

  $image_query = "select p.products_image
                 from   " . TABLE_PRODUCTS . " p
                 where  p.products_status = '1'
                 and    p.products_id = '" . (int)$pid . "'";
  $image = $db->Execute($image_query);

  return $image->fields['products_image'];

}

function pt_handle_ajax_search($query = '', $language = ''){
  global $db;

  $query = zen_db_prepare_input($query);
  $data = array();

  $no_result = '';
  $no_result .= '<div class="product-suggestion">';
    $no_result .= '<div class="no-products-icon"><i class="fa fa-search"></i></div>';
    $no_result .= '<p class="no-products-text">There is no product that matches the search criteria. You could try an <a href="' . zen_href_link(FILENAME_ADVANCED_SEARCH) . '">' . BOX_SEARCH_ADVANCED_SEARCH . '</a></p>';
  $no_result .= '</div>';

  if (empty($language)) $language = $_SESSION['languages_id'];

//  $product_query = "select p.products_id, pd.products_id, pd.products_name  
//                      from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p  
//                      where pd.products_name LIKE '%" . $query . "%'
//                      and p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$language . "' LIMIT 0,4";
// zm edit
  $product_query = "select p.categories_id as products_id, pd.categories_name  
                      from " . TABLE_CATEGORIES_DESCRIPTION . " pd, " . TABLE_CATEGORIES . " p  
                      where pd.categories_name LIKE '%" . $query . "%'
                      and p.categories_status = '1' and pd.categories_id = p.categories_id and pd.language_id = '" . (int)$language . "' and p.categories_id not in ('1','2','3','4','5') LIMIT 0,4";


  $product = $db->Execute($product_query);

  if($product->RecordCount() > 0) {
    while (!$product->EOF) {
      $data['query'] = $query;
      $data['suggestions'][] = array(
        'value' => pt_get_suggestion_markup_categories($product->fields['products_id']),
        'data'  => htmlspecialchars_decode(pt_get_full_categories_url($product->fields['products_id']))
      );
      $product->MoveNext();
    }
  }else{
      $data['query'] = $query;
      $data['suggestions'][] = array(
        'value' => $no_result,
        'data'  => htmlspecialchars_decode(zen_href_link(FILENAME_ADVANCED_SEARCH))
      );
  }

  return $data;

}

function pt_get_custom_style(){

  $style = '';

  $data_blocks = pt_get_framework_config('PT_HOME_BLOCKS');
  $blocks = pt_parse_framework_config($data_blocks);
  $themes_setting = pt_get_framework_config();
  $data_themes = pt_parse_framework_config($themes_setting);

  /* Layout */
  if($data_themes['pt_container_type'] == 'boxed'){
    if($data_themes['pt_bodybg_img'] != ''){
      $style .= 'body.boxed { background-image: url(' . $data_themes['pt_bodybg_img'] . ') } ';
      $style .= 'body.boxed { background-repeat: ' . $data_themes['pt_bodybg_repeat'] . ' } ';
      if($data_themes['pt_bodybg_cover'] == 'true'){
        $style .= 'body.boxed { -webkit-background-size:cover; -moz-background-size:cover; background-size:cover; } ';
      }
      if($data_themes['pt_bodybg_fixed'] == 'true'){
        $style .= 'body.boxed { background-attachment:fixed; } ';
      }
    }else{
      $style .= 'body.boxed { background-color: ' . ($data_themes['pt_bodybg_color'] != '' ? $data_themes['pt_bodybg_color'] : '#fff') . ' } ';
    }
  }

  if(is_array($blocks['block_contents'])){
    foreach ($blocks['block_contents'] as $key => $value) {
      if($value['nav_color'] != '' || $value['nav_color_hover'] != ''){
        $style .= '.' . $key . ' .owl-prev,' . '.' . $key . ' .owl-next {';
          $style .= 'color: ' . $value['nav_color'] . ';';     
        $style .= '}';

        $style .= '.' . $key . ':hover .owl-prev.disabled,'; 
        $style .= '.' . $key . ':hover .owl-next.disabled,'; 
        $style .= '.' . $key . ':hover .owl-prev.disabled:hover,'; 
        $style .= '.' . $key . ':hover .owl-next.disabled:hover {';
          $style .= 'color: ' . $value['nav_color'] . ';';
        $style .= '}';

        $style .= '.' . $key . ' .owl-prev:hover,';
        $style .= '.' . $key . ' .owl-next:hover {';
          $style .= 'color: ' . $value['nav_color_hover'] . ';';
        $style .= '}';
      }
    }
  }

  /* Font Face */
  if($data_themes['pt_heading_fontface'] != '' && $data_themes['pt_heading_fontface'] != 'Arvo'){
    $style .= 'legend,.heading-font,.logo,.pt_shop_feature4-text h3,.pt_shop_feature3-text h3,.section-content .section-title,.section-title .centerBoxHeading, 
              .product-carousel .product-name,.product-list .product-name,.product-carousel .item-boxed .product-name,.product-list .item-boxed .product-name, 
              .widget-title,.product-info-detail-inner #productName,.product-list-widget .products-name,.cart-qty-input,.page-default-heading,#cartContentsDisplay .cartProductDisplay .products-name, 
              .pt-shipping-method .shipping-detail label,.pt-shipping-method .shipping-quote,.tweet-carousel .tweet-text {font-family: ' . $data_themes['pt_heading_fontface'] . ', Arial, Helvetica, sans-serif }';
  }

  if($data_themes['pt_content_fontface'] != '' && $data_themes['pt_content_fontface'] != 'Lato'){
    $style .= 'body,h1,h2,h3,h4,h5 {font-family: ' . $data_themes['pt_content_fontface'] . ', Arial, Helvetica, sans-serif }';
  }

  /* Header */
  if($data_themes['pt_top_header_bg'] != '#ffffff'){
    $style .= '.nav-top { background: ' . $data_themes['pt_top_header_bg'] . '}';
  }
  if($data_themes['pt_top_header_border'] != '#e9e9e9'){
    $style .= '.nav-top { border-bottom: 1px solid ' . $data_themes['pt_top_header_border'] . '}';
  }
  if($data_themes['pt_top_header_color'] != '#393939'){
    $style .= '.nav-top { color: ' . $data_themes['pt_top_header_color'] . '}';
    $style .= '.nav-top a { color: ' . $data_themes['pt_top_header_color'] . '}';
  }
  if($data_themes['pt_top_header_hover_bg'] != $data_themes['pt_top_header_bg']){
    $style .= '.nav-top a:hover { background: ' . $data_themes['pt_top_header_hover_bg'] . '}';
  }
  if($data_themes['pt_top_header_hover_color'] != $data_themes['pt_base_color']){
    $style .= '.nav-top a:hover { color: ' . $data_themes['pt_top_header_hover_color'] . '}';
  }  
  if($data_themes['pt_top_header_decoration'] != ''){
    $style .= '.nav-top a:hover { text-decoration: ' . $data_themes['pt_top_header_decoration'] . '}';
  }   

  /* Color Themes */
  if($data_themes['pt_base_color'] != ''){

    $style .= '.noUi-connect, .pt-button, .popup-title, .product-carousel .sticker, .product-list .sticker, .product-carousel .item-standard .product-qv, .product-list .item-standard .product-qv, 
              #producttabs.sidebar-widget .nav-tabs > li.active > a, #categoriesContent ul li .has-products, #documentcategoriesContent ul li .has-products, .categoryListBoxContents .categories-view:hover, 
              .product-list-filter .view-switch li button.active, .product-list-filter .view-switch li button:hover, .navSplitPagesLinks .current, .navSplitPagesLinks a:hover, .navNextPrevWrapper .prev-next .button:hover, 
              .navNextPrevWrapper .prev-next .button:hover, .product-info-social .product-share ul li a, .cartAttribsList ul li, .ccCartAttribsList ul li, #cartContentsDisplay .cartRemoveItemDisplay a, 
              .cart-popup-content ul li .products-detail .products-remove, .messageStack, #menu-button a:hover .bar { background: ' . $data_themes['pt_base_color'] . '}';

    $style .= 'a:hover, a:active, .tp-caption a:hover, .tp-caption a:active, .pt-nav-tabs > li > a:hover, .pt-nav-tabs > li.active > a, .pt-nav-tabs > li.active > a:hover, .pt-nav-tabs > li.active > a:focus, 
              .productSpecialPrice, .nav-top a:hover, .top-dd ul li a:hover, .main-menu > ul > li > a:hover, .misc-menu > ul > li > a:hover, .main-menu ul li:hover a span, .main-menu ul li:hover a span, 
              .section-content .section-subtitle a, .pt_carousel .owl-prev:hover, .pt_carousel .owl-next:hover, .product-carousel .product-name a:hover, .product-list .product-name a:hover, 
              .product-carousel .product-price, .product-list .product-price, .product-carousel .product-wishlist:hover, .product-list .product-wishlist:hover, .product-list-widget .products-price, 
              #categoriesContent ul li a.side-active, #documentcategoriesContent ul li a.side-active, #categoriesContent ul li .expand-btn:hover, #documentcategoriesContent ul li .expand-btn:hover, 
              .sidebar-widget .sideBoxContent a:hover, .product-suggestion .products-price, .product-suggestion .no-products-text a, .categoryListBoxContents .categories-view, .product-info-detail-inner #productPrices, 
              .product-info-detail-list dt, .cart-qty-control a:hover, .img-carousel .owl-prev, .img-carousel .owl-next, .img-carousel .image-item .image-zoom, .img-thumb .owl-prev:hover, .img-thumb .owl-next:hover, 
              .pt-tabs .nav-tabs > li.active > a, #shippingEstimatorContent td.bold { color: ' . $data_themes['pt_base_color'] . '}';

    $style .= 'textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, 
              input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus,  
              select:focus, .main-menu ul li:hover a span, .main-menu ul > li.dd-parent ul.dd-menu, .main-menu ul > li.dd-parent.mega .mega-inner, .main-menu ul > li.dd-parent.mega .mega-inner, 
              .main-menu.style1 ul > li.dd-parent ul.dd-menu:after, .pt_carousel .owl-prev:hover, .pt_carousel .owl-next:hover, .product-carousel .product-wishlist:hover, .product-list .product-wishlist:hover, 
              #producttabs.sidebar-widget .nav-tabs > li.active, #producttabs.sidebar-widget .nav-tabs > li:hover, #producttabs.sidebar-widget .nav-tabs > li:focus, 
              #producttabs.sidebar-widget .nav-tabs > li.active:hover, #producttabs.sidebar-widget .nav-tabs > li.active:focus, .autocomplete-suggestions, .categoryListBoxContents .categories-view, 
              .product-list-filter .view-switch li button.active, .product-list-filter .view-switch li button:hover, .navSplitPagesLinks .current, .navSplitPagesLinks a:hover, 
              .navNextPrevWrapper .prev-next .button:hover, .img-carousel .owl-prev, .img-carousel .owl-next, .img-carousel .image-item .image-zoom, .pt-tabs .nav-tabs > li.active, .pt-tabs .nav-tabs > li:hover, 
              .pt-tabs .nav-tabs > li:focus, .pt-tabs .nav-tabs > li.active:hover, .pt-tabs .nav-tabs > li.active:focus { border-color: ' . $data_themes['pt_base_color'] . '}';

  }
  
  return $style;
}

function pt_get_center_column_grid($left = true, $right = true){
  $grid = 0;

  if(!$left && !$right){
    $grid = 12 - 6;
  }elseif (!$left || !$right) {
    $grid = 12 - 3;
  }else{
    $grid = 12;
  }

  return $grid;
}
// 
function pt_get_product_grid_class($left = true, $right = true){
  $grid = 'one-third';

  if(!$left && !$right){
    $grid = 'one-half';

  }elseif (!$left || !$right) {
    $grid = 'one-fourth';
  }else{
	 //edit start
    $grid = 'one-fourth';
	//edit end
  }

  return $grid;
}

function pt_get_categories_products_list(&$categories, $categories_id, $include_deactivated = false, $include_child = true, $parent_category = '0', $display_limit = '') {
  global $db;
  global $categories_products_id_list;
  $childCatID = str_replace('_', '', substr($categories_id, strrpos($categories_id, '_')));

  $current_cPath = ($parent_category != '0' ? $parent_category . '_' : '') . $categories_id;

  $sql = "select p.products_id
          from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c inner join products_description as cd
		  on cd.products_id = p2c.products_id
          where p.products_id = p2c.products_id
		  
          and p2c.categories_id = '" . (int)$childCatID . "' and p.products_status =1 " .
          $display_limit;

  $products = $db->Execute($sql);
  while (!$products->EOF) {
    $categories_products_id_list[$products->fields['products_id']] = $current_cPath;
    $categories[$categories_id][] = $products->fields['products_id'];
    $products->MoveNext();
  }

  if ($include_child) {
    $sql = "select categories_id from " . TABLE_CATEGORIES . "
            where parent_id = '" . (int)$childCatID . "'";

    $childs = $db->Execute($sql);
    if ($childs->RecordCount() > 0 ) {
      while (!$childs->EOF) {
        pt_get_categories_products_list($categories, $childs->fields['categories_id'], $include_deactivated, $include_child, $current_cPath, $display_limit);
        $childs->MoveNext();
      }
    }
  }
}

function pt_has_category_subcategories($category_id) {
  global $db;
  $child_category_query = "select count(*) as count
                           from " . TABLE_CATEGORIES . "
                           where categories_status = 1 and 
                           parent_id = '" . (int)$category_id . "'";

  $child_category = $db->Execute($child_category_query);

  if ($child_category->fields['count'] > 0) {
    return true;
  } else {
    return false;
  }
}

function pt_get_product_reviews_detail($pid = ''){
  global $db;

  $sql = "SELECT r.reviews_id, r.products_id, r.customers_name, r.reviews_rating, r.date_added, rd.reviews_text FROM " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd
        where r.products_id = '" . (int)$pid . "'
        and r.reviews_id = rd.reviews_id
        and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "'
        and r.status = '1' LIMIT 0, 2";

  $reviews_detail = $db->Execute($sql);

  return $reviews_detail;

}

function pt_get_product_avg_rating($pid = ''){
  global $db;

  $avg_query = $db->Execute("SELECT avg(reviews_rating) as avg FROM " . TABLE_REVIEWS . " WHERE products_id = '". (int)$_GET['products_id'] ."' AND status = '1'");
  $avg = round((float)$avg_query->fields['avg'], 1);

  return $avg;
}

function pt_get_max_product_price($cid = ''){
  global $db;

  $max_query = $db->Execute("SELECT max(products_price_sorter) as max FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c WHERE p.products_id = p2c.products_id AND p2c.categories_id = '". (int)$cid ."' AND p.products_status = '1'");
  $max = round($max_query->fields['max'], 0);

  return $max;
}