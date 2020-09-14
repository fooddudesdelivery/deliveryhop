<?php

$orders_id_string = $this->get_id_list($new_difference);
$hidden_dropdown = '';
if($this->past_sync){
	$hidden_dropdown = ' style="display:none" ';
}else{
	$hidden_dropdown = ' ';
}


// BOF sql statement bank

//a
$orders_sql = 'SELECT pickup_order,duration_to_deliver,payment_module_code,orders_status,cash_order, categories_id, customers_id, customers_lat, customers_lng, customers_name, customers_telephone, date_deliver, date_purchased, delivery_city, delivery_company, delivery_country, delivery_name, delivery_postcode, delivery_state, delivery_street_address, delivery_suburb, distance_to_deliver, duration_to_deliver, last_modified, orders_id, orders_status, order_total, payment_module_code, updated_from_dispatched, updated_from_future
FROM orders as o where o.orders_id in ('.$orders_id_string.') order by date_deliver desc';

//b
$orders_products_sql='SELECT op.onetime_charges,op.orders_products_id,op.orders_id,op.products_name, op.products_price, op.products_quantity from orders_products as op inner join orders as o on o.orders_id = op.orders_id where o.orders_id in ('.$orders_id_string.') and op.products_model !="BEVERAGE"';

//c
$orders_total_sql='select orders_id,value from orders_total where class="ot_subtotal" and orders_id in ('.$orders_id_string.')';

//d
$orders_products_attributes_sql='select orders_products_id,orders_id,options_values_price,price_prefix,products_options, products_options_values from orders_products_attributes where orders_id in ('.$orders_id_string.')';

//e
$this->note_array=array();
$this->get_note_array($new_difference);
$orders_notes = $this->note_array;

