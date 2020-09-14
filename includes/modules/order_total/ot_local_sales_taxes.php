<?php
/**
 *  ot_local_sales_tax module
 *
 *   By Heather Gardner AKA: LadyHLG
 *   The module should apply tax based on the field you
 *	choose options are Zip Code, City, and Suburb.
 *	It should also compound the tax to whatever zone
 *	taxes you already have set up.  Which means you
 *	can apply multiple taxes to any zone based on
 *	different criteria.
 *  ot_local_sales_taxes.php  version 2.5.3
 */

class ot_local_sales_taxes {

var $title, $output;

//
function ot_local_sales_taxes(){
	$this->code = 'ot_local_sales_taxes';
  	$this->title = MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_TITLE;
  	$this->description = MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_DESCRIPTION;
  	$this->sort_order = MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_SORT_ORDER;
  	$this->store_tax_basis = MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_STORE_TAX_BASIS;
  	$this->mod_debug = MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_DEBUG;
  	$this->output = array();
}

//Primary function that updates tax display
function process(){
	global $order;
  	global $currencies;
  	global $db;
  	global $debug;
	//print_r($order);

  	if($this->mod_debug =='true'){
  		//print_r($order);
	  	$debug = true;
  	}
  	else{
		$debug = false;
  	}
	if(isset($_POST['update_products']) || isset($_POST['update_info_payment_method'])){
		return;
	}

	if(isset($_SESSION['customer_id'])){
		$tax_ex = $db->Execute("select customers_tax_exempt from customers where customers_id=".$_SESSION['customer_id']);
		if($tax_ex->fields['customers_tax_exempt']=='ALL'){
			return;
		}
	}
	
	
 	//find out the store tax method - checking for store pick up too
	$customer_ship_method = $order->info['shipping_module_code'];
	$ot_local_sales_taxes_basis = $this->get_store_tax_basis($customer_ship_method);
	if($debug){echo 'Taxing based on: ' .$ot_local_sales_taxes_basis. '<br />';}

	//are we taxing based on billing address or shipping address zone id?
	//blank shipping means probably download default to billing
	$ot_local_sales_taxes_zoneid = $this->get_local_taxable_zoneid($ot_local_sales_taxes_basis);

	if($debug){echo 'Taxing For Zone: ' .$ot_local_sales_taxes_zoneid. '<br />';}

	//echo $ot_local_sales_taxes_zoneid;
	if($debug){echo 'Local Store Tax For: ' .$this->store_tax_basis. '<br /><br />';}

    //go get all local taxes for the local taxable zone if none return 0
	$local_taxes = $this->get_local_zone_taxes($ot_local_sales_taxes_zoneid,$ot_local_sales_taxes_basis,$this->store_tax_basis);
//print_r($local_taxes);
	//start of if local tax <> 0
	if( $local_taxes <> 0 ){

		//list of data to search for should be in semicolon delimeted list
		//can be single entry -ie 53545
		//can be mulitple single entries - ie 53545;53711;54302
		//can be ranges - ie 53545-to-53571
		//treat all as arrays and split

		//print_r($local_taxes);

		//for each local zone tax loop through to see if it applies to this order and if it applies to any of the products
		//start foreach tax loop
		foreach($local_taxes as $taxrec){

			//print_r($local_taxes);
			//check to see if this tax applies to this order
			$apply_local_tax = $this->check_for_datamach($taxrec['order_data'], $taxrec['matching_data']);

		   	//if tax applies then get total for this tax class
		    if ($apply_local_tax){

				$tax_total_for_class = '';
				//$rec_tax_class, $rec_tax_name, $tax
				$tax_total_for_class = $this->get_tax_total_for_class($taxrec['tax_class'], $taxrec['id'], $taxrec['tax']);
				
				//$tax_total_for_class= 0.001;
				//eecho $cho tax class total;
//echo $tax_total_for_class;
	//$tax_total_for_class = $tax_total_for_class/2;
				//start of if tax total > 0
				if($tax_total_for_class >0){

					if($debug){echo 'Tax for Class id ' . $taxrec['tax_class'] .': ' .  $tax_total_for_class. '<br /><br />';}

					//add total tax to order info array
					$order->info['tax'] += $tax_total_for_class;
					$order->info['total'] += $tax_total_for_class;
					if(!isset($order->info['local_tax'])) $order->info['local_tax'] = 0;
					$order->info['local_tax'] += $tax_total_for_class;

					//add tax info to order info tax groups
					if ( isset($order->info['tax_groups'][$taxrec['id']]) ){
						$order->info['tax_groups'][$taxrec['id']] += $tax_total_for_class;
					}
					else{
						$order->info['tax_groups'][$taxrec['id']] = $tax_total_for_class;
					}//end if is set tax groups

					//update order info totals
					$apply_tax_to_shipping = $this->check_tax_on_shipping($taxrec['tax_shipping']);
if($_SESSION['fooddudestaging_login']==1){
	//print_r($order->info);
	//print_r($order);
}
					if($apply_tax_to_shipping){
						$shipping_tax = zen_calculate_tax($order->info['shipping_cost'], $taxrec['tax']);
					  	$order->info['shipping_tax'] += $shipping_tax;
					  	$order->info['total'] += $shipping_tax;
					  	$order->info['tax_groups'][$taxrec['id']] += $shipping_tax;
					  	$_SESSION['shipping_tax_amount'] += $shipping_tax;
					  	if(!isset($order->info['shipping_local_tax'])) $order->info['shipping_local_tax'] = 0;
					  	$order->info['shipping_local_tax'] += $shipping_tax;

					  	$tax_total_for_class += $shipping_tax;
					}// end if apply to shipping

					$showtax = $currencies->format($tax_total_for_class, true, $order->info['currency'], $order->info['currency_value']);
				
					$this->output[] = array('title' =>'',$taxrec['id'] .':' ,
											'text' =>'',$showtax,
											'value' => $tax_total_for_class);

				}//end if tax total > 0
			}//end if apply local tax
	   }//end foreach tax loop
	}//end if local tax <> 0
}//end function
function get_store_tax_basis($customer_shipping_method){

	if( $customer_shipping_method == 'storepickup_storepickup' ){
		return  'Store Pickup';
	}
	else{
	    return STORE_PRODUCT_TAX_BASIS;
	}
}

function get_local_taxable_zoneid($store_tax_basis){

	global $order;

	switch ($store_tax_basis){
    	case 'Shipping':
	  		if( empty($order->delivery['zone_id']) ){
	  			$taxable_zoneid = $order->billing['zone_id'];
			}
			else{
      			$taxable_zoneid  = $order->delivery['zone_id'];
	    	}
      		break;

      	case 'Billing':
     		$taxable_zoneid  = $order->billing['zone_id'];
      		break;

      	case 'Store':
      		if ( $billing_address->fields['entry_zone_id'] == STORE_ZONE ) {
       			$taxable_zoneid  = $order->billing['zone_id'];
      		}
      		else{
				$taxable_zoneid = $order->delivery['zone_id'];
      		}
      		break;

	   case 'Store Pickup':
     		$taxable_zoneid = STORE_ZONE;
      		break;
   	}
	return $taxable_zoneid;
}

//
function get_local_data_field($store_tax_basis, $order_match){

	global $order;

	switch ($store_tax_basis) {
      	case 'Shipping':
		    if( empty($order->delivery[$order_match]) ){
				$myfield = $order->billing[$order_match];
			}
			else{
				$myfield = $order->delivery[$order_match];
			}
			break;

		case 'Billing':
			$myfield = $order->billing[$order_match];
			break;

		case 'Store':
			if( $billing_address->fields[$order_match] == STORE_ZONE ) {
				$myfield = $order->billing[$order_match];
			}
			else{
				$myfield = $order->delivery[$order_match];
			}
			break;

		case 'Store Pickup':
			$myfield = $this->$store_tax_basis;
			break;
	}
	return $myfield;
}

//
function get_local_zone_taxes($local_sales_taxes_zoneid,$ot_local_sales_taxes_basis,$store_tax_basis){

	global $db;
	global $debug;

	$taxsql = "select local_tax_id, zone_id, local_fieldmatch,
			    local_datamatch, local_tax_rate, local_tax_label,
				local_tax_shipping, local_tax_class_id
				from " . TABLE_LOCAL_SALES_TAXES . " where zone_id =  '" . $local_sales_taxes_zoneid . "'";

	//get tax rates for field lookup
	$local_taxes = $db->Execute($taxsql);

	if ( $local_taxes->RecordCount() > 0 ){//Check to see if it was null and not found.
		//echo $local_taxes->RecordCount();

		while ( !$local_taxes->EOF ) {
			//echo $local_taxes->fields['local_tax_id'].'<br />';
			$orderdata = $this->get_order_data($ot_local_sales_taxes_basis,$local_taxes->fields['local_fieldmatch'],$store_tax_basis);
	        $taxarray[$local_taxes->fields['local_tax_id']] =
											array('id'=>$local_taxes->fields['local_tax_label'],
											  	  'tax' =>$local_taxes->fields['local_tax_rate'],
											  	  'match_field' => $local_taxes->fields['local_fieldmatch'],
											  	  'matching_data' =>$local_taxes->fields['local_datamatch'],
											  	  'tax_shipping' =>$local_taxes->fields['local_tax_shipping'],
											  	  'tax_class' =>$local_taxes->fields['local_tax_class_id'],
											  	  'order_data' => $orderdata);
			$local_taxes->MoveNext();
		}
		
	}
	else{
		$all_local_taxes = 0;
	}
	//print_r($taxarray);
	return $taxarray;
}

//
function get_order_data($ot_local_sales_taxes_basis,$taxmatch,$store_tax_basis){

	global $order;
	//echo $ot_local_sales_taxes_basis;
	//echo $store_tax_basis;

	switch ($ot_local_sales_taxes_basis) {
		case 'Shipping':
			if( empty($order->delivery[$taxmatch]) ){
				$orderdata = $order->billing[$taxmatch];
			}
			else{
				$orderdata = $order->delivery[$taxmatch];
			}
			break;

		case 'Billing':
			$orderdata = $order->billing[$taxmatch];
			break;

		case 'Store':
			if( $billing_address->fields[$taxmatch] == STORE_ZONE ) {
				$orderdata = $order->billing[$taxmatch];
			}
			else{
				 $orderdata = $order->delivery[$taxmatch];
			}
			break;

		case 'Store Pickup':
			$orderdata = $store_tax_basis;
			break;
	}
	return $orderdata;
}

//Primary test for customer location (normally zip code) to determine is tax should be applied
function check_for_datamach($order_data, $local_data_list){

	$taxapplies = false;

	//Remove the - and plus 4 if the customer entered it with the zip code
	if(strstr($order_data, '-') ){//test first if the - is present, if not there is no plus 4
	    $tmpOD = trim($order_data);//remove spaces fromn start and trailing
	    $tmpOD = explode('-', $tmpOD);//explode to remove -plus4
	    if( is_numeric($tmpOD[0]) ){//ensure result is numeric (assummed to be zip code)
	    	$order_data = $tmpOD[0];//assign result
	    }
	}

	$listarray = explode(";", $local_data_list);

	//loop through the array to check each item is it a range or single zip
	//ranges are usually used with postcodes
	foreach ($listarray as $value){
		$value = trim($value);

		//this array item is a range
		if( strstr($value,"-to-") ) {
			//split the range to see if zip falls within
			$rangearray = explode("-to-", $value);
			$lowerrange = trim($rangearray[0]);
			$upperrange = trim($rangearray[1]);

			if( $order_data >= $lowerrange && $order_data <= $upperrange ){
			   $taxapplies = true;
			   //stop here we have a match
			   break;
			}
		}//this array item is a single zip
		else{
			if( strtolower($order_data) == strtolower($value) ){
			   $taxapplies = true;
			   //stop here we have a match
			   break;
			}
		}
	}
	return $taxapplies;
}

//Check if shipping is taxed for localcality
function check_tax_on_shipping($taxshipping){

	global $debug;

	//do we tax shipping for this localcality
	if( $taxshipping == "true" ){
		if($debug) {echo 'Apply Local Tax To Shipping <br /><br />';}
		return true;
	}
	else{
		if($debug) {echo 'Do Not Apply Local Tax To Shipping <br /><br />';}
		return false;
	}
}

//
function get_product_tax_class($productid, $tax_class){

	global $db;
	global $debug;

	$productinfo = $db->Execute("select products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $productid . "'");

	if ( $productinfo->RecordCount() >0 ){//Check to see if it was null and not found.

		$ptc = $productinfo->fields['products_tax_class_id'];

		if($debug) {echo $productinfo->fields['products_model'] . " - product tax class " .$ptc.' - ';}

		if( $ptc == $tax_class ){
			if($debug) {echo "tax class match".'<br />';}
			return true;
		}else{
			if($debug) {echo "not a tax class match".'<br />';}
			return false;
		}
	}
	else{
		if($debug){echo "Item not found".'<br /><br />';}
		return false;
	}
}

//
function get_tax_total_for_class($rec_tax_class, $rec_tax_name, $rec_tax){

	global $order;
	global $debug;

    foreach( $order->products as $key => $product ){
		$prodid = $product['id'];
		$prod_in_tax_class = $this->get_product_tax_class($prodid, $rec_tax_class);

		if($prod_in_tax_class){

			//tax description
			$producttaxDescription = $rec_tax_name . ' ' . $rec_tax;

			//get product price
			$product_tax = 0;

			//$product_price = ($product['final_price'] * $product['qty']) + ($product['onetime_charges']);
			$product_tax = (zen_calculate_tax($product['final_price'] * $product['qty'], $rec_tax)) + zen_calculate_tax($product['onetime_charges'], $rec_tax);

			if($debug){echo 'Product Tax:' . $product_tax.'<br /><br />';}

			//add tax group to order product tax_group array
			if ( !isset($order->products[$key]['tax_groups'][$producttaxDescription]) ){
			  $order->products[$key]['tax_groups'][$producttaxDescription]= $rec_tax;
			}

			//update order product tax info
			$order->products[$key]['tax']+= $rec_tax;
			$order->products[$key]['tax_description'] .=  ' + ' .$producttaxDescription;

			//sum tax for all products in this class
			$tax_class_total += $product_tax;
		}
	}
	return $tax_class_total;
}
//
function check(){

	global $db;

  	if ( !isset($this->_check) ) {
		$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_STATUS'");
		$this->_check = $check_query->RecordCount();
  	}
  	return $this->_check;
}

//keys for the removal function remove()
function keys(){
	return array('MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_STATUS', 'MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_SORT_ORDER','MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_STORE_TAX_BASIS','MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_DEBUG');
}

//adds mod to admin
function install(){

	global $db;

	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('This module is installed', 'MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())");
  	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_SORT_ORDER', '301', 'Sort order of display.', '6', '2', now())");
	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Store Pickup Tax Basis', 'MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_STORE_TAX_BASIS', '', 'Should be a zip code, city name or suburb entry. This should match to at least one of the local tax records.', '6', '3', now())");
 	$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Debugging is active', 'MODULE_ORDER_TOTAL_COUNTY_LOCAL_TAX_DEBUG', 'false', 'Turn Debugging on or off.', '6', '6','zen_cfg_select_option(array(\'false\', \'true\'), ', now())");
}

//uninstalls the mod from the admin - does not remove the sales tax tables
function remove(){
	global $db;
  	$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
}

}//close class
