<?php
/**
 * index category_row.php
 *
 * Prepares the content for displaying a category's sub-category listing in grid format.  
 * Once the data is prepared, it calls the standard tpl_list_box_content template for display.
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: category_row.php 4084 2006-08-06 23:59:36Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
//ini_set('display_errors',true);
if(isset($_SESSION['restaurant_info'])){
	
	if(isset($_SESSION['fooddudestaging_login'])){
		
		$_SESSION['restaurant_info'][1916]=array( 'distance' => 5, 'duration' => 5, 'delivery_fee' => 2.99 );
		//$_SESSION['restaurant_info'][11833]=array( 'distance' => 1, 'duration' => 1, 'delivery_fee' => 2.99 );
	}
	
	//if(isset($_SESSION['customer_id']) && $_SESSION['customer_id']==22){
		//$_SESSION['restaurant_info'][11725]=array( 'distance' => 5, 'duration' => 5, 'delivery_fee' => 2.99 );
		//unset($_SESSION['restaurant_info'][11725]);
	//}
	
	/**/
	if(isset($_SESSION['restaurant_info']) && !empty($_SESSION['restaurant_info'])){
		foreach ($_SESSION['restaurant_info'] as $key => $value) {
			unset($_SESSION['delivery_fee_flag_'.$key]);
			
			//$restaurantinfo = zm_get_restaurant_info($key);
			$restaurantinfo = check_with_restaurant_info($key);
			if(!empty($restaurantinfo[$key]) && !empty($restaurantinfo[$key]['tier_5_distance'])){
				$rf = $restaurantinfo[$key];
				
				/*echo $key."<br /><pre>";
				print_r($rf);
				echo "</pre><br />";*/

				if($value['distance']>$rf['tier_5_distance'] || $value['duration']>$rf['tier_5_time']){
					unset($_SESSION['restaurant_info'][$key]);
					continue;
				}

				if(!empty($rf['estimated_delivery_time']) && $rf['estimated_delivery_time']>0){
					$_SESSION['restaurant_info'][$key]['eta'] = $rf['estimated_delivery_time'];
				}

				if(($value['distance'] > 0 && $value['distance'] < $rf['tier_1_distance']) || ($value['duration']>0 && $value['duration'] < $rf['tier_1_time'])){
					$_SESSION['restaurant_info'][$key]['delivery_fee'] = $rf['tier_1_price'];
					//$_SESSION['restaurant_info'][$key]['tier_duration'] = $rf['tier_1_time'];
					$_SESSION['delivery_fee_flag_'.$key] = 'Local';
				}elseif(($value['distance'] > $rf['tier_1_distance'] && $value['distance'] < $rf['tier_2_distance']) || ($value['duration']>$rf['tier_1_time'] && $value['duration'] < $rf['tier_2_time'])){
					$_SESSION['restaurant_info'][$key]['delivery_fee'] = $rf['tier_2_price'];
					//$_SESSION['restaurant_info'][$key]['tier_duration'] = $rf['tier_2_time'];
					$_SESSION['delivery_fee_flag_'.$key] = 'Local';
				}elseif(($value['distance'] > $rf['tier_2_distance'] && $value['distance'] < $rf['tier_3_distance']) || ($value['duration']>$rf['tier_2_time'] && $value['duration'] < $rf['tier_3_time'])){
					$_SESSION['restaurant_info'][$key]['delivery_fee'] = $rf['tier_3_price'];
					//$_SESSION['restaurant_info'][$key]['tier_duration'] = $rf['tier_3_time'];
					$_SESSION['delivery_fee_flag_'.$key] = 'Local';
				}elseif(($value['distance'] > $rf['tier_3_distance'] && $value['distance'] < $rf['tier_4_distance']) || ($value['duration']>$rf['tier_3_time'] && $value['duration'] < $rf['tier_4_time'])){
					$_SESSION['restaurant_info'][$key]['delivery_fee'] = $rf['tier_4_price'];
					//$_SESSION['restaurant_info'][$key]['tier_duration'] = $rf['tier_4_time'];
					$_SESSION['delivery_fee_flag_'.$key] = 'Local';
				}elseif(($value['distance'] > $rf['tier_4_distance'] && $value['distance'] < $rf['tier_5_distance']) || ($value['duration']>$rf['tier_4_time'] && $value['duration'] < $rf['tier_5_time'])){
					$_SESSION['restaurant_info'][$key]['delivery_fee'] = $rf['tier_5_price'];
					//$_SESSION['restaurant_info'][$key]['tier_duration'] = $rf['tier_5_time'];
					$_SESSION['delivery_fee_flag_'.$key] = 'Local';
				}elseif($value['distance']>$rf['tier_5_distance'] || $value['duration']>$rf['tier_5_time']){
					//$_SESSION['restaurant_info'][$key]['delivery_fee'] = $rf['tier_5_price'];
					//$_SESSION['restaurant_info'][$key]['tier_duration'] = $rf['tier_5_time'];
					unset($_SESSION['restaurant_info'][$key]);
				}
			}else{
				$_SESSION['delivery_fee_flag_'.$key] = 'Global';

			}
		}
	}
	/**/

	$restaurant_info = $_SESSION['restaurant_info'];
	$restaurant_id_list = array_keys($restaurant_info);
}
$new_restaurant=array();
		$closed_restaurants_sql = $db->Execute('
SELECT categories_id
FROM categories
WHERE categories_status =0
AND parent_id
IN (

SELECT categories_id
FROM categories
WHERE parent_id
IN (

SELECT categories_id
FROM categories
WHERE parent_id =1
)
)');
		$closed_restaurants=array();
		while(!$closed_restaurants_sql->EOF){
			$closed_restaurants[]=$closed_restaurants_sql->fields['categories_id'];
			$closed_restaurants_sql->MoveNext();
		}

$first_one=false;
$n=0;
$c_level = zm_get_c_level($_GET['cPath']);
$tmp_m = explode('_',$_GET['cPath']);
$tmp_a = $tmp_m[count($tmp_m)-1];
if($tmp_a!='1915'){
	$view_all=1;
}
if(isset($tmp_a)){
	$out_timezone = $db->Execute("select timezone from categories_description where categories_id = ".intval($tmp_a));
	$current_timezone = $out_timezone->fields['timezone'];
}

if($c_level==3 && !isset($_SESSION['restaurant_info']) && !isset($view_all)){
		echo '<script>window.location.href="'.HTTPS_SERVER.'"</script>';
}
$title = '';
$master_list = '';

if(isset($view_all) || $c_level==4){
	$num_categories = $categories->RecordCount();	
}else{
	$num_categories = count($restaurant_info);	
}
$row = 0;
$col = 0;
$list_box_contents = '';
if ($num_categories > 0) {
  if ($num_categories < MAX_DISPLAY_CATEGORIES_PER_ROW || MAX_DISPLAY_CATEGORIES_PER_ROW == 0) {
    $col_width = floor(100/$num_categories);
  } else {
    $col_width = floor(100/MAX_DISPLAY_CATEGORIES_PER_ROW);
  }

$productsInCategory = zen_get_categories_products_list($cPath, false, true, 0, '');
$categories_count = zm_get_menu_count($_GET['cPath']);

$count_row=0;

/* $c_tz_id = zen_categories_lookup($restaurant_id_list[0],'parent_id');
if(is_numeric($c_tz_id)){
	$state_tz_id = zen_categories_lookup($c_tz_id,'parent_id');
	if(is_numeric($state_tz_id)){
		$s_c_tz = $db->Execute("SELECT timezone FROM timezones WHERE categories_id=$state_tz_id");
		$s_c_tz = $s_c_tz->fields['timezone'];
		//echo $s_c_tz;
		if($s_c_tz==NULL){
			date_default_timezone_set('America/Chicago');
			$_SESSION['new_tz']='America/Chicago';
		}else{
			date_default_timezone_set($s_c_tz);	
			$_SESSION['new_tz']=$s_c_tz;
		}
	}
}
 */
  while ($num_categories>$count_row) {
	  
    $products_array = array();
    $the_list = '';
    if (!$categories->fields['categories_image']) !$categories->fields['categories_image'] = 'pixel_trans.gif';

	if(isset($view_all) || $c_level==4 ){
		$cPath_new = zen_get_path($categories->fields['categories_id']);
	}else{
		$cPath_new = zen_get_path($restaurant_id_list[$count_row]);
	}
	$cArray = explode('_',$cPath_new);
	$current_category = $cArray[count($cArray)-1];
	
	
	$count_row++;

      if($c_level==4){
        $subcat = array();
		
		$get_carray = explode('_',$_GET['cPath']);
		$open_cats_by_time=array();
		$open_cats_by_time=zm_check_if_menu_open($get_carray[count($get_carray)-1],$_SESSION['delivery_time']);
		
	  
        zen_get_subcategories($subcat, $categories->fields['categories_id']);
		$additional_text ='';
		if(is_array($open_cats_by_time) && in_array($current_category,$open_cats_by_time)){
			$this_sub_open=true;
			$open_close_class= 'list-group-item-custom';	
			
		}else{
			$this_sub_open=false;
			$open_close_class= 'list-group-item-custom-closed';
			$tmp_array=array();
			$tmp_array[]=$current_category;
			
			$additional_text =' - '.zm_check_when_open_next(0,$tmp_array);
		}

        $the_list .= '<ul class="category-list-widget drop-sub-menu col-md-12 col-sm-12 list-group" id="menu_'.($row+$col).'">';
          foreach ($subcat as $cat) {
			  if(zen_get_category_name($cat, $_SESSION['languages_id']) !='Restaurant Misc' || $_SESSION['restaurant_login']==1 || $_SESSION['fooddudestaging_login']==1){
				  $names = zen_get_category_name($cat, $_SESSION['languages_id']);
			if( $names !='Fooddudes Misc' && $names !='Food Dudes Misc' || $_SESSION['fooddudestaging_login']==1){
				
				
				if(in_array(intval($current_category),array(990))){
					$superbuffetfix=' order by products_sort_order ';
					
				}else if(in_array(intval($current_category),array(11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11834,11926))){
					
					$superbuffetfix=' order by products_id ';
				}else{
					$superbuffetfix=' order by products_sort_order, products_name ';
				}
				
			pt_get_categories_products_list($products_array, $cat, false, true, 0,' '.$superbuffetfix.'  LIMIT 0, 500');
			$c_name = zen_get_category_name_if_avail($cat);
			if(count($products_array)==0 || $c_name==''){
				$disp_menu_head=' hide-menu ';
			}else{
				$disp_menu_head='';
			}
            $the_list .= '<li id="dropdown_'.$cat.'" class="list-group-item drop-outer-sub-menu '.$disp_menu_head.'" data-toggle="collapse" data-target="#product_list_'.$cat.'">';
             $the_list .=  zen_get_category_name($cat, $_SESSION['languages_id']);
			 	$has_in='';
			if(in_array($cat,explode(',',$_COOKIE['menu_save'])) ){
				$has_in=' in ';
				$lord= 'down';
				$first_one=true;
			}else{
				$lord= 'left';
				
			}
			
			//if($n==0 && count(explode(',',$_COOKIE['menu_save']))==1){$n=1;
//			
//				$has_in=' in ';
//				$lord= 'down';
//			
//			}
			 $the_list.='<span class="outer-sub-menu-icon"><i class="fa fa-chevron-'.$lord.'"></i></span>';
            $the_list .= '</li>';
			
			// zm massive edit start
			 $the_list .= '<ul class="inner-sub-menu collapse '.$has_in.'" id="product_list_'.$cat.'">';

		 if(is_array($products_array[$cat])){
          foreach ($products_array[$cat] as $product) {
			  if($this_sub_open && isset($_SESSION['address_separated'])){
				  $links = '<div href="' . pt_get_full_product_url($product) . '&real_menu='.$categories->fields['categories_id'].'" class="product-qv" data-toggle="pt-quickview" >';
			  }else if($this_sub_open && !isset($_SESSION['address_separated'])){
				  $links ='<div  data-toggle="pt-inlightbox" href="#address-deploy-popup">';
			  }else if(!$this_sub_open && isset($_SESSION['address_separated'])){
				  $links ='<div class="timecode-click" data-toggle="pt-inlightbox" href="#timecode-popup">';
			  }else{
				 $links ='<div  data-toggle="pt-inlightbox" href="#address-deploy-popup">'; 
			  }
            $the_list .= $links.'<li class="'.$open_close_class.'">';
           $the_list .=  '<div class="subcategories-name sub-info ">'.zen_get_products_name($product).'</div>' ;
			  $pro_price=((zen_has_product_attributes_values((int)$product) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$product) . '<meta itemprop="price" content="' . round(zen_get_products_actual_price((int)$product), 2, PHP_ROUND_HALF_UP) . '">';
			  $the_list .=  '<div class="subcategories-price sub-info">'.$pro_price.'</div>' ;
			  $the_list .=  '<br /><div class="subcategories-description sub-info">'.
			  	zen_get_products_description($product).'</div>' ;
              $the_list .= '</li></div>';
          }
		 }
        $the_list .= '</ul>';
		}//res end if
		}//fooduddes end if
		// zm massive edit end
        }
        $the_list .= '</ul>';
    }

//$closed_restaurants = array(80,97,83);

    if($c_level==3 && !in_array($current_category,$closed_restaurants)){
		
        $the_list .= '<div class="restaurant-tab-info-container">distance: '.$restaurant_info[$current_category]['distance'];
          $the_list .= '<div class="restaurant-tab-info info-cuisine">-';
            $the_list .= zm_get_cuisine($current_category);
          $the_list .= '</div>';
		$open_cats=zm_check_if_menu_open($current_category,strtotime('now'));

		  if(count($open_cats)>0){
			  $open_restaurant = '<div class="restaurant-tab-info info-open"> Open'.' </div>';
			  $open_now = true;
		  }else{
			  $open_restaurant ='<div class="restaurant-tab-info info-closed"> '.
			  zm_check_when_open_next($current_category,0).' </div>';
			  $open_now = false;
		  }
            $the_list .= $open_restaurant;
      		$the_list .= '</div>';  	
			
			if(!isset($view_all)){
				$the_list .= '<div class="restaurant-tab-info info-dev-time">';
            	$the_list .= '<i class="fa fa-clock-o"></i>';
				$eta_add=zm_analyze_eta_top_down(zen_get_generated_category_path_ids($current_category));
				/*if(!empty($_SESSION['restaurant_info'][$current_category]['tier_duration']) && !empty($_SESSION['restaurant_info'][$current_category]['eta']) && $_SESSION['restaurant_info'][$current_category]['tier_duration'] != "9999"){
					$res_duration=($_SESSION['restaurant_info'][$current_category]['tier_duration']/60)*1.2+floatval($_SESSION['restaurant_info'][$current_category]['eta']);
				}else{
					$res_duration=($restaurant_info[$current_category]['duration']/60)*1.2+floatval($eta_add);
				}*/
				$res_duration=($restaurant_info[$current_category]['duration']/60)*1.2+floatval($eta_add);
				echo "res_duration ".$restaurant_info[$current_category]['duration'];


				$the_list.=number_format(($res_duration),0);
				//$the_list.=($restaurant_info[$current_category]['duration']*1.2)/60;
         		$the_list .= '</div>duration:'.$restaurant_info[$current_category]['duration'];
	        	$the_list .= '<div class="restaurant-tab-info info-dev-fee">';
           		$the_list .= '<i class="fa fa-usd"></i>';
				$the_list .=money_format('%i',$restaurant_info[$current_category]['delivery_fee']);		
	        	$the_list .= '</div> ';
			}
	}
// zm edit  
      
    
	

// zm edit

if($c_level==3 && !in_array($current_category,$closed_restaurants)){	


if(isset($view_all)){
	$picture = zen_image(DIR_WS_IMAGES . $categories->fields['categories_image'], $categories->fields['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT);
	$name =$categories->fields['categories_name'];
}else{
	$picture=zen_image(DIR_WS_IMAGES . zen_get_categories_image($current_category), $categories->fields['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT);
	$name = zen_get_categories_name($current_category);
}


 $main_res=array('params' => 'href="'.zen_href_link(FILENAME_DEFAULT, $cPath_new).'" class="categoryListBoxContents zm-category-restaurant '.  pt_get_product_grid_class($flag_disable_left, $flag_disable_right) . '"',
                                       'text' => '<div class="categories-img">' .$picture  . '</div>'.'<h4 class=" restaurant-name">'.$name . '</h4>'. $the_list,
										'cPath'=>$cPath_new,
										'open_now'=>$open_now,
										'duration'=>$res_duration,
										'distance'=>$restaurant_info[$current_category]['distance'],
										'panel'=>'<a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '"><div href="'.zen_href_link(FILENAME_DEFAULT, $cPath_new).'" class="categoryListBoxContents zm-category-restaurant '.  pt_get_product_grid_class($flag_disable_left, $flag_disable_right) . '" >' . '<div class="categories-img">' .$picture  . '</div>'.'<h4 class=" restaurant-name">'. $name . '</h4>'. $the_list .  '</div></a>' . "\n",
										'name'=>$name,
										'categories_id'=>$current_category);
	$new_restaurant[]=	$main_res	;							


	}else if($c_level==4){
		$master_list .=$the_list;
		
		if($categories_count==1){
			$disp_menu=' hiddenField ';
			$disp_text_no_menu='<h3 class="categories-name">'.$additional_text.'</h3>';
			$no_show_one=true;
		}else{
			$disp_menu=' ';
		}
		if($additional_text!=''){
			$disp_text='<div style="text-align: center;"><span style="font-size:1.6em;padding-left:5px;line-height:48px;">' . $categories->fields['categories_name'] .'</span><span>'.$additional_text.  '</span></div>';
		}else{
			$disp_text='<h3 class="categories-name  panel-body">' . $categories->fields['categories_name'] . '</h3>';	
			$no_show_two=true;
		}
		if($no_show_two && $no_show_one){
			$no_menu=' hiddenField ';
		}else{
			$no_menu='';	
		}
		if(isset($list_box_contents[$row][$col]['cPath'])){
			$path=$list_box_contents[$row][$col]['cPath'];
		}else{
			$path='';
		}
$list_box_contents[$row][$col] = array('params' => 'href="'.
zen_href_link(FILENAME_DEFAULT, $path).'" class="col-md-6 header-menu '.$no_menu.'"',
                                       'text' => $disp_text_no_menu.'<div id="menu_id_'.($row+$col).'" class="'.$disp_menu.' panel panel-default zm-category-outer-menu" data-show="menu_'.($row+$col).'">'.$disp_text.'</div>',
										'cPath'=>$cPath_new);
	}else if($c_level==5){
		$category_class_in = 'zm-category-inner-menu';
	}


    $col ++;
    if ($col > (MAX_DISPLAY_CATEGORIES_PER_ROW -1)) {
      $col = 0;
      $row ++;
    }
    $categories->MoveNext();
  }

}

?>
