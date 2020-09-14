<?php
/**
 * @package Pepper Themes Framework
 * @copyright Copyright 2012 - 2014 Pepper Themes
 * @author IronLady
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

$content = "";
$content .= '<div class="sideBoxContent centeredContent iframe-responsive">';

$content .= '<iframe src="//www.facebook.com/plugins/likebox.php?href=' . urlencode($data_themes['pt_store_facebook']) . '&amp;width=500&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=325595680979520" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:258px;" allowTransparency="true"></iframe>';

$content .= '</div>' . "\n";
?>
