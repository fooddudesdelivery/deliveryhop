<?php



include(__DIR__.'/CreditCard.php');







class Display extends CreditCard{

	private $restaurantMatrix = array();

	private $mainMenu = array();

	private $subMenu = array();

	private $productids = array();

	private $allPages = array('start','delivery-contact','main-menu','checkout','thankyou');

	//compare open menus to these menus

	

	//link is not needed in this class

	

	public function runDisplay(){

		if(!$this->generateRestaurantMatrix()){

			$this->addError(ERROR_TOP_LEVEL_DISPLAY,1);

			return false;

		}

		foreach($this->allPages as $page){

			$this->displayPage($page);

		}

		return true;

	}



	public function generateRestaurantMatrix(){

		if

		(

			$this->getMainMenu() &&

			$this->getSubMenu() &&

			$this->getProducts() &&

			$this->getAttributes()

			

		)

		{

			return true;	

		}else{

			$this->addError(ERROR_TOP_LEVEL_RESTAURANT_MATRIX,1);

			return false;

		}

		

	}

	

	

	public function displayPageAjax($page,$val){

		$route='pages';

	

		$ajaxproducts =$val;

		require($route.'/'.$page.'.php');

		return true;

	}

	

	public function displayPage($page){

		//renovate whole thing

		$cookie_page='#'.$page.'-page';

		if(in_array($page,$this->allPages)){

			if(!is_array($this->restaurantMatrix) || count($this->restaurantMatrix)<1){

				$this->addError(ERROR_TOP_MUST_GENERATE_MATRIX,1);

				return false;//possibly do better

			}

			$route='pages';

		}else{

			$route='common';	

		}

		

		//if($page==='start' && $this->Config['delivery']['active']===1 && $this->Config['pickup']['active']===1){

//			$display_current_page=' show_page ';

//		}else if($page==='delivery-contact' && $this->Config['delivery']['active']===1 && $this->Config['pickup']['active']===0){

//			$display_current_page=' show_page ';

//		}else if($page==='main-menu' && $this->Config['delivery']['active']===0 && $this->Config['pickup']['active']===1){

//			$display_current_page=' show_page ';

//		}else{

//			$display_current_page='';

//		}

		require($route.'/'.$page.'.php');

		return true;

	}

	

	public function sendCustomerReceipt($orders_id){

		$orders_id=intval($orders_id);

		if($orders_id<90000){

			return false;

		}

		$headers = "MIME-Version: 1.0" . "\r\n";

		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= 'From: service@deliverhop.app' . "\r\n";

		$receipt = include(__DIR__.'/../module/customer_receipt.php');

		

		mail('order@deliverhop.app','[NEW ORDER] Order Confirmation No: '.$orders_id,$receipt['message'],$headers);	

		if (!filter_var($receipt['email'], FILTER_VALIDATE_EMAIL)) {

			// add error email invalid

    		return false;

		}else{

			return mail($receipt['email'],$receipt['restaurant'].' Receipt',$receipt['message'],$headers);	

		}

	}

	

	

	

	private function getMainMenu(){

		$main_menu_sql="

		SELECT cd.categories_id, cd.categories_name

		FROM categories_description AS cd

		INNER JOIN categories AS c ON c.categories_id = cd.categories_id

		WHERE  c.categories_status =1

		AND    c.parent_id = $this->CategoriesId

		ORDER BY c.sort_order

		LIMIT 0,9999";



		

		$r = $this->db->query($main_menu_sql);

		foreach($r as $e){

			$this->mainMenu[]=$e['categories_id'];

			$this->restaurantMatrix['master'][$e['categories_id']]=array('categories_name'=>utf8_encode($e['categories_name']));

		}

		

		if(count($this->mainMenu)<1){

			$this->addError(ERROR_NO_MAIN_MENU,1);

			return false;

		}else if(count($this->mainMenu)>1){

			$this->restaurantMatrix['has_multiple_menus']=true;	

			return true;	

		}else{

			$this->restaurantMatrix['has_multiple_menus']=false;	

			return true;	

		}

	}

	

	

