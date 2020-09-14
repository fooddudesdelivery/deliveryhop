<?php
/**
 * Common Template - tpl_header.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_header.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_header = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Tue Aug 14 14:56:11 2012 +0100 Modified in v1.5.1 $
 */
?>

<?php if(!isset($flag_disable_header) || !$flag_disable_header){ ?>
	<header id="header" class="header-wrap <?php echo $data_themes['pt_header_type']; ?> <?php echo ($data_themes['pt_header_sticky']=='true' ? 'sticky' : ''); ?>">
		<div id="main-nav">
			<noscript>
				<div class="messageStack messageStackError larger" style="position:fixed;width:100%;z-index:9999999">Food Dudes Delivery relies heavily on javascript, please enable it in your browser or you may not be able to order.</div>
				<div style="height:40px"></div>
			</noscript>
			<div class="nav-top hidden">
	  			<div class="container">
					<div class="info-top">
						<ul>
							<?php
							if(zen_decode_specialchars($data_themes['pt_header_content'][$_SESSION['languages_id']])){
								echo '<li><a href="">'.zen_decode_specialchars($data_themes['pt_header_content'][$_SESSION['languages_id']]).'</a></li>';
							}else{
								if(isset($_SESSION['customer_id'])){
									echo'<li><a>Hi, '.zm_get_first_name().'</a></li>'; 
								}
							} ?>
						</ul>
					</div>
				<?php
				$top_menu = pt_get_menu('1'); 
				?>
					<nav class="menu-top">
						<ul>
							<?php if ($_SESSION['customer_id']) { ?>
								<li>
									<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a>
								</li>
							<?php } ?>
							<?php if(is_array($top_menu)){
									foreach($top_menu as $menu){
										if($menu['label']=='Rewards'){
							  				echo '<li id="menu-top-'.$menu['id'].'" style="display:none"><a title="" style="cursor:pointer" >'.$menu['label'].'</a></li>';	
							  				break;
						  				}
						  				if($menu['label']=='Live Chat'){
											if($_SESSION['live_chat']==0 || !isset($_SESSION['live_chat'])){
												$live='Live Chat';
											}else{
												$live='Stop Chat';
											}
										?>
											<li style="display:none" id="menu-top-<?php echo $menu['id']; ?>" class="live_chat">
												<a style="cursor:pointer" title="<?php echo $title ?>" id="chat_text">
													<?php echo  $live ?>
												</a>
											</li>
									<?php
										}else{?>
											<li id="menu-top-<?php echo $menu['id']; ?>"><a href="<?php echo str_replace('&', '&amp;', zen_output_string($menu['url'])); ?>" title="<?php echo zen_output_string($menu['title']); ?>" <?php echo ($menu['new_window'] == 'true' ? 'target="_blank"' : ''); ?>><?php echo zen_decode_specialchars($menu['label']); ?></a></li>
										<?php
										}
									} ?>
							<?php }
								if($data_themes['pt_languages_header'] == 'true'){
									require(DIR_WS_MODULES . PT_NAME . '/languages.php'); 
								}
							if($data_themes['pt_currencies_header'] == 'true'){
								require(DIR_WS_MODULES . PT_NAME . '/currencies.php'); 
							}?>
						</ul>
					</nav>
					<div class="clearfix"></div>
				</div>
			</div>
		<?php if(isset($_SESSION['customer_id'])){?>
			<div class='hidden' style="background-color:#E9E9E9;height:1px;"></div>
		<?php } ?>
	<div class="nav-bot">
	<?php
		$message_err = get_stack_error();
		if($message_err !=2){
			echo '<div class="messageStack messageStackError larger" style="margin-bottom: 0px;">
		<i class="fa fa-warning"></i> '.$message_err.'<button data-dismiss="alert" class="close" type="button">
			<span aria-hidden="true">×</span>
			<span class="sr-only">Close</span>
			</button>
			</div>';
		}
		?>
		<div id="messageStackHeader">
		<div id="new_js_error" class="messageStack messageStackError larger" style="width:100%;z-index:9999999;display:none;"></div>
		<?php
		if ($messageStack->size('header') > 0) {
		  echo $messageStack->output('header');
		}
		?>

		<?php
		if ($messageStack->size('upload') > 0) echo $messageStack->output('upload');

		if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
			echo htmlspecialchars(urldecode($_GET['error_message']), ENT_COMPAT, CHARSET, TRUE);
		}
		if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
			echo htmlspecialchars($_GET['info_message'], ENT_COMPAT, CHARSET, TRUE);
		}
		?>
	  
	  <div class="container">
	  
		<!-- Mobile Menu Button -->
		<span id="menu-button" class="visible-sm visible-xs">
		  <a href="#">
			<span class="bar-wrap">
			  <span class="bar first"></span>
			  <span class="bar"></span>
			  <span class="bar last"></span>
			</span>
		  </a>
		</span>
		<!-- Mobile Menu Button -->
		<h1 class="logo"><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>"><img src="<?php echo $data_themes['pt_logo']; ?>" alt="<?php echo STORE_NAME; ?>" class="img-responsive"></a></h1>
		<?php 
		  $main_menu = pt_get_menu('2');
		  require_once (DIR_WS_CLASSES . 'menu_tree.php');
		  $menu = new menu_tree($main_menu);
		?>
		<div class="header-nav-menu-wrap">             
		  <nav class="main-menu">
			<ul class="menu">
			  <?php echo $menu->populate_menu_tree(); ?>
			</ul>
		  </nav>
		  <nav class="misc-menu">
			<ul>														   
							   <?php
		if($_SESSION['cart']->count_contents()>0){
				echo'<li class="account-list"><a href="'.HTTP_SERVER .'/index.php?main_page=checkout">';   
				echo'Checkout</a></li>'; 
			}
		if($_SESSION['cart']->count_contents()>0){
			$das_link= zm_get_current_restaurant_link();
			echo'<li class="account-list"><a href="'.$das_link .'">';   
			echo RETURN_TO_RESTAURANT.'</a></li>';
		}
