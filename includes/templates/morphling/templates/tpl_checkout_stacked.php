<?php 

if(isset($_SESSION['tip_updated'])){
	echo '<script>window.tip_updated=1</script>';
}
	// no cash begin
$hide_cod_ = false;
if(!empty($_SESSION['current_page_category_id'])){ 
    $cod_ = $db->Execute("SELECT cod FROM categories INNER JOIN categories_description ON(categories.parent_id=categories_description.categories_id) Where categories.categories_id='".$_SESSION["current_page_category_id"]."'");
    if($cod_->fields['cod'] == "N"){
        $hide_cod_ = true;
    }    
}
// no cash end
?>
<script type="text/javascript" language="javascript"><!--//

window.current_page=66;
var selected;
var submitter = null;

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function couponpopupWindow(url) {
  window.open(url,'couponpopupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function submitFunction(jQuerygv,jQuerytotal) {
  if (jQuerygv >=jQuerytotal) {
    submitter = 1;	
  }
  jQuery('div#checkout form').attr({
    name: 'checkout_payment',
    onsubmit: 'return true;',
    action: '<?php echo SITE_FRONT_URL.'/index.php?main_page=fec_confirmation&fecaction=process';?>'
  }); 
}

function methodSelect(theMethod) {
  if (document.getElementById(theMethod)) {
    document.getElementById(theMethod).checked = 'checked';
  }
}

function updateForm() {
  jQuery('div#checkout form').attr({
    name: 'checkout_payment',
    onsubmit: 'return true;',
    action: 'index.php?main_page=checkout&fecaction=update'
  });
  jQuery('div#checkout form').submit(); 
}

jQuery(document).ready(function() {
  jQuery('.fec_discount .button_update').click(function() {
  	return updateForm();
  });
});
//--></script>


<script>
$(document).ready(function(e) {
	
	$('.shipping_btn_exp').click(function(){
		//$('#shipping_btn_stan').attr('checked',false);
		//$('#shipping_btn_exp').attr('checked',true);
		//updateForm();
	});
	$('.shipping_btn_stan').click(function(){
		//$('#shipping_btn_stan').attr('checked',true);
		//$('#shipping_btn_exp').attr('checked',false);
		//updateForm();
	});
	$('.btn').addClass('checkout-btn');
	$('.no-check').removeClass('checkout-btn');
	$('.init-search-popup').removeClass('checkout-btn');
	$('#time-save').removeClass('checkout-btn');
	var total_checkout  = parseFloat($('.ottotal_price').html().replace("$", "").replace(/,/g, ""));
	console.log(total_checkout);
	$('.tip-row label').click(function(){
		calc_tip_button(this.id);	
	});
$('#checkout_tip_id').keyup(function(e) {
    calc_tip_keyup();
});

function calc_tip_button(id){
	var tip_val = parseFloat($('#checkout_tip_id').val());
	if(isNaN(tip_val)){
		tip_val =0;
			
	}
	//console.log(total_checkout);
	//console.log(tip_val);
	if(id=='cash'){
		$('#checkout_tip_id').hide();
		$('.ottip_price').html('Cash');
		if(!window.tip_updated){
			$('.ottotal_price').html('$'+total_checkout.toFixed(2));
		}
		$('.final_total').html('$'+total_checkout.toFixed(2));
		$('#add_tip').val(0);
	}
	if(id=='flat'){
		$('#checkout_tip_id').show();
		$('.ottip_price').html('$'+tip_val.toFixed(2));
		if(!window.tip_updated){
			$('.ottotal_price').html('$'+(total_checkout+tip_val).toFixed(2));
		}
		
		$('.final_total').html('$'+(total_checkout+tip_val).toFixed(2));
		$('#add_tip').val(tip_val);
	}
	if(id=='percent'){
		$('#checkout_tip_id').show();
		var percent = ((tip_val/100)*total_checkout);
		$('.ottip_price').html('$'+percent.toFixed(2));
		if(!window.tip_updated){
			$('.ottotal_price').html('$'+(total_checkout+percent).toFixed(2));
		}
		
		$('.final_total').html('$'+(total_checkout+percent).toFixed(2));
		$('#add_tip').val(percent.toFixed(2));
	}
}

function calc_tip_keyup(id){
	var tip_val = parseFloat($('#checkout_tip_id').val());
	if(isNaN(tip_val) || tip_val<0){
		tip_val =0;
		console.log(tip_val);	
	}
	if($('#cash').hasClass('active')){
		$('#checkout_tip_id').hide();
		$('.ottip_price').html('Cash');
		$('.ottotal_price').html('$'+total_checkout.toFixed(2));
		$('.final_total').html('$'+total_checkout.toFixed(2));
		$('#add_tip').val(0);
	}
	if($('#flat').hasClass('active')){
		$('#checkout_tip_id').show();
		$('.ottip_price').html('$'+tip_val.toFixed(2));
		$('.ottotal_price').html('$'+(total_checkout+tip_val).toFixed(2));
		$('.final_total').html('$'+(total_checkout+tip_val).toFixed(2));
		$('#add_tip').val(tip_val);
	}
	if($('#percent').hasClass('active')){
		$('#checkout_tip_id').show();
		var percent = ((tip_val/100)*total_checkout);
		$('.ottip_price').html('$'+percent.toFixed(2));
		$('.ottotal_price').html('$'+(total_checkout+percent).toFixed(2));
		$('.final_total').html('$'+(total_checkout+percent).toFixed(2));
		
		$('#add_tip').val(percent);
	}
}

	<?php

	if(isset($_SESSION['form_submit_save']['payment'])){
		?>
		$('#lbl-<?php echo $_SESSION['form_submit_save']['payment'] ?>').click();
		<?php
	}
	?>
<?php if(!isset($_SESSION['form_submit_save']['hold-tip'])){ ?>	
	<?php if(!isset($_SESSION['fooddudestaging_login']) && !isset($_SESSION['restaurant_login'])){  ?>
		$('#percent').click();
	<?php }else if($_SESSION['restaurant_login']){ ?>	
		$('#percent').click();
	<?php }else{ ?>
		$('#flat').click();
	<?php } ?>	
<?php }else{ ?>
	$(".tipa").click();
<?php }?>


    <?php
	if(isset($_SESSION['COWOA']) && $_SESSION['COWOA']==1){
	?>
	$('#special-pay-1').click(function(e){
		e.preventDefault();
		e.stopPropagation();
		alert('Please create an account or login to use Gift Certificates');
	});
	<?php
	}
	?>
});

$(document).ready(function() {
    $("#checkout_tip_id").click(function() { $(this).select(); } );
});
</script>
<?php 



$is_gift_card=$_SESSION['is_gift_card'];
	if(!isset($_SESSION['fast_ship'])){
		$_SESSION['fast_ship']=false;
	}
	
echo '<script>console.log('.json_encode($order).')</script>';
if($order->products[0]['tax'] && $order->products[0]['tax']>0){
	$_SESSION['real_tax']=$order->products[0]['tax'];
}else if($order->products[1]['tax'] && $order->products[1]['tax']>0){
	$_SESSION['real_tax']=$order->products[1]['tax'];
}
//print_r($_SESSION);


if($is_gift_card || $_SESSION['is_gift_card_non_rewards']){
	
}else{
	if(!isset($_SESSION['COWOA'])){
		zm_add_address_to_book();
	}
}

if(isset($_SESSION['fooddudestaging_login'])){
	//print_r($_SESSION);
	
}

$credit_covers = false;
if(isset($_SESSION['company_shipping'])){
	update_company_shipping($_SESSION['sendto'],$_SESSION['company_shipping']);	
}
if(isset($_SESSION['suburb_shipping'])){
	update_suburb_shipping($_SESSION['sendto'],$_SESSION['suburb_shipping']);	
}

// echo $_SESSION['form_submit_save']['payment'];
//print_r($_SESSION);
//this is vitally important
?>

<?php
    echo zen_draw_hidden_field('shipping', 'flat_flat') ;
    if (FEC_SPLIT_CHECKOUT == 'true') {
        $splitColumns = "split-column";
    }

?>
<?php
if(isset($_SESSION['sendto']) && $_SESSION['sendto']>0){
$zone_idsc = $db->Execute('select entry_zone_id from address_book where address_book_id="'.$_SESSION['sendto'].'"');
if($zone_idsc->fields['entry_zone_id']==0 && !$new_zip_update){
	//echo $zone_ids->fields['entry_zone_id'];
	//die;
?>
<script>
$(document).ready(function(e) {
    $('#myModal').modal({ show: false, backdrop: 'static', keyboard: false});
	$('#myModal').modal('show');
	$(document).on('click','#close_zip',function(){
		var new_zip = $('#new_zip_id').val();
		$.ajax(
		{
		  url:"zm_ajax.php",
		  type:'post',
		  dataType:"JSON",
		  data:{recalc_zip:new_zip},
		  success: function(data){
			  if(data.done==1){
					location.reload();  
			  }
		  },error: function(data){
			  
		  }
		}
		);
		//$('#myModal').modal('hide');
		//location.reload();
	});
});
</script>
<?php
}
}
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title" id="myModalLabel">Please enter your zipcode</h4>
      </div>
        <div class="modal-body">
          <div class="form-group">
              <label for="new_zip_id">Enter Zipcode:</label>
              <input type="number" name="new_zip" class="form-control" id="new_zip_id" placeholder="Zipcode"/>
          </div>
        </div>
        <div class="modal-footer" style="height:40px">
          <button id="close_zip" type="button" class="btn btn-default" style="border:1px solid #ef6f00">Save</button>
        </div>
    </div>
  </div>
</div>
<div class="fec-container">
  <ul class="checkout-columns">
  	<li class="checkout-leftcolumn <?php echo $splitColumns; ?>">
  		<!-- BOF SHOPPING CART -->
      <?php
          
          if (FEC_SPLIT_CHECKOUT == 'true') {
              $selectionStyle = ($numselection%2 == 0 ? 'split' : '');
          }
      ?>
      
	<div class="row">
          <fieldset class="col-md-12 " id="chk-shopping-cart">
  <legend class="shopping-legend"><?php echo TABLE_HEADING_SHOPPING_CART; ?></legend>
  <br />
                            <div class="buttonRow forward fec-edit-button" id="editButton"><?php echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
              <?php 
                  if ($flagAnyOutOfStock) {
              ?>
                  <?php
                      if (STOCK_ALLOW_CHECKOUT == 'true') {
                  ?>
                          <div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
                  <?php }
                      else {
                  ?>
                          <div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
                  <?php } //endif STOCK_ALLOW_CHECKOUT ?>
              <?php  } //endif flagAnyOutOfStock ?>
                    
              <table id="cartContentsDisplay">

                      
              

                  
                  
                  <tr class="cartTableHeading">
                      <td scope="col" class="checkout-header-cart-th" id="ccQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></td>
                      <td scope="col" class="checkout-header-cart-th" id="ccProductsHeading" ><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                      <td scope="col" class="checkout-header-cart-th" id="ccTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></td>
                  </tr>
    
                  <?php // now loop thru all products to display quantity and price ?>
                  <?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { ?>
                        <?php $thumbnail = zen_get_products_image($order->products[$i]['id'], 40, 42); ?>
                        <tr class="<?php echo $order->products[$i]['rowClass']; ?>">
                            
                            <td class="cartQuantity"><?php echo $order->products[$i]['qty']; ?>&nbsp;x</td>
                            
                            <td class="cartProductDisplay" ><?php echo $order->products[$i]['name']; ?>
                                <?php  echo $stock_check[$i]; ?>
                                
                                <?php // if there are attributes, loop thru them and display one per line
                                    if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) {
                                    echo '<ul class="cartAttribsList">';
                                      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                                ?>
                                      <li><?php echo  nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])); ?></li>
                                <?php
                                      } // end loop
                                      echo '</ul>';
                                    } // endif attribute-info
                                ?>
                            </td>
                            <td class="cartTotalDisplay">
                                <?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
                                    if ($order->products[$i]['onetime_charges'] != 0 ) echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
                                ?>
                            </td>
    
                        </tr>
                    <?php  }  // end for loopthru all products 
                    ?>   
              </table>
                    

          </fieldset>

  <!-- EOF SHOPPING CART -->



