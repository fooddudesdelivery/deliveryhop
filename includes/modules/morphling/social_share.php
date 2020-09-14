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

  $twitter_card = '';
  $twitter_card .= '<meta name="twitter:card" content="product">' . "\n";
  $twitter_card .= '<meta name="twitter:title" content="' . zen_get_products_name((int)$_GET['products_id']) . '">' . "\n";
  $twitter_card .= '<meta name="twitter:image" content="' . (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ) . DIR_WS_IMAGES . pt_get_products_image((int)$_GET['products_id']) . '">' . "\n";
  $twitter_card .= '<meta name="twitter:description" content="' . zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description((int)$_GET['products_id'], $_SESSION['languages_id']))), 200) . '">' . "\n";  
  $twitter_card .= '<meta name="twitter:label1" content="Price">' . "\n";
  $twitter_card .= '<meta name="twitter:data1" content="' . $currencies->display_price(zen_products_lookup((int)$_GET['products_id'], 'products_price_sorter'), '') . '">' . "\n";
  $twitter_card .= '<meta name="twitter:label2" content="Availability">' . "\n";
  $twitter_card .= '<meta name="twitter:data2" content="' . zen_get_products_stock((int)$_GET['products_id']) . TEXT_PRODUCT_QUANTITY . '">' . "\n";

  $fb_og = '';

  if (isset($canonicalLink) && $canonicalLink != '') {
    $fb_og .= '<meta name="og:url" content="' . $canonicalLink . '">' . "\n";
  }
  $fb_og .= '<meta name="og:title" content="' . zen_get_products_name((int)$_GET['products_id']) . '">' . "\n";
  $fb_og .= '<meta name="og:image" content="' . (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ) . DIR_WS_IMAGES . pt_get_products_image((int)$_GET['products_id']) . '">' . "\n";
  $fb_og .= '<meta name="og:description" content="' . zen_trunc_string(zen_clean_html(stripslashes(zen_get_products_description((int)$_GET['products_id'], $_SESSION['languages_id']))), 200) . '">' . "\n";  

  echo $fb_og . $twitter_card;