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

<style>
	#company{
	background-image: url(includes/templates/morphling/images/bg_icon.png);
    background-repeat: no-repeat;
    background-position: right;
	background-size: 400px 400px;
 		 	}
		
	@media (max-width: 767px) {
	#company{
    background-image: none !important;
  }
}	
</style>

<!-- bof tpl_company_default.php -->
	<div class='centerColumn' id='company'>
		<h3 id='company-heading'><?php echo HEADING_TITLE; ?></h3>
		<div id='company-content' class='content'>
		<?php
		/**
		* require the html_define for the company page
		*/
		require($define_page);
		?>
		</div>
	</div>
<!-- eof tpl_company_default.php -->