	private function getSubMenu(){

		

		$sub_menu_sql='

		SELECT c.parent_id,cd.categories_id, cd.categories_name

		FROM categories_description AS cd

		INNER JOIN categories AS c ON c.categories_id = cd.categories_id

		WHERE  c.categories_status =1

		AND	   c.parent_id

		IN ( '.implode(',',$this->mainMenu).' ) 

		ORDER BY c.sort_order

		LIMIT 0,9999';

		

		$m = $this->db->query($sub_menu_sql);

		foreach($m as $u){

			

		

			$this->subMenu[]=$u['categories_id'];

			$this->restaurantMatrix['master'][$u['parent_id']]['menus'][$u['categories_id']]=array('categories_name'=>utf8_encode($u['categories_name']));

		}

		

		if(!count($this->subMenu)){

			$this->addError(ERROR_NO_SUB_MENU,1);

			return false;

		}else{

			return true;	

		}

	}

	

	

	private function getProducts(){

		$product_sql='

		SELECT     p.products_id, 

				   p.products_model, 

				   p.products_price, 

				   p.products_tax_class_id, 

				   p.products_quantity_order_min, 

				   p.products_priced_by_attribute, 

				   pd.products_name, 

				   pd.products_description, 

				   pc.categories_id, 

				   c.parent_id

				   

		FROM       products AS p

		

		INNER JOIN products_description AS pd

		ON         pd.products_id=p.products_id 

		

		INNER JOIN products_to_categories AS pc 

		ON         pc.products_id = p.products_id 

		

		INNER JOIN categories as c

		ON		   c.categories_id = pc.categories_id

		

		WHERE      pc.categories_id IN ( '.implode(',',$this->subMenu).' ) 

		AND        p.products_status=1 

		

		ORDER BY   p.products_sort_order,

				   p.products_id, 

				   pd.products_name

				   

		LIMIT 0,9999';  

		

		$p=$this->db->query($product_sql);

	

		$product_flag_array=array();

		foreach($p as $d){

			

			$this->restaurantMatrix['master'][$d['parent_id']]['menus'][$d['categories_id']]['products'][$d['products_id']]=array(

			'categories_id'=>$d['categories_id'],

			'products_name'=>utf8_encode($d['products_name']),

			'products_description'=>utf8_encode($d['products_description']),

			'products_price'=>$d['products_price'],

			'products_model'=>$d['products_model'],

			'products_tax_class_id'=>$d['products_tax_class_id'],

			'products_quantity_order_min'=>$d['products_quantity_order_min'],

			'products_priced_by_attribute'=>$d['products_priced_by_attribute']);



			$this->productids[]=$d['products_id'];

		}

		

		if(count(array_values($this->productids))<2){

			$this->addError(ERROR_NO_PRODUCTS,1);

			return false;

		}else{

			return true;

		}

		

	}

	

	

