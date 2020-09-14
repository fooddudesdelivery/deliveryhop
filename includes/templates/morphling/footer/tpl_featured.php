<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_featured.php 18698 2011-05-04 14:50:06Z wilt $
 */
  $content = "";
  $content .= '<div class="' . $box_id . ' widget col-md-3 col-sm-6 col-xs-12">' . "\n";
  $content .= '<h3 class="widget-title"><span>' . $title . '</span></h3>' . "\n";
  $featured_box_counter = 0;
  $content .= '<ul class="product-list-widget">';
  while (!$random_featured_product->EOF) {
    $featured_box_counter++;
    $featured_box_price = zen_get_products_display_price($random_featured_product->fields['products_id']);
    $content .= "\n" . '  <li class="sideBoxContentItem">';
    $content .=  '<a href="' . zen_href_link(zen_get_info_page($random_featured_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_featured_product->fields["master_categories_id"]) . '&products_id=' . $random_featured_product->fields["products_id"]) . '" class="products-link">' . zen_image(DIR_WS_IMAGES . $random_featured_product->fields['products_image'], $random_featured_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="img-responsive"');
    $content .= '<span class="products-name">' . $random_featured_product->fields['products_name'] . '</span></a>';
    $content .= '<div class="products-detail">' . '<span class="products-price">' . 
                $featured_box_price . '</span>' . '</div>';
    $content .= '<div class="clearfix"></div>';
    $content .= '</li>';
    $random_featured_product->MoveNextRandom();
  }
  $content .= '</ul>';
  $content .= '</div>' . "\n";

  echo $content;
