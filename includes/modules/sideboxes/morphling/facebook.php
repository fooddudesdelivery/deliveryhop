<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

$title =  BOX_HEADING_FACEBOOK;
$title_link = false;

require($template->get_template_dir('tpl_facebook.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_facebook.php');
require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);