<?PHP 

if(!$_SESSION['is_virtual'] && $is_gift_card || $_SESSION['is_gift_card_non_rewards']){

if($is_gift_card || $_SESSION['is_gift_card_non_rewards']){ 	 
//print_r($_SESSION);
	if($_SESSION['fast_ship']){
		$fast_check=' checked="checked" ';
		$stan_check=' ';
		$stan_active=' not-active ';
		$fast_active=' active ';
	}else{
		$stan_active=' active ';
		$fast_active=' not-active ';
		$fast_check='  ';
		$stan_check=' checked="checked" ';
	}
}
?>
<style>
.not-active {
	background-color:#e6e6e6;
	color:black;
}

</style>
<?php  if(!$_SESSION['is_virtual']){ ?>
<fieldset class="zm-checkout col-md-5  <?php  echo $rewards_ship ?>" id="chk-ship_rewards">
      	 <legend>Shipping</legend>
         
	<label class="btn btn-default no-check <?php echo $stan_active?>" id="percent" for="shipping_btn_stan"> Standard Shipping
        		 <input id='shipping_btn_stan' type="radio"  value='stan'  name='stanexp' <?php echo $stan_check ?> onclick='updateForm()' style="display:none">
                 </label>
        	
        	<label class="btn btn-default no-check <?php echo $fast_active?>" id="percent" for="shipping_btn_exp">Expedited Shipping
        		 <input id='shipping_btn_exp' type="radio"  value='exp'  name='stanexp' <?php echo $fast_check ?> onclick='updateForm()'  style="display:none">
                 
                 </label>
         
        
 </fieldset>


<?php  }} ?>
      
      
      
      <?PHP if(!$is_gift_card && !$_SESSION['is_gift_card_non_rewards']){ 	 ?>
      <!-- BOF tip -->
      <fieldset class="zm-checkout col-md-5  " id="chk-tip">
      	 <legend><?php echo DRIVER_TIP; //echo $_SESSION['form_submit_save']['hold-tip'];//print_r($_SESSION['form_submit_save']);?></legend>
			<div class="row">
            <div class="col-xs-3  col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 tip-offset">
            <div class="btn-group-vertical tip-row" data-toggle="buttons">
            	<?php
				$a_active ='';
				$a_radio ='';
				$b_active ='';
				$b_radio ='';
				$c_active ='';
				$c_radio ='';
				
				if($_SESSION['form_submit_save']['hold-tip']=='cash-tip'){
					$a_active =' active tipa';
					$a_radio =' checked="checked" ';
				}else if($_SESSION['form_submit_save']['hold-tip']=='flat-tip' ){
					$b_active =' active tipa';
					$b_radio =' checked="checked" ';
				}else if($_SESSION['form_submit_save']['hold-tip'] =='percent-tip'){
					$c_active =' active tipa';
					$c_radio =' checked="checked" ';
				}
				
				
				?>
                <label  class="btn btn-default <?php echo $a_active ?>" id="cash" for="lla">
                    <input type="radio" id='lla' value="cash-tip" name='hold-tip' <?php echo $a_radio ?> /> Cash
                </label> 
                <label  class="btn btn-default <?php echo $b_active ?>" id="flat" for="nnc">
                    <input type="radio"  id='nnc' value="flat-tip" name='hold-tip' <?php echo $b_radio ?> /> $
                </label> 
                <label  class="btn btn-default <?php echo $c_active ?>" id="percent" for="vvc">
                    <input type="radio" id='vvc' value="percent-tip" name='hold-tip' <?php echo $c_radio ?>  /> %
                </label> 
                <input id="add_tip"  type="hidden"  name="add_tip"  > 
            </div>
            </div>
            <div class="col-xs-3  col-sm-5 col-md-5">
            <?php
			//print_r($_POST);
			if(isset($_POST['decoy_tip'])){
				
					$tip_val =$_POST['decoy_tip'];
				
				
			}else if(isset($_SESSION['form_submit_save'])){
				if($_SESSION['form_submit_save']['hold-tip']=='percent-tip'){
					$tip_val =15;
				}else{
					$tip_val=$_SESSION['form_submit_save']['add_tip'];
				}
				
			}else if(!isset($_SESSION['fooddudestaging_login']) && !isset($_SESSION['restaurant_login'])){
				$tip_val = 15;
			}else{
				$tip_val = 0;	
			}
			?>
            <div class="tipvalbox"><input type="text" id="checkout_tip_id" name='decoy_tip' value="<?php echo $tip_val;?>"></div>
            	
            </div>
            </div>
      </fieldset>
      <?php } ?>
      <!-- EOF tip -->
      
      <?php
      if(!$is_gift_card && !$_SESSION['is_gift_card_non_rewards']){
      	$totals_offset = 'col-md-offset-2'; 
		$id_gift= 'chk-order-total';
      }else{
		$id_gift= '';
		if(!$_SESSION['is_virtual']){
			$totals_offset = 'col-md-offset-2';
		}else{
			$totals_offset = '';
		}
		
		 
	  }


	  ?>
           <!-- BOF TOTALS -->
      <fieldset class="zm-checkout col-md-5 <?php echo $totals_offset ?>" id="<?php echo $id_gift ?>">
      <legend><?php echo TABLE_HEADING_ORDER_TOTALS; ?></legend>
                    <?php
                  if (MODULE_ORDER_TOTAL_INSTALLED) {
                      $order_totals = $order_total_modules->process();

					  ?>
					        <div id="orderTotals"><?php $order_total_modules->output(); ?></div>
              
                    
              <?php } ?>

      
      </fieldset>
     <!-- EOF TOTALS -->   
 
      
   <!--BOF everything BOF everything -->   
      
      
      
      <?php
      if(!$is_gift_card && !$_SESSION['is_gift_card_non_rewards']){
		  $dev_offset = '';
      	
      }else{
		  if(!$_SESSION['is_virtual']){
			  $dev_offset = ' '; 
		  }else{
			  $dev_offset = ' hiddenField '; 
		  }
		
	  }
	  ?>
      
 <fieldset class="zm-checkout col-md-5 <?php echo $dev_offset ?>" id="chk-shipping-address">
                        <legend><?php echo TABLE_HEADING_SHIPPING_ADDRESS; ?></legend>

                
                        <?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>  
                        <div class="fec-address-container">
                            
                                <address class="checkoutAddress"><?php echo html_entity_decode(zm_address_label_checkout($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />')); ?></address>
                                
                          <div class="row address-btn">

                            <?php if ($displayAddressEdit) { ?>
                                <?php 

									                              echo '<a id="linkCheckoutShippingAddr" class="col-md-5" href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, 'Change Delivery Address','id="ship-add-btn"') . '</a>';
                                ?>
                            <?php } ?>
                           <?php 
                          if (MAX_ADDRESS_BOOK_ENTRIES >= 2) { 
                              echo '<a id="linkCheckoutPaymentAddr" class="col-md-5" href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_BILL,'id="bill-add-btn"') . '</a>';
                      ?>
                      <?php } ?>
                            </div>
                            
                        </div>
                    </fieldset>

         <?PHP if(!$is_gift_card && !$_SESSION['is_gift_card_non_rewards']){ 	 ?>             
                    <fieldset id="chk-datetime" class="zm-checkout col-md-5 col-md-offset-2 ">
                    <legend><?php echo TABLE_HEADING_DELIVERY_TIME; ?></legend>
                    <div class="row">
                    <h5 class="time-checkout">
                    	
                        <?php
						if($_SESSION['delivery_time']==1){
							echo '<div class="col-md-4 col-sm-4">Delivery Date:</div>';
							echo '<div class="col-md-5 col-sm-5">Today</div>';	
							echo '<div class="col-md-4 col-sm-4">Delivery Time:</div>';
							echo '<div class="col-md-5 col-sm-5">ASAP</div>';	
						}else{
							echo '<div class="col-md-4 col-sm-4">Delivery Date:</div>';
							echo '<div class="col-md-5 col-sm-5">'.date('D m/d/Y',$_SESSION['delivery_time']).'</div>';	
							echo '<div class="col-md-4 col-sm-4">Delivery Time:</div>';
							echo '<div class="col-md-5 col-sm-5">'.date('g:ia',$_SESSION['delivery_time']).'</div>';
						}
						
						?>
                    	
						<a data-toggle="pt-inlightbox" href="#timecode-popup">
                        	<span id="chk-edit-time" class="timecode-click btn checkout-btn edit-time">Edit Time</span>
                        </a>
                    </h5>
                    </div>

                    		<div class="col-md-4 col-sm-4"></div>
                    
                    </fieldset>
        <?php  } ?>      
              
              
                    
<!--                   <fieldset id="chk-billing-address" class="zm-checkout col-md-5 col-md-offset-2 ">
                 <legend><?php //echo TABLE_HEADING_BILLING_ADDRESS; ?></legend>

                  <div class="fec-address-container">
                    
                          <address><?php //echo html_entity_decode(zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />')); ?></address>
                    
                      <?php 
                          if (MAX_ADDRESS_BOOK_ENTRIES >= 2) { 
                              //echo '<a id="linkCheckoutPaymentAddr" href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_BILL) . '</a>';
                      ?>
                      <?php } ?>
                  </div>
              </fieldset>-->
      
      
      
      
      <!-- start/coditions -->
      <?php
          if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
      ?>
              <fieldset class=" <?php echo $checkoutStyle; ?>" id="checkoutConditions">
                  <legend><?php echo TABLE_HEADING_CONDITIONS; ?></legend>
                  <span class="-legend"><?php echo TABLE_HEADING_CONDITIONS; ?></span>
                  
                  <div class="fec-information"><?php echo TEXT_CONDITIONS_DESCRIPTION;?></div>
          
                  <?php echo  zen_draw_checkbox_field('conditions', '1', false, 'id="conditions"');?>
                  <label class="checkboxLabel" for="conditions"><?php echo TEXT_CONDITIONS_CONFIRM; ?></label>
              </fieldset>
      <?php
        }
      ?>
      <!-- end/coditions -->
      

      
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
        if (!$payment_modules->in_special_checkout()) {
          // ** END PAYPAL EXPRESS CHECKOUT ** ?>
        <?php
          if ($order->content_type != 'virtual') {
            $heading_title_payment = HEADING_TITLE_PAYMENT;
          } else {
            $heading_title_payment = HEADING_TITLE_PAYMENT_VIRTUAL;
          }
        ?>
      <?php if (FEC_SPLIT_CHECKOUT == 'false') { ?>
    
      <?php } ?>
      <?php
        if ($credit_covers != true && !$_SESSION['credit_covers']) { 
          if ($order->content_type == 'virtual') {
            $checkoutStyle .= "Full";
          }
      ?>
      <!-- bof payment -->
      
          <!-- <h1 id="checkoutPaymentHeading"><?php echo $heading_title_payment; ?></h1> -->
           <?php
		   if($is_gift_card || $_SESSION['is_gift_card_non_rewards']){
			     if(!$_SESSION['is_virtual']){
					 $bill_offset=' col-md-offset-2';
					 

				 }else{
					 $bill_offset=' col-md-offset-2';
				 }
			   
		   }else{
			  $bill_offset=' '; 
		   }
		   if(!$_SESSION['fast_ship'] && $is_gift_card){
				$bill_offset='  hiddenField ';
			}
			if($_SESSION['is_virtual'] && $is_gift_card){
				$bill_offset='  hiddenField ';
			}
		   ?>
          <fieldset class="<?php echo   $bill_offset ?> col-md-5" id="chk-payment">
          
            
            <div class="btn-group btn-group-payment" data-toggle="buttons">

              <!--BILLING ADDRESS-->
              <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
                    if (!$payment_modules->in_special_checkout()) {
                    // ** END PAYPAL EXPRESS CHECKOUT ** 
              ?>

              <?php
                //require($template->get_template_dir('tpl_modules_fec_change_checkout_payment_address.php', DIR_WS_TEMPLATE, $current_page_base,'templates/fec'). '/' . 'tpl_modules_fec_change_checkout_payment_address.php');
              ?>
    
          <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
                }
                // ** END PAYPAL EXPRESS CHECKOUT ** 
          ?>
          
          <?php
            if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
          ?>
          
          <?php
              if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
              }
              if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
              }
          ?>
      
          <?php } ?>
          
          <legend><?php echo TABLE_SUBHEADING_PAYMENT_METHOD; ?></legend>
          <?php
            foreach($payment_modules->modules as $pm_code => $pm) {
              if(substr($pm, 0, strrpos($pm, '.')) == 'googlecheckout') {
                unset($payment_modules->modules[$pm_code]);
              }
            }
            $selection = $payment_modules->selection();
          	$selection = array_reverse($selection);
            if (sizeof($selection) > 1) {
          ?>
              <!-- <span class="fec-information"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></span> -->
          <?php
            } elseif (sizeof($selection) == 0) {
          ?>
              <!-- <span class="fec-information"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></span> -->
          
          <?php
            }
          ?>

          <?php
            $radio_buttons = 0;
			
            for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
