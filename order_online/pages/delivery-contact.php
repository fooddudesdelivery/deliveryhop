
<?php if($this->Config['delivery']['active']){ ?> 
        <div id="<?php echo ID_PAGE_DELIVERY_CONTACT ?>" data-role="page" class="ui-page ui-page-theme-a ui-page-header-fixed">
        <?php
		$this->displayPage('header');
	?>
    		<div data-role="main" class="ui-content" style="padding:0px;">
            <div class="container-fluid" style="padding:0px;"> 
            
            <div class="col-xs-12" style="    text-align: center;
    font-weight: bold;
    font-size: 25px;
    background-color: <?php echo $this->Config['primary_color'] ?> !important;
    color: white;
    text-shadow: 0 2px 0 black;
    margin-bottom: 40px;padding-top:15px;
    padding-bottom:15px;">Enter Your Address</div>
                <form id="main_del_form" style=" padding-left: 0px;
    padding-right: 0px;" class="col-xs-12"><div class="container-fluid">
                     		<div class="col-xs-10" style="padding:0px;">
                            <input 
                            id="<?php echo ID_GOOGLE_ADDRESS_SEARCH_TEXT ?>" 
                            placeholder="<?php echo TEXT_GOOGLE_SEARCH_PLACEHOLDER ?>" 
                            type="text" 
                            class=" form-control google_address_text" 
                            value=""
                     		style="height: 45.8px;text-shadow:none !important;border-radius:0px !important;"
                            autocomplete="off"
                            aria-describedby="<?php echo ID_GOOGLE_ADDRESS_SEARCH_BUTTON ?>" />
                            </div>
                            <div style="padding:0px;font-size:25px;margin-top:-4px;" class="col-xs-2"><button id="<?php echo ID_GOOGLE_ADDRESS_SEARCH_BUTTON ?>" type="button" class="google_address_button" style="padding:5px;"><i class="glyphicon glyphicon-search"></i></button></div>
                   
            		<div id="mapcont" class="col-xs-12" style="padding:0px;width:100%;height:350px;margin-top:20px;margin-bottom:20px;">
                    <div id="gmap" style="width:100%;height:100%"></div>
                    </div>
                    
                    <div id="<?php echo ID_CONTACT_FORM ?>" style="display:none;padding:0px" class="col-xs-12">
                    <div class="form-group">
                      <label for="<?php echo ID_CUSTOMER_NAME ?>">Name</label>
                      <input id="<?php echo ID_CUSTOMER_NAME ?>" type="text" class="form-control"   placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_CUSTOMER_PHONE ?>">Phone</label>
                      <input id="<?php echo ID_CUSTOMER_PHONE ?>" type="tel" class="form-control"  placeholder="Phone">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_CUSTOMER_EMAIL ?>">Email</label>
                      <input id="<?php echo ID_CUSTOMER_EMAIL ?>" type="email" class="form-control"  placeholder="Email">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_DELIVERY_STREET_AND_NUMBER ?>">Address</label>
                      <input id="<?php echo ID_DELIVERY_STREET_AND_NUMBER ?>" type="text" class="form-control"  placeholder="Address">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_DELIVERY_APT ?>">Apt/Suite</label>
                      <input id="<?php echo ID_DELIVERY_APT ?>" type="text" class="form-control"  placeholder="Apt/Suite">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_DELIVERY_CITY ?>">City</label>
                      <input id="<?php echo ID_DELIVERY_CITY ?>" type="text" class="form-control"  placeholder="City">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_DELIVERY_STATE ?>">State</label>
                      <input id="<?php echo ID_DELIVERY_STATE ?>" type="text" class="form-control"  placeholder="State">
                    </div>
                    <div class="form-group">
                      <label for="<?php echo ID_DELIVERY_ZIPCODE ?>">Zipcode</label>
                      <input id="<?php echo ID_DELIVERY_ZIPCODE ?>" type="number" class="form-control"  placeholder="Zipcode">
                    </div>
               		</div>
                    </div>
                </form>
            </div>
            <div style="height:40px;">
            
            </div>
            </div>
            <?php
		$this->getFooter('delivery-contact');
	?>
        </div>
<?php } ?> 