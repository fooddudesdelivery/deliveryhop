<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @creator IronLady
 * @modded by m0dn3dit
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
?>

<?php
//
$_SESSION['rewards_page']=0;
$_SESSION['current_page_category_id']=zm_get_restaurant_id_for_current_page();
$c_level = zm_get_c_level($_GET['cPath']);
if(isset($_SESSION['fooddudestaging_login'])){
	//print_r($_SESSION);
	
}
$epic_restaurant_array = array();
echo'<div class="row">';
if($c_level==4){
	$cArray = explode('_',$_GET['cPath']);
	$current_category = $cArray[count($cArray)-1];
	$open_cats=zm_check_if_menu_open($current_category,strtotime('now'));
	
	if(!isset($_SESSION['fooddudestaging_login'])){
	?>
    <script>
	$(document).ready(function(e) {
       // $('.drop-outer-sub-menu')[0].click();
    });
	</script>
    <?php
	}
	echo'<div class="col-md-4 col-md-push-8 timecode-container">';
	//this contains the timecode
	echo '<div class="col-sm-12 timecode-container-inner">';
	

	 if(isset($_SESSION['delivery_time']) && $_SESSION['delivery_time'] !=''){
		 if($_SESSION['delivery_time']==1){
			 if($open_cats==0){
				 $time_text='Select Time';
			 }else{
				 $time_text='ASAP';
			 }
			
		 }else{
			$time_text=zm_date($_SESSION['delivery_time']); 
		 }
		 
	 }
	?>
    
	      <a href="#timecode-popup" data-toggle="pt-inlightbox" class="timecode-click">
            <div class="panel panel-default sidebox-panels">
                 <h4 class="categories-name timecode-text"><?php echo $time_text ?></h4>
			</div>
          </a>
     <?php
	 $address_text = ' Enter Delivery Address ';
	 if(isset($_SESSION['address_separated'])){
		 $address_text=$_SESSION['address_separated'][0]['street_number'].' '.$_SESSION['address_separated'][0]['street'];
		 
	 }
	 $size_of_address='h4';
	 if(strlen($address_text)>22){
		 $size_of_address='h4';
	 }
	 if(strlen($address_text)>26){
		 $size_of_address='h5';
	 }
	 if(strlen($address_text)>40){
		 $size_of_address='h6';
	 }
	 ?>
          <a href="#address-deploy-popup" data-toggle="pt-inlightbox">
			<div class="panel panel-default sidebox-panels">
                 <?php echo '<'.$size_of_address ?> class="categories-name address-deploy-text"><?php echo $address_text ?></ <?php echo $size_of_address ?>>
			</div>
          </a>
	
	
	<?php
	if(isset($_SESSION['fooddudestaging_login']) && $_SESSION['fooddudestaging_login']==1){
		echo '<input id="drop-close" class="btn btn-default" value="Drop Menu" type="button">';
		?>
        <script>
		$(document).ready(function(e) {
            //$('#drop-close').click();
        });
		</script>
        <?php
	}
	echo '</div>';
	echo'</div>';
	echo'<div class="col-md-8 col-md-pull-4 ">';	
	echo'<div class="row">';
	
}
if (is_array($list_box_contents) > 0 ) {
 for($row=0;$row<sizeof($list_box_contents);$row++) {
    $params = '';
    for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
      $r_params = '';
      if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
        if (isset($list_box_contents[$row][$col]['text'])) {
?>

<?php 



if($c_level==3){
	

}else if($c_level==4){

	echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n";	


}else if($c_level==5){
echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n"; 	
}


?>

<?php
      }
    }
  }
}


if($c_level==3){
	//start by sorting by open time

		//print_r($epic_restaurant_array);
		//print_r($new_restaurant);
		//array_multisort($new_restaurant);
		$epic_restaurant_array = array_sort($new_restaurant,'open_now',SORT_DESC);
		$all_restaurant_ids=array();
		foreach($epic_restaurant_array as $cd){
			$all_restaurant_ids[]=$cd['categories_id'];
		}
		
	//
	$farthest_restaurants=array();
	try{
		$farthest_restaurants = array_values(getRestaurantDistance($all_restaurant_ids));
	}catch(Exception $e){
		
	}
	
	$open_array=array();
	$closed_array=array();
	if(isset($_SESSION['fooddudestaging_login'])){
		//print_r($epic_restaurant_array);die;
	}
	//then split open and closed into two arrays
	foreach($epic_restaurant_array as $key=>$e){
		if(in_array($e['categories_id'],$farthest_restaurants)){
			unset($epic_restaurant_array[$key]);
		}
		
		if($e['open_now']){
			$open_array[]=$e;
		}else{
			$closed_array[]=$e;
		}
	}
	
	/*echo "<br /><pre>";
	print_r($epic_restaurant_array);
	echo "<br /></pre>";
	exit();*/

	//then sort those two arrays by drive time if they can order/ name if they cant
	
	if($epic_restaurant_array[0]['distance']!=''){
		$open_array = array_sort($open_array,'distance');
		$closed_array = array_sort($closed_array,'distance');
	}else{
		if( isset($_SESSION['customers_lat_lng'][0]) && !empty($_SESSION['customers_lat_lng'][0]) && isset($_SESSION['customers_lat_lng'][1]) && !empty($_SESSION['customers_lat_lng'][1]) ){
			$open_array = array_sort($open_array,'distance');
			$closed_array = array_sort($closed_array,'distance');
		}else{
			$open_array = array_sort($open_array,'name');
			$closed_array = array_sort($closed_array,'name');		
		}
	}

	//then combine those two arrays back into one
	$epic_restaurant_array=array_merge($open_array,$closed_array);
	//then get all the restaurant names into another array
	foreach($epic_restaurant_array as $e){
		$names[]=$e['name'];	
	}
	//find the keys of duplicate values and unset those values since its sorted by time the furthest one will be unset
	foreach(array_values(get_keys_for_duplicate_values($names)) as $dup){
		foreach($dup as $key => $r){
			unset($epic_restaurant_array[$r]);
		}
	}
	//finally display the panels	
	$has_new_sort=false;
	$new_panel='';
	
	foreach($epic_restaurant_array as $key=>$epic){
			if($epic['name']=='Vitta Pizza' || $epic['name']=='Kwik Trip' || $epic['categories_id']==26147 || $epic['categories_id']==26158){
				$new_panel.=$epic['panel'];
				unset($epic_restaurant_array[$key]);
				$has_new_sort=true;
			}
		if($epic['name']=='All Cities'){
			unset($epic_restaurant_array[$key]);
		}
	}
	if($has_new_sort){
		echo $new_panel;
	}
	foreach($epic_restaurant_array as $epic){
	
			echo $epic['panel'];	
	}
		
}


if($c_level==4){
	
	//
	//this contains the products and subcategories lists
	echo $master_list;
	
	echo'</div>';
	echo'</div>';
	echo'<script>window.current_page=1</script>';
}
	echo'</div>';

?> 

