<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_whats_new.php 18698 2011-05-04 14:50:06Z wilt $
 */
?>
<div class="widget widget-store-contact col-md-4 col-sm-12">  
  <h3 class="widget-title"><span><?php echo zen_decode_specialchars($data_themes['pt_store_contact_title'][$_SESSION['languages_id']]); ?></span></h3> 
  
 <ul>
 	<!--<li><span class="contact-dd"><a href="index.php?main_page=company">About Food Dudes</a></span></li>-->
    <li><span class="contact-dd"><a href="index.php?main_page=driver">Become a Driver</a></span></li>
    <li><span class="contact-dd"><a href="index.php?main_page=restaurant">Restaurant Owners</a></span></li>
  	<li><span class="contact-dd"><a href="index.php?main_page=billing">Corporate Accounts</a></span></li>
	<li><span class="contact-dd"><a href="index.php?main_page=careers">Job Openings</a></span></li>
 </ul>
  
<!-- <ul>
    <li><span class="contact-dt"><i class="fa fa-map-marker"></i></span><span class="contact-dd"><?php //echo $data_themes['pt_store_contact_address'] ?></span></li>
    <li><span class="contact-dt"><i class="fa fa-phone"></i></span><span class="contact-dd"><?php //echo $data_themes['pt_store_contact_phone'] ?></span></li>
    <li><span class="contact-dt"><i class="fa fa-envelope"></i></span><span class="contact-dd"><?php //echo $data_themes['pt_store_contact_email'] ?></span></li>
  </ul>-->
</div>