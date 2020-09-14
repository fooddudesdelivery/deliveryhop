<?php
	$gift_cards = $db->Execute('
	SELECT p.products_image,p.products_price,pd.products_name,pd.products_id,p.master_categories_id
	FROM products_description pd
	INNER JOIN products p ON p.products_id = pd.products_id
	WHERE p.products_model in("E_GIFT_CARD_NON_REWARDS","GIFT_CARD_NON_REWARDS")
	and p.products_status !=0
	LIMIT 0 , 999');
	//"GIFT_CARD_NON_REWARDS",
	$customers_points = GetCustomersRewardPoints($_SESSION['customer_id']);
	$redeem_ratio=.01;
?>

<style>
.gift-panel{
	text-align:center;
	border:1px solid #ef6f00;
	height:240px;
	margin-bottom:30px;
	cursor:pointer;
	padding:15px;
}
.gift-panel:hover{
	box-shadow: 0 0 0 3px #ef6f00 inset;
}
.gift-panel-text{
	text-align:center;
	border:1px solid #ef6f00;
	height:500px;
	padding:15px;
		
}
h3{
	color:black;
}
.gift{
	text-align:center;
	color:black;
	font-size:46px;
	margin-bottom:50px;
}
@media (max-width: 600px) {
	.gift_cards_class{
		font-size:26px;
	}
}

</style>
<div class="container">
<div class="gift">
Give the gift of restaurant delivery.
</div>

<?php
	if(!empty($_SERVER['HTTPS'])) {
		$ssl_sx='SSL';	
	}else{
		$ssl_sx='NONSSL';
	}
	while(!$gift_cards->EOF){
?>

	<div class="col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-3">
        	<div class="product-qv gift-panel" data-toggle="pt-quickview" href="<?php echo zen_href_link('product_info','&cPath=1_'.$gift_cards->fields['master_categories_id'].'&products_id='.$gift_cards->fields['products_id'].'&real_menu='.$gift_cards->fields['master_categories_id'],$ssl_sx) ?>">
				<h3 class="gift_cards_class"><?php echo $gift_cards->fields['products_name']  ?></h3>
               	<img src="images/<?php echo $gift_cards->fields['products_image'] ?>" />
			</div>
            
    </div> 
    
<?php
	$gift_cards->MoveNext();
 	} 
?>
</div>