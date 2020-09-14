<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=product_info.<br />
 * Displays details of a typical product
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_info_display.php 19690 2011-10-04 16:41:45Z drbyte $
 */
 //require(DIR_WS_MODULES . '/debug_blocks/product_info_prices.php');
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_PRODUCT_REVIEWS_WRITE . '.php');

?>


<div class="centerColumn" id="productGeneral">

<?php
//Begin Edit_Cart mod Justin - Part 1
//This bit contributed by Damian Taylor, makes the SEO mod CEON URI work with "Edit Cart"
if($_SERVER['QUERY_STRING'][0] == ':') {
	$_GET['products_id'] = $_GET['products_id'] . $_SERVER['QUERY_STRING'];
}

//This bit looks at the product id param and if it is not a simple number like "121", 
// but a big string like "52:96f247828566a562a4e8de1552a48c65" diverts form action to "Edit Cart"
if(is_numeric($_GET['products_id'])) {
	$cartAction="add_product";	
}else{
	$cartAction = "edit_product_in_cart";
}

//End Edit_Cart mod Justin - Part 1
?>
<?php if ($messageStack->size('product_info') > 0) echo $messageStack->output('product_info'); ?>

<!--bof Prev/Next top position -->
<?php if (PRODUCT_INFO_PREVIOUS_NEXT == 1 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { ?>
<?php
/**
 * display the product previous/next helper
 */
require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
<?php } ?>
<!--eof Prev/Next top position-->

<div class="product-info-detail" itemscope itemtype="http://schema.org/Product">

  <div class="product-info-detail-inner row">

  <!--bof Form start-->
  <?php echo zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(array('action')) . 'action=' . $cartAction, $request_type), 'post', 'enctype="multipart/form-data"') . "\n"; ?>
  <!--eof Form start-->
  <input type="hidden" name='real_menu' value="<?php echo $_GET['real_menu']  ?>">
   <?php 
	
		if (zen_not_null($products_image) && $products_image!='no_picture.gif') { ?>
    <div class="product-info-left col-md-5">

      <div class="product-info-img-wrap">
        <!--bof Main Product Image -->
        
     
        <?php
        /**
         * display the main product image
         */
           require($template->get_template_dir('/tpl_modules_main_product_image.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_main_product_image.php'); ?>
        
        <!--eof Main Product Image-->

        <!--bof Additional Product Images -->
        <?php
        /**
         * display the products additional images
         */
          require($template->get_template_dir('/tpl_modules_additional_images.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_additional_images.php'); ?>
        <!--eof Additional Product Images -->
      </div>

    </div><!-- Product Info Left -->
<?php }else{
$no_img_class = 'product-info-right-addon';	
	echo'<script>no_product_img();</script>';
}?>
    <div class="product-info-right <?php echo $no_img_class ?> col-md-7">
    
    <script>
   $(document).ready(function(){
	   $(".btn-group-container div").each(function(index, element) {
        $(this).addClass('btn-group product-btn-group');
		$(this).attr('data-toggle', 'buttons');
    });
	$(".btn-group-container div").children("label").each(function(){
		var forele = $(this).attr('for');
		var text = $(this).text();
		$(this).remove();
		$('#'+forele).wrap('<label class="btn btn-default btn-attributes">');
		$('#'+forele).after(text);
	});
	
	$('.btn-default').next('br').remove();
	$('.btn input').each(function(index, element) {
	 	  if($(this).attr('checked')){
				$(element).click();   
	 	  }
   	 });
	 

   });

</script>
      <!--bof Product Name-->
      <h1 id="productName" class="productGeneral" itemprop="name"><?php echo $products_name; ?></h1>
      <!--eof Product Name-->

      <!--bof Product Price block -->
      <h2 id="productPrices" class="productGeneral" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
      <meta itemprop="priceCurrency" content="<?php echo $_SESSION['currency']; ?>" />
      <?php echo ($products_quantity > 0 ? '<link itemprop="availability" href="http://schema.org/InStock" />' : '<link itemprop="availability" href="http://schema.org/OutOfStock" />'); ?>
      <?php
      // base price
        if ($show_onetime_charges_description == 'true') {
          $one_time = '<span>' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
        } else {
          $one_time = '';
        }
        echo $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$_GET['products_id']) . '<meta itemprop="price" content="' . round(zen_get_products_actual_price((int)$_GET['products_id']), 2, PHP_ROUND_HALF_UP) . '">';
      ?></h2>
      <!--eof Product Price block -->

      <?php 
        $products_rating = pt_get_products_rating((int)$_GET['products_id']); 

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
          $ratings = '';
        }  

        $products_rating_count = pt_get_products_rating_count((int)$_GET['products_id']);
      ?>
      <div class="product-info-social">
        <?php echo $ratings; ?>  
        <?php if($products_rating > 0){ ?>
        <span class="product-rating-count">
          <span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            <meta itemprop="ratingValue" content="<?php echo pt_get_product_avg_rating((int)$_GET['products_id']); ?>" />
            <span itemprop="reviewCount"><?php echo $products_rating_count; ?></span> Review(s)
          </span>
        </span>  
        <span class="product-rating-separator">&#124;</span>
        <?php } ?>
        <span class="product-rating-add"><a href="#reviews" id="review-trigger" data-toggle="tab"><?php echo BUTTON_WRITE_REVIEW_ALT; ?></a></span>
        <span class="product-rating-separator">&#124;</span>
        <div class="product-share">
          <ul>
            <li><a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(htmlspecialchars_decode(zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id((int)$_GET['products_id'])) . '&products_id=' . (int)$_GET['products_id'] . '&amp;p[images][0]=' . (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ) . $products_image_large, $request_type, false))); ?>" class="facebook-share" data-toggle="pt-tooltip" title="Share on Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li> 
            <li><a href="http://www.twitter.com/share?url=<?php echo urlencode(htmlspecialchars_decode(zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id((int)$_GET['products_id'])) . '&products_id=' . (int)$_GET['products_id'], $request_type, false))); ?>" class="twitter-share" data-toggle="pt-tooltip" title="Share on Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li> 
            <?php /*?><li><a href="https://plus.google.com/share?url=<?php echo urlencode(htmlspecialchars_decode(zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id((int)$_GET['products_id'])) . '&products_id=' . (int)$_GET['products_id'], $request_type, false))); ?>" class="google-plus-share" data-toggle="pt-tooltip" title="Share on Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php */?>
            <li><a href="https://www.instagram.com/fooddudesdelivery?url=<?php echo urlencode(htmlspecialchars_decode(zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id((int)$_GET['products_id'])) . '&products_id=' . (int)$_GET['products_id'], $request_type, false))); ?>&amp;media=<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ) . $products_image_large; ?>&amp;description=" class="instagram-share" data-toggle="pt-tooltip" title="Share on Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
            <li><a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(htmlspecialchars_decode(zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id((int)$_GET['products_id'])) . '&products_id=' . (int)$_GET['products_id'], $request_type, false))); ?>&amp;media=<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ) . $products_image_large; ?>&amp;description=" class="pinterest-share" data-toggle="pt-tooltip" title="Share on Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li> 
            <li><a href="mailto:please_enter_your@emailaddresshere.com?subject=<?php echo $products_name; ?>&amp;body=<?php echo urlencode(htmlspecialchars_decode(zen_href_link(zen_get_info_page((int)$_GET['products_id']), 'cPath=' . zen_get_generated_category_path_rev(zen_get_products_category_id((int)$_GET['products_id'])) . '&products_id=' . (int)$_GET['products_id'], $request_type, false))); ?>" data-toggle="pt-tooltip" title="Email a Friend"><i class="fa fa-envelope"></i></a></li>
          </ul>
        </div>
      </div>

      <?php if ($products_description != '') { ?>
        <div class="quick-view-desc"><?php echo stripslashes($products_description); ?></div>
      <?php } ?>

      <!--bof Product details list  -->
      <div class="product-info-detail-list hiddenField">
        <dl id="productDetailsList" class="floatingBox dl-horizontal ">
        <?php if($flag_show_product_info_model == 1 and $products_model != ''){ ?>
          <dt><?php echo TEXT_PRODUCT_MODEL; ?></dt>
          <dd itemprop="model" content="<?php echo (($flag_show_product_info_model == 1 and $products_model !='') ? $products_model : ''); ?>"><?php echo (($flag_show_product_info_model == 1 and $products_model !='') ? $products_model : ''); ?></dd>
        <?php } ?>
        <?php if($flag_show_product_info_weight == 1 and $products_weight !=0){ ?>
          <dt><?php echo TEXT_PRODUCT_WEIGHT; ?></dt>
          <dd><?php echo (($flag_show_product_info_weight == 1 and $products_weight !=0) ? $products_weight . TEXT_PRODUCT_WEIGHT_UNIT : ''); ?></dd>
        <?php } ?>
        <?php if($flag_show_product_info_quantity == 1){ ?>
          <dt><?php echo TEXT_PRODUCT_AVAILABILITY; ?></dt>
          <dd><?php echo (($flag_show_product_info_quantity == 1) ? $products_quantity . TEXT_PRODUCT_QUANTITY : ''); ?></dd>
        <?php } ?>
        <?php if($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name)){ ?>
          <dt><?php echo TEXT_PRODUCT_MANUFACTURER; ?></dt>
          <dd itemprop="brand"><?php echo (($flag_show_product_info_manufacturer == 1 and !empty($manufacturers_name)) ? $manufacturers_name : ''); ?></dd>
        <?php } ?>
        </dl>
      </div>
      <!--eof Product details list -->

      <!--bof Attributes Module -->
      <?php if ($pr_attr->fields['total'] > 0) { ?>
        <div class="product-info-attributes">
        <?php
        /**
         * display the product atributes
         */
          require($template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_attributes.php'); ?>
        </div>
      <?php } ?>
      <!--eof Attributes Module -->

      <!--bof Add to Cart Box -->
      <?php if (CUSTOMERS_APPROVAL != 3 and TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM != '') { ?>
        <?php
          $display_qty = (($flag_show_product_info_in_cart_qty == 1 and $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART.$_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
         		//================================Start of Edit_Cart mod Justin Part Two =================================================================
		// What follows is the old code. You need to replace or comment this section, and add the "Edit Cart" code just below it.
		/* if ($products_qty_box_status == 0 or $products_quantity_order_max== 1) {
			// hide the quantity box and default to 1
				              $the_button = '<input type="hidden" name="cart_quantity" value="1" />' . 
							  zen_draw_hidden_field('products_id', (int)$_GET['products_id']) .
							  zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
		*/
		//========================================================================================================================================				  
		// This bit prepares the paramaters that the "Edit Cart" needs and put an edit cart button on screen, if we are in edit mode
            if ($products_qty_box_status == 0 or $products_quantity_order_max== 1 or (! is_numeric($_GET['products_id'])) ) {

					//Edit Justin replaced the $the_button with a new def. that supports editing,  20071120
					//if the item being displayed was referred here from the cart, we are in edit mode  					
					if (! is_numeric($_GET['products_id'])){
						//establish	quantity of product in cart
						$existing_quantity=$_SESSION['cart']->get_quantity($_GET['products_id']);
						
						//make the edit button
						$the_button = '<input type="hidden"  name="cart_quantity" value="' . $existing_quantity . '" />' . 
									zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . 
									zen_draw_hidden_field('edit_item_id', $_GET['products_id']) . 
									'<input type="submit" class="pt-button pt-button-m" value="Update">';
					
					//If we were not referred from cart, we are not in edit mode
					}else{
							
				              // hide the quantity box and default to 1
				              $the_button = '<input type="hidden" name="cart_quantity" value="1" />' . 
							  zen_draw_hidden_field('products_id', (int)$_GET['products_id']) .
							  zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
					}
		//================================End of Edit_Cart mod Justin Part Two=================================================================

          } else {
            $qty_control = '<div class="cart-qty-control"><a href="#" class="qty-control cart-qty-inc"><i class="fa fa-angle-up"></i></a><a href="#" class="qty-control cart-qty-dec"><i class="fa fa-angle-down"></i></a></div>';
            $the_button = PRODUCTS_ORDER_QTY_TEXT . '<div class="cart-qty"><input type="text" class="cart-qty-input" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" />' . $qty_control . '</div>'  . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . '&nbsp;&nbsp;<input type="submit" class="pt-button pt-button-m" value="' . BUTTON_IN_CART_ALT . '"></div>';
          }
          $display_button = zen_get_buy_now_button((int)$_GET['products_id'], $the_button);
        ?>
        <?php if ($display_qty != '' or $display_button != '') { ?>
          <div id="cartAdd">
            <?php echo $display_qty . $display_button; ?>
          </div>
        <?php } ?>
      <?php } ?>
      <!--eof Add to Cart Box-->

      <!--bof free ship icon  -->
      <?php if(zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) { ?>
      <div id="freeShippingIcon"><?php echo TEXT_PRODUCT_FREE_SHIPPING_ICON; ?></div>
      <?php } ?>
      <!--eof free ship icon  -->
     
    </div><!-- Product Info Right -->

  <!--bof Form close-->
  </form>
  <!--bof Form close-->

  </div>

  <!-- Product Tabs -->
  <div id="product-tabs" class="pt-tabs">
    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#description-tab" role="tab" data-toggle="tab"><?php echo TEXT_PRODUCTS_DESCRIPTION; ?></a></li> 
      <li><a href="#information-tab" role="tab" data-toggle="tab"><?php echo TEXT_PRODUCTS_INFORMATION; ?></a></li>
      <li><a href="#reviews-tab" role="tab" data-toggle="tab"><?php echo TEXT_PRODUCTS_REVIEW . ' (' . $reviews->fields['count'] . ')'; ?></a></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade in active" id="description-tab">
        <?php if ($products_description != '') { ?>
        <p id="productDescription" class="productGeneral" itemprop="description"><?php echo stripslashes($products_description); ?></p>
        <?php } ?>
      </div>
      <div class="tab-pane fade" id="information-tab">

        <!--bof Product date added/available-->
        <?php
          if ($products_date_available > date('Y-m-d H:i:s')) {
            if ($flag_show_product_info_date_available == 1) {
        ?>
          <p id="productDateAvailable" class="productGeneral"><?php echo sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)); ?></p>
        <?php
            }
          } else {
            if ($flag_show_product_info_date_added == 1) {
        ?>
          <p id="productDateAdded" class="productGeneral"><?php echo sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)); ?></p>
        <?php
            } // $flag_show_product_info_date_added
          }
        ?>
        <!--eof Product date added/available -->

        <!--bof Product URL -->
        <?php
          if (zen_not_null($products_url)) {
            if ($flag_show_product_info_url == 1) {
        ?>
          <p id="productInfoLink" class="productGeneral centeredContent"><?php echo sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($products_url), 'NONSSL', true, false)); ?></p>
        <?php
            } // $flag_show_product_info_url
          }
        ?>
        <!--eof Product URL -->

        <?php if ($products_discount_type != 0) { ?>    
        <?php
        /**
         * display the products quantity discount
         */
         require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_products_quantity_discounts.php'); ?>
        <?php } ?>
      </div> 
      
      <?php if ($flag_show_product_info_reviews == 1) { ?>
        <!--bof Reviews button and count-->
        <div class="tab-pane fade" id="reviews-tab">
          <div class="row">
            <div class="reviews-write-wrap col-lg-6">
              <?php echo zen_draw_form('product_reviews_write', zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'action=process&products_id=' . (int)$_GET['products_id'], 'SSL'), 'post'); ?>
                <?php if ($messageStack->size('review_text') > 0) echo $messageStack->output('review_text'); ?>

                <h3 class="write-review-title"><?php echo BUTTON_WRITE_REVIEW_ALT; ?></h3>

                <p><?php echo SUB_TITLE_REVIEW; ?></p>

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
            <div class="review-list col-lg-6">
              <?php if ($reviews->fields['count'] > 0 ) { ?>
                <?php $reviews_detail = pt_get_product_reviews_detail((int)$_GET['products_id']); ?>

                <?php if($reviews_detail->RecordCount() > 0){ ?>
                  <ul>
                  <?php while(!$reviews_detail->EOF){ ?>
                    <li>
                      <div class="review-item">
                        <?php
                          $ratings = '<span class="product-rating">';

                          for($i=1;$i<=5;$i++){
                            if($i<=$reviews_detail->fields['reviews_rating']){
                              $ratings .= '<i class="fa fa-star filled"></i>';
                            }else{
                              $ratings .= '<i class="fa fa-star"></i>';
                            }
                          }

                          $ratings .= '</span>';
                        ?>
                        <span class="the-rating"><?php echo $ratings; ?></span>
                        <div class="clearfix"></div>
                        <p class="the-review"><?php echo zen_trunc_string(zen_clean_html(stripslashes($reviews_detail->fields['reviews_text']))); ?></p>
                        <p class="the-reviewer"><?php echo $reviews_detail->fields['customers_name']; ?></p>
                        <p class="the-date"><?php echo $reviews_detail->fields['date_added']; ?></p>
                      </div>
                      <div class="review-icon"><i class="fa fa-user"></i></div>
                      <div class="clearfix"></div>
                    </li>
                  <?php $reviews_detail->MoveNext(); ?>
                  <?php } ?>
                  </ul>
                <?php } ?>
                <div class="view-all-review"><?php echo '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()) . '" class="pt-button pt-button-vs">' . BUTTON_REVIEWS_ALT . ' &rarr;</a>'; ?></div>
              <?php } ?>
            </div><!-- Review List -->
          </div><!-- Review Row -->       
        </div><!-- Review Pane -->
        <?php } ?>
      </div><!-- Tab Content -->
    </div><!-- Product Tabs -->
    
</div><!-- Product Info Detail -->




<!--bof Prev/Next bottom position -->
<?php if (PRODUCT_INFO_PREVIOUS_NEXT == 2 or PRODUCT_INFO_PREVIOUS_NEXT == 3) { ?>
<?php
/**
 * display the product previous/next helper
 */
 require($template->get_template_dir('/tpl_products_next_previous.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_products_next_previous.php'); ?>
<?php } ?>
<!--eof Prev/Next bottom position -->



<!--bof also purchased products module-->
<?php require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_also_purchased_products.php');?>
<!--eof also purchased products module-->


</div>