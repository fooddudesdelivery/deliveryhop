<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=cookie_usage.<br />
 * Displays information page, if cookie only is set in admin and cookies disabled in users browser.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_cookie_usage_default.php 2540 2005-12-11 07:55:22Z birdbrain $
 */
?>
<div class="centerColumn" id="cookieUsageDefault">

<!--<h1 id="cookieUsageDefaultHeading"><?php echo HEADING_TITLE; ?></h1>-->

<p id="cookieUsageDefaultMainContent" class="content"><?php echo TEXT_INFORMATION; ?></p>

<fieldset>
<legend><?php echo BOX_INFORMATION_HEADING; ?></legend>
<p id="cookieUsageDefaultSecondaryContent" class="content"><?php echo BOX_INFORMATION; ?></p>
</fieldset>

<p id="cookieUsageDefaultContent2" class="content"><?php echo TEXT_INFORMATION_2; ?></p>

<p id="cookieUsageDefaultContent3" class="content"><?php echo TEXT_INFORMATION_3; ?></p>

<p id="cookieUsageDefaultContent4" class="content"><?php echo TEXT_INFORMATION_4; ?></p>

<p id="cookieUsageDefaultContent5" class="content"><?php echo TEXT_INFORMATION_5; ?></p>

<br class="clearBoth"/>

<div class="buttonRow back"><a href="<?php echo zen_back_link(true); ?>" class="pt-button"><?php echo BUTTON_CONTINUE_ALT; ?></a></div>
</div>
