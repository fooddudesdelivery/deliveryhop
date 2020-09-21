<?php
include(__DIR__.'/Location.php');

class Total extends Location{

	protected function runTotal(){
		if
		(
			$this->tsaPreCheck() && 
			$this->mainCalculation()
		)
		{
			return true;
		}else{
			$this->addError(ERROR_TOP_LEVEL_TOTAL);
			return false;
		}
	}
	
	private function tsaPreCheck(){
		if($this->Link['delivery']===1){
			
			if(!$this->runLocation()){
				return false;
			}
	
			if(!$this->runTime()){
				return false;
			}
			
            if(isset($this->Config['tax_rate'])){
				$this->Link['tax_rate']=floatval($this->Config['tax_rate']);
                return true;
			}else{
                $tax_sql = $this->db->query("SELECT combined_tax FROM real_tax_rates WHERE zipcode=".$this->Link['delivery_address']['zipcode']." LIMIT 0,1")->fetch();
                if(!isset($tax_sql['combined_tax'])){
                    //possible auto tax?
                    $this->addError(ERROR_NO_TAX);
                    return false;
                }else{
                    $tax_sql['combined_tax']=floatval($tax_sql['combined_tax']);
                    if($tax_sql['combined_tax']===0){
                        $this->addError(ERROR_NO_TAX);
                        return false;
                    }else{
                        $this->Link['tax_rate']=$tax_sql['combined_tax'];
                        return true;
                    }
                }
            }
		}else{
				
			//restaurant tax rate here
			if(isset($this->Config['tax_rate'])){
				$this->Link['tax_rate']=floatval($this->Config['tax_rate']);
			}else{
				$this->Link['tax_rate']=.08375;
			}
			
			return true;
		}	
		
	}
	
	private function mainCalculation(){
		$main_totals_array=array();
		$grandtotals=0.00;
		$subtotals=0.00;
		$taxes=0.00;
		
		foreach($this->Link['cart'] as &$items){//could probably do better
			$options_explode=array();
			$no_options_flag=false;

			foreach($items[3] as $options){
				if($options!==0){
					$splode = explode('-',$options);
					$options_explode['option'][]=intval($splode[0]);
					$options_explode['value'][]=intval($splode[1]);
				}else{
					$no_options_flag=true;
				}
			}
			
			if($no_options_flag){
				
				$product_price_query = '
				SELECT ap.products_id, ap.options_values_price, ap.price_prefix, p.products_price, p.products_tax_class_id
				FROM products_attributes AS ap
				INNER JOIN products AS p ON p.products_id = ap.products_id
				WHERE ap.products_id
				IN ( '.intval($items[0]).' ) 
				LIMIT 0,9999';
				
			}else{
				
				$product_price_query = '
				SELECT ap.products_id, ap.options_values_price, ap.price_prefix, p.products_price, p.products_tax_class_id
				FROM products_attributes AS ap
				INNER JOIN products AS p ON p.products_id = ap.products_id
				WHERE ap.products_id
				IN ( '.intval($items[0]).' ) 
				AND options_id
				IN ( '.implode(',',$options_explode['option']).' ) 
				AND options_values_id
				IN ( '.implode(',',$options_explode['value']).' ) 
				LIMIT 0,9999';
			
			}
			
			$product_price_sql = $this->db->query($product_price_query);
			$product_price=0;
			$product_is_taxable=1;
			$option_totals=0;
			$final_item_subtotal=0;
			
			foreach($product_price_sql as $prices){
				$product_price = $prices['products_price'];
				$product_is_taxable = $prices['products_tax_class_id'];
				if(!$no_options_flag){
					$option_totals+=floatval($prices['price_prefix'].$prices['options_values_price']);
				}
			}
			$final_item_subtotal=($product_price+$option_totals)*$items[1];
			
			$subtotals += $final_item_subtotal;
			$items[4]= $product_price+$option_totals;
			
			//
			if($product_is_taxable==1){
				$item_tax =  ($this->Link['tax_rate']*TAX_MULTIPLYER)*$final_item_subtotal;
				$taxes +=$item_tax;
				$items[5]= $item_tax/TAX_MULTIPLYER;
			}
			
			
			
		}
	
		$taxes+=($this->Link['tax_rate']*TAX_MULTIPLYER)*$this->Link['totals']['delivery_fee'];
		
		//subtotal
		$main_totals_array['subtotal']=$subtotals;

		
		//tax
		$main_totals_array['tax']=$taxes/TAX_MULTIPLYER;

		
		//grandtotal
		foreach($main_totals_array as $totals){
			$grandtotals+=$totals;
		}
		
		//make sure this is here and valid
		$grandtotals+=$this->Link['totals']['tip'];
		
		if($this->Link['delivery']===1){
				$grandtotals+=$this->Link['totals']['delivery_fee'];
		}
		
		
		$main_totals_array['grand_total']=$grandtotals;
		
		
		$this->Link['totals']=array_merge($this->Link['totals'],$main_totals_array);
		return true;
	}
	
	
}
?>