<?php
/**
 * category_tree Class.
 *
 * @package classes
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: category_tree.php 3041 2006-02-15 21:56:45Z wilt $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * category_tree Class.
 * This class is used to generate the category tree used for the categories sidebox
 *
 * @package classes
 */
class menu_tree {

  var $data = '';
  var $parent = '';

  function menu_tree($data = array(), $parent = 0){
    $this->data = $data;
    $this->parent = $parent;
  }
  
  function populate_menu_tree($parent = 0, $prefix = 'menu-main-'){
    if(is_array($this->data)){
      foreach ($this->data as $value) {
          if($value['parent_id'] == $parent){
              $content .= '<li id="' . $prefix . $value['id'] . '"' . ($value['has_child'] == 'true' ? ' class="dd-parent ' . ($value['mega'] == 'true' ? 'mega' : '') . '"' : '') . '>';
                  $content .= '<a href="' . str_replace('&', '&amp;', zen_output_string($value['url'])) . '" title="' . zen_output_string($value['title']) . '"' . ($value['new_window'] == 'true' ? 'target="_blank"' : '') . '>' . ($value['parent_id'] == 0 ? '' : '') . zen_decode_specialchars($value['label']) . (($value['has_child'] == 'true' && $value['parent_id'] == 0) ? '' : '') . ($value['parent_id'] == 0 ? '' : '') . '</a>';
                  
                  if($value['has_child'] == 'true'){
                    $content .= '<span class="child-button visible-sm visible-xs collapsed" data-toggle="collapse" data-target="#cID-' . $value['id'] . '"></span>';
                  }

                  if($value['mega'] == 'true' && $value['has_child'] == 'true'){
                    $content .= '<div id="cID-' . $value['id'] . '" class="mega-inner collapse">';
                  }

                    if($value['mega'] == 'true' && $value['has_child'] == 'true'){
                      $content .= $this->populate_mega_menu($value['id']);
                    }elseif ($value['has_child'] == 'true'){
                      $content .= '<ul id="cID-' . $value['id'] . '"  class="dd-menu collapse">';
                        $content .= $this->populate_menu_tree($value['id'], $prefix);
                      $content .= '</ul>';
                    }

                  if($value['mega'] == 'true' && $value['has_child'] == 'true'){
                    $content .= '</div>';
                  }

              $content .= '</li>';
          }
      }
    }

    return $content;
  }

  function populate_mega_menu($parent = 0){

    $content = '';
    
    foreach ($this->data as $value) {
      if($value['parent_id'] == $parent){
        $content .= '<div class="dd-menu">';
          $content .= '<span class="mega-title"><a href="' . str_replace('&', '&amp;', zen_output_string($value['url'])) . '" title="' . zen_output_string($value['title']) . '"' . ($value['new_window'] == 'true' ? 'target="_blank"' : '') . '>' . zen_decode_specialchars($value['label']) . '</a></span>';
          if($value['has_child'] == 'true'){

            $content .= '<span class="child-button visible-sm visible-xs collapsed" data-toggle="collapse" data-target="#cID-' . $value['id'] . '"></span>';

            $content .= '<ul id="cID-' . $value['id'] . '" class="collapse">';
              foreach ($this->get_children($value['id']) as $children) {
                $content .= '<li><a href="' . str_replace('&', '&amp;', zen_output_string($children['url'])) . '" title="' . $children['title'] . '" ' . ($children['new_window'] == 'true' ? 'target="_blank"' : '') . '>' . zen_decode_specialchars($children['label']) . '</a><li>';
              }
            $content .= '</ul>';
          }
        $content .= '</div>';
      }
    }

    return $content;

  }

  function get_children($parent = 0){

    $children = array();

    foreach ($this->data as $value) {
      if($value['parent_id'] == $parent){
        $children[] = $value;
      }
    }

    return $children;
  }
}
