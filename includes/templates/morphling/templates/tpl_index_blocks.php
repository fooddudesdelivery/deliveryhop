<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
?>
<?php
$data_blocks = pt_get_framework_config('PT_HOME_BLOCKS');
$blocks = pt_parse_framework_config($data_blocks);

if(is_array($blocks['block_contents'])){
	foreach($blocks['block_contents'] as $key=>$value){
		if($key=='pt_slider'){?>
			<section class="index_bg"></section>
			<span id="going-down" class="hidden-sm hidden-xs"><a><i class="fa fa-angle-down"></i></a></span>
		<?php
		}else{
			// bof howto zm edit
			if($key=="pt_grid_content3"){?>
				<div class="row main_zm_container how-to-cont" id="going-down-id">
					<div class="col-md-10 col-md-offset-1"> 
						<div class="col-md-12  how-to-order-boxes-head">How to Order</div>
						<div class="col-md-2 col-md-offset-1 how-to-order-boxes"><img src="<?php echo DIR_WS_IMAGES . 'pepper/map-pointer.png'?>" alt="Address" width="100%" style="max-width:170px" /><br />Enter Address</div>
						<div class="col-md-2 col-md-offset-2 how-to-order-boxes"><img src="<?php echo DIR_WS_IMAGES . 'pepper/menu.png'?>" alt="Menu" width="100%" style="max-width:170px" /><br />Select Restaurant</div>
						<div class="col-md-2 col-md-offset-2 how-to-order-boxes"><img src="<?php echo DIR_WS_IMAGES . 'pepper/cutlery.png' ?>" alt="Order" width="100%" style="max-width:170px" /><br />Place Order</div>
					</div>
				</div>
		<?php
			// eof how to zm edit
			}else if($key=="pt_banner3"){?>
				<!-- bof locations zm edit -->
				<div class="row main_zm_container">
					<div class="col-md-8 col-md-offset-2">
						<div class="locations_head">Locations</div>
						<div class="col-md-3 state_block">
						<div class="state_head">Colorado</div>
							<div class="city_head"><a href="grandjunction">Grand Junction</a></div>
							<div class="city_head"><a href="montrose">Montrose</a></div>
						</div>
						<div class="col-md-3 state_block">
						<div class="state_head">Iowa</div>
							<div class="city_head"><a href="desmoines">Des Moines</a></div>
							<div class="city_head"><a href="siouxcity">Sioux City</a></div>
						</div>
						<div class="col-md-3 state_block">
						<div class="state_head">North Dakota</div>
							<div class="city_head"><a href="bismarck">Bismarck</a></div>
							<div class="city_head"><a href="fargo">Fargo</a></div>
							<div class="city_head"><a href="grandforks">Grand Forks</a></div>
							<div class="city_head"><a href="minot">Minot</a></div>
						</div>
						<div class="col-md-3 state_block">
						<div class="state_head">South Dakota</div>
							<div class="city_head"><a href="rapidcity">Rapid City</a></div>
							<div class="city_head"><a href="siouxfalls">Sioux Falls</a></div>
						</div>
						<div class="col-md-3 state_block">
						<div class="state_head">Minnesota</div>
							<div class="city_head"><a href="alexandria">Alexandria</a></div>
							<div class="city_head"><a href="brainerd">Brainerd</a></div>
							<div class="city_head"><a href="duluth">Duluth</a></div>
							<div class="city_head"><a href="mankato">Mankato</a></div>
							<div class="city_head"><a href="rochester">Rochester</a></div>
							<div class="city_head"><a href="saintcloud">Saint Cloud</a></div>
							<div class="city_head"><a href="twincities">Twin Cities</a></div>
							<div class="city_head"><a href="willmar">Willmar</a></div>
						</div>
						<div class="col-md-3 state_block">
						<div class="state_head">Wisconsin</div>
							<div class="city_head"><a href="foxcities">Fox Cities</a></div>
							<div class="city_head"><a href="greenbay">Green Bay</a></div>
							<div class="city_head"><a href="manitowoc">Manitowoc</a></div>
							<div class="city_head"><a href="manitowoc">Two Rivers</a></div>
						</div>
					</div>
				</div>
				<div class="downloadapp">
					<div class="state_head">Download Food Dudes App</div>
					<div style="text-align:center">
						<a href="https://itunes.apple.com/us/app/food-dudes/id1180442819?mt=8" target="_blank">
						<img src="<?php echo DIR_WS_IMAGES.'/app_store.png'?>" alt="App Store" width="100%" style="max-width:170px" /></a>&nbsp;&nbsp;
						<a href="https://play.google.com/store/apps/details?id=io.cordova.fddcustomer&hl=en_US" target="_blank"><img src="<?php echo DIR_WS_IMAGES.'/google_play.png'?>" alt="Google Play" width="100%" style="max-width:170px" /></a>
					</div>
				</div>
				<!-- eof locations zm edit -->
		<?php
			}else{?>
				<section class="<?php echo $key; ?> <?php echo ($value['type'] == 'carousel' ? 'pt_carousel' : ''); ?> <?php echo $value['type']; ?>-block section-content" style=" <?php echo ($value['bodybg_color'] != '' ? 'background-color:' . $value['bodybg_color'] . ';' : 'background-color:#fff;') . ($value['bodybg_img'] != '' ? 'background-image:url(' . $value['bodybg_img'] . ');' : '') . ($value['bodybg_cover'] == 'true' ? ' background-size:cover;' : '') . ($value['bodybg_fixed'] == 'true' ? ' background-attachment:fixed;' : ''); ?>">
	
					<?php if($value['type'] == 'carousel'){ ?>
						<div class="preloader-wrap"><div class="preloader"></div></div>
					<?php } ?>

					<div class="section-content-inner<?php echo ($value['type']=='carousel'?'hide-first':''); ?>"<?php echo (($value['type']=='module' && $value['content_color']!=''?'style="color:'.$value['content_color'].';"':'')); ?>>

						<?php if($value['title'][$_SESSION['languages_id']]!='' || $value['subtitle'][$_SESSION['languages_id']]!=''){ ?>
							<div class="section-header <?php echo $key.'_sec' ?>">
								<?php
								if($value['title'][$_SESSION['languages_id']]!=''){ ?>
									<h1 class="<?php echo $key.'_head' ?> featured_title"><?php echo zen_decode_specialchars($value['title'][$_SESSION['languages_id']]); ?></h1>
								<?php } ?>
								<?php
								if($value['subtitle'][$_SESSION['languages_id']] != ''){
									if($key=='pt_fun_fact'){?>
										<div class="custom-home">
											<?php echo zen_decode_specialchars(base64_decode($value['subtitle'][$_SESSION['languages_id']]));?>
										</div>
								<?php
									}else{
								?>
										<p class="section-subtitle">
											<?php echo zen_decode_specialchars($value['subtitle'][$_SESSION['languages_id']]); ?>
										</p>
								<?php
									}
								} ?>
							</div>
						<?php }
						switch($value['type']){
							case 'grid':
								echo '<div class="row">';
								for($i=0;$i<$value['num'];$i++){
									echo '<div class="' . $key . '-item col-md-' . (12/$value['num']) . ' col-sm-6">';
										if($value['icon'][$i] != ''){
											echo '<div class="' . $key . '-icon"><i class="fa ' . $value['icon'][$i] . '"></i></div>';
										}
										if($value['image'][$i] != ''){
											echo '<div class="' . $key . '-img"><img src="' . $value['image'][$i] . '" alt=""></div>';
										}
										if($value['html'][$i][$_SESSION['languages_id']] != ''){
											echo '<div class="' . $key . '-text">' . zen_decode_specialchars($value['html'][$i][$_SESSION['languages_id']]) . '</div>';
										}
									echo '</div>';
								}
								echo '</div>';
								break;
							case 'banner':
								$num = count($value['image']);
								echo '<div class="row">';
								foreach ($value['image'] as $banner) {
									echo '<div class="col-md-' . (12/$num) . '">';
									echo '<img src="' . $banner . '" alt="Banner">';
									echo '</div>';
								}
								echo '</div>';
								break;
							case 'html':
								echo zen_decode_specialchars($value['html'][$_SESSION['languages_id']]);
								break;
							case 'carousel':
								require($template->get_template_dir($value['name'],DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . $value['file']);
								break;
							default:
								require($template->get_template_dir($value['name'],DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . $value['file']);
								break;
						}?>
					</div>
				</section>
			<?php
			}
		}
	}
}
?>
