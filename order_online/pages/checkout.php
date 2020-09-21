      <div id="<?php echo ID_PAGE_CHECKOUT ?>" data-role="page" class="ui-page ui-page-theme-a ui-page-header-fixed">
      
              <?php
		$this->displayPage('header');
	?>
    <?php /*?><div class="col-xs-12" style="height:62px;" ></div><?php */?>
    		<div data-role="main" class="ui-content" style="padding:0px;">
          <div class="col-xs-12">
  
          <?php if($this->Config['delivery']['active']){ ?>
               <fieldset>
               <legend class="checkoutlegend"><?php echo TEXT_HEADER_CONTACT ?></legend>
                   <div class="text-center col-xs-12">
                   <div class="panel panel-default">
                   <div class="panel-heading container-fluid">
                   
                   <?php if($this->Config['pickup']['active']){ ?>
                   <fieldset class="ui-grid-a">

                   <div class="ui-block-a" style="padding-right: 10px;"><button   class="checkbtn ui-btn ui-shadow <?php echo CLASS_TOGGLE_TOPICKUP ?>"><?php echo TEXT_PICKUP ?></button></div>
                   <div class="ui-block-b"  style="padding-left: 10px;"><button  class="checkbtn ui-btn ui-shadow checkdelivery <?php echo CLASS_TOGGLE_TODELIVERY ?>"><?php echo TEXT_DELIVERY ?></button></div>
                   </fieldset>
                   <?php }else{ ?>
                   		Delivery Address
<!--                   <div id="checkout-delivery" class="col-xs-12 btn btn-default active <?php //echo CLASS_TOGGLE_TODELIVERY ?>"><?php //echo TEXT_DELIVERY ?></div>
-->                   <?php } ?>
                   
                   </div>
                   <div id="pickup_contact" style="display:none">
                   		<div class="container-fluid">
                            <div class="form-group">
                                <label for="pickup_name" >Name:</label>
                                <input type="text" id="pickup_name" placeholder="Enter your name"/>
                            </div>
                            <div class="form-group">
                                <label for="pickup_number" >Phone Number:</label>
                                <input type="tel" id="pickup_number" placeholder="Enter your phone number"/>
                            </div>
                            <div class="form-group">
                                <label for="pickup_name" >Estimated time for pickup 20 minutes</label>
                            </div>

                        </div>
                   		
                   </div>
                   <div id="<?php echo ID_CHECKOUT_ADDRESS ?>" class="panel-body " style="position:relative">
                 
                      <div class="col-xs-12">
                      	<div class="<?php echo LABEL_CUSTOMER_NAME ?>"></div>
                        <div class="<?php echo LABEL_CUSTOMER_PHONE ?>"></div>
                        <div class="<?php echo LABEL_CUSTOMER_EMAIL ?>"></div>
                      </div>
                      <div class="col-xs-12">
                      	<span class="<?php echo LABEL_DELIVERY_STREET_AND_NUMBER ?>"></span>
                      	<span class="<?php echo LABEL_DELIVERY_APT ?>"></span>
                      </div>
                      <div class="col-xs-12">
                      	<span class="<?php echo LABEL_DELIVERY_CITY ?>"></span> 
                      	<span class="<?php echo LABEL_DELIVERY_STATE ?>"></span>
                      	<span class="<?php echo LABEL_DELIVERY_ZIPCODE ?>"></span>
                      </div>
                   </div>
                   <div id="checkout-address-footer" class="panel-footer" style="padding-top:0px;padding-bottom:0px">
                     <a href="#delivery-contact-page" data-transition="slideup"> <div style="
    font-size: 25px;
    text-align: left;
    line-height: 20px;
    padding: 3px;
    color:black;
"><i class="glyphicon glyphicon-cog"></i></div></a>
                   </div>
                   </div>
                   </div>
               </fieldset>
          <?php } ?>
          
          
               <fieldset>
               <legend class="checkoutlegend"><?php echo TEXT_HEADER_CART ?></legend>
               
               <div id="<?php echo ID_CHECKOUT_CART ?>" class="col-xs-12">
                         
               </div>
               </fieldset>
               
               

              
              
               <fieldset><legend class="checkoutlegend"><?php echo TEXT_HEADER_TOTALS ?></legend>
               <div class="col-xs-12">
               <div class="panel panel-default">
               <div class="panel-body container-fluid">
                 <div class="row">
                 <span class="col-xs-6 text-right"><?php echo TEXT_SUBTOTAL ?></span><span class="col-xs-6 text-left <?php echo CLASS_TOTALS_SUBTOTAL ?>"></span>
                 </div>
                 
                 <div class="row">
                 <span class="col-xs-6 text-right"><?php echo TEXT_TAX ?></span><span class="col-xs-6 text-left <?php echo CLASS_TOTALS_TAX ?>"></span>
                 </div>
                 
                 <div class="<?php echo CLASS_TOGGLE_ISDELIVERY ?>">
                 	<div class="row">
                    <span class="col-xs-6 text-right <?php echo CLASS_TOGGLE_ISDELIVERY ?>"><?php echo TEXT_DELIVERY_FEE ?></span><span class="col-xs-6 text-left <?php echo CLASS_TOTALS_DELIVERY_FEE ?>"></span>
                    </div>
                    
                 	<div class="row <?php echo CLASS_TOGGLE_ISDELIVERY_ANDCREDIT ?>">
                    <span class="col-xs-6 text-right"><?php echo TEXT_TIP ?></span><span class="col-xs-6 text-left <?php echo CLASS_TOTALS_TIP ?>"></span>
                    </div>
                 </div>
                 
                 <div class="row">
                 <span class="col-xs-6 text-right"><?php echo TEXT_GRAND_TOTAL ?></span><span class="col-xs-6 text-left <?php echo CLASS_TOTALS_GRAND_TOTAL ?>"></span>
                 </div>
               </div>
               
               <?php if($this->Config['delivery']['active']){ ?>
                   <div id="<?php echo ID_CHECKOUT_TIP_FOOTER ?>" class="panel-footer text-center <?php echo CLASS_TOGGLE_ISDELIVERY_ANDCREDIT ?>" style="display:none">
                   <div class="col-xs-12 text-center" style="margin-bottom:10px;"><span class="tip-label">Gratuity</span></div>
                   <button type="button" class="btn btn-default tip-btn" data-value="15">15%</button>
                   <button type="button" class="btn btn-default tip-btn" data-value="20">20%</button>
                   <button type="button" class="btn btn-default tip-btn" data-value="25">25%</button>
                   <button id="other_tip" type="button" class="btn btn-default tip-btn" data-value="other">Other</button>
                   </div>
               <?php } ?>
               
               </div>
               
	   <?php if($this->Config['delivery']['active']){ ?>
        <div id="custom-tip" style="display:none">
          <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="tip-dropdown-btn btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span id="tip-option" data-value="percent">% </span><span class="caret"></span>
              </button>
              <ul class="dropdown-menu" style="margin-top: -51px;margin-left: 14px;">
                  <li id="tip-percent"><a>%</a></li>
                  <li id="tip-flat"><a>$</a></li>
              </ul>
            </div><!-- /btn-group -->
          <input id="tip-option-val" type="number" class="form-control" value="0">
          </div>
        </div>
    <?php } ?>
               </div>
               
               
               </fieldset>
              
              
               <fieldset>
               <legend class="checkoutlegend"><?php echo TEXT_HEADER_PAYMENT ?></legend>
               <div class="col-xs-12">

               <div class="ui-field-contain">
                  <select id="<?php echo ID_PAYMENT_SELECTOR ?>" class="" >
                  <option value="x">Select Payment Method</option>
                  </select>
                  </div>
         
                  
     			<?php if($this->Config['pickup']['active'] && $this->Config['pickup']['credit']
					  || $this->Config['delivery']['active'] && $this->Config['delivery']['credit']){ ?>
                   <div id="<?php echo ID_CHECKOUT_CREDIT_CARD_INFO ?>" style="display:none" data-role="none">
                  <form id="<?php echo ID_BRAINTREE_FORM ?>" method="post" data-role="none">
                    <div class="form-group">
                         <label >Card Number</label>
      				     <div id="<?php echo ID_BRAINTREE_CREDIT_CARD ?>" class="form-control"></div>
                    </div>
                    <div class="form-group col-xs-4" style="padding-left:0px">
                         <label >Expiration Month</label>
      				     <div id="<?php echo ID_BRAINTREE_MONTH ?>" class="form-control"></div>
                    </div>
                    <div class="form-group col-xs-4">
          			    <label >Expiration Year</label>
      				    <div id="<?php echo ID_BRAINTREE_YEAR ?>" class="form-control"></div>
                    </div>
                    <div class="form-group col-xs-4" style="padding-right:0px">
                        <label >Cvv code</label>
      					<div id="<?php echo ID_BRAINTREE_CVV ?>" class="form-control"></div>
                    </div>
                    <input id="<?php echo ID_BRAINTREE_SUBMIT ?>" type="submit" value=" " style="display:none !important" data-role="none">
                  </form>
                  </div>

                 <?php } ?>
              </div>
              </fieldset>
              
              <fieldset style="margin-top:20px;margin-bottom:20px">
              	<legend class="" style="text-align:center">Special Instructions</legend>
                <div class="col-xs-12">
                	<textarea id="<?php echo ID_SPECIAL_INSTUC ?>" class="form-control"></textarea>
                </div>
              </fieldset>

          </div>
                      <?php
		$this->getFooter('checkout');
	?>
    <div style="margin-bottom:100px;"></div>
    </div>
      </div>