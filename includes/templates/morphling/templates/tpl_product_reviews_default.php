<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_reviews_default.php 4852 2006-10-28 06:47:45Z drbyte $
 */
?>
<div class="centerColumn" id="reviewsDefault">
  <div class="product-info-detail-inner row">
    <div class="product-info-left product-info-right col-lg-5">
      <?php if (zen_not_null($products_image)) { ?>
        <div id="productReviewsDefaultProductImage" class="centeredContent back"><?php require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?></div>
      <?php } ?>
      <a href="<?php echo zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('reviews_id'))); ?>"><h2 id="productName"><?php echo $products_name . $products_model; ?></h2></a>
      <!--<h3 id="productPrices"><?php echo $products_price; ?></h3>-->
    </div>
    <div class=" col-lg-7">
      <?php if ($reviews_split->number_of_rows > 0) { ?>
        <?php if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) { ?>
          <div id="productReviewsDefaultListingTopNumber" class="navSplitPagesResult"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>
          <div id="productReviewsDefaultListingTopLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
        <?php } ?>
        <?php foreach ($reviewsArray as $reviews) { ?>
          <div class="review-list">
            <ul>
              <li>
                <?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . (int)$_GET['products_id'] . '&reviews_id=' . $reviews['id']) . '">'; ?>
                <div class="review-item">
                  <?php
                    $ratings = '<span class="product-rating">';

                    for($i=1;$i<=5;$i++){
                      if($i<=$reviews['reviewsRating']){
                        $ratings .= '<i class="fa fa-star filled"></i>';
                      }else{
                        $ratings .= '<i class="fa fa-star"></i>';
                      }
                    }

                    $ratings .= '</span>';
                  ?>
                  <span class="the-rating"><?php echo $ratings; ?></span>
                  <div class="clearfix"></div>
                  <p class="the-review"><?php echo zen_break_string(zen_output_string_protected(stripslashes($reviews['reviewsText'])), 60, '-<br />') . ((strlen($reviews['reviewsText']) >= 100) ? '...' : ''); ?></p>
                  <p class="the-reviewer"><?php echo zen_output_string_protected($reviews['customersName']); ?></p>
                  <p class="the-date"><?php echo zen_date_short($reviews['dateAdded']); ?></p>
                </div>
                <div class="review-icon"><i class="fa fa-user"></i></div>
                <div class="clearfix"></div>
                </a>
              </li>
            </ul>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div id="productReviewsDefaultNoReviews" class="content"><?php echo TEXT_NO_REVIEWS . (REVIEWS_APPROVAL == '1' ? '<br />' . TEXT_APPROVAL_REQUIRED: ''); ?></div>
      <?php } ?>
      <?php if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) { ?>
        <div id="productReviewsDefaultListingBottomNumber" class="navSplitPagesResult"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>
        <div id="productReviewsDefaultListingBottomLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
      <?php } ?>
    </div>
  </div>
  <br class="clearBoth">
  <div class="buttonRow pull-right"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params(array('reviews_id'))) . '" class="pt-button pt-button-l"><i class="fa fa-edit"></i> ' . BUTTON_WRITE_REVIEW_ALT . '</a>'; ?></div>   
  <br class="clearBoth">
</div>
