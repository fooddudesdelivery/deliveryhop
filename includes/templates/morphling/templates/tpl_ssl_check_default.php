<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_ssl_check_default.php 2540 2005-12-11 07:55:22Z birdbrain $
 */
?>
<div class="centerColumn" id="sslCheck">    

<!--<h1 id="sslCheckHeading"><?php echo HEADING_TITLE; ?></h1>-->

<p id="sslCheckMainContent" class="content text-danger"><?php echo TEXT_INFORMATION; ?></p>
<br class="clearBoth" />

<h2 id="sslCheckSubHeading" class="page-default-heading"><?php echo BOX_INFORMATION_HEADING; ?></h2>
<p id="sslCheckSecondaryContent" class="content"><?php echo BOX_INFORMATION; ?></p>

<p  id="sslCheckContent2" class="content"><?php echo TEXT_INFORMATION_2; ?></p>
<p  id="sslCheckContent3" class="content"><?php echo TEXT_INFORMATION_3; ?></p>
<p  id="sslCheckContent4" class="content"><?php echo TEXT_INFORMATION_4; ?></p>
<p  id="sslCheckContent5" class="content"><?php echo TEXT_INFORMATION_5; ?></p>

<br class="clearBoth" />
<div class="buttonRow"><?php echo '<a href="' . zen_href_link(FILENAME_LOGIN) . '" class="pt-button">' . BUTTON_CONTINUE_ALT . '</a>'; ?></div>
</div>