	private function getAttributes(){

		$product_attribute_sql='

		SELECT     

				   

			p.products_id,

			pa.attributes_default,

			pa.options_values_price,

			pa.price_prefix,

			pa.products_options_sort_order,

			pa.product_attribute_is_free,

			pa.attributes_price_base_included,

			pov.products_options_values_name,

			pot.products_options_types_name,

			po.products_options_sort_order,

			po.products_options_name,

			pa.options_id,

			pa.options_values_id,

		    pc.categories_id, 

			c.parent_id

		

		FROM       products AS p

		

		INNER JOIN products_to_categories AS pc 

		ON         pc.products_id = p.products_id 

		

		INNER JOIN products_attributes AS pa 

		ON         pa.products_id = p.products_id 

		

		INNER JOIN products_options AS po 

		ON         po.products_options_id = pa.options_id 

		

		INNER JOIN products_options_types AS pot 

		ON         pot.products_options_types_id = po.products_options_type

		 

		INNER JOIN products_options_values AS pov 

		ON         pov.products_options_values_id = pa.options_values_id 

		

		INNER JOIN categories as c

		ON		   c.categories_id = pc.categories_id

		

		WHERE      p.products_id IN ( '.implode(',',$this->productids).' ) 

		

		ORDER BY   po.products_options_sort_order,pov.products_options_values_sort_order

		

				   

		LIMIT 0,9999'; 



		$p=$this->db->query($product_attribute_sql);

		foreach($p as $d){

			if(in_array($d['parent_id'],$this->mainMenu)){

			  $this->restaurantMatrix['master'][$d['parent_id']]['menus'][$d['categories_id']]['products'][$d['products_id']]['attributes'][$d['products_options_name']]

			  [$d['products_options_types_name']][]=array(

			  'options_values_price'=>$d['options_values_price'],

			  'price_prefix'=>$d['price_prefix'],

			  'attributes_default'=>$d['attributes_default'],

			  'products_options_sort_order'=>$d['products_options_sort_order'],

			  'product_attribute_is_free'=>$d['product_attribute_is_free'],

			  'attributes_price_base_included'=>$d['attributes_price_base_included'],

			  'products_options_values_name'=>utf8_encode($d['products_options_values_name']),

			  'products_options_sort_order'=>$d['products_options_sort_order'],

			  'option_key'=>$d['options_id'].'-'.$d['options_values_id']);

			}

			

		}

		

		return true;	

	}

	

	

	protected function getAttributesAjax($product_id,$menu_id){

		$product_id= intval($product_id);

		//print_r($product_id);

		if($product_id==0){

			return false;

		}

		//$this->getMainMenu();

		$product_attribute_sql="

		SELECT     

				   

			p.products_id,

			pa.attributes_default,

			pa.options_values_price,

			pa.price_prefix,

			pd.products_name,

			p.products_price,

			pd.products_description,

			pa.products_options_sort_order,

			pa.product_attribute_is_free,

			pa.attributes_price_base_included,

			pov.products_options_values_name,

			pot.products_options_types_name,

			po.products_options_sort_order,

			po.products_options_name,

			pa.options_id,

			pa.options_values_id,

		    pc.categories_id, 

			c.parent_id

		

		FROM       products AS p

		

		left JOIN products_description as pd 

		ON 		   pd.products_id = p.products_id

		

		left JOIN products_to_categories AS pc 

		ON         pc.products_id = p.products_id 

		

		left JOIN products_attributes AS pa 

		ON         pa.products_id = p.products_id 

		

		left JOIN products_options AS po 

		ON         po.products_options_id = pa.options_id 

		

		left JOIN products_options_types AS pot 

		ON         pot.products_options_types_id = po.products_options_type

		 

		left JOIN products_options_values AS pov 

		ON         pov.products_options_values_id = pa.options_values_id 

		

		left JOIN categories as c

		ON		   c.categories_id = pc.categories_id

		

		WHERE      p.products_id = $product_id

		

		AND 	   c.parent_id = $menu_id 

		

		ORDER BY   po.products_options_sort_order,pov.products_options_values_sort_order

		

				   

		LIMIT 0,9999"; 

		

		$p=$this->db->query($product_attribute_sql)->fetchAll(PDO::FETCH_ASSOC);

		$main_return=array();

		

		foreach($p as $d){

			//if(in_array($d['parent_id'],$this->mainMenu)){

			$main_return['parent_id']=$d['parent_id'];

			$main_return['products'][$d['products_id']]['products_name']=$d['products_name'];

			$main_return['products'][$d['products_id']]['products_price']=$d['products_price'];

			$main_return['products'][$d['products_id']]['products_description']=$d['products_description'];

			  $main_return['products'][$d['products_id']]['attributes'][$d['products_options_name']]

			  [$d['products_options_types_name']][]=array(

			  'options_values_price'=>$d['options_values_price'],

			  'price_prefix'=>$d['price_prefix'],

			  'attributes_default'=>$d['attributes_default'],

			  'products_options_sort_order'=>$d['products_options_sort_order'],

			  'product_attribute_is_free'=>$d['product_attribute_is_free'],

			  'attributes_price_base_included'=>$d['attributes_price_base_included'],

			  'products_options_values_name'=>utf8_encode($d['products_options_values_name']),

			  'products_options_sort_order'=>$d['products_options_sort_order'],

			  'option_key'=>$d['options_id'].'-'.$d['options_values_id']);

			//}

			

		}

			//print_r($main_return);

		return $main_return;	

	}

