<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_reviews_info_default.php 2993 2006-02-08 07:14:52Z birdbrain $
 */
?>
<div class="centerColumn" id="reviewsInfoDefault">
  <div class="product-info-detail-inner row">
    <div class="product-info-left product-info-right col-lg-5">
      <?php if (zen_not_null($products_image)) { ?>
        <div id="productReviewsDefaultProductImage" class="centeredContent back"><?php require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?></div>
      <?php } ?>
      <a href="<?php echo zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('reviews_id'))); ?>"><h2 id="productName"><?php echo $products_name . $products_model; ?></h2></a>
      <!--<h3 id="productPrices"><?php echo $products_price; ?></h3>-->
    </div>
    <div class=" col-lg-7">
          <div class="review-list">
            <ul>
              <li>
                <div class="review-item">
                  <?php
                    $ratings = '<span class="product-rating">';

                    for($i=1;$i<=5;$i++){
                      if($i<=$review_info->fields['reviews_rating']){
                        $ratings .= '<i class="fa fa-star filled"></i>';
                      }else{
                        $ratings .= '<i class="fa fa-star"></i>';
                      }
                    }

                    $ratings .= '</span>';
                  ?>
                  <span class="the-rating"><?php echo $ratings; ?></span>
                  <div class="clearfix"></div>
                  <p class="the-review"><?php echo zen_break_string(nl2br(zen_output_string_protected(stripslashes($review_info->fields['reviews_text']))), 60, '-<br />'); ?></p>
                  <p class="the-reviewer"><?php echo zen_output_string_protected($review_info->fields['customers_name']); ?></p>
                  <p class="the-date"><?php echo zen_date_short($review_info->fields['date_added']); ?></p>
                </div>
                <div class="review-icon"><i class="fa fa-user"></i></div>
                <div class="clearfix"></div>
              </li>
            </ul>
          </div>
    </div>
  </div>
  <br class="clearBoth">
  <div class="buttonRow pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array('reviews_id'))) . '" class="pt-button pt-button-l"><i class="fa fa-edit"></i> ' . BUTTON_WRITE_REVIEW_ALT . '</a>'; ?></div>   
  <div id="reviewsInfoDefaultReviewsListingLink" class="buttonRow pull-left"><?php echo ($reviews_counter > 1 ? '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params(array('reviews_id'))) . '" class="pt-button pt-button-l">' . BUTTON_MORE_REVIEWS_ALT . '</a>' : ''); ?></div>
  <br class="clearBoth">
</div>