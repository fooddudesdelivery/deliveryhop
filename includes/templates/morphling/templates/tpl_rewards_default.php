<?php
	$gift_cards = $db->Execute('
	SELECT p.products_image,p.products_price,pd.products_name,pd.products_id,p.master_categories_id
	FROM products_description pd
	INNER JOIN products p ON p.products_id = pd.products_id
	WHERE p.products_model in( "GIFT_CARD","E_GIFT_CARD", "OTHER_GIFT_CARD")
	and p.products_status !=0
	LIMIT 0 , 999');
	
	$customers_points = GetCustomersRewardPoints($_SESSION['customer_id']);
	$redeem_ratio=.01;
	$_SESSION['rewards_page']=1;
?>
<style>
.gift-panel{
	text-align:center;
	border:1px solid #ef6f00;
	height:160px;
	margin-bottom:30px;
	cursor:pointer;
	min-width:210px;
	padding:0px ;
	padding-top:15px;
	padding-bottom:15px;
}
.gift-panel:hover{
	box-shadow: 0 0 0 3px #ef6f00 inset;
}
.gift-panel-text{
	text-align:center;
	border:1px solid #ef6f00;
	height:400px;
	padding:15px;	
	margin-bottom:30px;
}
h4,h5{
	color:black;
}

</style>

<div class="container">

<div class="col-md-6 col-sm-6 col-lg-4 gift-panel-outer">
	<div class="gift-panel-text">
    	<h4>How it works</h4>
        <p><?php echo TEXT_REWARD_SIDEBOX ?></p>
        <?php if(isset($_SESSION['customer_id'])){ ?>
        <h5>Points: <?php echo $customers_points ?></h5>
        <h5>Value: <?php echo money_format('$%i',$customers_points*$redeem_ratio) ?></h5>
        <?php } ?>
       
    </div>
</div>

<?php
	if (!empty($_SERVER['HTTPS'])) {
		$ssl_sx='SSL';	
	}else{
		$ssl_sx='NONSSL';
	}
	while(!$gift_cards->EOF){
//		$product= $gift_cards->fields['products_id'];
//  $pro_price=((zen_has_product_attributes_values((int)$product) and $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') . zen_get_products_display_price((int)$product) . '<meta itemprop="price" content="' . round(zen_get_products_actual_price((int)$product), 2, PHP_ROUND_HALF_UP) . '">';
// echo zm_test();
//if(file_exists ('images/'.$gift_cards->fields['products_image'])){
if(true){	
?>

	<div class="col-md-6 col-sm-6 col-lg-4 gift-panel-outer">
        	<div class="product-qv gift-panel" data-toggle="pt-quickview" href="<?php echo zen_href_link('product_info','&cPath=1_'.$gift_cards->fields['master_categories_id'].'&products_id='.$gift_cards->fields['products_id'].'&real_menu='.$gift_cards->fields['master_categories_id'],$ssl_sx) ?>">
				<!--<h4><?php// echo $gift_cards->fields['products_name']  ?></h4>-->
                <!--<h4>Starts at <?php //echo $pro_price  ?></h4>-->
                	<img alt="<?php echo  $gift_cards->fields['products_name'] ?>" src="images/<?php echo $gift_cards->fields['products_image'] ?>" />
			</div>
    </div> 
<?php
}
	$gift_cards->MoveNext();
 	} 
?>
</div>