//f
$orders_restaurant_adjustment_sql='select orders_id,value from orders_total where class="ot_restaurant_adjustment" and orders_id in ('.$orders_id_string.')';



	
//BOF sql looping to array
	try{
		$a = $this->db->query($orders_sql);
		$order=array();
		foreach ($a as $ax){


		
		
//echo $discount[0]['discount'];die;
				$order[]=array('orders_id'=>$ax['orders_id'],
								'order_total'=>$ax['order_total'],
								'orders_status'=>$ax['orders_status'],
								'duration_to_deliver'=>$ax['duration_to_deliver'],
								'payment_module_code'=>$ax['payment_module_code'],
								'pickup_order'=>$ax['pickup_order'],
								'date_deliver'=>$ax['date_deliver']);
		
		}	
	}catch(Exception $e){
		$this->error($e->getMessage().' Error at sql a in restaurant_table');
	}
	
	try{
		$b = $this->db->query($orders_products_sql);
		$orders_products=array();
		foreach ($b as $bx){
				$orders_products[$bx['orders_id']][]=
				array('products_name'=>$bx['products_name'],
					  'orders_products_id'=>$bx['orders_products_id'],
					  'products_quantity'=>$bx['products_quantity'],
					  'onetime_charges'=>$bx['onetime_charges'],
					  'products_price'=>$bx['products_price']);
	
		}
	}catch(Exception $e){
		$this->error($e->getMessage().' Error at sql b in restaurant_table');
	}


	try{
		$c = $this->db->query($orders_total_sql);
		$orders_total=array();
		foreach ($c as $cx) {
						$discount =  $this->db->query('select sum(final_price * products_quantity) as discount from orders_products where products_model in ("BEVERAGE","FOODDUDEMISC") and orders_id="'.$cx['orders_id'].'"')->fetchAll(PDO::FETCH_ASSOC);
				$orders_total[$cx['orders_id']]=$cx['value']-$discount[0]['discount'];
	
		}
	}catch(Exception $e){
		$this->error($e->getMessage().' Error at sql c in restaurant_table');
	}



	try{
		$d = $this->db->query($orders_products_attributes_sql);
		$orders_products_attributes=array();
		foreach ($d as $dx){
				$orders_products_attributes[$dx['orders_products_id']][]=array(
 					'products_options'=>$dx['products_options'], 
					'price_prefix'=>$dx['price_prefix'], 
					'options_values_price'=>$dx['options_values_price'], 
					'products_options_values'=>$dx['products_options_values']);
	
		}
	}catch(Exception $e){
		$this->error($e->getMessage().' Error at sql d in restaurant_table');
	}
	
	
	
	try{
		$f = $this->db->query($orders_restaurant_adjustment_sql);
		$orders_restaurant_adjustment=array();
		foreach($this->orders_id as $o){
			$orders_restaurant_adjustment[$o]=0;
		}

		foreach ($f as $fx){
				$orders_restaurant_adjustment[$fx['orders_id']]+=$fx['value'];
	
		}
	}catch(Exception $e){
		$this->error($e->getMessage().' Error at sql e in restaurant_table');
	}

	$orders_status = $this->orders_status_name;


 		$r_table='';
		foreach($order as $o){
		$order_is_accepted = $this->check_status($o['orders_id'],4);
		$driver_accepted = $this->check_status($o['orders_id'],5);
		$this->orders_object[$o['orders_id']]=array(
		'orders_total'=>$orders_total[$o['orders_id']],
		'payment_module_code'=>$o['payment_module_code'],
		'order_is_accepted'=>$order_is_accepted,
		'adjustment'=>$orders_restaurant_adjustment[$o['orders_id']]);
		
		
       $r_table.='
		<div id="'.$o['orders_id'].'-main-panel" class="panel panel-default col-md-12 main-panel">
			<div  id="'.$o['orders_id'].'-panel" data-drop=".panel-drop-'.$o['orders_id'].'" class=" drop-panel  panel-heading restaurant-heading">
            	<div class="container-fluid info-fluid">
           			<span class="info-panel col-lg-12 col-md-12 col-sm-12 col-xs-12">';
						if($o['orders_status']==10){
							$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-3">
							#'.$o['orders_id'].'
                   		</span>';
						$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-3">
							'.money_format('$%i',$orders_total[$o['orders_id']]).'
                   		</span>';
						}else if($o['orders_status']==6){
						$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-5">
							#'.$o['orders_id'].'
                   		</span>';	
						$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-5">
							'.money_format('$%i',$orders_total[$o['orders_id']]).'
                   		</span>';
						}else{
							$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-5">
							#'.$o['orders_id'].'
                   		</span>';	
						$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-5">
							'.money_format('$%i',$orders_total[$o['orders_id']]).'
                   		</span>';
							
						}

						
						
						
						if($o['orders_status']==10){
							$r_table.='<span class="info-panel-inside date_d col-md-6 col-sm-7 col-xs-4">';
							$r_table.=date('g:ia m/d',strtotime($o['date_deliver'])-$o['duration_to_deliver']-300);
							$swit=1;
						}else if($o['orders_status']==6 || $o['orders_status']==9){
							$r_table.='<span class="info-panel-inside date_d col-md-4 col-sm-5 col-xs-5">';
							$r_table.=date('g:ia m/d',strtotime($o['date_deliver'])-$o['duration_to_deliver']-300);
							$swit=1;
						}else{
							$r_table.='<span class="info-panel-inside col-md-2 col-sm-2 col-xs-5">';
							$r_table.=date('g:ia',strtotime($o['date_deliver'])-$o['duration_to_deliver']-300);
							$swit=2;
						}

                    	$r_table.='</span>';
						if($o['orders_status']!=10 && $o['orders_status']!=6){
						$r_table.='<span id="'.$o['orders_id'].'-orders_status" class=" info-panel-inside col-md-4 col-sm-5 ">
							'.$orders_status[$o['orders_status']].'
                    	</span>';
						}else if($o['orders_status']==6){
							$r_table.='<span id="'.$o['orders_id'].'-orders_status" class=" info-panel-inside col-md-2 col-sm-2 ">
							'.$orders_status[$o['orders_status']].'
                    	</span>';
						}

                    	
       $r_table.='</span>
	   			
                </div>
				
             </div>
              
			 <div  class="panel-drop-'.$o['orders_id'].' panel-body restaurant-body  " '.$hidden_dropdown.'>
             <legend></legend>
             <fieldset class="fieldset_order">
             <legend >';
			 $r_table.='<span >
                    		Order 

                    		</span>';
			 $r_table.='</legend>';
				  foreach($orders_products[$o['orders_id']] as $menu_item){ 
                		$r_table.='<div class="col-md-12 col-sm-12 col-xs-12">
							'.$menu_item['products_quantity'].' x '.$menu_item['products_name'].'
                        ';
						$r_table.='<span class="money_f">'.money_format('$%i',floatval($menu_item['products_quantity'])*floatval($menu_item['products_price'])).'</span>
                        </div>';
						if(is_array($orders_products_attributes[$menu_item['orders_products_id']])){
                         foreach($orders_products_attributes[$menu_item['orders_products_id']] as $attributes){ 
                          		$r_table.='<div class="col-md-12 ">
									&nbsp;&nbsp;&nbsp;-'.$attributes['products_options_values'].'
                           		';
									$prefix='';
									if($attributes['price_prefix']){
										$prefix=$attributes['price_prefix'];
									}
									if($attributes['options_values_price']>0){
										$r_table.='<span class="money_f">'.$prefix.money_format('$%i',floatval($menu_item['products_quantity'])*floatval($attributes['options_values_price'])).'</span>';
									}
									
									
									$r_table.='</div>';
                          } 
						}
						  if($menu_item['onetime_charges']>0){
							  $r_table.='<div class="col-md-6 col-sm-6 col-xs-6">
								  Misc Charge
							  </div>';
							  $r_table.='<div class="col-md-2 col-sm-2 col-xs-6 orders_price">
								  &nbsp;'.money_format('$%i',$menu_item['onetime_charges']).'
							  </div>';
						  }
						  $r_table.='<div class="col-md-12 col-sm-12 col-xs-12"><hr /></div>';
                  }
              $r_table.='</fieldset>';
               
               
                  if(count($orders_notes[$o['orders_id']])>0){ 
               		$r_table.='<fieldset>
              		<legend>Notes</legend>';
               		     foreach($orders_notes[$o['orders_id']] as $notes){   
               					$r_table.='<div class="col-md-12 col-sm-12 col-xs-12">
                        			'.$notes['note'].'
                       			</div>';
              		    } 
               		$r_table.='</fieldset>';
                     }       
             
             
            $is_display=' style="display:none" ';//
             if(!$order_is_accepted && $o['orders_status']!=6 && $o['orders_status']!=10 && $driver_accepted){ 
			 
			 	
					
				
			 	$r_table.='<div id="confirm-'.$o['orders_id'].'" class="col-md-3 col-sm-6 col-xs-12 col-sm-offset-6 col-md-offset-9 ">';
				
					  
					  $r_table.='<span '.$hidden_dropdown.'  data-id="'.$o['orders_id'].'" class="panel-drop-'.$o['orders_id'].'  btn btn-default  confirm-btn">
											  Accept
								  </span>';
				
					   $r_table.='</div>';
                   }else{
					   
					 
						   $is_display='  ';
					
					   
				   }
					   $r_table.='<div id="'.$o['orders_id'].'-adjust_btn" class="col-xs-12 " '.$is_display.'>';
					   if($o['pickup_order']==1){
						   $r_table.='<span class="other-btn btn btn-default col-xs-5 complete_order_btn" data-id="'.$o['orders_id'].'">Complete Order</span>';
						   $r_table.='<span id="'.$o['orders_id'].'-toggle_price_modal"  data-id="'.$o['orders_id'].'" class="col-xs-5 col-xs-offset-2 cog cog-modal other-btn btn btn-default">Adjust</span></div>';
					   }else{
						$r_table.='<span id="'.$o['orders_id'].'-toggle_price_modal"  data-id="'.$o['orders_id'].'" class="col-xs-12 cog cog-modal other-btn btn btn-default">Adjust</span></div>';   
					   }
					  
						$r_table.='</div>';
		 $r_table.='</div>';
		}
	
$this->restaurant_table=utf8_encode(preg_replace('/\s+/', ' ',$r_table));
?>