// no cash begin
                if($selection[$i]["id"] == "cod" && $hide_cod_){ continue; }
 // no cash end
         ?>
          <?php
              if (sizeof($selection) > 1) {
				  $for_data='';
			if($selection[$i]['id']=='braintree_api'){
				$for_data='  data-toggle="collapse" data-target="#credit-collapse" ';
			}
			$hide='';
			if($selection[$i]['id']=='cod' && $is_gift_card || $selection[$i]['id']=='cod' &&$_SESSION['is_gift_card_non_rewards'] ){
				$hide='  hiddenField ';
			}
			
            ?>
            <label   <?php echo $for_data  ?> id="<?php echo 'lbl-'.$selection[$i]['id'] ?>" for="pmt-<?php echo $selection[$i]['id']; ?>" class="payment-label radioButtonLabel btn btn-default <?php echo $hide ?>">
            
                  <?php      
                      if (empty($selection[$i]['noradio'])) {
                  ?>
                          <?php echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); ?>
                  
                  <?php } ?>
                
                  <?php } 
                      else { 
                  ?>
                  
                          <?php echo zen_draw_hidden_field('payment', $selection[$i]['id']); ?>
                  
                  <?php } ?>
          
                  <?php echo $selection[$i]['module']; ?></label>
    
          <?php
              if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod') {
          ?>
            <div class="alert hiddenField"><?php echo TEXT_INFO_COD_FEES; ?></div>
          <?php
              } else {
                // echo 'WRONG ' . $selection[$i]['id'];
          ?>
          <?php
              }
          ?>
          
          <?php
              if (isset($selection[$i]['error'])) {
          ?>
              <div><?php echo $selection[$i]['error']; ?></div>
          
          <?php
              } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
          ?>
          
          <div class="fec-credit-card-info collapse" id="credit-collapse">
          <?php
                for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
          ?>
                    <div class="fec-field credit-field">
                        <label  <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?> class=" credit-label"><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
                        <?php echo $selection[$i]['fields'][$j]['field']; ?>
                    </div>
                    
          <?php
                }
          ?>
          </div>
          <?php
              }
              $radio_buttons++;
			  
          ?>

          <?php
            }
          ?>
          


            </div>
        <!-- bof doublebox? -->
    <!--  eof doublebox? -->
        </fieldset>
        

    
    
		<?php
		//print_r($_SESSION);
		if($_SESSION['is_gift_card_non_rewards']){
			if($_SESSION['is_virtual']){
				$isnonoffset = ' ';
			}else{
				if($_SESSION['fast_ship']){
					$isnonoffset = '';
				}else{
					$isnonoffset = '';
				}
				
			}
			
		}else{
			if($_SESSION['is_virtual']){
				$isnonoffset = ' col-md-offset-2';
			}else{
				if(!$_SESSION['fast_ship']){
					$isnonoffset = 'col-md-offset-2';
				}else{
					$isnonoffset = '';
				}
				
			}
			
		}
		if($is_gift_card && !$_SESSION['fast_ship']){
			$isnonoffset = 'col-md-offset-2';
		}
		if($_SESSION['is_virtual'] && $is_gift_card){
				$isnonoffset='  col-md-offset-2 ';
			}
		?>
                      <!-- begin/comments -->
      <fieldset class="zm-checkout col-md-5 <?php  echo $isnonoffset ?> " id="chk-comments">
          <legend><?php echo TABLE_HEADING_COMMENTS; ?></legend>
          <?php 
		  if(isset($_POST['comments'])){
			  $com_val =$_POST['comments']; 
		  }else if(isset($_SESSION['form_submit_save'])){
			  $com_val = $_SESSION['form_submit_save']['comments'];
		  }else{
			  $com_val='';
		  }
		  
		  echo zen_draw_textarea_field('comments', '45', '3',$com_val,'id="comment_checkout_text" placeholder="Enter apt/suite numbers and messages for drivers or restaurants"'); ?>
      </fieldset>
      <!-- end/comments -->
        
        
        
                  <!--bof special payment--> 
	<!-- contactless popout begin -->  
        <fieldset class="zm-checkout col-md-5 <?php  echo $isnonoffset ?> " id="chk-contactless">
            <legend>Non-Contact Delivery</legend>
            <div class="row">
                <div class="selected_option col-md-6">Hand to me</div>
                <div class="col-md-6"><a class="add_edit" data-toggle="pt-inlightbox" href="#contactless-popup">Edit</a></div>
            </div>
        </fieldset>
      
        <!-- contactless popout end -->  
          <?php
          
          // GOOGLE CHECKOUT
          foreach($payment_modules->modules as $pm_code => $pm) {
              if(substr($pm, 0, strrpos($pm, '.')) == 'googlecheckout') {
                  unset($payment_modules->modules[$pm_code]);
              }
          }
          //print_r($_SESSION);
          // following used for setting style type of order total and discount modules only
          $selection =  $order_total_modules->credit_selection();
          $numselection = sizeof($selection);
    
              if ($numselection>0) {
                  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
                      

                          // $i starts at 0
                          if ($i%2 == 0) $box = 'odd'; else $box = 'even';
                      
                      
                      if ($_GET['credit_class_error_code'] == $selection[$i]['id']) { 
                      ?>
                          <div class="messageStackError"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>
            
      <?php
          }
      ?>
      
      		<?php
			$offset ='';
			if($box=='even'){
				$offset = 'col-md-5 no-pad';
			}else{
				$offset = 'col-md-5 no-pad';
			}
			if($selection[$i]['module']=='Gift Certificates'){
				$offset = 'col-md-5 no-pad';
			}
			
			if($selection[$i]['module']!='Reward Points'){
				//if(true){
			?>
             <?PHP 
			 if($is_gift_card || $_SESSION['is_gift_card_non_rewards']){ 
				 $offset .=' hiddenField';
			 }
			 if(isset($_SESSION['fooddudestaging_login'])){
				// print_r($_SESSION);
			 }
			 if($_SESSION['COWOA'] == 1 && $i == 0 || $_SESSION['COWOA'] == 1 && $i == 1 ){
				 $offset .=' hiddenField';
			 }
			 ?> 
			
            <div class="col-md-12" style="padding-bottom:6px">
            <div class="<?php echo $offset  ?>">
                          <legend id="special-pay-<?php echo $i; ?>" data-target="#chk-special-pay-<?php echo $i ?>" class="special-pay-legend" data-toggle="collapse"><?php echo $selection[$i]['module']; ?> <i class="fa fa-chevron-left"></i></legend>
      
          <fieldset id="chk-special-pay-<?php echo $i; ?>"class="collapse  zm-checkout-<?php echo $box; ?>  ">

              

              <div class="fec-information">
                  <?php echo $selection[$i]['redeem_instructions']; 
				 
				  ?>
              </div>
              
              <div class="gvBal larger">
			  <?php 
			 	 echo $selection[$i]['checkbox']; 
			  ?>
              </div>
              <div class="fec-field-inline">
                  <?php 
				  foreach ($selection[$i]['fields'] as $field) { 
				  
				 	// if($field['tag']!='disc-ot_gv'){
				  ?>
                                        <label class="inputLabel"<?php echo ($field['tag']) ? ' for="'.$field['tag'].'"': ''; ?>><?php echo $field['title']; ?></label> 
                      <?php 
					  echo $field['field']; ?> 
                  <?php 
				  	//}
				  } ?>
                  <?php
                      if ( ($selection[$i]['module'] != MODULE_ORDER_TOTAL_INSURANCE_TITLE) && ($selection[$i]['module'] != MODULE_ORDER_TOTAL_SC_TITLE) ) { ?>
                      <div class="buttonRow"><?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT, 'onclick="updateForm();"'); ?></div>
                  <?php } ?>
              </div> 

          </fieldset>
    
          </div>
          </div>
          
      <?php
          }}
      ?>
      
      <?php

	  
        }
      ?>  
        
        
        <!--eof special payment-->  
        
        
        
        
        
          </div>
      </div>
      
      
      <?php 
        }
      ?>
      <!-- eof payment -->
      
      
      
 <?php

 
 
 ?>
      
      
      
      
      
      <!-----   aparently unused stuff      ---->
      
      
      
      
      
      
      <?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
            } else {
              ?><input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" /><?php
            }
            // ** END PAYPAL EXPRESS CHECKOUT ** 
      ?>
      <!-- EOF PAYMENT -->
      
      <!-- bog FEC v1.27 CHECKBOX -->
      <?php
      if (FEC_CHECKBOX == 'true') {
        $checkbox = ($_SESSION['fec_checkbox'] == '1' ? true : false);
      ?>
      <fieldset class=" <?php echo $checkoutStyle; ?>" id="checkoutFECCheckbox">
          <legend><?php echo TABLE_HEADING_FEC_CHECKBOX; ?></legend>
          <span class="-legend"><?php echo TABLE_HEADING_FEC_CHECKBOX; ?></span>
          
          <label><?php echo TEXT_FEC_CHECKBOX; ?></label>
          <?php echo zen_draw_checkbox_field('fec_checkbox', '1', $checkbox, 'id="fec_checkbox"'); ?>
      </fieldset>
      <?php 
      } 
      ?>
      <!-- eof FEC v1.27 CHECKBOX -->
      <!-- bof FEC v1.24a DROP DOWN -->
      <?php 
        if (FEC_DROP_DOWN == 'true') {
      ?>
      <fieldset class=" <?php echo $checkoutStyle; ?>" id="checkoutDropdown">
          <legend><?php echo TABLE_HEADING_DROPDOWN; ?></legend>
          <span class="-legend"><?php echo TABLE_HEADING_DROPDOWN; ?></span>
          
          <label><?php echo TEXT_DROP_DOWN; ?></label>
          <?php echo zen_draw_pull_down_menu('dropdown', $dropdown_list_array, $_SESSION['dropdown'], 'onchange="updateForm()"', false); ?>
      </fieldset>
      <?php
        }
        if (FEC_GIFT_MESSAGE == 'true') {
      ?>
      <fieldset class=" <?php echo $checkoutStyle; ?>" id="giftMessage">
          <legend><?php echo TABLE_HEADING_GIFT_MESSAGE; ?></legend>
          <span class="-legend"><?php echo TABLE_HEADING_GIFT_MESSAGE; ?></span>
          <?php echo zen_draw_textarea_field('gift-message', '45', '3', $_SESSION['gift-message']); ?>
      </fieldset>
      <!-- eof DROP DOWN -->
    <?php
        }
    ?>


      <!--BOF SHIPPING-->
      
    <?php
        if (false) {
    ?>
            <div id="checkoutShippingForm" class="<?php echo $checkoutStyle; ?>">
  
                <!-- <h1 id="checkoutShippingHeading"><?php echo HEADING_TITLE_SHIPPING; ?></h1> -->
                
                <fieldset class="fec-shipping-methods " id="checkoutShippingMethods">
                 
                    
                
                   
          <?php
            //$addresses_count = zen_count_customer_address_book_entries();
            //require($template->get_template_dir('tpl_modules_fec_change_checkout_shipping_address.php', DIR_WS_TEMPLATE, $current_page_base,'templates/fec'). '/' . 'tpl_modules_fec_change_checkout_shipping_address.php');
          ?>
  
      <?php
          if (zen_count_shipping_modules() > 0) {
      ?>
              
  
              <?php
                  if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
              ?>
                      <!-- <div id="checkoutShippingContentChoose" class="fec-information"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></div> -->
              <?php } 
                  elseif ($free_shipping == false) {
              ?>
                      <!-- <div id="checkoutShippingContentChoose" class="fec-information"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></div> -->
      
              <?php
                  }
              ?>
              <?php
                  if ($free_shipping == true) {
              ?>
                      <div id="freeShip" class="fec-information" ><?php echo FREE_SHIPPING_TITLE; ?>&nbsp;<?php echo $quotes[$i]['icon']; ?></div>
                      <div id="defaultSelected"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . zen_draw_hidden_field('shipping', 'free_free'); ?></div>
      
              <?php }
                  else {
                      $radio_buttons = 0;
                      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
                  ?>
  
                          <div class="fec-shipping-method">
                              <span><?php echo $quotes[$i]['module']; ?>&nbsp;<?php if (isset($quotes[$i]['icon']) && zen_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></span>
                              <?php
                                  if (isset($quotes[$i]['error'])) {
                              ?>  
                                      <div><?php echo $quotes[$i]['error']; ?></div>
                              <?php }
                                  else {
                                      for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
										  print_r($quotes[$i]['methods'][$j]['id']);
										  print_r($quotes[$i]['methods'][$j]['id']);
                                      // set the radio button to be checked if it is the method chosen
                                          $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : true);
      
                                          if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
                                              //echo '      <div id="defaultSelected" class="moduleRowSelected">' . "\n";
                                          //} else {
                                              //echo '      <div class="moduleRow">' . "\n";
                                          }
                                  ?>
                              <?php
                  if ( ($n > 1) || ($n2 > 1) ) {
  
      ?>
                      <div class="important fec-shipping-value"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></div>
      <?php
                  } else {
      ?>
                      <div class="important fec-shipping-value"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></div>
      <?php
                  }
      ?>
                
                  <div class="fec-box-check-radio">
                      <?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, 'onclick="updateForm();" id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"'); ?>
                      <label for="ship-<?php echo $quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id']; ?>" class="checkboxLabel" ><?php echo $quotes[$i]['methods'][$j]['title']; ?></label>
                  </div>
      <!--</div>-->
      <?php
                  $radio_buttons++;
                }
                //bof tell a friend
                if($quotes[$i]["id"] == "tellafriend") {
                  echo MODULE_SHIPPING_TELL_A_FRIEND_TEXT_CUSTOMER;
                  echo $tell_a_friend_email_error != "" ? "<div class='messageStackWarning'>$tell_a_friend_email_error</div>" : "";
  ?>
                  <div class="tellAFriendContent" style="width:50%;"><strong>Email</strong></div>
                  <div class="tellAFriendContent" style="width:25%;"><strong>First Name</strong></div>
                  <div class="tellAFriendContent" style="width:25%;"><strong>Last Name</strong></div>
  <?php          
            for ($j = 0; $j < $quotes[$i]['email_no']; $j++) {
  ?>
                <div class="tellAFriendContent" style="width:50%;"><?php echo zen_draw_input_field('tell_a_friend_email[]', $_SESSION["tell_a_friend_email"][$j], 'size="28"'); ?></div>
                <div class="tellAFriendContent" style="width:25%;"><?php echo zen_draw_input_field('tell_a_friend_email_f_name[]', $_SESSION["tell_a_friend_email_f_name"][$j], 'size="15"'); ?></div>
                <div class="tellAFriendContent" style="width:25%;"><?php echo zen_draw_input_field('tell_a_friend_email_l_name[]', $_SESSION["tell_a_friend_email_l_name"][$j], 'size="15"'); ?></div>
      
  <?php
            }
  // BOF Captcha
  if(is_object($captcha)) {
  ?>
  <?php echo $captcha->img(); ?>
  <?php echo $captcha->redraw_button(BUTTON_IMAGE_CAPTCHA_REDRAW, BUTTON_IMAGE_CAPTCHA_REDRAW_ALT); ?>
      <br class="clearBoth" />
      <label for="captcha"><?php echo TITLE_CAPTCHA; ?></label>
  <?php echo $captcha->input_field('captcha', 'id="captcha"') . '&nbsp;<span class="alert">' . TEXT_CAPTCHA . '</span>'; ?>
      <br class="clearBoth" />
  <?php
  }
  // EOF Captcha          
                }
  //eof tell a friend
              }
      ?>
      
      </div>
      <?php
            }
          }
      ?>
      
      <?php
        } else {
      ?>
        <h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
        <div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
      <?php
        }
      ?>
      </fieldset>
      </div>
      <?php
        }
      ?>
      <!--EOF SHIPPING-->




  <!-- bof doublebox -->
          <?php
            if (MODULE_ORDER_TOTAL_DOUBLEBOX_STATUS == 'true') {
              $value = "ot_doublebox_checkout.php"; 
              include_once(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] .
                    '/modules/order_total/', $value, 'false'));
              include_once(DIR_WS_MODULES . "order_total/" . $value);
              $doublebox_mod = new ot_doublebox_checkout(); 
              $use_doublebox = true;
              if ($doublebox_mod->check() && $doublebox_mod->enabled) {
          ?>
                <br />
                <hr />
          <fieldset class="shipping" id="doublebox">
          <legend><?php echo DOUBLEBOX_HEADING; ?></legend>
          <?php
              echo '<div id="cartDoubleBoxExplain">'; 
              echo '<a href="javascript:alert(\'' . DOUBLEBOX_EXPLAIN_DETAILS . '\')">' . DOUBLEBOX_EXPLAIN_LINK . '</a>';
              echo '</div>'; 
          ?>
                <table border="0" width="100%" cellspacing="0" cellpadding="0" id="cartContentsDisplay">
                  <tr class="cartTableHeading">
                  <th scope="col" id="ccProductsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
                   <th scope="col" id="ccDoubleBoxHeading"><?php echo DOUBLEBOX_CHECKOFF; ?></th>
                  </tr>
          <?php  
                 // now loop thru all products to display quantity and price
             $prod_count = 1; 
          // tsg_logger($order->products); 
             for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
               for ($q = 1; $q <= $order->products[$i]['qty']; $q++) {
                  if ($prod_count%2 == 0) {
                     echo '<tr class="rowEven">';
                  } else {
                     echo '<tr class="rowOdd">';
                  }
                  echo '<td class="cartProductDisplay">' . $order->products[$i]['name'];
    
                  // if there are attributes, loop thru them and display one per line
                  if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) {
                      echo '<ul class="cartAttribsList">';
                      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                          echo '<li>' . $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br($order->products[$i]['attributes'][$j]['value']) . '</li>'; 
                      } // end loop
                      echo '</ul>';
                  } // endif attribute-info
          ?>
                  </td>
          <?php
                   // doublebox setting
                   echo '<td class="cartDoubleBoxCheckDisplay">'; 
                   $prid = $order->products[$i]['id'];
                   if (zen_get_products_virtual($order->products[$i]['id'])) {
                      echo DOUBLEBOX_NA;
                   } else if (DOWNLOAD_ENABLED && product_attributes_downloads_status($order->products[$i]['id'], $order->products[$i]['attributes'])) {
                      echo DOUBLEBOX_NA; 
                   } else if ($doublebox_mod->exclude_product($prid)) {
                      echo DOUBLEBOX_NA; 
                   } else if ($doublebox_mod->exclude_category($prid)) {
                      echo DOUBLEBOX_NA; 
                   } else { 
                      $doublebox_id = "doublebox_prod_" . $prod_count;
                      echo zen_draw_checkbox_field($doublebox_id,'1',$_SESSION[$doublebox_id], 'id="'.$doublebox_id .'"');
                   }
                   echo "</td>"; 
          ?>
                </tr>
          <?php
                      $prod_count++; 
                   }
                 }  // end for loopthru all products 
          ?>
                </table>
          </fieldset>
                <hr />
                <br />
          <?php
             }
            }  
          ?>
          <!-- eof doublebox -->     
    <input type="hidden" id="h_contactless" name="h_contactless" value="" />
    <input type="hidden" id="h_driver_notes" name="h_driver_notes" value="" />

