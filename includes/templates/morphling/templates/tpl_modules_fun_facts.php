<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_featured_products.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PT_FUN_FACTS));
?>
<!-- bof: fun facts  -->

<div class="fun-facts row">
	<?php foreach ($facts as $fact) { ?>
		<?php if($fact['id'] == 'orders'){
			$curr = pt_get_default_currency();
		} ?>	
		<div class="facts-item col-md-6 col-md-offset-3">


            
            
            
            
            
				<?php if($fact['id'] != 'orders'){ ?>
			
				<?php }else{ ?>
					<?php //echo $curr['symbol_left'] . '<span class="count-up">' . number_format(zen_round($fact['value'], $curr['decimal_places']), $curr['decimal_places'], $curr['decimal_point'], $curr['thousands_point']) . '</span>' . $curr['symbol_right']; ?>
				<?php } ?>
                
                
                
                
			
			
		</div>	
	<?php } ?>
</div>
<!-- eof: fun facts  -->
