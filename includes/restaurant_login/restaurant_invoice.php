<?php

  
$oID=$this->transfer['orders_id'];
	
if($_SESSION['admin_id']==1){
	//$oID=94308;	
}
      $order_array = array();
 	 $order_array_sql = $this->db->query("	
SELECT o.products_price as products_price,o.onetime_charges,op.duration_to_deliver,o.products_name,o.products_quantity,op.date_purchased,op.date_deliver,o.orders_products_id
FROM  orders_products AS o 
LEFT JOIN orders AS op ON op.orders_id = o.orders_id
WHERE o.products_model != 'BEVERAGE'
AND   o.products_model != 'FOODDUDEMISC'
AND op.orders_id =". (int)$oID);

 foreach ($order_array_sql as $os) {
$order_array[] = array('products_price'=>  $os['products_price'], 
 					'products_quantity'=>  $os['products_quantity'], 
					'date_deliver'=>  $os['date_deliver'], 
					'onetime_charges'=>  $os['onetime_charges'], 
					'duration_to_deliver'=>  $os['duration_to_deliver'], 
					  'date_purchased'=>  $os['date_purchased'], 
					   'orders_products_id'=>  $os['orders_products_id'],
						'products_name'=>  $os['products_name']);


  }
  
  $note_string='';
  $note_sql=$this->db->query('select note from notes where note_type="1" and order_id="'.$oID.'"');
  foreach($note_sql as $nq) {
	  $note_string.=', '.$nq['note'];
	  

  }
   
  $name=$this->db->query('select c.categories_name from categories_description as c inner join orders o on o.categories_id=c.categories_id where o.orders_id="'.$oID.'"');
         foreach($name as $n){
			 $name=$n;
		 }
		 
		  $order_atr = array();
 	 $order_atr_sql = $this->db->query("	
SELECT pa.orders_products_id,pa.products_options, pa.products_options_values,pa.options_values_price,pa.price_prefix from orders_products_attributes as pa where 
 pa.orders_id =". (int)$oID);
	
  foreach($order_atr_sql as $oas) {
$order_atr[] = array(      'orders_products_id'=>  $oas['orders_products_id'], 
 					'products_options'=>  $oas['products_options'], 
					'price_prefix'=>  $oas['price_prefix'], 
					  'options_values_price'=>  $oas['options_values_price'], 
						'products_options_values'=>  $oas['products_options_values']);


  }
   $tmp = $this->db->query('select limit_value from limits where limit_name="time_difference_to_be_future"');
   
     foreach($tmp  as $tt) {
		 $limit = -$tt['limit_value'];
	 }
   $del_est = floatval($order_array[0]['duration_to_deliver'])+300;
  
   if($del_est<900){
	   $del_est=900;
   }
  $format_date = date('m/d/y g:ia',strtotime($order_array[0]['date_deliver'])-$del_est);
  $format_date_asap = date('m/d/y',strtotime($order_array[0]['date_deliver'])-$del_est);
  $true_date = strtotime($order_array[0]['date_deliver']);
  $now = strtotime('now');
  $difference = ($now - $true_date)/60;

  if($difference<$limit){
	  $asap=false;
	 $when_to_make = "";
	 $when_to_format=$format_date;
  }else{
	  $asap=true;
	 $when_to_make = ""; 
	 $when_to_format=$format_date_asap.' ASAP';
  }
  $grand_total=0;
?>
<?php


$r_invoice='';
$r_invoice.='<table width="100%" border="0">

<tr style="text-align:center">
<th  colspan="3" style="font-size:16px;text-align:center">'
.$name['categories_name'].
'</th>
</tr>';

$r_invoice.='<tr style="text-align:center">
<th  colspan="3" style="font-size:16px;text-align:center">
Order: '.$oID.'
</th>';

$r_invoice.='</tr>
<tr style="text-align:center">
<th colspan="3" style="font-size:16px">'
.$when_to_make;

if($asap){
	$r_invoice.=$when_to_format; 
}else{
	$r_invoice.='<b style="font-size:18px">'.$when_to_format.'</b>' ;
}


$r_invoice.='</th>

</tr>
    <tr >
      <td colspan="3" width="97%"><hr /></td>

    </tr>';
     for($r=0;$r<count($order_array);$r++){ 
   $r_invoice.=' <tr >
      <td style="font-size:14px" width="9%">'.$order_array[$r]['products_quantity'].'&nbsp; x</td>
      <td style="font-size:14px" width="59%" >'.$order_array[$r]['products_name'].'</td>
      <td style="font-size:14px" width="29%">&nbsp;'.money_format('$%i', floatval($order_array[$r]['products_quantity'])*$order_array[$r]['products_price']).'</td>
    </tr>';

	if($order_array[$r]['onetime_charges']!=0){
		 $r_invoice.= '<tr>';
		 $r_invoice.= '<td></td><td style="font-size:14px">Order Adjustment</td><td style="font-size:14px">&nbsp;'.money_format('$%i', $order_array[$r]['onetime_charges']).'</td>';
		 $r_invoice.='</tr>';
	}	
	?>
    <?php $grand_total= $grand_total + floatval($order_array[$r]['products_quantity'])*$order_array[$r]['products_price']+$order_array[$r]['onetime_charges'] ?>
    <?php for($ra=0;$ra<count($order_atr);$ra++){ 
	  		if($order_atr[$ra]['orders_products_id']==$order_array[$r]['orders_products_id'])
	  		{
	  
     $r_invoice.='<tr>
      <td></td>
      <td style="font-size:14px">&nbsp;&nbsp;-'.$order_atr[$ra]['products_options_values'].'</td>';
      
	  if($order_atr[$ra]['options_values_price'] !=0){   
	  		if($order_atr[$ra]['price_prefix']=='+' || $order_atr[$ra]['price_prefix']==''){
				$grand_total= $grand_total + $order_array[$r]['products_quantity']*floatval($order_atr[$ra]['options_values_price']);
			}else{
				$grand_total= $grand_total -$order_array[$r]['products_quantity']*floatval($order_atr[$ra]['options_values_price']);
			}
	 
     $r_invoice.= '<td style="font-size:14px">&nbsp;'.$order_atr[$ra]['price_prefix'].money_format('$%i', $order_array[$r]['products_quantity']*$order_atr[$ra]['options_values_price']).'</td>';
    
     
	  }
	 $r_invoice.=' </tr>';
	  }  
	    } 
    $r_invoice.='<tr >
      <td><hr /></td>
      <td><hr /></td>
      <td><hr /></td>
    </tr>';
    
      } 
	
    $r_invoice.='<tr>
    <td></td>
      <td style="font-size:14px">Total: </td>
      <td style="font-size:14px">&nbsp;'.money_format('$%i', $grand_total).'</td>
    </tr>';
//     if(function_exists(zen_get_orders_comments) && zen_get_orders_comments($oID)!='' || $note_string !=''){  
//    $r_invoice.='<tr>
//    <td></td>
//    <td  style="font-size:14px">Special Instructions:&nbsp;&nbsp; &nbsp;'. zen_get_orders_comments($oID).' '.$note_string .'</td>
//    <td></td>
//    </tr>';
//     }    

$r_invoice.='</table>';
$this->invoice=preg_replace('/\s+/', ' ',$r_invoice);
?>