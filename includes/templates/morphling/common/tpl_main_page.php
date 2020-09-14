<?php

/**
 * Common Template - tpl_main_page.php
 *
 *
 *
 *
 *
 *
 * Governs the overall layout of an entire page<br />
 * Normally consisting of a header, left side column. center column. right side column and footer<br />
 * For customizing, this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * - make a directory /templates/my_template/privacy<br />
 * - copy /templates/templates_defaults/common/tpl_main_page.php to /templates/my_template/privacy/tpl_main_page.php<br />
 * <br />
 * to override the global settings and turn off columns un-comment the lines below for the correct column to turn off<br />
 * to turn off the header and/or footer uncomment the lines below<br />
 * Note: header can be disabled in the tpl_header.php<br />
 * Note: footer can be disabled in the tpl_footer.php<br />
 * <br />
 * $flag_disable_header = true;<br />
 * $flag_disable_left = true;<br />
 * $flag_disable_right = true;<br />
 * $flag_disable_footer = true;<br />
 * <br />
 * // example to not display right column on main page when Always Show Categories is OFF<br />
 * <br />
 * if ($current_page_base == 'index' and $cPath == '') {<br />
 *  $flag_disable_right = true;<br />
 * }<br />
 * <br />
 * example to not display right column on main page when Always Show Categories is ON and set to categories_id 3<br />
 * <br />
 * if ($current_page_base == 'index' and $cPath == '' or $cPath == '3') {<br />
 *  $flag_disable_right = true;<br />
 * }<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_main_page.php 7085 2007-09-22 04:56:31Z ajeh $
 */

// the following IF statement can be duplicated/modified as needed to set additional flags
//print_r($_SESSION['cxx']);
//print_r($_SESSION['cx']);
//print_r($_SESSION['xc']);
//
////foreach($_SESSION['xc'][1590][0] as $r){
////	echo zm_date($r).'<br />';
////}
//echo '<br />'
//.'<br />'
//.'<br />'
//.'<br />';
//foreach($_SESSION['xc'] as $r){
//	echo zm_date($r).'<br />';
//}
//echo floatval(str_replace(':','',$ff['start']));
//print_r($_SESSION['address_separated']);
//print_r($_SESSION);

  if (in_array($current_page_base,explode(",",'')) ) {
    $flag_disable_right = true;
  }

  $header_template = 'tpl_header.php';
  $footer_template = 'tpl_footer.php';
  $left_column_file = 'column_left.php';
  $right_column_file = 'column_right.php';
  $body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);

  if ((COLUMN_LEFT_STATUS == 0 || !in_array($data_themes['pt_base_layout'], array('left', 'both'))) || $this_is_home_page || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
    $flag_disable_left = true;
  }
  if ((COLUMN_RIGHT_STATUS == 0 || !in_array($data_themes['pt_base_layout'], array('right', 'both'))) || $this_is_home_page || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
    $flag_disable_right = true;
  }
?>

<body id="<?php echo $body_id . 'Body'; ?>"<?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?> class="<?php echo $data_themes['pt_container_type']; ?>">
  <div class="outer-wrap">
    <div class="main-wrap">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZR6S44"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php  //$address = 'value="'.random_address().'"';  ?>
