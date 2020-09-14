<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_products_next_previous.php 6912 2007-09-02 02:23:45Z drbyte $
 */

/*
 WebMakers.com Added: Previous/Next through categories products
 Thanks to Nirvana, Yoja and Joachim de Boer
 Modifications: Linda McGrath osCommerce@WebMakers.com
*/

?>
<div class="navNextPrevWrapper">
<?php
// only display when more than 1
  if ($products_found_count > 1) {
?>
	<div class="prev-next">    
	    <?php if($position == 0){ ?>
	    <a href="javascript:void(0);" class="button button-disabled">&larr; <?php echo TEXT_PREV; ?></a>
	    <a href="<?php echo zen_href_link(zen_get_info_page($next_item), "cPath=$cPath&products_id=$next_item"); ?>" class="button" data-toggle="pt-tooltip" title="<?php echo zen_get_products_name($next_item); ?>"><?php echo TEXT_NEXT; ?> &rarr;</a>
	    <?php }elseif($position == $counter - 1){ ?>
	    <a href="<?php echo zen_href_link(zen_get_info_page($previous), "cPath=$cPath&products_id=$previous"); ?>" class="button" data-toggle="pt-tooltip" title="<?php echo zen_get_products_name($previous); ?>">&larr; <?php echo TEXT_PREV; ?></a>
	    <a href="javascript:void(0);" class="button button-disabled"><?php echo TEXT_NEXT; ?> &rarr;</a>
	    <?php }else{ ?>
		<a href="<?php echo zen_href_link(zen_get_info_page($previous), "cPath=$cPath&products_id=$previous"); ?>" class="button" data-toggle="pt-tooltip" title="<?php echo zen_get_products_name($previous); ?>">&larr; <?php echo TEXT_PREV; ?></a>
		<a href="<?php echo zen_href_link(zen_get_info_page($next_item), "cPath=$cPath&products_id=$next_item"); ?>" class="button" data-toggle="pt-tooltip" title="<?php echo zen_get_products_name($next_item); ?>"><?php echo TEXT_NEXT; ?> &rarr;</a>
	    <?php } ?>
	</div>
    <?php
  }
?>
</div>
<div class="clearfix"></div>
