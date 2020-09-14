<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

$content = "";
$content .= '<div class="sideBoxContent centeredContent">';

  $content .= '<ul class="nav nav-tabs" role="tablist">';
    $content .= '<li class="active"><a href="#featured-tabs" role="tab" data-toggle="tab">' . $featured_title . '</a></li>';
    $content .= '<li><a href="#specials-tabs" role="tab" data-toggle="tab">' . $specials_title . '</a></li>';
    $content .= '<li><a href="#latest-tabs" role="tab" data-toggle="tab">' . $latest_title . '</a></li>';
  $content .= '</ul>';

  $content .= '<div class="tab-content">';
    $content .= '<div class="tab-pane fade in active" id="featured-tabs">';
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
    $content .= '</div>';

    $content .= '<div class="tab-pane fade" id="specials-tabs">';
      $content .= '<ul class="product-list-widget">';
      while (!$random_specials_sidebox_product->EOF) {
        $specials_box_counter++;
        $specials_box_price = zen_get_products_display_price($random_specials_sidebox_product->fields['products_id']);
        $content .= "\n" . '  <li class="sideBoxContentItem">';
        $content .=  '<a href="' . zen_href_link(zen_get_info_page($random_specials_sidebox_product->fields["products_id"]), 'cPath=' . zen_get_generated_category_path_rev($random_specials_sidebox_product->fields["master_categories_id"]) . '&products_id=' . $random_specials_sidebox_product->fields["products_id"]) . '" class="products-link">' . zen_image(DIR_WS_IMAGES . $random_specials_sidebox_product->fields['products_image'], $random_specials_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="img-responsive"');
        $content .= '<span class="products-name">' . $random_specials_sidebox_product->fields['products_name'] . '</span></a>';
        $content .= '<div class="products-detail">' . '<span class="products-price">' . 
                    $specials_box_price . '</span>' . '</div>';
        $content .= '<div class="clearfix"></div>';
        $content .= '</li>';
        $random_specials_sidebox_product->MoveNextRandom();
      }
      $content .= '</ul>';
    $content .= '</div>';

    $content .= '<div class="tab-pane fade" id="latest-tabs">';
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
    $content .= '</div>';
  $content .= '</div>';

$content .= '</div>' . "\n";




