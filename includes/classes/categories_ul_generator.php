<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: categories_ul_generator.php 2004-07-11  DrByteZen $
//      based on site_map.php v1.0.1 by networkdad 2004-06-04
// Fix for line 48 provided by Paulm, uploaded by Kelvyn
// Changes for click-show-hide menu by Cameron, 2008-01-10

// Showing category counts will use default Zen function, which generates massive
// recusive database queries. Could be improved by instead retrieving in a single
// query all products to categories and then using recursive PHP to fetch counts.

class zen_categories_ul_generator {
  var $root_category_id = 0,
      $max_level = 6,
      $data = array(),
      $root_start_string = '',
      $root_end_string = '',
      $parent_start_string = '',
      $parent_end_string = '',
      $parent_group_start_string = '%s<ul>',
      $parent_group_end_string = '%s</ul>',
      $child_start_string = '%s<li>',
      $child_end_string = '%s</li>',
      $spacer_string = '',
	  $count = 0,
      $spacer_multiplier = 1;
  var $document_types_list = ' (3) ';  // acceptable format example: ' (3, 4, 9, 22, 18) '

  function zen_categories_ul_generator($restric_type = '') {
    global $languages_id, $db, $request_type;
    $this->server    = ((ENABLE_SSL == true && $request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER);
    $this->base_href = ((ENABLE_SSL == true && $request_type == 'SSL') ? DIR_WS_HTTPS_CATALOG : DIR_WS_CATALOG);
    $this->data = array();

    if(zen_not_null($restric_type) && $restric_type != ''){
	    $categories_query = "select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " ptc " . 
	                        "where c.categories_id = cd.categories_id and c.categories_status=1 and ptc.category_id = cd.categories_id and ptc.product_type_id = " . $restric_type . " and c.categories_id = ptc.category_id and cd.language_id = '" . (int)$_SESSION['languages_id']  . "'" .
	                        "order by c.parent_id, c.sort_order, cd.categories_name";
	}else{	
		$categories_query = "select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd " . 
	                        "where c.categories_id = cd.categories_id and c.categories_status=1 and c.categories_id NOT IN (select categories_id from " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCT_TYPES . " pt, " . TABLE_PRODUCT_TYPES_TO_CATEGORY . " ptc where pt.type_master_type = 3 and ptc.product_type_id = pt.type_id and c.categories_id = ptc.category_id and c.categories_status=1) and cd.language_id = '" . (int)$_SESSION['languages_id']  . "'" .
	                        "order by c.parent_id, c.sort_order, cd.categories_name";
	}

    $categories = $db->Execute($categories_query);
    while (!$categories->EOF) {
      $products_in_category = (SHOW_COUNTS == 'true' ? zen_count_products_in_category($categories->fields['categories_id']) : 0);
      $this->data[$categories->fields['parent_id']][$categories->fields['categories_id']] = array('name' => $categories->fields['categories_name'], 'count' => $products_in_category);
      $categories->MoveNext();
    }
// DEBUG: These lines will dump out the array for display and troubleshooting:
// foreach ($this->data as $pkey=>$pvalue) { 
//   foreach ($this->data[$pkey] as $key=>$value) { echo '['.$pkey.']'.$key . '=>' . $value['name'] . '<br>'; }
// }
  }

  function buildBranch($parent_id, $level = 0, $cpath = '') {
    global $cPath;
    //$result = "\n".sprintf($this->parent_group_start_string, str_repeat(' ', $level*4))."\n";
    if (isset($this->data[$parent_id])) {
	  
	  $length = count($this->data[$parent_id]);
      foreach ($this->data[$parent_id] as $category_id => $category) {

        if ($level == 0) {
          $result .= $this->root_start_string;
          $new_cpath  = $category_id;
        } else {
          $new_cpath = $cpath."_".$category_id;
        }
				
		//cpath compare for sidebox categories
		$path_array = explode('_', $cPath);
		if(pt_has_category_subcategories($category_id)){
			if(in_array($category_id, $path_array)){
				$result .= '<li>';
			}else{
				$result .= '<li>';
			}
		}else{
			if(in_array($category_id, $path_array)){
				$result .= '<li>';
			}else{
				$result .= '<li>';
			}
		}

		if(pt_has_category_subcategories($category_id)){
			if(in_array($category_id, $path_array)){
				$result .= '<a ' . ($category_id == end($path_array) ? 'class="side-active"' : '' ) . ' href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $new_cpath) . '"><i class="icon-angle-right"></i> ' . $category['name'] . '</a>';
				$result .= '<span class="expand-btn" data-toggle="collapse" data-target="#catSide_'.$category_id.'"></span>'; 
    		}else{
                $result .= '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $new_cpath) . '"><i class="icon-angle-right"></i> ' . $category['name'] . '</a>';               
				$result .= '<span class="expand-btn collapsed" data-toggle="collapse" data-target="#catSide_'.$category_id.'"></span>';             	
			}
		}else{
			if(in_array($category_id, $path_array)){
				$result .= '<a ' . ($category_id == end($path_array) ? 'class="side-active"' : '' ) . ' href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $new_cpath) . '"><i class="icon-angle-right"></i> ' . $category['name'] . (zen_count_products_in_category($category_id) > 0 ? '<span class="has-products">' . zen_count_products_in_category($category_id) . '</span>' : '') . '</a>';
			}else{
				$result .= '<a href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . $new_cpath) . '"><i class="icon-angle-right"></i> ' . $category['name'] . (zen_count_products_in_category($category_id) > 0 ? '<span class="has-products">' . zen_count_products_in_category($category_id) . '</span>' : '') . '</a>';
			}
		}
		
		$cat = array();
		zen_get_parent_categories($cat, $category_id);
		$cat_count = count($cat);
		if($cat_count==0){
			$result .= '';
		}else{
			if(pt_has_category_subcategories($category_id)){
                if(in_array($category_id, $path_array)){
				    $result .= '<ul id="catSide_'.$category_id.'" class="childCat collapse in">';
                }else{
                    $result .= '<ul id="catSide_'.$category_id.'" class="childCat collapse">';
                }
			}else{
				$result .= '';
			}
		}
		
		$cat = array();
		zen_get_parent_categories($cat, $category_id);
		$cat_count = count($cat);
		if($cat_count==0 && pt_has_category_subcategories($category_id)){
            if(in_array($category_id, $path_array)){
			     $result .= '<ul id="catSide_'.$category_id.'" class="childCat collapse in">';
            }else{
                 $result .= '<ul id="catSide_'.$category_id.'" class="childCat collapse">';
            }
		}else{
			$result .= '';
		}
        if ($level == 0) {
          $result .= $this->root_end_string;
        }
        if (isset($this->data[$category_id])) {
          $result .= $this->parent_end_string;
        }
        if (isset($this->data[$category_id]) && (($this->max_level == '0') || ($this->max_level > $level+1))) {

          $result .= $this->buildBranch($category_id, $level+1, $new_cpath);
		  		
				$cat = array();
				zen_get_parent_categories($cat, $category_id);
				$cat_count = count($cat);
				if($cat_count==0){
					$result .= '';
				}else{
					if(pt_has_category_subcategories($category_id)){
						$result .= '</ul>';
					}else{
						$result .= '';
					}
				}
				
		$cat = array();
		zen_get_parent_categories($cat, $category_id);
		$cat_count = count($cat);
		if($cat_count==0){
			$result .= '</ul>';
		}else{
			$result .= '';
		}
				
          $result .= sprintf($this->child_end_string, str_repeat(' ', $level*4+2))."\n";
		  		
        } else {
          $result .= sprintf($this->child_end_string, '')."\n";
        }
	
      }
    }
   return $result;
  }

  function buildTree() {
  	global $db, $current_page_base;
	
    $main_menu = $this->buildBranch($this->root_category_id, 0);
	$misc_menu = '';
		    /*Added misc link on sidebar nav*/
	    if (SHOW_CATEGORIES_BOX_SPECIALS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true' or SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
	// display a separator between categories and links
	    if (SHOW_CATEGORIES_SEPARATOR_LINK == '1') {
	      //$misc_menu .= '</ul>'. "\n" . '<hr id="catBoxDivider" />' . "\n" . '<ul class="categories-side">' . "\n";
	    }
	    if (SHOW_CATEGORIES_BOX_SPECIALS == 'true') {
	      $show_this = $db->Execute("select s.products_id from " . TABLE_SPECIALS . " s where s.status= 1 limit 1");
	      if ($show_this->RecordCount() > 0) {
	      	if($current_page_base == 'specials'){
	      		$misc_menu .= '<li><a class="parent-active" href="' . zen_href_link(FILENAME_SPECIALS) . '">&rarr; ' . CATEGORIES_BOX_HEADING_SPECIALS . '</a></li>' . "\n";
	      	}else{
	      		$misc_menu .= '<li><a href="' . zen_href_link(FILENAME_SPECIALS) . '">&rarr; ' . CATEGORIES_BOX_HEADING_SPECIALS . '</a></li>' . "\n";	
	      	}
      	  }
	    }
	    if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true') {
	      // display limits
	//      $display_limit = zen_get_products_new_timelimit();
	      $display_limit = zen_get_new_date_range();
	
	      $show_this = $db->Execute("select p.products_id
	                                 from " . TABLE_PRODUCTS . " p
	                                 where p.products_status = 1 " . $display_limit . " limit 1");
	      if ($show_this->RecordCount() > 0) {
	      	if($current_page_base == 'products_new'){
	        	$misc_menu .= '<li><a class="side-active" href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">&rarr;  ' . CATEGORIES_BOX_HEADING_WHATS_NEW . '</a></li>' . "\n";
			}else{
				$misc_menu .= '<li><a href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">&rarr;  ' . CATEGORIES_BOX_HEADING_WHATS_NEW . '</a></li>' . "\n";
			}
		  }
	    }
	    if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true') {
	      $show_this = $db->Execute("select products_id from " . TABLE_FEATURED . " where status= 1 limit 1");
	      if ($show_this->RecordCount() > 0) {
	      	if($current_page_base == 'featured_products'){
	        	$misc_menu .= '<li><a class="side-active" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">&rarr;  ' . CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS . '</a></li>' . "\n";
	        }else{
	        	$misc_menu .= '<li><a href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">&rarr;  ' . CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS . '</a></li>' . "\n";	        	
	        }
	      }
	    }
	    if (SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
	    	if($current_page_base == 'products_all'){
	      		$misc_menu .= '<li><a class="side-active" href="' . zen_href_link(FILENAME_PRODUCTS_ALL) . '">&rarr;  ' . CATEGORIES_BOX_HEADING_PRODUCTS_ALL . '</a></li>' . "\n";
			}else{
				$misc_menu .= '<li><a href="' . zen_href_link(FILENAME_PRODUCTS_ALL) . '">&rarr;  ' . CATEGORIES_BOX_HEADING_PRODUCTS_ALL . '</a></li>' . "\n";
			}
		}
	  }

	return $main_menu;
  }
}
?>
