	<div id="<?php echo ID_PAGE_START ?>"  data-role="page" class="">
<?php
		$this->displayPage('header');
	?>
    <div data-role="main" class="ui-content">
		<div id="start-spacer" class="col-xs-12"></div>
        <div id="start_div" class="col-xs-12">
        
       		<?php if($this->Config['delivery']['active'] && $this->Config['pickup']['active']){ ?>
                      <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                          <a href="#<?php echo ID_PAGE_MAIN_MENU ?>"   data-transition="slide"
                          style="
    font-size: 36px;
    padding-top: 15px;
    padding-bottom: 15px;
" 
                          class="ui-btn ui-shadow ui-corner-none <?php echo CLASS_TOGGLE_TOPICKUP  ?>"
                     
                           
                          ><?php echo TEXT_PICKUP ?></a>
                      </div>
            
                      <div class="start-page-row col-xs-12 text-center">
                          <h3 style="height:32px;margin:0px;"><span id="orLabel" class="label label-default" style="border-radius:0px;background-color:<?php echo $this->Config['primary_color'] ?>;color:white;text-shadow: 0 /*{a-body-shadow-x}*/ 2px /*{a-body-shadow-y}*/ 0 /*{a-body-shadow-radius}*/ black /*{a-body-shadow-color}*/;"><?php echo TEXT_START_PAGE_OR  ?></span></h3>
                      </div>

                      <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                          <a 
                          class="ui-btn ui-shadow ui-corner-none <?php echo CLASS_TOGGLE_TODELIVERY  ?>"
                          href="#<?php echo ID_PAGE_DELIVERY_CONTACT ?>"  
                          data-transition="slideUp" 
                                      style="
    font-size: 36px;
    padding-top: 15px;
    padding-bottom: 15px;
" 
                          ><?php echo TEXT_DELIVERY ?></a>
                          </div>
               
			<?php } ?>        
           
        </div>
           </div>
    </div>