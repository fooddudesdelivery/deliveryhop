<?php
/**
 * Page Template
 *
 * Loaded by messageStack system to display error/caution messages as needed
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_message_stack_default.php 3192 2006-03-15 22:37:24Z wilt $
 */
?>
<?php for ($i=0, $n=sizeof($output); $i<$n; $i++) { ?>
  <div <?php echo $output[$i]['params']; ?>>
  	<?php echo $output[$i]['text']; ?>
	<button type="button" class="close" data-dismiss="alert">
	  <span aria-hidden="true">&times;</span>
	  <span class="sr-only">Close</span>
	</button>
  </div>

<?php } ?>