<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

  $zc_show_twitter = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PT_TWITTER));
?>
<!-- bof: Twitter Slider -->
<?php if ($zc_show_twitter == true) { ?>
<div class="tweet-carousel owl-carousel">
<?php
/**
 * require the carousel_display to display product carousel
 */
  require($template->get_template_dir('tpl_carousel_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_carousel_display.php');
?>
</div>
<?php } ?>
<!-- eof: Twitter Slider -->
