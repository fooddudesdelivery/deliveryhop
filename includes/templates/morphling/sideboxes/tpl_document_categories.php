<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_document_categories.php 2975 2006-02-05 19:33:51Z birdbrain $
 */

  $content = "";
  
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content .= '<ul>' . "\n";
    require_once DIR_WS_CLASSES . 'categories_ul_generator.php'; 
    $zen_categories_side = new zen_categories_ul_generator(3);
    $menulist = $zen_categories_side->buildTree(true);
    $content .= $menulist;
  $content .= '</ul>' . "\n";
  $content .= '</div>';
?>