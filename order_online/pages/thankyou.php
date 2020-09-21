    <div id="<?php echo ID_PAGE_THANKYOU  ?>" data-role="page">
    <?php
		$this->displayPage('header');
	?>
    	<div data-role="main" class="ui-content" >
        <div class="col-xs-12 h2 text-center">
            <?php echo TEXT_THANK_YOU ?>
        </div>
        <div class="col-xs-12 h4 text-center">
            <?php echo TEXT_YOUR_ORDER_NUMBER ?><span id="<?php echo ID_FINAL_ORDERS_ID ?>"></span>
        </div>
        <div class="col-xs-12">
        
            <div class="panel panel-default <?php echo CLASS_TOGGLE_ISDELIVERY ?>">
            <div class="panel-body">
<?php /*?>                <legend><?php echo TEXT_HEADER_CONTACT ?></legend>
<?php */?>                <div class="text-center col-xs-12">
                    <div class="col-xs-12">
                      	<span class="<?php echo LABEL_CUSTOMER_NAME ?>"></span>
                    </div>
                    <div class="col-xs-12">
                      <span class="<?php echo LABEL_DELIVERY_STREET_AND_NUMBER ?>"></span>
                      <span class="<?php echo LABEL_DELIVERY_APT ?>"></span>
                   </div>
                    <div class="col-xs-12">
                      <span class="<?php echo LABEL_DELIVERY_CITY ?>"></span>, 
                      <span class="<?php echo LABEL_DELIVERY_STATE ?>"></span>
                      <span class="<?php echo LABEL_DELIVERY_ZIPCODE ?>"></span>
                    </div>
                </div>
            </div>
            </div>
     
               <?php /*?> <legend><?php echo TEXT_HEADER_CART ?></legend><?php */?>
                <div id="<?php echo ID_THANKYOU_CART ?>" class="col-xs-12"></div>

            
            <div class="panel panel-default">
            <div class="panel-body">
            	<?php /*?><legend><?php echo TEXT_HEADER_TOTALS ?></legend><?php */?>
               <div class="col-xs-12">

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
            </div></div>
            
            <div class="panel panel-default">
            <div class="panel-body">
<?php /*?>                <legend><?php echo TEXT_HEADER_PAYMENT ?></legend>
<?php */?>                	<div class="col-xs-12 text-center <?php echo LABEL_PAYMENT_TYPE ?>">
                </div>
            </div>
            </div>
        </div>
         </div>
    </div>