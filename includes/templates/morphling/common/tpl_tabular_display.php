<?php
/**
 * Common Template - tpl_tabular_display.php
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_tabular_display.php 3957 2006-07-13 07:27:06Z drbyte $
 */
?>
<div class="product-list-wrapper">
  <div class="product-list">
  <?php if(!$error_categories){ ?>
  <?php
    for($row=0; $row<sizeof($list_box_contents); $row++) {
      $r_params = "";
      $c_params = "";
      if (isset($list_box_contents[$row]['params'])) $r_params .= ' ' . $list_box_contents[$row]['params'];
  ?>
    <div class="pt-list-item item-standard <?php echo pt_get_product_grid_class($flag_disable_left, $flag_disable_right); ?> row">
  <?php
      for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
        if (isset($list_box_contents[$row][$col]['text'])) {
  ?>
     <?php echo $list_box_contents[$row][$col]['text'] ?>
  <?php
        }
      }
  ?>
    </div>
  <?php
    }
  ?>
  <?php }else{ ?>
  <?php
    for($row=0; $row<sizeof($list_box_contents); $row++) {
      $r_params = "";
      $c_params = "";
      if (isset($list_box_contents[$row]['params'])) $r_params .= ' ' . $list_box_contents[$row]['params'];
  ?>
    <div class="pt-list-item item-standard <?php echo pt_get_product_grid_class($flag_disable_left, $flag_disable_right); ?> row">
  <?php
      for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
        if (isset($list_box_contents[$row][$col]['text'])) {
  ?>
     <?php echo $list_box_contents[$row][$col]['text'] ?>
  <?php
        }
      }
  ?>
    </div>
  <?php
    }
  ?>
  <?php } ?>
  </div>
</div>