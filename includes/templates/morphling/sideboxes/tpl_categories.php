<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_categories.php 4162 2006-08-17 03:55:02Z ajeh $
 */
  $content = "";
  
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content .= '<ul>' . "\n";
    require_once DIR_WS_CLASSES . 'categories_ul_generator.php'; 
    $zen_categories_side = new zen_categories_ul_generator;
    $menulist = $zen_categories_side->buildTree(true);
    $content .= $menulist;
  $content .= '</ul>' . "\n";
  $content .= '</div>';
?>