 <div id="<?php echo ID_PAGE_MAIN_MENU ?>" data-role="page" class="ui-page ui-page-theme-a ui-page-header-fixed" >

	<?php

		$this->displayPage('header');

	?>

    <div data-role="main" class="ui-content">

  <?php /*?>  <div class="col-xs-12" style="height:62px;"></div><?php */?>

    <?php 

	if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))

		{

			$is_iproduct=true;

		}else{

			$is_iproduct=false;

		}

		

	?>

    

    	<?php

	if($is_iproduct){

			echo '<div class="container-fluid" style="margin:0px;padding:0px;">';

			$this->getFooter('main-menu');

			echo '</div>';

		}

	?>

    

    <div class="container-fluid" data-role="content">

	  <?php if($this->restaurantMatrix['has_multiple_menus']){ ?>

      <div >

      		<ul class="nav nav-tabs nav-justified multimenu">

      		<?php 	

				$count=0;

				foreach($this->restaurantMatrix['master'] as $top_menu_id=>$z){ 

					if($count==0){

						$active_or='active';

					}else{

						$active_or='';

					}

					$count++;

			?>

            		<li role="presentation"  class="<?php echo $active_or ?> top-menu-select" data-target="#top-menu-<?php echo $top_menu_id ?>">

                    <a><?php echo $z['categories_name'] ?></a>

                    </li>

            <?php } ?>

            </ul>

       </div>

      <?php } ?>

      <div >

                  <ul data-filter="true" data-filter-placeholder="Search Products"

                  data-filter-theme="a" data-inset="true" data-role="listview" style="left: 0;

                  margin-top: -1px;

                  position: absolute;

                  right: 0;

                  z-index: 5;" >

                  

     

      			<?php foreach($this->restaurantMatrix['master'] as $top_menu_id=>$z){ 

					  foreach($z['menus'] as $menu_id=>$a){ ?>

                <?php if(isset($a['products'])){

					foreach($a['products'] as $products_id=>$c){ ?>

                <li class="search-item" style="display:none"><a  class="search-dropdown" style="border-bottom: 2px solid <?php echo $this->Config['primary_color'] ?> !important;

    font-size: 20px;

    padding-bottom: 10px;

    padding-top: 10px;background-color: white;

    text-align: center;" data-transition="slideup" href="future_index.php?ajax=product&amp;products_id=<?php echo $products_id ?>&amp;menu_id=<?php echo $top_menu_id ?>"><?php echo $c['products_name'] ?></a></li>

     

                <?php } ?>

                <?php }} ?>

				<?php } ?>

            </ul>

            </div>

      <?php  

	  		$count_menu=0;

	  		foreach($this->restaurantMatrix['master'] as $top_menu_id=>$z){ 

			if($count_menu==0){

				$active_or_menu='';

			}else{

				$active_or_menu=' style="display:none" ';

			}

			$count_menu++;

			?>



      		<div <?php echo $active_or_menu ?>  class="top-menu" id="top-menu-<?php echo $top_menu_id ?>">

		  <?php foreach($z['menus'] as $menu_id=>$a){ ?>

    			<?php if($a['categories_name']!='Fooddudes Misc'  && $a['categories_name']!='Beverages'){ ?>

                <?php if($this->Config['instore_ordering']==1 || $a['categories_name']!='Restaurant Misc'){ ?>

                <div class="row text-bold menu-header" data-toggle="collapse" data-target="#menu-<?php echo $menu_id ?>" style="margin-right:5px;margin-left:5px;">

                  <span class="col-xs-10"><?php echo $a['categories_name'] ?></span>

                  <span class="col-xs-2 text-right">

                  <span class="circlegl1"></span>

                  <i class="menu-left glyphicon glyphicon-chevron-left"></i></span>

                </div>

                <?php

			

					

				?>

                <div id="menu-<?php echo $menu_id ?>" class="collapse">

					 <?php $prcount=0; foreach($a['products'] as $products_id=>$c){ ?>

            		<a data-transition="slideup" href="future_index.php?ajax=product&amp;products_id=<?php echo $products_id ?>&amp;menu_id=<?php echo $top_menu_id ?>">

                    

                    <?php

					if($prcount==0){

						$spec_marg = ' margin-top:0px; ';

					}else{

						$spec_marg ='';

					}

					

					?>

                    <div id="products_id-<?php echo $products_id ?>" data-products-id="<?php echo $products_id ?>" class="row product-row gotoproduct" style="margin-right:5px;margin-left:5px;<?php echo $spec_marg ?>">

                    <?php

					if($prcount==0){

						echo '<div class="col-xs-12" style="height:15px">&nbsp;</div>';

					}

					

					?>

                        <span class="col-xs-9 text-bold"><?php echo $c['products_name'] ?></span>

                        <?php 

						$prcount++;

						if(intval($c['products_price'])>0){

							$display_price=$this->moneyFormat($c['products_price']);

						}else if(intval($c['products_price'])==0){
							$display_price=0;
							$options_valu_ar=array();
							foreach($c['attributes'] as $key=>$val){
								foreach($val as $attr){
									foreach($attr as $subattr){
										if($subattr['attributes_default']==1){
											if(floatval($subattr['options_values_price'])>0){
												$options_valu_ar[] =$subattr['options_values_price'];
											}
										}
									}
								}
							}
							if(count($options_valu_ar)>0){
								$display_price=	floatval(min($options_valu_ar));
							}
							$display_price = $this->moneyFormat($display_price);

						}else{
							$display_price='';
						}

						?>

                        <span class="col-xs-3 text-right text-bold"><?php echo $display_price ?></span>

                        <div class="col-xs-12" style="font-weight:400"><?php echo $c['products_description'] ?></div>

                        <div  class="col-xs-12 " ><hr class="hr-menu" /></div>

                        

                    </div>

                    </a>

                    

                    <?php } ?>

                </div>

              

                

          <?php }}} ?>

          </div>

	  <?php } ?>

    </div>

    <div style="height:50px;"></div>

    </div>

    <?php

	

	if(!$is_iproduct){

			$this->getFooter('main-menu');

		}

	?>

  </div>

  