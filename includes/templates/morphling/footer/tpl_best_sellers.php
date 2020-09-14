<?php
/**
 * Footer Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_best_sellers.php 2982 2006-02-07 07:56:41Z birdbrain $
 */
  $content = '';
  $content .= '<div class="' . $box_id . ' widget col-md-3 col-sm-6 col-xs-12">' . "\n";
  $content .= '<h3 class="widget-title"><span>' . $title . '</span></h3>' . "\n";
  $content .= '<ul class="product-list-widget">' . "\n";
  for ($i=1; $i<=sizeof($bestsellers_list); $i++) {
  	$best_seller_price = zen_get_products_display_price($bestsellers_list[$i]['id']);
    $content .= '<li class="sideBoxContentItem">';
    $content .= '<a href="' . zen_href_link(zen_get_info_page($bestsellers_list[$i]['id']), 'products_id=' . $bestsellers_list[$i]['id']) . '" class="products-link">' . zen_image(DIR_WS_IMAGES . $bestsellers_list[$i]['image'], $bestsellers_list[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="img-responsive"');
    $content .= '<span class="products-name">' . zen_trunc_string($bestsellers_list[$i]['name'], BEST_SELLERS_TRUNCATE, BEST_SELLERS_TRUNCATE_MORE) . '</span></a>';
	$content .= '<div class="products-detail">' . '<span class="products-price">' . 
                $best_seller_price . '</span>' . '</div>';
    $content .= '<div class="clearfix"></div>';
    $content .= '</li>' . "\n";
  }
  $content .= '</ul>' . "\n";
  $content .= '</div>';

  echo $content;
?>