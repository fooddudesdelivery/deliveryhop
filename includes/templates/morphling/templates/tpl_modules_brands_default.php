<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_whats_new.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_brands = true;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PT_BRANDS));
  
?>
<!-- bof: brands -->
<?php if ($zc_show_brands == true) { ?>
<div class="brand-carousel owl-carousel">
<?php
/**
 * require the carousel_display to display product/brand carousel
 */
  require($template->get_template_dir('tpl_carousel_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_carousel_display.php');
?>
</div>
<?php } ?>
<!-- eof: brands -->
