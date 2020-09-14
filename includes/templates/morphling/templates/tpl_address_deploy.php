<?php





?>



<div id="address-deploy-popup" class="pt-popup pt-paddingless mfp-hide">
	<div class="address-deploy-popup-head">
		<div class="popup-title"><?php echo DEPLOY_ADDRESS; ?></div>
</div>
	<div class="address-deploy-popup-content">
    	 <div class="input-group deploy-container">
  			 <input id="pac-inputtest" <?php  echo $address  ?> class="search form-control" style="margin-top: 0px;
			    box-sizing: border-box;
			    height: 50px;
			    padding-left: 15px;
			    font-size: 20px;
			    font-weight: 500;
			    text-overflow: ellipsis;
			    z-index: 50;" type="text" aria-describedby="search_icon" placeholder="Enter your delivery address">
  			<input type="text" <?php echo $address  ?> id="pac-input" class="form-control" style="display: none;"  placeholder="Enter your delivery address" aria-describedby="deploy-search">

  			<span class="input-group-addon btn init-search-popup hidden-sm hidden-xs" id="search-btn-txt">Update Address</span>
             <span class="input-group-addon init-search-popup hidden-md hidden-lg" id="search_icon"><i class="fa fa-search"></i></span>

		</div>
     
	</div>
</div>