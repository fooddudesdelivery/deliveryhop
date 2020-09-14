<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_logoff_default.php 2975 2006-02-05 19:33:51Z birdbrain $
 */
?>
<script>
$(document).ready(function(e) {
//    timer_custom(10,.1,100,$('#recount'))
	setTimeout(function(){
		window.location.replace('<?php echo HTTP_SERVER  ?>');
	},10000);		
//	
});
</script>
<div class="centerColumn" id="logoffDefault">

<!--<h1 id="logoffDefaultHeading"><?php echo HEADING_TITLE; ?></h1>-->

<p id="logoffDefaultMainContent" class="content"><?php echo TEXT_MAIN; ?></p>
<div id="recount" style="width:30px;"></div>
</div>