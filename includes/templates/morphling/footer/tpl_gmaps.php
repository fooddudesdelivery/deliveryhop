<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_whats_new.php 18698 2011-05-04 14:50:06Z wilt $
 */
?>
<div class="widget widget-html-content col-md-4 col-sm-12">  
  <h3 class="widget-title"><span><?php echo zen_decode_specialchars($data_themes['pt_google_maps_title'][$_SESSION['languages_id']]); ?></span></h3>  
  <div class="google-maps">
    <div id="map-canvas" data-map-zoom="<?php echo $data_themes['pt_google_maps_zoom']; ?>" data-map-address="<?php echo $data_themes['pt_google_maps_address']; ?>" data-map-lat="<?php echo $data_themes['pt_google_maps_lat']; ?>" data-map-lon="<?php echo $data_themes['pt_google_maps_lon']; ?>" style="width:320px;height:200px;"></div>
  </div>      
</div>
<script>
  jQuery(window).load(function(){
    loadScript();
  });
</script>