<?php  if(!$this_is_home_page && in_array($_GET['main_page'],$search_pages)){  ?>
<!--    
zm edit
bof timecode
-->
<?php
 require($template->get_template_dir('tpl_timecode.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_timecode.php'); 
?>
<!--
eof timecode
bof address
-->
 <?php if(!$this_is_home_page && in_array($_GET['main_page'],$search_pages)){ ?>
<?php
 require($template->get_template_dir('tpl_address_deploy.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_address_deploy.php'); 
?>
<?php  } ?>
<!--
eof address
zm edit
-->
<?php  } 	?>


	<a href="#deletcart-popup" data-toggle="pt-inlightbox" id="delete_cart">

   </a>
  <div id="deletcart-popup" class="pt-popup pt-paddingless mfp-hide">
	<div class="deletcart-deploy-popup-head">
		<div class="popup-title"><?php echo 'Delete Cart?' ?></div>
	</div>
	<div class="deletcart-popup-content" style="height:150px;padding:10px;">
				<p style="margin-bottom:20px">You currently have items in your cart which are unavailable to the new entered address.
                Would you like to delete your cart and use the new address or stick with the current address?
                </p>
                <br />
             <span class='btn btn-default' id='clear_cart' style="float:left">Delete Cart</span>
             <span class='btn btn-default' id='keep_current_address' style="float:right">Keep Current Address</span>
     
	</div>
</div>        
    <div id="circularG">
<div id="circularG_1" class="circularG">
</div>
<div id="circularG_2" class="circularG">
</div>
<div id="circularG_3" class="circularG">
</div>
<div id="circularG_4" class="circularG">
</div>
<div id="circularG_5" class="circularG">
</div>
<div id="circularG_6" class="circularG">
</div>
<div id="circularG_7" class="circularG">
</div>
<div id="circularG_8" class="circularG">
</div>
</div>      

      <!--Header-->
      <?php 
      if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
        $flag_disable_header = true;
      }
      require($template->get_template_dir('tpl_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header.php'); 
      ?>
      <!--Header-->
<?php

?>
      <!-- bof  breadcrumb -->
      <?php if (!$this_is_home_page) { ?>
        <div class="page-head">
          <div class="container">
          <?php  
		  if(isset($_GET['cPath'])){
		 	 $cArray = explode('_',$_GET['cPath']);
		  }
		  if(!isset($cArray) || $cArray[count($cArray)-1]!=1915){
		   ?>
            <h1 class="crumbs reg_crumb"><?php echo $breadcrumb->last(); ?></h1>
			<h5 style="text-align:center"><? if(isset($_SESSION['fooddudestaging_login'])){ 
			$new_res_info = getRestaurantInfo($cArray[count($cArray)-1]);
			echo $new_res_info['phone'].' ';
			echo '- '.$new_res_info['address'];
			 } ?></h5>
    <?php  }else{ 
		 if(isset($_SESSION['address_separated'])){
			 if(isset($_SESSION['address_separated'][0]['apt'])){
				 $disp_apt = ' '.$_SESSION['address_separated'][0]['apt'];
			 }else{
				 $disp_apt = '';
			 }
		 $address_text=$_SESSION['address_separated'][0]['street_number'].' '.$_SESSION['address_separated'][0]['street'].$disp_apt.'<br /><a data-toggle="pt-inlightbox" href="#address-deploy-popup"><span class="" style="margin-left:20px">Change Address</span></a> ';
		 
		 }
	?>
		 <h3 class="crumbs avail_res_crumb"><?php echo $address_text; ?></h3>
		<?php }?>
            <div id="navBreadCrumb"<?php echo ((DEFINE_BREADCRUMB_STATUS == '1' || DEFINE_BREADCRUMB_STATUS == '2') ? '' : ' class="hidden"'); ?>><?php echo $breadcrumb->trail('<span class="breadcrumb-separator"><i class="fa fa-angle-right"></i></span>'); ?></div>
          </div>
        </div>
      <?php } ?>
      <!-- eof breadcrumb -->

      <?php if(!$this_is_home_page){ ?>
      <div id="contentMainWrapper">
        <div class="main-wrap-inner row">
      <?php } ?>

        <!-- Homepage Blocks -->
        <?php if(!$this_is_home_page){ ?>
          <div class="center-column inner-page col-md-<?php echo pt_get_center_column_grid($flag_disable_left, $flag_disable_right); ?> col-sm-12 <?php echo ((!isset($flag_disable_left) || !$flag_disable_left) ? 'col-md-push-3' : ''); ?>">
            <?php require($body_code); ?>
        <?php }else{ ?>
          <div class="center-column">
            <?php require($template->get_template_dir('tpl_index_blocks.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_index_blocks.php'); ?>
        <?php } ?>
            <div class="clearfix"></div>
          </div>
        <!-- Homepage Blocks -->
        

<?php if($this_is_home_page){ ?>

<script>
	$(document).ready(function(e) {
        var bottom_img = $('.index_bg').offset().top+$('.index_bg').height();
		$('#going-down a').css('top',bottom_img-75+'px')
		var where_to_go = $('#going-down-id').offset().top;
 	 	$(window).resize(function () {
			 where_to_go = $('#going-down-id').offset().top;
			 bottom_img = $('.index_bg').offset().top+$('.index_bg').height();
			$('#going-down a').css('top',bottom_img-75+'px')
  		});
		
  		$('#going-down a').click(function (ev) {
    		ev.preventDefault();
    		$('body,html').animate({
      	scrollTop: where_to_go-55
   		 }, 800);
    		return false;
  		});
		$('#going-down').animate({
			opacity:1
		},1000);
    });
	
</script>
<?php	
	 
if(isset($_GET['l']) && !isset($_SESSION['first_search'])){
	if(isset($_SESSION['customer_id']) && isset($_SESSION['customer_default_address_id'])){
		$address = 'value="'.zm_address_label($_SESSION['customer_id'],$_SESSION['customer_default_address_id']).'"';
		$_SESSION['first_search']=1;
		?>
        <script>
		$(document).ready(function(e) {
            $('#pac-input').focus();
			
        });
		</script>
        <?php
	}
	 
}

?>
<div class="overlap_text"><?php echo 'Order delivery from your<br />favorite restaurants' ?></div>
<div class="search_container">
<div class="input-group">
<?php
if(isset($_SESSION['fooddudestaging_login'])){
	//$address ='value="'.random_address().'"';

}
?>
 <!-- matellio code for preventing start -->
 <input id="pac-inputtest" <?php  echo $address  ?> class="search form-control" style="margin-top: 0px;
    box-sizing: border-box;
    height: 50px;
    padding-left: 15px;
    font-size: 20px;
    font-weight: 500;
    text-overflow: ellipsis;
    z-index: 50;" type="text" aria-describedby="search_icon" placeholder="Enter your delivery address">
    <!-- // matellio code for preventing end -->
 <input id="pac-input" <?php  echo $address  ?> class="search form-control" style="display: none;" type="text" aria-describedby="search_icon" placeholder="Enter your delivery address">

 <span class="input-group-addon btn button init-search hidden-sm hidden-xs" id="search-btn-txt"  >Find Restaurants</span>
 <span class="input-group-addon init-search hidden-md hidden-lg" id="search_icon" ><i class="fa fa-search" ></i></span>

 </div>
</div>
<?php  } ?>
        <?php if (!isset($flag_disable_left) || !$flag_disable_left) { ?>
          <div id="left-column" class="col-md-3 col-sm-12 col-md-pull-<?php echo pt_get_center_column_grid($flag_disable_left, $flag_disable_right); ?>"><?php require(DIR_WS_MODULES . zen_get_module_directory('column_left.php')); ?></div>
        <?php } ?>
        
        <?php if (!isset($flag_disable_right) || !$flag_disable_right) { ?>
          <div id="right-column" class="col-md-3 col-sm-12"><?php require(DIR_WS_MODULES . zen_get_module_directory('column_right.php')); ?></div>
        <?php } ?>

      <?php if(!$this_is_home_page){ ?>
        </div><!-- Row -->
      </div>
      <?php } ?>

      <?php
        if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_FOOTER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
          $flag_disable_footer = true;
        }
        require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');
      ?>
      
      <div class="responsive-overlay"></div> 
    </div><!-- Main Wrap -->
  </div><!-- Outer Wrap -->
  <?php if (!$_SESSION['customer_id'] && STORE_STATUS == '0') { ?>
  <!-- Login Modal -->
  <?php require($template->get_template_dir('tpl_login_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_login_header.php'); ?>
  <!-- Login Modal -->
  <?php } ?>
  <?php require($template->get_template_dir('tpl_cart_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_cart_header.php'); ?>
  
<!-- Global site tag (gtag.js) - Google Ads: 1006634219 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-1006634219"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-1006634219');
</script>

</body>
