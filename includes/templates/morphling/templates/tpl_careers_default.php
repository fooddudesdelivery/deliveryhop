<?php
/**
* @package page template
* @copyright Copyright 2003-2006 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: Define Generator v0.1 $
*/

// THIS FILE IS SAFE TO EDIT! This is the template page for your new page 

?>
<!--
<style>
	#careers{
	background-image: url(includes/templates/morphling/images/bg_icon.png);
    background-repeat: no-repeat;
    background-position: right;
	background-size: 400px 400px;
 		 	}
		
	@media (max-width: 767px) {
	#careers{
    background-image: none !important;
  }
}	
</style>
-->
<!-- bof tpl_careers_default.php -->
	<div class='centerColumn' id='careers'>
		<h3 id='careers-heading'><?php echo HEADING_TITLE; ?></h3>
		<div id='careers-content' class='content'>
		<?php
		/**
		* require the html_define for the careers page
		*/
		require($define_page);
		?>
		</div>
	</div>
<!-- eof tpl_careers_default.php -->
