<?php
/**
 * Page Template
 *
 * Displays EZ-Pages footer-bar content.<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_ezpages_bar_footer.php 15645 2010-03-07 18:17:19Z drbyte $
 */

   /**
   * require code to show EZ-Pages list
   */
  include(DIR_WS_MODULES . zen_get_module_directory('ezpages_bar_footer.php'));
?>
<?php if (sizeof($var_linksList) >= 1) { ?>
<div class="widget widget-info-links col-lg-4 col-sm-12">
	<h3 class="widget-title"><span>Information</span></h3>
	<ul class="menu-links-widget">
	<?php for ($i=1, $n=sizeof($var_linksList); $i<=$n; $i++) {  ?>
	  <li><a href="<?php echo $var_linksList[$i]['link']; ?>"><?php echo $var_linksList[$i]['name']; ?></a></li>
	<?php } // end FOR loop ?>
	</ul>
</div>
<?php } ?>