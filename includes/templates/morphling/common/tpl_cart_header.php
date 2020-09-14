<?php
/**
 * Common Template - tpl_login_header.php
 *
 *
 * @package Pepper Framework 
 * @copyright Copyright 2009-2014 Pepper Themes
 * @copyright Portions Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 */
require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/shopping_cart.php');
$cart = $_SESSION['cart']->get_products(true);

?>

<!-- Cart Modal -->
<div id="cart-popup" class="pt-popup pt-paddingless mfp-hide">
  <div class="cart-popup-head">
    <div class="popup-title"><?php echo HEADER_TITLE_CART_CONTENTS; ?></div>
  </div>
  <div class="cart-popup-content">
    <?php if(count($cart) > 0){ ?>
    <ul class="product-list-widget">
    <?php foreach ($cart as $content) { ?>
      <li>
        <div  ><?php echo zen_image(DIR_WS_IMAGES . $content['image'], $content['name'], 80, 80); ?>
        <span class="products-name"><?php echo $content['name']; ?></span></div>
        <div class="products-detail">
          <span class="products-price"><?php echo $content['quantity']; ?> &times; <?php echo $currencies->format(zen_round($content['final_price'], $currencies->get_decimal_places($_SESSION['currency']))); ?> <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $content['id']); ?>" data-toggle="pt-tooltip" title="<?php echo ICON_TRASH_ALT; ?>" class="products-remove"><i class="fa fa-times"></i></a></span>
        </div>
      </li>
    <?php } ?>
    </ul>
    <div class="cart-popup-footer">
      <h5 class="cart-total"><?php echo TABLE_HEADING_TOTAL . ' : ' . $currencies->format($_SESSION['cart']->show_total()); ?></h5>
<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>" class="pt-button pt-button-s pt-button-c pull-left"><?php echo HEADER_TITLE_CART_EDIT; ?></a></span>
      <div href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>" class="pt-button pt-button-s pt-button-c pull-right checkout-btn-popout"><?php echo HEADER_TITLE_CHECKOUT; ?></div>
      <div class="clearfix"></div>
    </div>   
    <?php }else{ ?>
      <h5 class="important text-center"><?php echo TEXT_CART_EMPTY; ?></h5>
    <?php } ?> 
  </div>
</div>
<!-- Cart Modal -->