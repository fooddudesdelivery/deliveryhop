<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Sun Aug 19 09:47:29 2012 -0400 Modified in v1.5.1 $
 */
?>
<div class="centerColumn" id="reviewsWrite">
  <?php if ($messageStack->size('review_text') > 0) echo $messageStack->output('review_text'); ?>
  <div class="product-info-detail-inner row">
    <div class="product-info-left product-info-right col-lg-5">
      <?php if (zen_not_null($products_image)) { ?>
        <div id="productReviewsDefaultProductImage" class="centeredContent back"><?php require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?></div>
      <?php } ?>
      <a href="<?php echo zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('reviews_id'))); ?>"><h2 id="productName"><?php echo $products_name . $products_model; ?></h2></a>
      <!--<h3 id="productPrices"><?php echo $products_price; ?></h3>-->
    </div>
    <div class=" col-lg-7">
      <?php echo zen_draw_form('product_reviews_write', zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'action=process&products_id=' . $_GET['products_id'], 'SSL'), 'post', 'onsubmit="return checkForm(product_reviews_write);"'); ?>
        <p id="reviewsWriteReviewer" class="page-default-heading"><?php echo SUB_TITLE_FROM, zen_output_string_protected($customer->fields['customers_firstname'] . ' ' . $customer->fields['customers_lastname']); ?></p>   
        <div id="rate-it" class="product-rating" data-toggle="pt-tooltip" data-title="<?php echo SUB_TITLE_RATING; ?>"><i id="rate-1" class="fa fa-star" data-value="1"></i><i id="rate-2" class="fa fa-star" data-value="2"></i><i id="rate-3" class="fa fa-star" data-value="3"></i><i id="rate-4" class="fa fa-star" data-value="4"></i><i id="rate-5" class="fa fa-star" data-value="5"></i></div>
        <div id="rate-hide">
          <?php echo zen_draw_radio_field('rating', '1', '', 'id="rating-1"'); ?>
          <?php echo zen_draw_radio_field('rating', '2', '', 'id="rating-2"'); ?>
          <?php echo zen_draw_radio_field('rating', '3', '', 'id="rating-3"'); ?>
          <?php echo zen_draw_radio_field('rating', '4', '', 'id="rating-4"'); ?>
          <?php echo zen_draw_radio_field('rating', '5', '', 'id="rating-5"'); ?>
        </div>
        <?php echo zen_draw_textarea_field('review_text', 60, 5, '', 'id="review-text"'); ?>
        <?php echo zen_draw_input_field('should_be_empty', '', ' size="60" id="RAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>
        <input type="submit" value="<?php echo BUTTON_SUBMIT_ALT; ?>" class="pt-button">
        <div id="reviewsWriteReviewsNotice" class="notice"><?php echo TEXT_NO_HTML . (REVIEWS_APPROVAL == '1' ? '<br />' . TEXT_APPROVAL_REQUIRED: ''); ?></div>
      </form>
    </div>
  </div>
</div>
