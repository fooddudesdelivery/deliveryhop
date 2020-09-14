<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shopping_cart_default.php 15881 2010-04-11 16:32:39Z wilt $
 */
?>
<div style="min-height:390px">

<div class="centerColumn" id="shoppingCartDefault">
<?php if ($flagHasCartContents) { ?>

<?php if ($_SESSION['cart']->count_contents() > 0) { ?>
<div class="pull-right"><a href="<?php echo zen_href_link(FILENAME_INFO_SHOPPING_CART,'','SSL'); ?>" data-toggle="pt-ajaxlightbox" class="page-popup pt-button pt-button-vs"><?php echo TEXT_VISITORS_CART; ?></a></div>
<?php } ?>
<h1 id="cartDefaultHeading" class="page-default-heading"><?php echo HEADING_TITLE; ?></h1>
<div class="clearfix"></div>

<?php if ($messageStack->size('shopping_cart') > 0) echo $messageStack->output('shopping_cart'); ?>

<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type)); ?>
<div id="cartInstructionsDisplay" class="content"><?php echo TEXT_INFORMATION; ?></div>

<?php if (!empty($totalsDisplay) && false) { ?>
  <div class="cartTotalsDisplay important text-center"><?php echo $totalsDisplay; ?></div>
<?php } ?>

<?php if ($flagAnyOutOfStock) { ?>
  <?php if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
    <div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
  <?php } else { ?>
    <div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
  <?php } //endif STOCK_ALLOW_CHECKOUT ?>
<?php } //endif flagAnyOutOfStock ?>

<table  border="0" width="100%" cellspacing="0" cellpadding="0" id="cartContentsDisplay">
  <tr class="tableHeading">
    <th scope="col" id="scQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>      
    <th style="text-align:center" scope="col" id="scProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
   <!-- <th scope="col" id="scUnitHeading" class="hidden-sm hidden-xs"><?php //echo TABLE_HEADING_PRICE; ?></th> -->
    <th scope="col" id="scTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
    <th scope="col" id="scRemoveHeading">&nbsp;</th>
  </tr>
  <!-- Loop through all products /-->
<?php foreach ($productArray as $product) { ?>
  <tr class="<?php echo $product['rowClass']; ?>">
  
    <!-- Begin Edit_Cart mod Justin  /-->


<!-- End Edit_Cart mod Justin  /--> 
     <td class="cartQuantity">
      <?php
        if ($product['flagShowFixedQuantity']) {
          echo $product['showFixedQuantityAmount'] . '<p class="text-danger"><strong>' . $product['flagStockCheck'] . '</strong></p><p>' . $product['showMinUnits'] . '</p>';
        } else {
          echo '<div class="cart-qty"><input class="cart-qty-input" name="cart_quantity[]" value="' . $_SESSION['cart']->get_quantity($product['id']) . '" maxlength="6" size="4" type="text"><div class="cart-qty-control hidden-sm hidden-xs"><a href="#" class="qty-control cart-qty-inc"><i class="fa fa-angle-up"></i></a><a href="#" class="qty-control cart-qty-dec"><i class="fa fa-angle-down"></i></a></div></div>' . '<p class="text-danger"><strong>'  . '</strong></p><p>'  . '</p>';
        }
      ?>
    </td>

    <td class="cartProductDisplay">
    <?php  //echo $product['linkProductsName']  
	if (empty($_SERVER['HTTPS'])) {
		$product_link = str_replace('http','http',$product_link = $product['linkProductsName']);
	}else{
		$product_link = str_replace('http','http',$product_link = $product['linkProductsName']);
	}
	
	?>
      <div class="products-link "><a class="product-qv" data-toggle="pt-quickview"  href="<?php echo $product_link; ?>"><span id="cartImage" class="back"><?php echo $product['productsImage']; ?></span><span id="cartProdTitle">
<?php echo $product['productsName'];

echo ' [click to edit]';

echo '<span class="alert bold">' . $product['flagStockCheck'] . '</span>'; ?></span></a> 
</span>
        <?php
          echo $product['attributeHiddenField'];
          echo zen_draw_hidden_field('products_id[]', $product['id']);
          if (isset($product['attributes']) && is_array($product['attributes'])) {
          echo '<div class="cartAttribsList">';
          echo '<ul>';
            reset($product['attributes']);
            foreach ($product['attributes'] as $option => $value) {
        ?>
          <li data-toggle="pt-tooltip" data-title="<?php echo $value['products_options_name']; ?>"><?php echo nl2br($value['products_options_values_name']); ?></li>
        <?php
            }
          echo '</ul>';
          echo '</div>';
          }
        ?>
      </div>
    </td>
   <!-- <td class="cartUnitDisplay hidden-sm hidden-xs"><?php //echo $product['productsPriceEach']; ?></td>  -->
    <td class="cartTotalDisplay"><?php echo $product['productsPrice']; ?></td>
    <td class="cartRemoveItemDisplay">
      <?php if ($product['checkBoxDelete'] ) { 
        echo zen_draw_checkbox_field('cart_delete[]', $product['id']);
      } ?>
      <?php if ($product['buttonDelete']) { ?>
        &nbsp;<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>" data-toggle="pt-tooltip" title="<?php echo ICON_TRASH_ALT; ?>"><i class="fa fa-times"></i></a>
      <?php } ?>
    </td>
  </tr>  
<?php } // end foreach ($productArray as $product) ?>
  <tr class="tableFooter">
    <td></td>
    <td class="cartSubTotalText"><?php echo SUB_TITLE_SUB_TOTAL; ?></td>
    <td class="cartSubTotal"><?php echo $cartShowTotal; ?></td>
    <td></td>
  </tr>
