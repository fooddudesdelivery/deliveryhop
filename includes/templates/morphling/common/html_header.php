<?php
	/**
	 * Common Template
	 *
	 * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
	 *
	 * @package templateSystem
	 * @copyright Copyright 2003-2012 Zen Cart Development Team
	 * @copyright Portions Copyright 2003 osCommerce
	 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
	 * @version GIT: $Id: Author: DrByte  Tue Jul 17 16:02:00 2012 -0400 Modified in v1.5.1 $
	 */
	// Pepper Framework
	$themes_setting = pt_get_framework_config();
	$data_themes = pt_parse_framework_config($themes_setting);

	require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));

	if(!isset($_SESSION['delivery_time'])){
		$_SESSION['delivery_time']=1;
	}else{
		if($_SESSION['delivery_time']!=1){
			if($_SESSION['delivery_time']<strtotime('now')){
				$_SESSION['delivery_time']=1;
			}
		}
	}
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
	<head>	
		<title><?php echo META_TAG_TITLE; ?></title>
		<meta charset="<?php echo CHARSET; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php if($current_page_base=='product_info'){
			require(DIR_WS_MODULES . zen_get_module_directory('social_share.php'));
		} ?>
		<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
		<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<meta name="generator" content="" />
		<?php if(defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base,explode(",",constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base=='down_for_maintenance' || $robotsNoIndex===true){ ?>
			<meta name="robots" content="noindex, nofollow" />
		<?php } ?>
		<?php if($data_themes['pt_favicon']!=''){ ?>
			<?php if(strpos($data_themes['pt_favicon'], '.ico')===false){ ?>
				<link rel="icon" href="<?php echo $data_themes['pt_favicon']; ?>" type="image/x-icon" />
				<link rel="shortcut icon" href="<?php echo $data_themes['pt_favicon']; ?>" type="image/x-icon" />
			<?php }else{ ?>
				<link rel="icon" type="image/png" href="<?php echo $data_themes['pt_favicon']; ?>" />
			<?php } ?>
		<?php } ?>
		<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />
		<?php if(isset($canonicalLink) && $canonicalLink!=''){ ?>
			<link rel="canonical" href="<?php echo $canonicalLink; ?>" />
		<?php } ?>
		<?php
			/**
			 * load all template-specific stylesheets, named like "style*.css", alphabetically
			 */
			$directory_array = $template->get_template_part($template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css'), '/^style/', '.css');
			while(list ($key, $value) = each($directory_array)) {
				echo '<link rel="stylesheet" type="text/css" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . $value . '?v=1.2" />'."\n";
			}

			/**
			 * load stylesheets on a per-page/per-language/per-product/per-manufacturer/per-category basis. Concept by Juxi Zoza.
			 */
			$manufacturers_id = (isset($_GET['manufacturers_id'])) ? $_GET['manufacturers_id'] : '';
			$tmp_products_id = (isset($_GET['products_id'])) ? (int)$_GET['products_id'] : '';
			$tmp_pagename = ($this_is_home_page) ? 'index_home' : $current_page_base;
			if($current_page_base == 'page' && isset($ezpage_id)) $tmp_pagename = $current_page_base . (int)$ezpage_id;
				$sheets_array = array('/' . $_SESSION['language'] . '_stylesheet',
									'/' . $tmp_pagename,
									'/' . $_SESSION['language'] . '_' . $tmp_pagename,
									'/c_' . $cPath,
									'/' . $_SESSION['language'] . '_c_' . $cPath,
									'/m_' . $manufacturers_id,
									'/' . $_SESSION['language'] . '_m_' . (int)$manufacturers_id,
									'/p_' . $tmp_products_id,
									'/' . $_SESSION['language'] . '_p_' . $tmp_products_id
								);
			while(list ($key, $value) = each($sheets_array)) {
				$perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . $value . '.css';
				if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile .'" />'."\n";
			}

			/**
			 * custom category handling for a parent and all its children... works for any c_XX_XX_children.css where XX_XX is any parent category
			 */
			$tmp_cats = explode('_', $cPath);
			$value = '';
			foreach($tmp_cats as $val){
				$value .= $val;
				$perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/c_' . $value . '_children.css';
				if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile .'" />'."\n";
				$perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $_SESSION['language'] . '_c_' . $value . '_children.css';
				if (file_exists($perpagefile)) echo '<link rel="stylesheet" type="text/css" href="' . $perpagefile .'" />'."\n";
				$value .= '_';
			}

			/**
			 * load printer-friendly stylesheets -- named like "print*.css", alphabetically
			 */
			$directory_array = $template->get_template_part($template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css'), '/^print/', '.css');
			sort($directory_array);
			while(list ($key, $value) = each($directory_array)) {
				echo '<link rel="stylesheet" type="text/css" media="print" href="' . $template->get_template_dir('.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/' . $value . '" />'."\n";
			}
		?>
		<?php
			/**
			 * load all site-wide jscript_*.js files from includes/templates/YOURTEMPLATE/jscript, alphabetically
			 */
			$directory_array = $template->get_template_part($template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/^jscript_/', '.js');
			while(list ($key, $value) = each($directory_array)) {
				echo '<script type="text/javascript" src="' .  $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/' . $value . '?v=3"></script>'."\n";
			}

			/**
			 * load all page-specific jscript_*.js files from includes/modules/pages/PAGENAME, alphabetically
			 */
			$directory_array = $template->get_template_part($page_directory, '/^jscript_/', '.js');
			while(list ($key, $value) = each($directory_array)) {
				echo '<script type="text/javascript" src="' . $page_directory . '/' . $value . '"></script>' . "\n";
			}

			/**
			 * load all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically
			 */
			$directory_array = $template->get_template_part($template->get_template_dir('.php',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/^jscript_/', '.php');
			while(list ($key, $value) = each($directory_array)) {
				/**
				 * include content from all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically.
				 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
				 */
				require($template->get_template_dir('.php',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/' . $value); echo "\n";
			}
			/**
			 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
			 */
			$directory_array = $template->get_template_part($page_directory, '/^jscript_/');
			while(list ($key, $value) = each($directory_array)) {
				/**
				 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
				 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
				 */
				require($page_directory . '/' . $value); echo "\n";
			}
		?>
		<?php if($data_themes['pt_heading_fontface']!='' && $data_themes['pt_heading_fontface']!='Arvo'){ ?>
			<link href="//fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $data_themes['pt_heading_fontface']); ?>:700,400" rel="stylesheet" type="text/css">
		<?php } ?>
		<?php if($data_themes['pt_content_fontface']!='' && $data_themes['pt_content_fontface']!='Lato'){ ?>
			<link href="//fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $data_themes['pt_content_fontface']); ?>:300,400,700,900" rel="stylesheet" type="text/css">
		<?php } ?>
		<style type="text/css">
			<?php echo pt_get_custom_style(); ?>
		</style>
		<?php
			if(in_array($_SERVER['REMOTE_ADDR'],zm_get_restaurant_ips())){
				$_SESSION['restaurant_login']=1;
			}elseif(isset($_SESSION['restaurant_login'])){
				unset($_SESSION['restaurant_login']);	
			}

			if(in_array($_SERVER['REMOTE_ADDR'],zm_get_fooddudestaging_ips())){
				$_SESSION['fooddudestaging_login']=1;	
			}else if(isset($_SESSION['fooddudestaging_login'])){
				unset($_SESSION['fooddudestaging_login']);	
			}

			$search_pages=['index','no_account','login','checkout','checkout_shipping_address'];
			//do not edit this
			if($_GET['main_page']=='checkout'){
				$_SESSION['current_page_category_id']=zm_check_cart();
			}
			$_SESSION['cat_id_for_closed_dates']=zm_get_restaurant_id_for_current_page();
			if($_GET['main_page']=='index' || $this_is_home_page){
				if(true){
					$city_names = front_city_name_array(); ?>
					<script>
						window.city_name_array_from_php = JSON.parse('<?php echo json_encode($city_names); ?>');
					</script>
					<script type="text/javascript" src="includes/location_process/GoogleProcess.js?v=<?php echo time()?>"></script> 
					<script>
						window.goog = new GoogleProcess();
						goog.initilize();
					</script>
					<script src='https://maps.googleapis.com/maps/api/js?key='+GOOGLE_MAP_API_V3_KEY+'&libraries=places,geometry&callback=goog.googleOnload' defer></script>
				<?php
				}else{
				?>
					<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $g_key ?>&libraries=places&callback=googleInit" defer></script>
					<script type="text/javascript" src="https://open.mapquestapi.com/sdk/js/v7.2.s/mqa.toolkit.js?key=iWtagMfwf2smjHAxHUbdNxJZHZgQdwGf" async></script>
				<?php
				}
				?>
		<?php
			}
			$lx = array();
			for($i=0;$i<11;$i++){
				$lx[]=substr(str_shuffle(str_repeat("QWERTYUIOPASDFGHJKLZXCVBNMabcdefghijklmnopqrstuvwxyz", 5)), 0, rand(2,6));
			}
			$gen_number = $lx[0].'3'.$lx[1].'2'.$lx[2].'0'.$lx[3].'3'.$lx[4].'1'.$lx[5].'0'.$lx[6].'6'.$lx[7].'2'.$lx[8].'1'.$lx[9].'6'.$lx[9];
		?>
		<script>
			function googleInit(){
				try{
					window.initializeSearch();
					console.log('loaded');
				}catch(e){
					console.log('not loaded yet');
					setTimeout(googleInit,200);
				}
			}
			window.get_params=<?php echo json_encode($_GET) ?>;
			<?php
			if($_SERVER['REMOTE_ADDR']=='50.188.211.151'){
				echo 'window.fooddudestaging_login=1;';
			}else{
				echo 'window.fooddudestaging_login=0;';
			} ?>

		/* Google Tag Manager */
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PZR6S44');</script>
		<!-- End Google Tag Manager -->
		<meta name="google-site-verification" content="c3tY6hTZxPsu4Qbv59jo-K-9t1LbGymb4VSCg3w-iiE" />
	</head>
