<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_reviews_random.php 16044 2010-04-23 01:15:45Z drbyte $
 */
  $content = "";
  $review_box_counter = 0;
  while (!$random_review_sidebox_product->EOF) {
    $review_box_counter++;

    $products_rating = $random_review_sidebox_product->fields['reviews_rating'];
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
        $ratings = '<span class="product-rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>';
    }

    $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent centeredContent">';
    $content .= '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_review_sidebox_product->fields['products_id'] . '&reviews_id=' . $random_review_sidebox_product->fields['reviews_id']) . '" class="review-random">' . 
    			zen_image(DIR_WS_IMAGES . $random_review_sidebox_product->fields['products_image'], $random_review_sidebox_product->fields['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="img-responsive"') . 
    			'<span class="the-review">' . zen_trunc_string(nl2br(zen_output_string_protected(stripslashes($random_review_sidebox_product->fields['reviews_text']))), 60) . '</span></a>' . 
    			$ratings;
    
    $content .= '</div>';
    $content .= '<div class="clearfix"></div>';
    $random_review_sidebox_product->MoveNextRandom();
  }
