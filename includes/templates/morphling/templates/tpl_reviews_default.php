<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_reviews_default.php 2905 2006-01-28 01:25:36Z birdbrain $
 */
?>
<div class="centerColumn" id="reviewsDefault">

<!--<h1 id="reviewsDefaultHeading"><?php echo $breadcrumb->last();  ?></h1>-->

<?php if ($reviews_split->number_of_rows > 0) { ?>
  <?php if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) { ?>
    <div id="reviewsDefaultListingTopNumber" class="navSplitPagesResult"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>
    <div id="reviewsDefaultListingTopLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
  <?php } ?>
  <?php
    $reviews = $db->Execute($reviews_split->sql_query);
    while (!$reviews->EOF) {
  ?>
  <div class="row">
    <div class="col-lg-3">
      <div class="smallProductImage"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews->fields['products_id'] . '&reviews_id=' . $reviews->fields['reviews_id']) . '">' . zen_image(DIR_WS_IMAGES . $reviews->fields['products_image'], $reviews->fields['products_name'], MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT, 'class="img-responsive"') . '</a>'; ?></div>
    </div>
    <div class="col-lg-9">
      <h2 class="page-default-heading"><?php echo $reviews->fields['products_name']; ?></h2>
      <?php
        $ratings = '<span class="product-rating">';

        for($i=1;$i<=5;$i++){
          if($i<=$reviews->fields['reviews_rating']){
            $ratings .= '<i class="fa fa-star filled"></i>';
          }else{
            $ratings .= '<i class="fa fa-star"></i>';
          }
        }

        $ratings .= '</span>';
      ?>
      <p class="rating"><?php echo $ratings; ?></p>
      <p class="content"><?php echo zen_break_string(nl2br(zen_output_string_protected(stripslashes($reviews->fields['reviews_text']))), 60, '-<br />') . ((strlen($reviews->fields['reviews_text']) >= 100) ? '...' : ''); ?></p> 
      <p><em><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, zen_date_short($reviews->fields['date_added'])); ?>&nbsp;<?php echo sprintf(TEXT_REVIEW_BY, zen_output_string_protected($reviews->fields['customers_name'])); ?></em></p>
      <div class="buttonRow"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews->fields['products_id'] . '&reviews_id=' . $reviews->fields['reviews_id']) . '" class="pt-button pt-button-vs">' . BUTTON_READ_REVIEWS_ALT . '</a>'; ?></div>
    </div>
  </div>
  <br class="clearBoth">
<?php
      $reviews->MoveNext();
    }
?>
<?php
  } else {
?>
<div id="reviewsDefaultNoReviews" class="content"><?php echo TEXT_NO_REVIEWS; ?></div>
<?php
  }
?>
<?php
  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<div id="reviewsDefaultListingBottomNumber" class="navSplitPagesResult"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></div>

<div id="reviewsDefaultListingBottomLinks" class="navSplitPagesLinks"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'main_page'))); ?></div>
<br class="clearBoth" />
<?php
  }
?>

</div>
