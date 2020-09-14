<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_whats_new.php 18698 2011-05-04 14:50:06Z wilt $
 */
  $content = "";
  $content .= '<div class="sideBoxContent centeredContent">';
  $whats_new_box_counter = 0;
  $content .= '<ul class="product-list-widget">';
  while (!$random_whats_new_sidebox_product->EOF) {
    $whats_new_box_counter++;
    $whats_new_price = zen_get_products_display_price($random_whats_new_sidebox_product->fields['products_id']);
    $content .= "\n" . '  <li class="sideBoxContentItem">';
    $content .=  '<a href="' . zen_href_link(zen_get_info_page($random_whats_new_sidebox_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_whats_new_sidebox_product->fields["master_categories_id"]) . '&products_id=' . $random_whats_new_sidebox_product->fields["products_id"]) . '" class="products-link">' . zen_image(DIR_WS_IMAGES . $random_whats_new_sidebox_product->fields['products_image'], $random_whats_new_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="img-responsive"');
    $content .= '<span class="products-name">' . $random_whats_new_sidebox_product->fields['products_name'] . '</span></a>';
    $content .= '<div class="products-detail">' . '<span class="products-price">' . 
                $whats_new_price . '</span>' . '</div>';
    $content .= '<div class="clearfix"></div>';
    $content .= '</li>';
    $random_whats_new_sidebox_product->MoveNextRandom();
  }
  $content .= '</ul>';
  $content .= '</div>' . "\n";  