<!-- Finished loop through all products /-->
</table>

<!--bof shopping cart buttons-->
<div class=" check-btn"><?php echo '<div href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '" class="pt-button pt-button-m checkout-btn-popout ">' . BUTTON_CHECKOUT_ALT . ' &rarr;</div>'; ?></div>

<!---- zm edit   --->
<div class="pull-left continue-shop"><a href="<?php echo zm_get_current_restaurant_link(); ?>" class="pt-button pt-button-m">&larr; <?php echo BUTTON_CONTINUE_SHOPPING_ALT; ?></a></div>
<?php if (SHOW_SHOPPING_CART_UPDATE == 2 or SHOW_SHOPPING_CART_UPDATE == 3) { ?>
<div class="pull-left cart-update" data-toggle="pt-tooltip" data-title="<?php echo ICON_UPDATE_ALT; ?>"><button type="submit" class="pt-button pt-button-m ">Update Quantities</button></div>
<?php } ?>
<!--eof shopping cart buttons-->
</form>
<div class="clearfix"></div>

<?php if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '1') { ?>
<div class="ship-estimator-button">
  <a href="<?php echo zen_href_link(FILENAME_POPUP_SHIPPING_ESTIMATOR ,'','SSL'); ?>" data-toggle="pt-ajaxlightbox" class="page-popup pt-button pt-button-vs">
    <?php echo BUTTON_SHIPPING_ESTIMATOR_ALT; ?>
  </a>
</div>
<?php } ?>

<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
  include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
}
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
      if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2') {
/**
 * load the shipping estimator code if needed
 */
?>
<hr>
      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>

<?php
      }
?>
<?php
  } else {
?>

<h3 id="cartEmptyText" class="important"><?php echo TEXT_CART_EMPTY; ?></h3>

<?php
$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);

while (!$show_display_shopping_cart_empty->EOF) {
?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') { ?>
<?php
/**
 * display the Featured Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') { ?>
<?php
/**
 * display the Special Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
    include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
  }
?>
<?php
  $show_display_shopping_cart_empty->MoveNext();
} // !EOF
?>
<?php
  }
?>
</div>
</div>