</div>
  	</li>
  </ul>
 	<!-- contactless popout begin -->
<script type="text/javascript" language="javascript">
jQuery(document).ready(function (){
    jQuery('input[type=radio][name=contactless]').change(function() {
        var ht = "";
        if (this.value == '1') {
            jQuery("#delivery_instruction").css("visibility","hidden");
            //jQuery(".selected_option").html("Hand to me");
            ht = "Hand to me";
            jQuery('#driver_notes').val("");
            jQuery('#h_driver_notes').val("");
        }
        else if (this.value == '2') {
            jQuery("#delivery_instruction").css("visibility","visible");
            //jQuery(".selected_option").html("Leave at door"); 
            ht = "Leave at door";
            jQuery('#h_driver_notes').val(ht + " " + jQuery('#driver_notes').val());
        }
         
        if(jQuery('#driver_notes')){
            jQuery('#h_contactless').val(jQuery('input[name="contactless"]:checked').val());
        }
        //jQuery(".selected_option").append("<br />"+jQuery('#driver_notes').val());
        jQuery(".selected_option").html("");
        jQuery(".selected_option").html(ht);
        jQuery(".selected_option").append("<br />");
        jQuery(".selected_option").append(jQuery('#driver_notes').val());
    });
    jQuery('.closebtn').click(function (e) {
        var ht = "";
        var radio = jQuery('input[type=radio][name=contactless]:checked').val();
        if (radio == '1') {
            ht = "Hand to me";
            /*jQuery('#driver_notes').val("");
            jQuery('#h_driver_notes').val("");*/
        }
        else if (radio == '2') {
            ht = "Leave at door";
            //ht = jQuery('#driver_notes').val();
            jQuery('#h_driver_notes').val("Leave at door "+jQuery('#driver_notes').val());
            
        }
        //jQuery('#h_driver_notes').val(jQuery('#driver_notes').val());
        jQuery(".selected_option").html("");
        jQuery(".selected_option").html(ht);
        jQuery(".selected_option").append("<br />");
        jQuery(".selected_option").append(jQuery('#driver_notes').val());
        jQuery("#contactless-popup .mfp-close").trigger("click"); 
    });
    /*jQuery(".add_edit").trigger("click");*/ 
}); 
</script>
<style>
.add_edit{ color:#ef6f00 !important; }
#delivery_instruction{ visibility:hidden; } 
#contactless-popup .timecode-popup-content{ height:auto; padding:0px 15px; }
.closebtn{ /*margin-bottom:10px;  margin-top:10px;*/ } 
.btn_close1{ position:inherit; right:auto; float:right; background-color:#EF6F00 !important; border-color:#EF6F00 !important; }
.btn_close2{ position:inherit; right:auto; float:left; background-color:#E6E6E6 !important; border-color:#E6E6E6 !important; color:#000000; }
#driver_notes{ width:100%; }
/*#contactless-popup .modal-footer { padding:2px; }*/
#chk-contactless{ height:auto; }
/*.btn-primary{background-color:#2e6da4 !important;}*/
</style>    
    <div id="contactless-popup" class="pt-popup pt-paddingless mfp-hide">
    	<div class="timecode-popup-head">
    		<div class="popup-title">Delivery Options</div>
    	</div>
    	<div class="timecode-popup-content">
    	    <center><label class=""></label></center>
    	    <br />
           
            <div style="clear:borh;"></div> 
            <div class="form-check">
                <label class="form-check-label">
                    <input checked type="radio" class="form-check-input" name="contactless" value="1"> &nbsp;&nbsp;&nbsp; Hand to me
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="contactless" value="2"> &nbsp;&nbsp;&nbsp; Leave at door
                </label>
            </div>
            <div style="clear:borh;"></div>
            <br />
            <div id="delivery_instruction">
                <label class="form-check-label">Delivery Instructions</label>
                <div style="clear:borh;"></div>
                <textarea name="driver_notes" cols="45" rows="3" id="driver_notes" placeholder="Leave info for your driver here (e.g. Ring bell and leave bag on doorstep)."></textarea>
            </div>
          
            <div style="clear:borh;"></div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary btn_close1 closebtn" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-secondary btn_close2 closebtn" data-dismiss="modal">Cancel</button>
            </div>
            <div style="clear:borh;"></div>
    	    <!---->
            
    	</div>
    </div>
    <div style="clear:borh;"></div>
<!-- contactless popout end -->    

    <!-- include hidden payment attributes -->
    <?php if (is_array($payment_modules->modules)) {
      echo $payment_modules->process_button();
    }
  ?>
  </div>