<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_specials_default.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_specials = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_SPECIALS_INDEX));
?>
<!-- bof: specials -->
<?php if ($zc_show_specials == true) { ?>
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
<?php } ?>
<!-- eof: specials -->
