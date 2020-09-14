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
<!-- bof tpl_billing_default.php -->
	<div class='centerColumn' id='billing'>
		<h3 id='billing-heading'><?php echo HEADING_TITLE; ?></h3>
		<div id='billing-content' class='content'>
		<?php
		/**
		* require the html_define for the billing page
		*/
		require($define_page);
		?>
		</div>
	</div>
<!-- eof tpl_billing_default.php -->
