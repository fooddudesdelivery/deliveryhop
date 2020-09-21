<?php
if(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	/* special ajax here */
	header('Location: future_index.php?key=44');
	die;
}
?>
			<?php foreach($ajaxproducts['products'] as $products_id=>$c){
				

				?>
            
          
			       <div id="product-panel-<?php echo $products_id.'-'.$ajaxproducts['parent_id']?>" class="panelpage" data-role="page"   >
                           <div data-role="header"    data-id="persistent" data-position="fixed" data-transition="none"  data-tap-toggle="false" >
								<a 
                                data-products-id=<?php echo $products_id?> 
                                  class="panel-back-btn" data-rel="back" style="">
                        <i class="glyphicon glyphicon-remove" style=" margin: 10px 0 0;"></i>
                           </a>
            				</div>
					  <div class="" data-role="content"  style="">


							<h1 
                            class="text-center" 
                            id="product_name-<?php echo $products_id?>" 
                            data-product-name="<?php echo $c['products_name']?>"
                            ><?php echo $c['products_name']?></h1>
                            
							<h2 
                            class="text-center" 
                  
                            id="product_price-<?php echo $products_id?>"
                            >
							<?php
							if(intval($c['products_price'])>0){
								$display_price=$this->moneyFormat($c['products_price']);
							}else{
								$display_price='';
							}
							?>
							<?php echo $display_price?></h2>
                            
							<h4 class="text-center"><?php echo $c['products_description']?></h4>
							<div class="panel panel-default">
								<div class="panel-heading product-panel-heading">Quantity</div>
							</div>
							<input type="number"  id="product_quantity-<?php echo $products_id?>" class="form-control qty-box" value="1">
				
              <?php if(array_key_exists('attributes',$c) && is_array($c['attributes']) && count($c['attributes'])>0){  ?>               
			  <?php foreach($c['attributes'] as $header=>$h){ ?>
					  <div class="panel panel-default">
						  <div class="panel-heading product-panel-heading"><?php echo $header?></div>
					  </div>
                      
					  <?php foreach($h as $type=>$g){ ?>
                      
                              <?php switch($type){ 
                                        case 'Checkbox': 
                                        case 'Radio': ?>
                                          <fieldset data-role="controlgroup">
                                     
                                          
                                      <?php foreach($g as $o){ 
									  		if($o['attributes_default']==1){
												$is_default=' checked="checked" ';
											}else{
												$is_default='';
											}
									  ?>
                                        
                                          <input  
                                          data-option-key="<?php echo $o['option_key']?>"
                                          data-option-name="<?php echo $o['products_options_values_name']?>"
                                          value="<?php echo $o['option_key']?>"
                                          type="<?php echo strtolower($type)?>"  id="prid<?php echo $o['option_key'] ?>"  
                                          name="<?php echo $header ?>" 
                                          class="check_checked"
                                          <?php echo $is_default ?>
                                          >
                                         
	   
                                          <?php
								      if(intval($o['options_values_price'])!=0){
										  $display_attr = ' ('.$o['price_prefix'].$this->moneyFormat($o['options_values_price']).')';
									  }else{
										  $display_attr = '';
									  }
										  ?>
										  <label for="prid<?php echo $o['option_key'] ?>"><?php echo $o['products_options_values_name'].$display_attr ;?></label>
                                          
                                      <?php }	 ?>
                                        </fieldset>
                                  <?php break; ?>
                                  <?php case 'Dropdown': ?>
                                  <select 
                                  
								  
                                  class="form-control select-option-<?php echo $products_id?>">
                                  <?php foreach($g as $o){ 
								  		if($o['attributes_default']==1){
											$is_default=' selected="selected" ';
										}else{
											$is_default=' ';
										}
								  
								  ?>
                                  <option 
                                  <?php echo $is_default ?>
                                  class="product_option select_option"
                                  data-option-name="<?php echo $o['products_options_values_name']?>"
                                  data-option-key="<?php echo $o['option_key']?>"><?php echo $o['products_options_values_name'] ?></option>
                                  <?php } ?>
                                  
                                  </select>
                                  <?php break; ?>
                                  <?php case 'Text': ?>
                                          <textarea id="product_spec-<?php echo $products_id?>" class="form-control size-up-txt" rows="3" value="" ></textarea>
                                  <?php break; ?>
                              <?php } ?>
                              
                      <?php } ?>
			
			 <?php  } ?>
             <?php  } ?>
				    </div>
                    <?php
					$this->getFooter('product-panel');
					?>
                  </div>
	
    

    
		  <?php } ?>
