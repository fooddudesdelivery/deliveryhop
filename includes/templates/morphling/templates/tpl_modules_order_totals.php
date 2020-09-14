<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_order_totals.php 2993 2006-02-08 07:14:52Z birdbrain $
 */
 ?>
<?php 
/**
 * Displays order-totals modules' output
 */
/*echo "<pre>";
print_r($GLOBALS);
exit();*/
  for ($i=0; $i<$size; $i++) { 
  
  if($GLOBALS[$class]->code=='ot_shipping' && $GLOBALS[$class]->output[$i]['text']=='$0.00' && $_SESSION['is_virtual']){

  }else{
	  
  ?>
<div id="<?php echo str_replace('_', '', $GLOBALS[$class]->code); ?>">
    <div class="totalBox larger forward <?php echo str_replace('_', '', $GLOBALS[$class]->code); ?>_price"><?php echo $GLOBALS[$class]->output[$i]['text']; ?></div>
    <div class="lineTitle larger forward <?php echo str_replace('_', '', $GLOBALS[$class]->code); ?>_text"><?php 
	
	if($GLOBALS[$class]->output[$i]['title']=='Delivery ():'){
		echo 'Delivery:';
	}else{
		echo $GLOBALS[$class]->output[$i]['title'];
	} ?></div>
</div>
<br class="clearBoth <?php echo str_replace('_', '', $GLOBALS[$class]->code); ?>_clear " />
<?php } }?>
