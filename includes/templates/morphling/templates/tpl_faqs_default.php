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
<!-- bof tpl_faqs_default.php -->
	<div class='centerColumn' id='faqs'>
		<h2 id='faqs-heading'><?php echo HEADING_TITLE; ?></h1>
		<div id='faqs-content' class='content'>
		<?php
		/**
		* require the html_define for the faqs page
		*/
		require($define_page);
		?>
		</div>
	</div>
<!-- eof tpl_faqs_default.php -->