?>
<?php if(count($_SESSION['restaurant_info'])>0 ){ ?>
		<li class="account-list" ><a href="<?php echo _SITE_FRONT_URL.'?main_page='.FILENAME_DEFAULT.'&cPath=1_1914_1915'  ?>" >Restaurants  
			</a></li>
<?php } ?>
	
<li class="account-list">
<a href="javascript:void(Tawk_API.toggle())">Live Chat</a>
</li>
<?php
			if($_SESSION['customer_id']){  ?>
				<li class="account-list"><a href="<?php echo _SITE_FRONT_URL.'?main_page='.FILENAME_ACCOUNT  ?>" >My Account  
			</a></li>
			<?php  }
			  if ($_SESSION['customer_id']) { ?>
				<li class="account-list"><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
			  <?php 
				}else{ 
				  if (STORE_STATUS == '0') {
			  ?>
				<li class="account-list"><a href="<?php echo zen_href_link('create_account') ?>">Sign Up</a></li>
				<li class="account-list"><a href="#login-popup" data-toggle="pt-inlightbox">Login</a></li>
			  <?php 
				  } 
				}
			  ?>
			  <li class="cart-list hidden-sm hidden-xs"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', $request_type, false)  ?>" ><span class="cart-item"><?php echo $_SESSION['cart']->count_contents(); ?></span><span class="cart-total"><?php echo $currencies->format($_SESSION['cart']->show_total()); ?></span></a></li>
			  
			  </ul>
 		  </nav>
		</div>
		<!-- Mobile Cart Button -->
		<span id="cart-button" class="visible-sm visible-xs">
		  <a href="#cart-popup" data-toggle="pt-inlightbox">
			<span class="bag-handle"></span>
			<span class="bag-body">
			  <span class="cart-item"><?php echo $_SESSION['cart']->count_contents(); ?></span>
			</span>
		  </a>
		</span>
		<!-- Mobile Cart Button -->
	  </div>
	</div>
	</div>
  </div>
</header>
<?php } 
if($_SESSION['fooddudestaging_login']==1){
}
?>