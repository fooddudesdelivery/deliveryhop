<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_upcoming_products.php 6422 2007-05-31 00:51:40Z ajeh $
 */

  require_once(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PT_UPCOMING));
?>

<div class="<?php echo ($this_is_home_page ? 'product-carousel owl-carousel' : 'product-list after-product-listing'); ?>">
<?php
/**
 * require the list_box_content template to display the product
 */
  if($this_is_home_page){
    require($template->get_template_dir('tpl_carousel_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_carousel_display.php');
  }else{
    require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
  }
?>
</div>
<!-- eof: featured products  -->