	protected function getFooter($page){

		$func='';

		$text='';

		switch($page){

			case 'main-menu':

				$func='checkout';

				$text='Checkout';

			break;

			case 'product-panel':

				$func='add_to_cart';

				$text='Add to Cart';

			break;

			case 'delivery-contact':

				$func='save_address';

				$text='Save Address';

			break;

			case 'checkout':

				$func='place_order';

				$text='Place Order';

			break;

			

			

		}

		

		

		if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))

		{

			$is_iproduct=true;

			$fixed_footer='';

		}else{

			$is_iproduct=false;

			$fixed_footer='fixed';

		}

	

		if($page=='main-menu'){

		if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod' ))

		{

			

			$plate = '<div  data-function="'.$func.'"    class=" imain_footer">

					  <span class="fo">Checkout <i class="glyphicon glyphicon-chevron-right"></i></span>

				  </div>';

		}else{

						$plate = '<div  data-id="persistent" id="menu-footer"  data-role="footer"  data-position="fixed"   data-tap-toggle="false" class=" hide_footer">

						<div class="footerBack"></div>

						<div class="container-fluid" style="padding:0px;">

						<div data-role="popup" id="popupCart" data-dismissible="true">

						  

					  </div>

						<div class="col-xs-6 text-center cartbox" style=""><h1 class="cart_words"><i class="colprim stop3 onei pull-left glyphicon glyphicon-shopping-cart"></i><span class="intext">Cart</span></h1></div>

						<div class="col-xs-6 text-center checkbox checkoot" data-function="'.$func.'" ><h1 class="footer_words intext">'.$text.'<i class="stop4 colprim twoi pull-right glyphicon glyphicon-chevron-right"></i></h1></div>

						</div>

					  

					  

					  

				  </div>';

		}

//<span id="cart_count">0</span> 

		}else if($page=='product-panel'){

			$new_p = $is_iproduct ? '<div class="ispacer_product"></div>' : '' ;

			$nell = $is_iproduct ? 'ipanel' : '' ;

			$plate = $new_p.'<a   data-id="persistent" data-transition="flip" href="#main-menu-page"><div  data-function="'.$func.'" data-role="footer"  data-position="'.$fixed_footer.'"   data-tap-toggle="false" class="main_footer '.$nell.'">

				<div class="footerBack"></div>

					  <h1 class="footer_words">'.$text.'</h1>

				  </div></a>'.$new_p.$new_p;

		}else if($page=='delivery-contact'){

			$plate = '<div   data-id="persistent" id="address-footer" data-function="'.$func.'" data-role="footer"  data-position="'.$fixed_footer.'"   data-tap-toggle="false" class="main_footer hide_footer" >

			<div class="footerBack"></div>

					  <h1 class="footer_words">'.$text.'</h1>

				  </div>';

		}else{

		if($is_iproduct){

			$plate = '<div class="container-fluid" style="margin:0px;padding:0px;"><div  data-function="'.$func.'"   class="main_footer icheckoutfooter">

		

					  <h1 class="footer_words" style="color:white !important">'.$text.'</h1>

				  </div></div>';

		}else{

			$plate = '<div   data-id="persistent" data-function="'.$func.'" data-role="footer"  data-position="fixed"   data-tap-toggle="false" class="main_footer">

			<div class="footerBack"></div>

					  <h1 class="footer_words" >'.$text.'</h1>

				  </div>';

		}

			 

				  

		}

		echo $plate;

		

	}

	public function printJsonMatrix(){

		print_r( "<script>console.log(JSON.parse('".json_encode($this->restaurantMatrix['master'])."'))</script>");

		

	}

}

?>